<?php global $post; ?>

    <div class="home-title clearfix">
      <div class="icon-chat"></div>
      <h3 class="faq-title">Frequently Asked Questions</h3>
    </div>

    <div class="faq-slides">
    <?php
        if ( have_rows( 'faq') ) :
            while ( have_rows('faq') ) : the_row();
                echo '<div class="faq-slide"><div class="slide-inner">';
                $faq_image = wp_get_attachment_image( get_sub_field('image'), 'full', 'flase', array('class'  => "faq-img") );
                $faq_title = get_sub_field('title');
                $faq_url = get_sub_field('url');
                echo "<h4>$faq_title &nbsp;</h4>";
                echo $faq_image;
                echo '</div></div>';
            endwhile;
        endif;
     ?>
     </div>
