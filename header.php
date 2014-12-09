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
	<div id="navigation" class="wrapper clearfix">

		<div class="rockharbor-logo">
            <?php echo $theme->Html->image('logo_1.png', array('alt' => 'RockHarbor', 'parent' => false )); ?>
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

		<?php if ($hasHeader): ?>
		<header id="branding" role="banner" class="clearfix">
			<?php
			if (is_front_page() && count($featuredItems)) {
				if (!empty($featuredItems)) {
					echo '<div class="frontpage-banner">';
                    if ( have_rows( 'slide_banners') ) :
                        while ( have_rows('slide_banners') ) : the_row();
                            $image_link = get_sub_field('link_url');
                            $image = get_sub_field('slide_image');
                            $output = $theme->Html->tag('a', wp_get_attachment_image( $image, 'full'), array('href' => $image_link));
                            echo '<div>' . $output . '</div>';
                        endwhile;
                    endif;
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
		<?php
		if (!$theme->Shortcodes->hasShortcode('children-grid')) {
			// touch-accessible submenu
			get_sidebar();
		}
		?>
		<div id="main" class="clearfix">
