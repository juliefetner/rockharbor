<?php global $theme; ?>
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<?php if (is_single() || is_search()): ?>
		<header>
			<h2><a href="<?php the_permalink(); ?>" title="<?php printf(esc_attr__('Permalink to %s', 'rockharbor'), the_title_attribute('echo=0')); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
		</header>
		<?php endif; ?>

		<div class="entry-content clearfix">
			<?php the_content(__('Continue reading <span class="meta-nav">&rarr;</span>', 'rockharbor')); ?>
			<?php echo $theme->render('pagination_posts'); ?>
		</div>

	</article>
