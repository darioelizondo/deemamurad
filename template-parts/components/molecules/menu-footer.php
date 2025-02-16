<?php

    /**
     * Component: Molecule: Menu footer
     * 
     * @package Darío Elizondo
     * 
     */

    //  wp_enqueue_script( 'deemamurad.menu-footer' );

?>

<!-- Menu footer -->
<div id="menuFooter" class="menu-footer">
    <div class="menu-footer__inner">

        <!-- Menu navigation -->
        <div class="menu-footer__wrapper">
            <?php
                wp_nav_menu( array(
                    'theme_location'  => 'main_menu_footer',
                    'menu'            => 'menu-footer__footer',
                    'container_class' => 'menu-footer__list',
                    'menu_class'      => 'menu-footer__nav',
                    'echo'            => true,
                    'items_wrap'      => '<ul id = "%1$s" class = "%2$s">%3$s</ul>',
                    'depth'           => 0,
    		 		'walker'          => new DeemaMurad_Menu_Walker_Footer, 
                ));
            ?>
        </div>

    </div>
</div>
<!-- End menu footer -->