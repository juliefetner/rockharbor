<?php
/* In order to use this template as the front page, make sure to set it in
 * WordPress' backend
 *
 * Settings > Reading > Front page displays
 *
 * Choose "A static page" and select your home page under the "Front page"
 * dropdown
 */
global $wp_rewrite, $wp_query, $more, $wpdb, $post;

get_header();
?>
    <?php if( $theme->info('name') === "" ) echo $theme->render('campus-popup'); ?>
        <section id="faq" role="complementary" class="clearfix">
            <?php echo $theme->render('home-faq'); ?>
        </section>

        <section id="recent-news" class="clearfix">
        	   <?php echo $theme->render('home-news'); ?>
        </section>

    </div></div> <!-- #main & #page -->

    <?php echo $theme->render('home-map'); ?>


    <section id="mission">
        <h2><?php bloginfo('description'); ?></h2>
    </section>

<?php
get_footer();
