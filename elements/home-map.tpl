<?php global $post; ?>

    <div class="wrapper">
        <div class="one-third">
            <?php echo $theme->Html->image('logo_2.png', array('alt' => 'Menu', 'class' => 'map-logo', 'parent' => false )); ?>
        </div>
        <div class="one-third">
            <?php      
                $serviceTimes = $theme->options('service_time');           
                if ( $serviceTimes ) : foreach ($serviceTimes as $time) :
                        echo $time . '<br>';
                endforeach; endif;
            ?>
        </div>
        <div class="one-third last">
            <?php 
                echo $theme->options('campus_address_1') . '<br>';
                echo $theme->options('campus_address_2') . '<br>';
                echo $theme->options('campus_address_3');
            ?>
        </div>
    </div>