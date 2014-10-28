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
$serviceTimes = $theme->options('service_time');
$address1 = $theme->options('campus_address_1');
$address2 = $theme->options('campus_address_2');
$address3 = $theme->options('campus_address_3');

get_header();
?>
		<section id="faq" role="complementary" class="clearfix">
            <div class="icon-chat"></div>
            <h3 class="faq-title">Frequently Asked Questions</h3>
            <div class="clearfix"></div>
            <div class="faq-slides">
            <?php 
                if ( have_rows( 'faq') ) :
                    while ( have_rows('faq') ) : the_row();
                        echo '<div class="faq-slide"><div class="slide-inner">';
                        $faq_image = wp_get_attachment_image( get_sub_field('image'), 'full', 'flase', array('class'  => "faq-img") );
                        $faq_title = get_sub_field('title');
                        $faq_url = get_sub_field('url');
                        echo "<h4>$faq_title</h4>";
                        echo $faq_image;
                        echo '</div></div>';
                    endwhile;
                endif;
             ?>
             </div>
		</section>
        <section id="recent-news" class="clearfix">
    	   <div id="message" class="one-half">
                <?php if ( get_field('custom_sermon_series') ): ?>
                    <div class="section-title clearfix">
                        <h3><?php the_field('sermon_series_title'); ?></h3>
                    </div>
                    <a href="<?php the_field('sermon_series_url'); ?>">
                        <?php 
                            $sermon_series_image =  get_field('sermon_series_image');
                            if ( $sermon_series_image ) {
                                echo wp_get_attachment_image( $sermon_series_image, 'full', 'flase', array('class'  => "message-img") );
                            }?>
                    </a>                    
                <?php else : ?>
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
                <?php endif; ?>
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
            <?php echo $theme->Html->image('logo_2.png', array('alt' => 'Menu', 'class' => 'map-logo', 'parent' => false )); ?>
        </div>
        <div class="one-third">
            <?php                 
                if ( $serviceTimes ) : foreach ($serviceTimes as $time) :
                        echo $time . '<br>';
                endforeach; endif;
            ?>
        </div>
        <div class="one-third last">
            <?php 
                echo $address1 . '<br>';
                echo $address2 . '<br>';
                echo $address3 . '<br>';
            ?>
        </div>
    </div>
</section>
<section id="mission">
    <h2><?php bloginfo('description'); ?></h2>
</section>

<?php
get_footer();