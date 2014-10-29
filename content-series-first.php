<?php
/**
 * This template part is special and does not use `$wp_query`, but instead uses
 * what's made available in the manual `Message::shortcode()` loop.
 *
 * This is especially special because it's used only to display the first
 * series
 */
global $theme, $post, $item;
$permalink = get_permalink($item->last->ID);
$termlink = get_term_link((int)$item->term_id, 'series');
?>
	<article id="post-<?php echo $item->term_id ?>" class="first message-series clearfix">
		<div class="entry-content">
			<div class="series-image">
				<?php
				if (has_post_thumbnail($item->last->ID)) {
					echo $theme->Html->tag('a', get_the_post_thumbnail($item->last->ID, 'full'), array(
						'href' => $permalink,
						'title' => $item->last->post_title
					));
				}
				?>
			</div>
			<div class="series-details">
				<h2>
					<?php
					echo $theme->Html->tag('a', $item->last->post_title, array(
						'href' => $permalink,
						'title' => $item->last->post_title
					));
					?>
				</h2>
				<?php
				$date = date('Y-m-d', strtotime($item->last->post_date));
				$theme->set('date', $date);
				echo $theme->render('posted_date');
				?>
				<p>
					<?php echo $item->last->post_excerpt; ?>
				</p>
				<p class="series-link-buttons">
					<?php
					echo $theme->Html->tag('a', 'Watch This Message', array(
						'href' => $permalink,
						'title' => $item->last->post_title,
                        'class' => 'series-button'
 					));
					?>
				<span>or</span>
					<?php
					echo $theme->Html->tag('a', 'More Messages in "'.$item->name.'"', array(
						'href' => $termlink,
						'title' => $item->name,
                        'class' => 'series-button'
					));
					?>
				</p>
			</div>
		</div>
	</article>

	<h1>Past Series</h1>
