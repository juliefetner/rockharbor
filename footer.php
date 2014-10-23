<?php
global $theme;
$twitteruser = $theme->options('twitter_user');
$fbuser = $theme->options('facebook_user');
$coreid = $theme->options('core_id');
$mailchimp = $theme->options('mailchimp_id');
$feedburnerid = $theme->options('feedburner_main');
$ebulletinpage = $theme->options('ebulletin_archive_page_id');
?>
<?php if (! is_front_page() ) : ?>
	</div>
</div>
<?php endif; ?>
<footer role="contentinfo">	
    <div id="footer">
        <div class="one-fourth">
            <h3>Location</h3>
            <p>3095 Redhill Ave. <br>
            Costa Mesa, CA 92626 <br>
            (714) 384-0914</p>
        </div>
        <div class="one-fourth">
            <ul>
                <li>Connect</li>
            </ul>
        </div>
        <div class="one-fourth">
            <ul>
                <li>Online Giving</li>
                <li>Login to Core</li>
            </ul>
        </div>
        <div class="one-fourth last">
            <ul>
                <li>Contact Us</li>
                <li>Staff Directory</li>
                <li>Jobs</li>
            </ul>
        </div>
        <div class="bottom">
            <div class="one-fourth">
                 <?php echo $theme->Html->image('footer-logo.png', array('alt' => 'rockharbor', 'parent' => true )); ?>
            </div>
            <div class="one-fourth">
                <div class="newsletter">
                    <h3>E-Bulletin</h3>
                    <form action="http://rockharbor.us4.list-manage.com/subscribe/post?u=185dbb9016568292b89c8731c&amp;id=06151f2612" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank">
                        <input placeholder="Email Address" type="email" value="" name="EMAIL" class="required email" id="mce-EMAIL">
                        <input type="hidden" value="<?php echo $mailchimp; ?>" name="group[405][<?php echo $mailchimp; ?>]">
                        <input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="button">
                    </form>
                </div>
            </div>
        </div>
    </div>
</footer>
</div> <!-- main-content -->
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