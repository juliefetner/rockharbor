<?php
global $post;
if (!isset($page) || empty($page)) {
	$page = get_permalink($post->ID);
}
if (!isset($title) || empty($title)) {
	$title = get_the_title();
}
if (!isset($message)) {
	$message = null;
}
$message = rawurlencode($message);
$page = rawurlencode($page);
$title = rawurlencode($title);
?>
<a class="share-facebook" href="http://www.facebook.com/sharer.php?u=<?php echo $page; ?>&t=<?php echo $title; ?>">
	<span class="icon icon-facebook"></span>
</a>
<a class="share-twitter" href="http://twitter.com/home?status=<?php echo $message.$page; ?>" target="_blank">
	<span class="icon icon-twitter"></span>
</a>
<script type="text/javascript">
	jQuery('.share-facebook, .share-twitter').click(function() {
		window.open(jQuery(this).attr('href'), 'share', 'width=500,height=400');
		return false;
	});
</script>
