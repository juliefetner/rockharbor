<?php
global $post, $theme;
$meta = $theme->metaToData($post->ID);
$locations = get_nav_menu_locations();
$pageForPosts = get_option('page_for_posts');
$featuredItems = array();
if (!empty($locations['featured'])) {
	$featuredItems = wp_get_nav_menu_items($locations['featured']);
}
if (!empty($meta['video_campus_id'])) {
	$theme->set('campus', $meta['video_campus_id']);
}
$video = $theme->render('video');
$hasHeader =
	(
		is_front_page() && count($featuredItems)
	)
	|| (
		is_home() && has_post_thumbnail($pageForPosts)
	)
	|| (
		is_singular(array('post', 'page', 'message'))
		&& (!empty($video) || has_post_thumbnail($post->ID))
	)
	&& (
		empty($meta['hide_featured_content']) || !$meta['hide_featured_content']
	);
?>
<?php get_template_part('header', 'prebody') ?>
<body <?php body_class(); ?>>
    <div class="main-content">
    <?php echo $theme->render('global_navigation'); ?>
	<div id="navigation" class="wrapper">
            
		<div class="rockharbor-logo">
            <?php echo $theme->Html->image('rockharbor-logo.svg', array('alt' => 'RockHarbor', 'parent' => true )); ?>      
        </div>

		<nav id="access" role="navigation" class="clearfix">
			<?php
			$menu_items = wp_get_nav_menu_items($locations['main'], array('auto_show_children' => true));
			_wp_menu_item_classes_by_context($menu_items);
			$menu = array();
			$ids = array();
			foreach ($menu_items as $key => $menu_item) {
				$a = $theme->Html->tag('a', $menu_item->title, array('href' => $menu_item->url));
				$opts = array(
					'class' => implode(' ', $menu_item->classes)
				);
				if ($menu_item->menu_item_parent == 0) {
					// top level
					$menu[] = array(
						'a' => $a,
						'opts' => $opts,
						'children' => array()
					);
					$ids[$menu_item->ID] = count($menu)-1;
				} else {
					// child
					$menu[$ids[$menu_item->menu_item_parent]]['children'][] = $theme->Html->tag('li', $a, $opts);
				}
			}
			$output = '';
			$max_row = 5;
			foreach ($menu as $key => $top_level_menu_item) {
				$children = null;
				if (!empty($top_level_menu_item['children'])) {
					$class = null;
					if (count($top_level_menu_item['children']) > $max_row) {
						$top_level_menu_item['children'] = array_chunk($top_level_menu_item['children'], $max_row);
						foreach ($top_level_menu_item['children'] as $col) {
							$children .= $theme->Html->tag('ul', implode('', $col));
						}
						$class = 'cols'.count($top_level_menu_item['children']);
					} else {
						$children = $theme->Html->tag('ul', implode('', $top_level_menu_item['children']));
					}
					$children = $theme->Html->tag('div', $children, array('class' => 'submenu '.$class));
				}
				$output .= $theme->Html->tag('li', $top_level_menu_item['a'].$children, $top_level_menu_item['opts']);
			}
			echo $theme->Html->tag('ul', $output, array('class' => 'menu clearfix'));
			?>
		</nav>
    </div>
    <div id="page" class="hfeed clearfix">
		<?php
		if (!$theme->Shortcodes->hasShortcode('children-grid')) {
			// touch-accessible submenu
			get_sidebar();
		}
		?>

		<?php if ($hasHeader): ?>
		<header id="branding" role="banner" class="clearfix">
			<?php
			if (is_front_page() && count($featuredItems)) {
				if (!empty($featuredItems)) {
					$first = $featuredItems[0];
					$firstMeta = get_post_meta($first->object_id);

					if (!empty($firstMeta['video_url'][0]) && empty($meta['first_featured_only_image'])) {
						$theme->set('campus', null);
						if (!empty($firstMeta['video_campus_id'][0])) {
							$theme->set('campus', $firstMeta['video_campus_id'][0]);
						}
						$theme->set('src', $firstMeta['video_url'][0]);
						$banner = $theme->render('video');
					} else {
						if (!empty($meta['first_featured_story_height'])) {
							$theme->set('height', $meta['first_featured_story_height']);
						}
						$theme->set('id', $first->object_id);
						$theme->set('title', $first->title);
						$theme->set('type', $first->object);
						$theme->set('useThumbnail', false);
						$banner = $theme->Html->tag('div', $theme->render('story_box'));
					}

					echo $theme->Html->tag('div', $banner, array(
						'id' => 'main-feature',
						'class' => 'clearfix'
					));
					echo '<div class="stories-3 clearfix">';
					// only items 2,3,4 allowed
					$items = array_slice($featuredItems, 1, 3);
					foreach ($items as $item) {
						$theme->set('useThumbnail', true);
						$theme->set('id', $item->object_id);
						$theme->set('title', $item->title);
						$theme->set('type', $item->object);
						echo $theme->render('story_box');
					}
					echo '</div>';
				}
			} elseif (is_home() && has_post_thumbnail($pageForPosts)) {
				echo get_the_post_thumbnail($pageForPosts);
			} elseif (is_singular(array('post', 'page', 'message'))) {
				if (empty($video) && has_post_thumbnail($post->ID)) {
					echo get_the_post_thumbnail($post->ID, 'full');
				} else {
					echo $video;
				}
			}
			?>
		</header>
		<?php endif; ?>

		<?php
		if (isset($_SESSION['message'])) {
			echo $theme->Html->tag('div', $_SESSION['message'], array('class' => 'flash-message'));
			unset($_SESSION['message']);
		}
		?>

		<?php echo $theme->render('breadcrumbs'); ?>

		<div id="main" class="clearfix">