<?php
/**
 * Menu Walker
 *
 * @package Dario Elizondo
 */

class DeemaMurad_Menu_Walker extends Walker_Nav_Menu {

    function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {

        // Get image placeholder
        $image = get_field( 'image_menu_item', $item->ID );

        // CSS class of the <li> element
        $classes = implode(" ", $item->classes);

        if( isset( $image ) && !empty( $image ) ) {
            $output .= "<li class='" . esc_attr( $classes ) . "' data-image='" . esc_url( $image ) . "'>";
        }
        else {
            $output .= "<li class='" . esc_attr( $classes ) . "'>";
        }

        // Determine if the item has children
        $has_children = !empty($args->walker->has_children);

        // Build the link
        $link_class = $has_children ? "menu__link menu__has-child" : "menu__link";
        $link_class_first_level = $has_children && $depth == 0 ? "menu__has-child--first-level" : "";
        $output .= '<a class="' . esc_attr($link_class). ' ' . esc_attr($link_class_first_level) . '" href="' . esc_url($item->url) . '" data-title="' . esc_attr($item->title) . '" target="' . esc_attr($item->target) . '">';

        // Additional content if it is top level
        // if ($depth == 0) {
        //     $output .= '<span class="menu__count"></span>';
        // }

        // Link title
        $output .= '<span class="menu__link-title">' . esc_html($item->title) . '</span>';

        if( $has_children && $depth == 1 ) {
            $output .= '<span class="menu__plus-minus-toggle collapsed"></span>';
        }

        // Close tag <a>
        $output .= '</a>';
    }

    function start_lvl( &$output, $depth = 0, $args = null ) {
		
		// Submenu from first level
		if ($depth == 0) {
			$output .= '<div class="wrapper-submenu">';
            $output .= '<ul class="submenu submenu--first-level">';
        }
		
		if ($depth != 0) {
			$output .= '<ul class="submenu submenu--second-level">';
		}
		
        
    }

    function end_lvl( &$output, $depth = 0, $args = null ) {
		
		if( $depth == 0 ) {
			$output .= '<div class="menu__wrapper-image-placeholder">
                            <img id="imagePlaceholder" class="menu__image-placeholder image--fluid" data-image="' . TDU . '/assets/images/menu/menu-item-generic.jpg' . '" src="' . TDU . '/assets/images/menu/menu-item-generic.jpg' . '" alt="Menu image">
                        </div>';
		}

        $output .= '</ul>';

		if ( $depth == 0 ) {
			$output .= '</div">';
        }
    }

    function end_el( &$output, $item, $depth = 0, $args = null ) {
        $output .= '</li>';
    }
}

// Walker for menu footer
class DeemaMurad_Menu_Walker_Footer extends Walker_Nav_Menu {

    function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {

        // CSS class of the <li> element
        $classes = implode(" ", $item->classes);

        $output .= "<li class='" . esc_attr( $classes ) . "'>";

        // Determine if the item has children
        $has_children = !empty($args->walker->has_children);

        // Build the link
        $link_class = $has_children ? "menu-footer__link menu-footer__has-child" : "menu-footer__link";
        $link_class_first_level = $has_children && $depth == 0 ? "menu-footer__has-child--first-level" : "";
        $output .= '<a class="' . esc_attr($link_class). ' ' . esc_attr($link_class_first_level) . '" href="' . esc_url($item->url) . '" data-title="' . esc_attr($item->title) . '" target="' . esc_attr($item->target) . '">';

        // Link title
        $output .= '<span class="menu-footer__link-title">' . esc_html($item->title) . '</span>';

        if( $has_children && $depth == 0 ) {
            $output .= '<span class="menu-footer__plus-minus-toggle collapsed"></span>';
        }

        // Close tag <a>
        $output .= '</a>';
    }

    function start_lvl( &$output, $depth = 0, $args = null ) {
		
		// Submenu from first level
		if ($depth == 0) {
			$output .= '<div class="footer__wrapper-submenu">';
            $output .= '<ul class="footer__submenu footer__submenu--first-level">';
        }
		
		if ($depth != 0) {
			$output .= '<ul class="footer__submenu footer__submenu--second-level">';
		}
        
    }

    function end_lvl( &$output, $depth = 0, $args = null ) {
		
        $output .= '</ul>';

		if ( $depth == 0 ) {
			$output .= '</div">';
        }
    }

    function end_el( &$output, $item, $depth = 0, $args = null ) {
        $output .= '</li>';
    }
}