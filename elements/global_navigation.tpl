<?php

    $campus_short_name = $theme->themeOptions['short_name'];
?>
<section class="global-navigation clearfix">
	<div class="wrapper">
        <div class="campus-menu">
            <a id="simple-menu" class="select-campus" href="#campus-menu">SELECT CAMPUS</a>
        </div>

	<nav class="clearfix">
		<ul class="clearfix">

			<li class="menu icon-menu desktop-hide">
				<!-- for mobile use only -->
			</li>
			<li class="search">
				  <label for="search-toggle" class="search-label icon-search">
          </label>
          <input type="checkbox" id="search-toggle">
          <?php get_search_form(); ?>
			</li>
		</ul>
	</nav>
    </div>
</section>
