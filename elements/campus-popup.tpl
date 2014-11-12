<div id="frontpage-content">

    <div class="modal">
        <div class="header">
                <?php echo $theme->Html->image('welcome.png', array('parent' => true)); ?>
                <p>Please select from one of our campuses</p>
        </div>
        <ul class="campus-list campus-chooser">
            <li style='background-image: url(<?php echo $theme->Html->image('map-costamesa.jpg', array('parent' => true, 'url' => true)); ?>);'>
                <div class="campus-info">
                    <div class="title">
                        <a href="http://costamesa.rockharbor.org" class="campus-link">Costa Mesa</a>
                        <p>Visit costamesa.rockharbor.org &#8594;</p>
                    </div>
                    <div class="service-times">
                        <?php echo do_shortcode('[service-times campus="9"]'); ?>
                    </div>
                </div>
            </li>
            <li style='background-image: url(<?php echo $theme->Html->image('map-mission_viejo.jpg', array('parent' => true, 'url' => true)); ?>);'>
                <div class="campus-info">
                    <div class="title">
                        <a href="http://missionviejo.rockharbor.org" class="campus-link">Mission Viejo</a>
                        <p>Visit missionviejo.rockharbor.org &#8594;</p>
                    </div>
                    <div class="service-times">
                        <?php echo do_shortcode('[service-times campus="6"]'); ?>
                    </div>
                </div>
            </li>
            <li style='background-image: url(<?php echo $theme->Html->image('map-fullerton.jpg', array('parent' => true, 'url' => true)); ?>);'>
                <div class="campus-info">
                    <div class="title">
                        <a href="http://fullerton.rockharbor.org" class="campus-link">Fullerton</a>
                        <p>Visit fullerton.rockharbor.org &#8594;</p>
                    </div>
                    <div class="service-times">
                        <?php echo do_shortcode('[service-times campus="5"]'); ?>
                    </div>
                </div>
            </li>
            <li style='background-image: url(<?php echo $theme->Html->image('map-huntington_beach.jpg', array('parent' => true, 'url' => true)); ?>);'>
                <div class="campus-info">
                    <div class="title">
                        <a href="http://huntingtonbeach.rockharbor.org" class="campus-link">Huntington Beach</a>
                        <p>Visit huntingtonbeach.rockharbor.org &#8594;</p>
                    </div>
                    <div class="service-times">
                        <?php echo do_shortcode('[service-times campus="7"]'); ?>
                    </div>
                </div>
            </li>
            <li style='background-image: url(<?php echo $theme->Html->image('map-orange.jpg', array('parent' => true, 'url' => true)); ?>);'>
                <div class="campus-info">
                    <div class="title">
                        <a href="http://orange.rockharbor.org" class="campus-link">Orange</a>
                        <p>Visit orange.rockharbor.org &#8594;</p>
                    </div>
                    <div class="service-times">
                        <?php echo do_shortcode('[service-times campus="8"]'); ?>
                    </div>
                </div>
            </li>
        </ul>
        <a href="javascript:RH.hideSplash('www');" class="continue">
            CONTINUE TO ROCKHARBOR.ORG
        </a>
    </div>
</div>
