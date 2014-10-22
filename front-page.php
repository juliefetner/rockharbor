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
		<section id="frontpage-sidebar" role="complementary" class="clearfix">
            <div class="icon-book"></div>
            <h3>Frequently Asked Questions</h3>
            <?php 
                if ( have_rows( 'faq') ) :
                    while ( have_rows('faq') ) : the_row();
                        echo '<div class="one-fourth">';
                        $faq_image = wp_get_attachment_image( get_sub_field('image'), 'full' );
                        $faq_title = get_sub_field('title');
                        $faq_url = get_sub_field('url');
                        echo "<h4>$faq_title</h4>";
                        echo $faq_image;
                        echo '</div>';
                    endwhile;
                endif;
             ?>
		</section>
        <section id="recent-news" class="clearfix">
    	   <div id="message" class="one-half">
                <div class="section-title clearfix">
                    <div class="icon-book"></div>
                    <h3>Current Sermon Series</h3>
                </div>
                <?php $message = get_posts( array(
                    'post_type' => 'message',
                    'numberposts' => 1
                )); ?>
                <?php if( $message ) : foreach ($message as $m) : 
                    echo "<a href='".get_permalink( $m->ID )."'>";
                    // echo $m->post_title;
                    echo get_the_post_thumbnail( $m->ID, 'full' );
                    echo "</a>";
                endforeach; endif; ?>
           </div>
           <div id="story" class="one-half last">
                <div class="section-title clearfix">
                    <div class="icon-girl"></div>
                    <h3><?php the_field('featured_story_title'); ?></h3>
                </div>
                <a href="<?php the_field('featured_story_url'); ?>">
                    <?php 
                        $featured_story_image = get_field('featured_story_image');
                        echo wp_get_attachment_image( $featured_story_image, 'full' ); 
                    ?>
                </a>
           </div>
       </section>
        
    </div>
</div>
<section id="map" style="background-image: url( <?php echo $theme->Html->image('map.png', array('alt' => 'Menu', 'url' => true, 'parent' => false )); ?>)">
    <div class="wrapper">
        <div class="one-third">
            <?php echo $theme->Html->image('map_logo.png', array('alt' => 'Menu', 'class' => 'map-logo', 'parent' => false )); ?>
        </div>
        <div class="one-third">
            <?php the_field('service_times'); ?>
        </div>
        <div class="one-third last">
            <?php the_field('address'); ?>
        </div>
    </div>
</section>
<section id="mission">
    <h2><?php the_field('mission_statement'); ?></h2>
</section>

<?php
get_footer();