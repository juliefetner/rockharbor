<?php global $post; ?>

       <div id="message" class="one-half">
            <?php if ( get_field('custom_sermon_series') ): ?>
                <a href="<?php the_field('sermon_series_url'); ?>">
                    <div class="home-title clearfix">
                        <div class="icon icon-sermon"></div>
                        <h2><?php the_field('sermon_series_title'); ?></h2>
                        <div class="subtitle">
                            <?php the_field('sermon_series_subtitle'); ?>
                        </div>
                    </div>
                    <?php
                        $sermon_series_image =  get_field('sermon_series_image');
                        if ( $sermon_series_image ) {
                            echo wp_get_attachment_image( $sermon_series_image, 'full', 'flase', array('class'  => "message-img") );
                        }?>
                </a>
            <?php else : ?>
                <?php
                $message = get_posts( array( 'post_type' => 'message','numberposts' => 1 ));
                if( $message ) : foreach ($message as $m) : ?>
                    <a href="<?php echo get_permalink( $m->ID ); ?>">
                        <div class="home-title clearfix">

                            <div class="icon icon-sermon"></div>
                            <h2>Current Sermon Series</h2>
                            <div class="subtitle">
                                <?php echo $m->post_title; ?>
                            </div>
                        </div>
                        <?php echo get_the_post_thumbnail( $m->ID, 'full' ); ?>
                    </a>
                <?php endforeach; endif; ?>
            <?php endif; ?>
       </div>
       <div id="story" class="one-half last">
           <a href="<?php the_field('featured_story_url'); ?>">
                <div class="home-title clearfix">
                    <div class="icon icon-stories"></div>
                    <h2><?php the_field('featured_story_title'); ?></h2>
                    <div class="subtitle">
                        <?php the_field('featured_story_subtitle'); ?> &nbsp;
                    </div>
                </div>
                <?php
                    $featured_story_image = get_field('featured_story_image');
                    echo wp_get_attachment_image( $featured_story_image, 'full' );
                ?>
            </a>
       </div>
