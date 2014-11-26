<?php
get_header();
$meta = $theme->metaToData(get_queried_object_id());
$fullpage = !empty($meta['hide_widgets']) && !empty($meta['hide_submenu']);
$sidebar = empty($meta['hide_widgets']) || empty($meta['hide_submenu']);
?>
		<header id="content-title">
			<h1><?php wp_title(false); ?></h1>
		</header>

		<section id="content" role="main" <?php if ($fullpage) { echo 'class="full"'; }?>>
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

		<?php if ( $sidebar ): ?>
		<section id="sidebar" role="complementary" class="clearfix">
			<?php
			if (empty($meta['hide_submenu'])) {
				locate_template('sidebar.php', true, false);
			}
			if (empty($meta['hide_widgets'])) {
				dynamic_sidebar('sidebar-subnav');
			}
			?>
		</section>
		<?php endif; ?>

<?php
get_footer();
