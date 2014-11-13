<?php
global $theme, $post;
$meta = $theme->metaToData($post->ID);
?>
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<div class="entry-content clearfix">
			<?php if (has_post_thumbnail($post->ID)): ?>
			<div class="message-image clearfix">
				<a href="<?php the_permalink(); ?>">
					<?php echo get_the_post_thumbnail($post->ID, 'thumbnail'); ?>
				</a>
			</div>
			<?php endif; ?>
			<div class="message-details<?php if (has_post_thumbnail($post->ID)) { echo ' with-image'; } ?>">
				<h2>
					<?php
					echo $theme->Html->tag('a', $post->post_title, array(
						'class' => 'message-title',
						'href' => get_permalink()
					));
					$theme->set('date', $post->post_date);
					echo $theme->render('posted_date');
					?>
				</h2>
				<p><?php
				$content = $post->post_excerpt;
				if (empty($content)) {
					$content = $post->post_content;
				}
				echo $content;
				?></p>
				<div class="message-meta">
					<p><span class="meta-title">Series:</span><span class="meta-value"><?php echo get_the_term_list($post->ID, 'series', '', ', '); ?></span></p>
					<p><span class="meta-title">Teacher:</span><span class="meta-value"><?php echo get_the_term_list($post->ID, 'teacher', '', ', '); ?></span></p>
					<p><span class="meta-title">Scripture:</span><span class="meta-value"><?php echo $meta['scripture']; ?></span></p>
					<p><span class="meta-title">Length:</span><span class="meta-value"><?php echo $meta['length']; ?></span></p>
					<p><span class="meta-title">Tags:</span><span class="meta-value"><?php echo the_tags('', ', '); ?></span></p>
				</div>
			</div>
		</div>
	</article>
