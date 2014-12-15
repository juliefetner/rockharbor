<?php
global $theme;
$twitteruser = $theme->options('twitter_user');
$fbuser = $theme->options('facebook_user');
$instauser = $theme->options('instagram_user');
$coreid = $theme->options('core_id');
$feedburnerid = $theme->options('feedburner_main');
$ebulletinpage = $theme->options('ebulletin_archive_page_id');
$themeInfo = $theme->info();
    //  Front Page closes #main and #page earlier for full width sections
    if (! is_front_page() ) echo "</div></div>";
?>

<footer role="contentinfo">
    <div id="footer">
        <div class="desktop-hide tablet-hide mobile-newsletter clearfix">
            <?php echo $theme->render('newsletter'); ?>
        </div>
        <div class="clearfix">
            <div class="one-fourth">
                <h3>Office Location</h3>
                <p class="footer-address">
                <?php switch_to_blog(1);

                    echo $theme->options('campus_address_1') . '<br>';
                    echo $theme->options('campus_address_2') . '<br>';
                    echo $theme->options('campus_address_3');

                restore_current_blog();
                ?>
                </p>

            </div>
            <div class="one-fourth">
                <h3>Connect</h3>
                <ul class="socials">
                    <li>
                        <a href="http://twitter.com/<?php echo $twitteruser; ?>">
                            <div class="icon icon-twitter"></div>
                        </a>
                    </li>
                    <li>
                        <a href="http://facebook.com/<?php echo $fbuser; ?>">
                            <div class="icon icon-facebook"></div>
                        </a>
                    </li>
                    <li>
                        <a href="http://instagram.com/<?php echo $instauser; ?>">
                            <div class="icon icon-instagram"></div>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="one-fourth">
                <?php wp_nav_menu(array('theme_location' => 'footer', 'fallback_cb' => create_function('', 'return;'))); ?>
            </div>
            <div class="one-fourth last">
                <?php wp_nav_menu(array('theme_location' => 'footer2', 'fallback_cb' => create_function('', 'return;'))); ?>
            </div>
        </div>
        <div class="bottom">
            <div class="one-fourth">
                 <?php echo $theme->Html->image('footer-logo.png', array('alt' => 'rockharbor', 'parent' => true )); ?>
                 <p class="copy">&copy; 2014 ROCK HARBOR</p>
            </div>
            <div class="one-half mobile-hide">
                <?php echo $theme->render('newsletter'); ?>
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
            <li class="<?php if ($themeInfo['slug'] === 'costamesa') echo 'active'; ?>"><a href="//costamesa.rockharbor.org">Costa Mesa</a></li>
            <li class="<?php if ($themeInfo['slug'] === 'fullerton') echo 'active'; ?>"><a href="//fullerton.rockharbor.org">Fullerton</a></li>
            <li class="<?php if ($themeInfo['slug'] === 'orange') echo 'active'; ?>"><a href="//orange.rockharbor.org">Orange</a></li>
            <li class="<?php if ($themeInfo['slug'] === 'missionviejo') echo 'active'; ?>"><a href="//missionviejo.rockharbor.org">Mission Viejo</a></li>
            <li class="<?php if ($themeInfo['slug'] === 'huntingtonbeach') echo 'active'; ?>"><a href="//huntingtonbeach.rockharbor.org">Huntington Beach</a></li>
        </ul>
        <?php if( $theme->info('name') !== "" ) : ?>
            <div class="sidebar-footer">
                <a href="//www.rockharbor.org">
                    <p>&larr; <em>Back To</em> </p>
                    <h3>ROCKHARBOR.ORG</h3>
                </a>
            </div>
        <?php endif; ?>
    </nav>

</div>
<?php wp_footer(); ?>
</body>
</html>
