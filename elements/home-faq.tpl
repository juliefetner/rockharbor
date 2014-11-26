

    <div class="home-title clearfix">
      <div class="icon icon-faq"></div>
      <h2 class="faq-title">Frequently Asked Questions</h2>
    </div>

    <div class="faq-slides">
    <?php
        if ( have_rows( 'faq') ) :
            while ( have_rows('faq') ) : the_row();
                echo '<div class="faq-slide"><div class="slide-inner">';
                $faq_image = wp_get_attachment_image( get_sub_field('image'), 'full', 'flase', array('class'  => "faq-img") );
                $faq_title = get_sub_field('title');
                $faq_url = get_sub_field('url');
                $out = "<h4>$faq_title &nbsp;</h4>" . $faq_image;
                echo $theme->Html->tag('a', $out, array(
                    'href' => $faq_url
                ));
                echo '</div></div>';
            endwhile;
        endif;
     ?>
     </div>
