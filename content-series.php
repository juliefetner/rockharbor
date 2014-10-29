<?php
/**
 * This template part is special and does not use `$wp_query`, but instead uses
 * what's made available in the manual `Message::shortcode()` loop.
 */
global $theme, $post, $item;
$termlink = get_term_link((int)$item->term_id, 'series');
?>
	<article id="post-<?php echo $item->term_id ?>" class="message-series">
		<div class="entry-content">
			<div class="series-image">
				<?php
				if (has_post_thumbnail($item->last->ID)) {
					echo $theme->Html->tag('a', get_the_post_thumbnail($item->last->ID, 'thumbnail'), array(
						'href' => $termlink,
						'title' => $item->name
					));
				}
				?>
			</div>
            <div class="series-title">
                <h4>
                    <?php
                    echo $theme->Html->tag('a', $item->name, array(
                        'href' => $termlink,
                        'title' => $item->name
                    ));
                    ?>
                </h4>
                <p>
                    <?php
                    echo date('M. j, Y', strtotime($item->series_start_date));
                    if ($item->series_start_date != $item->series_end_date) {
                        echo ' - '.date('M. j, Y', strtotime($item->series_end_date));
                    }
                    ?>
                </p>
            </div>
            <div class="series-details">
                <p>
                    <?php
                    $suf = $item->series_message_count > 0 ? 'Messages' : 'Message';
                    echo $theme->Html->tag('a', $item->series_message_count." $suf", array(
                        'href' => $termlink,
                        'title' => $item->name
                    ));
                    ?>
                </p>
            </div>
		</div>
	</article>
