<?php 
    $menu_icon = $theme->Html->image('campus_menu.svg', array('alt' => 'Menu', 'parent' => true ));
    $campus_short_name = $theme->themeOptions['short_name'];
?>
<section class="global-navigation clearfix">
	<div class="wrapper">
        <div class="campus-menu">
            <a id="simple-menu" href="#campus-menu"><?php echo $menu_icon; ?></a>
            

            <div class="campus-name">
                <?php 
                    echo strtoupper( $campus_short_name ); 
                    if($campus_short_name !== '') echo ' Campus';
                ?>
            </div>
        </div>
    
	<nav class="clearfix">
		<ul class="clearfix">
            
			<li class="menu">
				<!-- for mobile use only -->
			</li>			
			<li class="search">
				<label for="search-toggle" class="search-label icon-search"></label>
                <input type="checkbox" id="search-toggle">
                <?php get_search_form(); ?>
                <!-- <?php echo $theme->Html->image('search-icon.svg', array('alt' => 'Search', 'class' => 'search-icon', 'parent' => true )); ?>  -->
			</li>
		</ul>
	</nav>
    </div>
</section>
