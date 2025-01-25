<?php

    /**
     * Component: Molecule: Menu
     * 
     * @package Darío Elizondo
     * 
     */

?>

<!-- Menu -->
<div id="menu" class="menu">
    <div class="menu__inner container">

        <!-- Menu navigation -->
        <div class="menu__wrapper">
            <?php
            if( isset( $context ) && $context === 'macollo' ) {
                wp_nav_menu( array(
                    'theme_location'  => 'main_menu_macollo',
                    'menu'            => 'menu__main',
                    'container_class' => 'menu__list',
                    'menu_class'      => 'menu__nav',
                    'echo'            => true,
                    'items_wrap'      => '<ul id = "%1$s" class = "%2$s">%3$s</ul>',
                ));
            } else {
                wp_nav_menu( array(
                    'theme_location'  => 'main_menu',
                    'menu'            => 'menu__main',
                    'container_class' => 'menu__list',
                    'menu_class'      => 'menu__nav',
                    'echo'            => true,
                    'items_wrap'      => '<ul id = "%1$s" class = "%2$s">%3$s</ul>',
                ));
            }
            ?>
        </div>

    </div>
</div>