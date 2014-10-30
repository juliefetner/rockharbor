<?php
/**
 * Includes
 */
require_once VENDORS . DS . 'S3' . DS . 'S3.php';

/**
 * ROCKHARBOR Admin class. All admin (backend) related tasks should go here.
 *
 * @package rockharbor
 */
class Admin {

/**
 * The theme
 *
 * @var RockharborThemeBase
 */
	public $theme = null;

/**
 * List of paths to invalidate in Cloudfront
 *
 * @var array
 */
	protected $pathsToInvalidate = array();

/**
 * Registers all shortcodes
 *
 * @param RockharborThemeBase $theme
 */
	public function __construct($theme = null) {
		$this->theme = $theme;

		add_action('admin_menu', array($this, 'adminMenus'));
		add_action('network_admin_menu', array($this, 'networkAdminMenus'));
		add_action('admin_init', array($this, 'init'));
	}

/**
 * Initializes admin specific code
 *
 * @return void
 */
	public function init() {
		// register options
		register_setting('rockharbor_options', 'rockharbor_options');
		register_setting('rockharbor_network_options', 'rockharbor_network_options');

		// default options
		update_option('blogdescription', 'We are a church of communities living out the gospel together.');
		update_option('blogname', 'RH '.$this->theme->info('name'));
		update_option('image_default_link_type', 'file');

		// thumbnail sizes
		update_option('thumbnail_size_w', 260);
		update_option('thumbnail_size_h', 150);
		// no medium or large sizes
		update_option('medium_size_w', 0);
		update_option('medium_size_h', 0);
		update_option('large_size_w', 0);
		update_option('large_size_h', 0);

		// add meta boxes
		add_meta_box('media-options', 'Media', array($this, 'mediaMetaBox'), 'page', 'normal');
		add_meta_box('media-options', 'Media', array($this, 'mediaMetaBox'), 'post', 'normal');
		add_meta_box('template-options', 'Template Options', array($this, 'templateOptionsMetaBox'), 'page', 'side');
		add_meta_box('cross-post', 'Cross-site Posting', array($this, 'crossPostMetaBox'), 'post', 'side');
		add_meta_box('core', 'CORE', array($this, 'coreMetaBox'), 'page', 'side');

		// add tags to 'page' post type
		add_meta_box('tagsdiv-post_tag', __('Page Tags'), 'post_tags_meta_box', 'page', 'side');
		register_taxonomy_for_object_type('post_tag', 'page');

		// special admin front page only tasks
		if (isset($_GET['post']) && ($_GET['post'] == get_option('page_on_front'))) {
			$this->frontPage();
		}

		wp_register_script('admin_scripts', $this->theme->info('base_url').'/js/admin.js');
		wp_enqueue_script('admin_scripts');
		wp_enqueue_script('thickbox');
		wp_enqueue_style('thickbox.css', '/'.WPINC.'/js/thickbox/thickbox.css', null, '1.0');

		add_filter('default_content', array($this, 'setDefaultComments'), 1, 2);

		add_action('edit_user_profile', array($this, 'userPage'));
		add_action('show_user_profile', array($this, 'userPage'));
		add_action('personal_options_update', array($this, 'onUserSave'));
		add_action('edit_user_profile_update', array($this, 'onUserSave'));

		add_filter('save_post', array($this, 'onSave'), 1, 2);
		add_filter('wp_delete_file', array($this, 'deleteS3File'));
		add_action('wp_redirect', array($this, 'invalidateCloudfrontPosts'));
		add_filter('wp_update_attachment_metadata', array($this, 'transferToS3'), 10, 2);
	}

/**
 * Adds any additional menus
 */
	public function adminMenus() {
		add_theme_page(__('Theme Options', 'rockharbor'), __('Theme Options', 'rockharbor'), 'edit_theme_options', 'theme_options', array($this, 'admin'));
	}

/**
 * Adds any additional network admin menus
 */
	public function networkAdminMenus() {
		add_menu_page(__('Network Options', 'rockharbor'), __('Network Options', 'rockharbor'), 'manage_network_options', 'network_options', array($this, 'networkAdmin'));
	}

/**
 * Called when a post is saved. Forces auto-generation of enclosure meta keys,
 * saves extra namespaced meta, and clears appropriate caches
 *
 * @param integer $post_id Post id
 * @param StdClass $post The post
 */
	public function onSave($post_id, $post) {
		delete_transient('header.php#access');
		do_enclose($post->post_content, $post_id);
		$this->saveMeta();
	}

/**
 * Any meta boxes that go on the front page only belong here
 *
 * @return void
 */
	public function frontPage() {
		add_meta_box('front-page-options', 'Front Page Options', array($this, 'frontPageOptions'), 'page');
	}

/**
 * Any meta boxes that go on the user profile page
 *
 * @param WP_User $user The user object
 * @return void
 */
	public function userPage($user) {
		// only show these options to administrators
		if (current_user_can('delete_users')) {
			$this->theme->set('userId', $user->ID);
			$this->theme->set('data', $this->theme->userMetaToData($user->ID));
			echo $this->theme->render('admin'.DS.'user_details');
		}
	}

/**
 * Saves user meta
 *
 * @param int $userId The user id
 */
	public function onUserSave($userId) {
		// only save these options if logged in user is an administrator
		if (current_user_can('delete_users')) {
			if (isset($_POST['usermeta'])) {
				foreach ($_POST['usermeta'] as $name => $value) {
					update_user_meta($userId, $name, $value);
				}
			}
		}
	}

/**
 * Sets the default comments as 'open' or 'closed' depending on if the post type
 * is in `$disabledComments`. #YAWPH
 *
 * @param string $content Default post content
 * @param StdClass $post Post object
 * @return string Default content
 */
	public function setDefaultComments($content = '', $post) {
		if (in_array($post->post_type, $this->theme->disableComments)) {
			$post->comment_status = 'closed';
			$post->ping_status = 'closed';
		}
		return $content;
	}

/**
 * Delete file from S3 when deleted from local disk
 *
 * Wordpress sometimes sends a partial path and sometimes sends and unescaped path
 * (depending on the OS), so this function normalizes it and removes the object
 * from the S3 bucket and returns a true absolute path to the file for `unlink()`
 * to do it's job.
 *
 * @param string $file Some sort of path
 * @return string Absolute path to file
 */
	public function deleteS3File($file) {
		$s3Key = $this->theme->options('s3_access_key');
		$s3KeySecret = $this->theme->options('s3_access_secret');
		$bucket = $this->theme->options('s3_bucket');

		$S3 = new S3($s3Key, $s3KeySecret);

		$path = $this->getS3Path($file);

		// delete from bucket
		$S3->deleteObject($bucket, $path);

		// save this image path for later cloudfront invalidation
		$this->pathsToInvalidate[] = "/$path";

		return $file;
	}

/**
 * Invalidates all cloudfront paths stored in `$pathsToInvalidate`. Needs to
 * invalidate everything in a single batch request otherwise cloudfront limits
 * are hit (3 active invalidation requests per distribution)
 *
 * Called on each wp_redirect since that's the only way to capture multiple
 * delete calls in a single request (i.e., through the bulk actions)
 *
 * @param integer $postId The original post ID
 */
	public function invalidateCloudfrontPosts($url) {
		if (empty($this->pathsToInvalidate)) {
			return $url;
		}

		$s3Key = $this->theme->options('s3_access_key');
		$s3KeySecret = $this->theme->options('s3_access_secret');

		$S3 = new S3($s3Key, $s3KeySecret);

		// invalidate cloudfront cache (if applicable)
		$downloadDomain = $this->theme->options('s3_download');
		if (!empty($downloadDomain)) {
			$distributions = $S3->listDistributions();
			// get matching distribution id
			foreach ($distributions as $distributionId => $distributionDetails) {
				if ($distributionDetails['domain'] === $downloadDomain) {
					$S3->invalidateDistribution($distributionId, $this->pathsToInvalidate);
					break;
				}
			}
		}

		return $url;
	}

/**
 * Transfers a recently uploaded file to S3, and deletes the local copy
 *
 * @param array $data Attachment data
 * @param integer $postID Post id
 * @return array
 */
	public function transferToS3($data, $postID) {
		// because sometimes it's not populated... #YAWPH
		$data['file'] = str_replace(DS, '/', get_attached_file($postID, true));

		if (!isset($data['sizes'])) {
			$data['sizes'] = array();
		}

		$s3Key = $this->theme->options('s3_access_key');
		$s3KeySecret = $this->theme->options('s3_access_secret');
		$bucket = $this->theme->options('s3_bucket');

		$S3 = new S3($s3Key, $s3KeySecret);

		$type = get_post_mime_type($postID);

		$file = array(
			'type' => $type,
			'file' => $data['file'],
			'size' => filesize($data['file']),
		);
		$s3filePath = $this->getS3Path($data['file']);

		if (file_exists($data['file'])) {
			if ($S3->putObject($file, $bucket, $s3filePath, $S3::ACL_PUBLIC_READ)) {
				unlink($data['file']);
			}
		}

		foreach ($data['sizes'] as $thumbkey => $info) {
			$fullThumbPath = str_replace(basename($data['file']), $info['file'], $data['file']);
			$fullThumbPath = str_replace('/', DS, $fullThumbPath);

			$s3ThumbPath = str_replace(basename($s3filePath), $info['file'], $s3filePath);

			$file = array(
				'type' => $type,
				'file' => $fullThumbPath,
				'size' => filesize($fullThumbPath),
			);

			if (file_exists($fullThumbPath)) {
				if ($S3->putObject($file, $bucket, $s3ThumbPath, $S3::ACL_PUBLIC_READ)) {
					unlink($fullThumbPath);
				}
			}
		}
		return $data;
	}

/**
 * Takes a fully qualified local path and creates a partial path for S3.
 *
 * This is necessary because, historically S3 objects were maintained by a plugin
 * which modified the upload path
 *
 * @param type $fullPath Full local path to file
 * @return string Partial path
 */
	public function getS3Path($fullPath = '') {
		global $current_blog;

		$uploadpaths = wp_upload_dir();

		$possiblyFull = str_replace(DS, '/', $fullPath);
		$base = str_replace(DS, '/', $uploadpaths['basedir']);
		// now remove full path if it existed
		$partial = trim(str_replace($base, '', $possiblyFull), '/');

		if ($current_blog && $this->theme->info('id') > 1) {
			// the s3 plugin that is currently used stores files under the domain
			$subsitePath = substr($current_blog->domain, 0, strpos($current_blog->domain, '.')) . '/files/';
		} else {
			$subsitePath = 'wp-content/uploads/';
		}

		return ltrim($subsitePath . $partial, '/');
	}

/**
 * Renders the theme options panel
 */
	public function admin() {
		$out = $this->theme->render('admin'.DS.'theme_options');
		echo $out;
	}

/**
 * Renders the network options panel.
 *
 * Clears the aggregated SQL query cache
 */
	public function networkAdmin() {
		foreach ($this->theme->getBlogs() as $blog) {
			switch_to_blog($blog['blog_id']);
			delete_transient('RockharborThemeBase::aggregatePosts');
		}
		$out = $this->theme->render('admin'.DS.'network_options');
		echo $out;
	}

/**
 * Saves extra meta data
 *
 * All extra custom meta data to be saved should be prefixed with 'meta' in
 * order to be saved by this function
 */
	public function saveMeta() {
		global $post;

		if (isset($_POST['meta'])) {
			foreach ($_POST['meta'] as $name => $value) {
				// the 'custom fields' meta box duplicates this meta as
				// $metaid => array($key => $value) so we need to ignore those
				// on save
				if (is_numeric($name) && is_array($value)) {
					continue;
				}
				update_post_meta($post->ID, $name, $value);
			}
		}
	}

/**
 * Renders the cross_post meta box on the edit posts page
 */
	public function crossPostMetaBox() {
		global $post;
		$blogs = $this->theme->getBlogs();
		$crossPostBlogs = array();
		$whitelist = $this->theme->networkOptions('cross_post_whitelist_'.$this->theme->info('id'));
		foreach ($blogs as $blog) {
			// get whitelist
			$id = $blog['blog_id'];
			if (isset($whitelist[$id]) && $whitelist[$id]) {
				$crossPostBlogs[] = $blog;
			}
		}
		$this->theme->set('data', $this->theme->metaToData($post->ID));
		$this->theme->set('blogs', $crossPostBlogs);
		echo $this->theme->render('admin'.DS.'cross_post');
	}

/**
 * Renders the meta box for core events on pages
 */
	public function coreMetaBox() {
		global $post;
		$this->theme->set('data', $this->theme->metaToData($post->ID));
		echo $this->theme->render('admin'.DS.'core_meta_box');
	}

/**
 * Renders the meta box for core events on pages
 */
	public function mediaMetaBox() {
		global $post;
		$this->theme->set('data', $this->theme->metaToData($post->ID));
		echo $this->theme->render('admin'.DS.'media_meta_box');
	}

/**
 * Renders the options meta box for the front page
 */
	public function frontPageOptions() {
		global $post;
		$this->theme->set('data', $this->theme->metaToData($post->ID));
		echo $this->theme->render('admin'.DS.'front_page_options');
	}

/**
 * Renders the template options meta box
 */
	public function templateOptionsMetabox() {
		global $post;
		$this->theme->set('data', $this->theme->metaToData($post->ID));
		echo $this->theme->render('admin'.DS.'template_options_meta_box');
	}

}