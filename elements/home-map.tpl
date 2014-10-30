<?php global $post; 

$serviceTimes = $theme->options('service_time');
$map = get_field('location_background');
?>

<section id="map" style="background-image: url( <?php echo wp_get_attachment_image_src( $map, 'full' )[0]; ?>)">
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
                echo $theme->options('campus_address_1') . '<br>' .
                     $theme->options('campus_address_2') . '<br>' .
                     $theme->options('campus_address_3');
            ?>
        </div>
    </div>
</section>