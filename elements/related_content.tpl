<?php

global $post;
$related = false;
$tags = wp_get_post_tags($post->ID);

if (!isset($limit)) {
	$limit = 4;
}
if (!isset($types)) {
	$types = array();
}
$_types = array('post');
$_types = $_types + (array)$types;
if ($tags) {
	$terms = array();
	foreach ($tags as $tag) {
		$terms[] = $tag->term_id;
	}
	$related = get_posts(array(
		'tag__in' => $terms,
		'post__not_in' => array($post->ID),
		'post_type' => $_types,
		'numberposts' => $limit
	));
}
$c = 0;

if ($related): ?>
<div class="related clearfix stories-4">
	<?php
	foreach ($related as $related_post) {
		$theme->set('id', $related_post->ID);
		$theme->set('title', $related_post->post_title);
		$theme->set('type', $related_post->post_type);
		echo $theme->render('story_box');
	}
	?>
</div>
<?php endif; ?>
