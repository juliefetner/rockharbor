<?php
global $post, $theme;

if (!isset($showUrl)) {
	$showUrl = false;
}
if (!isset($src)) {
	$src = $theme->getEnclosure('video');
}
if (empty($src)) {
	return null;
}
$vimeo = get_post_meta($post->ID, 'vimeo_url', true);
$vimeo_wide = get_post_meta($post->ID, 'vimeo_wide', true);


// check if we should pull streaming info from another blog
if (!isset($campus) || empty($campus)) {
	$campus = $theme->info('id');
}

$streamer = $theme->options('s3_streamer', false, $campus);
$downloader = $theme->options('s3_download', false, $campus);
$bucket = $theme->options('s3_bucket', false, $campus);

if (!isset($poster) || empty($poster)) {
	$poster = null;
	$thumb = get_post_thumbnail_id($post->ID);
	if (!empty($thumb)) {
		$attach = wp_get_attachment_image_src($thumb, 'large');
		$poster = $attach[0];
	}
}

$id = uniqid();
if ($vimeo == '1') : ?>
    <div class="embedded-video vimeo" id="player-<?php echo $id;?>">    
        <?php 
            $vimeo_id = str_replace('http://vimeo.com/','',$src); 
            $embedurl = "http://player.vimeo.com/video/".$vimeo_id;
            $vimeo_ratio = 'normal';
            $vimeo_ratio = $vimeo_wide == '1' ? 'wide' : 'normal';
        ?>
        <iframe data-ratio="<?php echo $vimeo_ratio; ?>" class="vimeo-embed" src="<?php echo $embedurl; ?>" webkitallowfullscreen="webkitallowfullscreen" mozallowfullscreen="mozallowfullscreen" allowfullscreen="allowfullscreen" frameborder="0"></iframe>
        
        <script type="text/javascript">
                var vimeoRatio = jQuery('.vimeo-embed').attr('data-ratio');
                if (vimeoRatio === 'wide'){
                    var ratio = 2.35/1;
                } else {
                    var ratio = 16/9;
                }
                var setVimeoHeight = function() {
                    var vimeo = jQuery('.vimeo-embed');
                    vimeo.width('100%');
                    vimeo.height(vimeo.width() / ratio);
                }
                jQuery(window).on('resize', setVimeoHeight);
                setVimeoHeight();
                
        </script>
    </div>
<?php else : ?>
    <div class="embedded-video" id="player-<?php echo $id;?>">
    	<?php if ($showUrl): ?>
    	<div class="referring-url">
    		<a href="<?php echo get_permalink(); ?>" target="_blank" class="referer-link" title="<?php echo get_permalink(); ?>">View <?php echo ucfirst($post->post_type); ?></a>
    	</div>
    	<?php endif; ?>
    	<div class="share-video">
    		<a href="javascript:;" class="embed-link">Share</a>
    	</div>
    	<div class="share-modal">
    		<a href="javascript:;" class="embed-link">X</a>
    		<p>To embed this video, copy and paste this code into your website.</p>
    		<textarea id="code-<?php echo $id;?>"><iframe src="<?php echo $theme->info('base_url'); ?>/embed.php?post=<?php echo $post->ID; ?>&blog=<?php echo $theme->info('id'); ?>" width="400" height="225" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe></textarea>
    		<label for="width-<?php echo $id;?>">Width:</label>
    		<input type="text" value="400" id="width-<?php echo $id;?>" size="10" />
    		<label for="height-<?php echo $id;?>">Height:</label>
    		<input type="text" value="225" id="height-<?php echo $id;?>" size="10" />
    	</div>

    	<video
    		id="embedded-player-<?php echo $id;?>"
    		src="<?php
    		$srcFile = $src;
    		if (!empty($downloader)) {
    			$srcFile = str_replace("http://$bucket.s3.amazonaws.com/", "http://$downloader/", $src);
    		}
    		echo $srcFile;
    		?>"
    		controls
    		preload="none"
    		style="width: 100%"
    		<?php
    		if (!empty($poster)) {
    			echo ' poster="'.$poster.'"';
    		}
    		if (!empty($streamer)) {
    			if (stripos($src, $bucket) !== false) {
    				$filename = str_replace("http://$bucket.s3.amazonaws.com/", 'mp4:', $src);
    				echo " data-streamfile=\"rtmp://$streamer/$filename\"";
    			}
    		}
    		?>
    	></video>
    </div>
    <script type="text/javascript">
    	jQuery('#player-<?php echo $id;?> .share-video a').click(function() {
    		jQuery('#player-<?php echo $id;?> .share-modal').show();
    		var h = jQuery('#player-<?php echo $id;?> .share-modal').outerHeight();
    		var w = jQuery('#player-<?php echo $id;?> .share-modal').outerWidth();
    		jQuery('#player-<?php echo $id;?> .share-modal').hide();
    		var t = (jQuery('#player-<?php echo $id;?>').height() - 30) / 2 - h/2;
    		var l = jQuery('#player-<?php echo $id;?>').width() / 2 - w/2;
    		jQuery('#player-<?php echo $id;?> .share-modal').css({
    			top: t+'px',
    			left: l+'px'
    		}).fadeIn();
    	});
    	jQuery('#player-<?php echo $id;?> .share-modal a').click(function() {
    		jQuery(this).parent().fadeOut();
    	});
    	jQuery('#code-<?php echo $id;?>').click(function() {
    		this.focus();
    		this.select();
    	});
    	jQuery('#width-<?php echo $id;?>, #height-<?php echo $id;?>').change(function() {
    		var w, h;
    		if (jQuery(this).attr('id') == 'width-<?php echo $id;?>') {
    			w = jQuery(this).val();
    			h = w*9/16;
    		} else {
    			h = jQuery(this).val();
    			w = h*16/9;
    		}

    		w = Math.ceil(w);
    		h = Math.ceil(h);

    		jQuery('#width-<?php echo $id;?>').val(w);
    		jQuery('#height-<?php echo $id;?>').val(h);

    		var embed = jQuery('#code-<?php echo $id;?>').val();
    		embed = embed.replace(/width="([0-9]+)"/, 'width="'+w+'"');
    		embed = embed.replace(/height="([0-9]+)"/, 'height="'+h+'"');
    		jQuery('#code-<?php echo $id;?>').val(embed);
    	});
    </script>
<?php endif; ?>