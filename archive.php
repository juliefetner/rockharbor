<?php
get_header();
?>
		<header id="content-title">
			<h1><?php echo wp_title(''); ?></h1>
		</header>
		<section id="content" role="main" class="full">
			<?php if (have_posts()):

				while (have_posts()) {
					the_post();
					$sub = get_post_type();
					get_template_part('content', $sub);
				}
				$theme->set('wp_rewrite', $wp_rewrite);
				$theme->set('wp_query', $wp_query);
				echo $theme->render('pagination');
			 else: ?>

			<article id="post-0" class="post no-results not-found">
				<header>
					<h1><?php _e('Nothing Found', 'rockharbor'); ?></h1>
				</header>

				<div class="entry-content">
					<p><?php _e('Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'rockharbor'); ?></p>
					<?php get_search_form(); ?>
				</div>
			</article>

			<?php endif; ?>

		</section>

<?php
get_footer();
