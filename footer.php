<?php
global $theme;
$twitteruser = $theme->options('twitter_user');
$fbuser = $theme->options('facebook_user');
$coreid = $theme->options('core_id');
$mailchimp = $theme->options('mailchimp_id');
$feedburnerid = $theme->options('feedburner_main');
$ebulletinpage = $theme->options('ebulletin_archive_page_id');
?>
	</div>
</div>
<footer role="contentinfo">
	<div class="tabs clearfix">
		<a href="javascript:void(0)" data-tab="#footer .first" class="icon-message"></a>
		<a href="javascript:void(0)" data-tab="#footer .second" class="icon-more"></a>
		<a href="javascript:void(0)" data-tab="#footer .third" class="icon-connect"></a>
		<a href="javascript:void(0)" data-tab="#footer .last" class="icon-campus"></a>
	</div>
	<div id="footer">
		<div class="first">
			<h3>Send Us a Message</h3>
			<?php
			echo $theme->render('quick_contact');
			?>
		</div>
		<div class="second">
			<h3>More</h3>
			<?php wp_nav_menu(array('theme_location' => 'footer', 'menu_class' => 'menu', 'fallback_cb' => create_function('', 'return;'))); ?>
		</div>
		<div class="third">
			<h3>Connect</h3>
			<p class="icons">
				<?php if (!empty($feedburnerid)): ?>
				<a href="http://feeds.feedburner.com/<?php echo $feedburnerid; ?>"><?php echo $theme->Html->image('rss-footer-icon.png', array('parent' => true)); ?></a>
				<?php else: ?>
				<a href="<?php bloginfo('rss2_url'); ?>"><?php echo $theme->Html->image('rss-footer-icon.png', array('parent' => true)); ?></a>
				<?php endif; ?>
				<a target="_blank" href="http://facebook.com/<?php echo $fbuser; ?>"><?php echo $theme->Html->image('facebook-footer-icon.png', array('parent' => true)); ?></a>
				<a target="_blank" href="http://twitter.com/<?php echo $twitteruser; ?>"><?php echo $theme->Html->image('twitter-footer-icon.png', array('parent' => true)); ?></a>
				<a target="_blank" href="https://core.rockharbor.org/campuses/view/Campus:<?php echo $coreid; ?>"><?php echo $theme->Html->image('core-footer-icon.png', array('parent' => true)); ?></a>
			</p>
			<hr />
			<?php if (!empty($mailchimp)): ?>
			<h3>ebulletin</h3>
			<?php if (!empty($ebulletinpage)) {
				echo $theme->Html->tag('a', 'View archive', array(
					'href' => get_permalink($ebulletinpage)
				));
			}
			?>
			<form action="http://rockharbor.us4.list-manage.com/subscribe/post?u=185dbb9016568292b89c8731c&amp;id=06151f2612" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank">
				<input placeholder="Email Address" type="email" value="" name="EMAIL" class="required email" id="mce-EMAIL">
				<input type="hidden" value="<?php echo $mailchimp; ?>" name="group[405][<?php echo $mailchimp; ?>]">
				<input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="button">
			</form>
			<hr />
			<?php endif; ?>
			<p>
				3095 Redhill Ave.<br />Costa Mesa, CA 92626<br />(714) 384-0914
			</p>
		</div>
		<div class="last">
			<h3>Campuses</h3>
			<?php
			echo $theme->render('campus_menu');
			?>
		</div>
	</div>
</footer>
<div id="campus-menu">
    <div class="icon-close"></div>
    <nav>
        <?php echo $theme->Html->image('campus-logo.png', array('alt' => 'RockHarbor', 'class' => 'campus-logo', 'parent' => true )); ?>
        <h2>Select Campus</h2>
        <ul>
            <li class="<?php if ($theme->info()['slug'] === 'costamesa') echo 'active'; ?>"><a href="#">Costa Mesa</a></li>
            <li class="<?php if ($theme->info()['slug'] === 'fullerton') echo 'active'; ?>"><a href="#">Fullerton</a></li>
            <li class="<?php if ($theme->info()['slug'] === 'orange') echo 'active'; ?>"><a href="#">Orange</a></li>
            <li class="<?php if ($theme->info()['slug'] === 'missionviejo') echo 'active'; ?>"><a href="#">Mission Viejo</a></li>
            <li class="<?php if ($theme->info()['slug'] === 'huntingtonbeach') echo 'active'; ?>"><a href="#">Huntington Beach</a></li>
        </ul>
    </nav>
</div>
<?php wp_footer(); ?>
</body>
</html>