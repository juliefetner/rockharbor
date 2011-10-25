<?php global $theme; ?>
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<?php if (is_single() || is_search()): ?>
		<header class="entry-header">
			<h1 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf(esc_attr__('Permalink to %s', 'rockharbor'), the_title_attribute('echo=0')); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
		</header>
		<?php endif; ?>

		<div class="entry-content">
			<?php the_content(__('Continue reading <span class="meta-nav">&rarr;</span>', 'rockharbor')); ?>
			<?php echo $theme->render('pagination_posts'); ?>
		</div>

	</article>
