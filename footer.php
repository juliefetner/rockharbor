<?php
global $theme;
$twitteruser = $theme->options('twitter_user');
$fbuser = $theme->options('facebook_user');
$instauser = $theme->options('instagram_user');
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
            <p><?php the_field('address'); ?></p>
        </div>
        <div class="one-fourth">
            <h3>Connect</h3>
            <ul class="socials">
                <li>
                    <a href="http://twitter.com/<?php echo $twitteruser; ?>">
                        <?php echo $theme->Html->image('twitter-icon.png', array('alt' => 'Twitter', 'class' => 'social-icon', 'parent' => true )); ?>
                    </a>
                </li>
                <li>
                    <a href="http://facebook.com/<?php echo $fbuser; ?>">
                        <?php echo $theme->Html->image('facebook-icon.png', array('alt' => 'Facebook', 'class' => 'social-icon', 'parent' => true )); ?>
                    </a>
                </li>
                <li>
                    <a href="http://instagram.com/<?php echo $instauser; ?>">
                        <?php echo $theme->Html->image('instagram-icon.png', array('alt' => 'Instagram', 'class' => 'social-icon', 'parent' => true )); ?>
                    </a>
                </li>
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
            <li class="<?php if ($theme->info()['slug'] === 'costamesa') echo 'active'; ?>"><a href="costamesa.tentsociety.com">Costa Mesa</a></li>
            <li class="<?php if ($theme->info()['slug'] === 'fullerton') echo 'active'; ?>"><a href="fullerton.tentsociety.com">Fullerton</a></li>
            <li class="<?php if ($theme->info()['slug'] === 'orange') echo 'active'; ?>"><a href="orange.tentsociety.com">Orange</a></li>
            <li class="<?php if ($theme->info()['slug'] === 'missionviejo') echo 'active'; ?>"><a href="missionviejo.tentsociety.com">Mission Viejo</a></li>
            <li class="<?php if ($theme->info()['slug'] === 'huntingtonbeach') echo 'active'; ?>"><a href="huntingtonbeach.tentsociety.com">Huntington Beach</a></li>
        </ul>
    </nav>

</div>
<?php wp_footer(); ?>
</body>
</html>