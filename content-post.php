<?php
global $theme, $more;
?>
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<?php if (!is_single() || is_search()): ?>
		<h2>
			<a href="<?php the_permalink(); ?>" title="<?php printf(esc_attr__('Permalink to %s', 'rockharbor'), the_title_attribute('echo=0')); ?>" rel="bookmark"><?php the_title(); ?></a>
			<?php
			$theme->set('pubdate', true);
			$theme->set('date', $post->post_date);
			echo $theme->render('posted_date');
			?>
		</h2>
		<?php endif; ?>

		<div class="entry-content clearfix">
			<?php
			if (!$more) {
				$attachId = get_post_thumbnail_id($id);
				if (!empty($attachId)) {
					$title = get_the_title();
					$imageUrl = call_user_func("wp_get_attachment_thumb_url", $attachId);
					echo "<img src=\"$imageUrl\" alt=\"$title\" class=\"every-other-float\" />";
				}
			}
			?>			
			<?php the_content(__('Read More', 'rockharbor')); ?>
			<?php echo $theme->render('pagination_posts'); ?>
		</div>

		<div class="entry-footer">
			<?php
			/**
			 * WordPress doesn't correctly/fully switch from blog to blog, so things
			 * like permalinking to categories will use the current blog's permalinks
			 * rather than the switched blog's. Instead, we'll show the blog it
			 * came from if this isn't the home blog.
			 *
			 * @see http://core.trac.wordpress.org/ticket/12040
			 */
			if (isset($post->blog_id) && $post->blog_id != $theme->info('id')):
				$blogDetails = get_blog_details($post->blog_id);
			?>
			<span class="tags">Posted from <a href="<?php echo $blogDetails->siteurl; ?>"><?php echo $blogDetails->blogname; ?></a>
			<?php else: ?>
			<span class="tags">Posted in <?php the_category(', ') . the_tags(' | ', ', '); ?>
			<?php endif; ?>
			</span>
			<?php if (!is_single() || is_search()): ?>
			<span class="comments-link"> | <?php comments_popup_link('<span class="leave-reply">' . __('Leave a reply', 'rockharbor') . '</span>', __('<b>1</b> Reply', 'rockharbor'), __('<b>%</b> Replies', 'rockharbor')) ?></span>
			<?php endif; ?>
		</div>

		<?php
		if ($more) {
			$theme->set('types', array('post', 'page'));
			$related = $theme->render('related_content');
			$comments = '';
			if (comments_open()) {
				// have to capture because wordpress just auto-echoes everything
				ob_start();
				comments_template('', true);
				$comments = ob_get_clean();
				$comments = trim(preg_replace('/\s+/', ' ', $comments));
			}
			if (!empty($related) || !empty($comments)) {
				echo $theme->Html->tag('footer', $related.$comments, array('class' => 'related clearfix'));
			}
		}
		?>
	</article>
