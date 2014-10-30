<?php global $post; ?>

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