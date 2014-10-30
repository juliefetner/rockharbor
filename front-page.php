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
        <section id="faq" role="complementary" class="clearfix">
            <?php echo $theme->render('home-faq'); ?>
        </section>
    		
        <section id="recent-news" class="clearfix">
        	   <?php echo $theme->render('home-news'); ?>
        </section>
            
    </div></div> <!-- #main & #page -->

    <section id="map" style="background-image: url( <?php echo $theme->Html->image('map.png', array('alt' => 'Menu', 'url' => true, 'parent' => false )); ?>)">
        <?php echo $theme->render('home-map'); ?>
    </section>

    <section id="mission">
        <h2><?php bloginfo('description'); ?></h2>
    </section>

<?php
get_footer();