<?php
$calendarPage = $theme->options('calendar_archive_page_id');
?>

<div class="core-events clearfix" data-core-feed-url="<?php echo $url; ?>" data-core-limit="<?php echo $limit; ?>">
	<p>Loading events...</p>
</div>
<?php
if ($calendarPage) {
	echo $theme->Html->tag('a', 'View Full Calendar', array(
	'href' => get_permalink($calendarPage)
	));
}
?>
