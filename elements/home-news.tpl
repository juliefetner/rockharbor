<?php global $post; ?>

       <div id="message" class="one-half">
            <?php if ( get_field('custom_sermon_series') ): ?>
                <div class="home-title clearfix">
                    <h3><?php the_field('sermon_series_title'); ?></h3>
                    <div class="subtitle">
                        <?php the_field('sermon_series_title'); ?>
                    </div>
                </div>
                <a href="<?php the_field('sermon_series_url'); ?>">
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
                    <div class="home-title clearfix">
                        <!-- <div class="icon-book"></div> -->
                        <?php echo $theme->Html->image('icon-book.svg', array('alt' => 'Sermon Series', 'class' => 'icon-book', 'parent' => true )); ?>
                        <h3>Current Sermon Series</h3>
                        <div class="subtitle">
                            <?php echo $m->post_title; ?>
                        </div>
                    </div>
                    <a href="<?php echo get_permalink( $m->ID ); ?>">
                        <?php echo get_the_post_thumbnail( $m->ID, 'full' ); ?>
                    </a>
                <?php endforeach; endif; ?>
            <?php endif; ?>
       </div>
       <div id="story" class="one-half last">
            <div class="home-title clearfix">
                <!-- <div class="icon-girl"></div> -->
                <?php echo $theme->Html->image('icon-girl.svg', array('alt' => 'featured-story-icon', 'class' => 'icon-girl', 'parent' => true )); ?>
                <h3><?php the_field('featured_story_title'); ?></h3>
                <div class="subtitle">
                    <?php the_field('featured_story_subtitle'); ?> &nbsp;
                </div>
            </div>
            <a href="<?php the_field('featured_story_url'); ?>">
                <?php
                    $featured_story_image = get_field('featured_story_image');
                    echo wp_get_attachment_image( $featured_story_image, 'full' );
                ?>
            </a>
       </div>
