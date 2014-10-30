<p>
	<strong>Header Video Message URL</strong><br />
	<a id="media_meta_video" title="Video Message" class="mceButton mceButtonEnabled" href="javascript:;" role="button" tabindex="-1" style="text-decoration: none;">
		<img alt="Video Message" src="<?php echo $theme->info('base_url'); ?>/js/mceplugins/video.png" class="mceIcon" />
	</a>
	<?php
	echo $theme->Html->input('video_url', array(
		'label' => false,
		'div' => false,
		'size' => 80,
        'width' => '100%'
	));
	?>
</p>
<p>
    <?php
    echo $theme->Html->input('vimeo_url', array(
        'type' => 'checkbox',
        'label' => 'Check If Vimeo URL',
        'value' => 1
    ));
    ?>
    <br>
    <?php
    echo $theme->Html->input('vimeo_wide', array(
        'type' => 'checkbox',
        'label' => 'Wide Format Vimeo',
        'value' => 1
    ));
    ?>
</p>
<p>
	<strong>Campus</strong><br />
	<?php
	echo $theme->Html->input('video_campus_id', array(
		'label' => false,
		'div' => false,
		'size' => 10
	));
	?>
	<small>(leave blank for current campus)</small>
</p>
<script type="text/javascript">
	jQuery('#media_meta_video').click(function() {
		RH.showMediaLibrary(function(html) {
			var url = jQuery(html).attr('href');
			jQuery('#metavideourl').val(url);
			return '';
		});
	});
	jQuery('#media_meta_audio').click(function() {
		RH.showMediaLibrary(function(html) {
			var url = jQuery(html).attr('href');
			jQuery('#metaaudiourl').val(url);
			return '';
		});
	})
</script>