<?php

    /**
     * Function: Menus
     * 
     * @package Darío Elizondo
     * 
     */

    add_action( 'init', 'deemamurad_add_menus' );

    function deemamurad_add_menus() {
        register_nav_menus( array(
            'main_menu'         => __( 'Main Menu' ),
        ) );
    }