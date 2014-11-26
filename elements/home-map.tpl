
<?php
$multi;
$locations = array(9, 5, 8, 6, 7);

if( $theme->info('name') !== "" ) {
    $locations = array( $theme->info('id') );
}
    $serviceTimes = $theme->options('service_time');
    $map_img = $theme->Html->image('map-'.$theme->info('slug').'.jpg', array( 'parent' => true, 'url' => true ));
?>


    <section id="map" class="global-maps">
        <?php foreach( $locations as $current ) : switch_to_blog( $current );  ?>
            <div class="global-location" style="background-image: url(<?php echo bloginfo('stylesheet_directory') . '/img/map.jpg' ?>)">
                <div class="wrapper">
                    <div class="one-third">
                        <img src="<?php echo bloginfo('stylesheet_directory') . '/img/map_logo.png' ?>">
                    </div>
                    <div class="one-third">
                        <?php
                            $serviceTimes = $theme->options('service_time', false, $current);
                            if ( $serviceTimes ) :
                                echo 'Weekend Services: <br>';
                                foreach ($serviceTimes as $time) :
                                    echo $time . '<br>';
                                endforeach;
                            endif;
                        ?>
                    </div>
                    <div class="one-third last">
                        <?php
                        echo $theme->options('campus_address_1', false, $current) . '<br>' .
                        $theme->options('campus_address_2', false, $current) . '<br>' .
                        $theme->options('campus_address_3', false, $current);
                        ?>
                        <?php if( $theme->options('campus_googlemaps', false, $current) ) : ?>
                            <a class="google-directions" href="<?php echo $theme->options('campus_googlemaps', false, $current); ?>" target="_blank">
                                Get Directions &#8594;
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php restore_current_blog(); endforeach; ?>
    </section>
