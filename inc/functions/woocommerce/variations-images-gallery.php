<?php

    /**
     * Function: Variations images gallery
     * 
     * @package Darío Elizondo
     * 
     */


add_action('woocommerce_variation_options', 'deemamurad_variation_gallery_fields', 10, 3);

function deemamurad_variation_gallery_fields($loop, $variation_data, $variation) {
    ?>
    <div class="variation-custom-gallery">
        <p class="form-row form-row-full">
            <label><?php esc_html_e('Images gallery', 'woocommerce'); ?></label>
            <input type="hidden" class="variation_gallery_ids" name="variation_gallery[<?php echo $variation->ID; ?>]" value="<?php echo get_post_meta($variation->ID, '_variation_gallery', true); ?>" />
            <button type="button" class="button upload_variation_gallery"><?php esc_html_e('Subir imágenes', 'woocommerce'); ?></button>
            <ul class="variation-gallery-preview">
                <?php
                $gallery_ids = get_post_meta($variation->ID, '_variation_gallery', true);
                if (!empty($gallery_ids)) {
                    $gallery_ids = explode(',', $gallery_ids);
                    foreach ($gallery_ids as $image_id) {
                        echo '<li style="display:inline-block; margin-right:10px;">' . wp_get_attachment_image($image_id, 'thumbnail') . '</li>';
                    }
                }
                ?>
            </ul>
        </p>
    </div>
    <?php
}

add_action('woocommerce_save_product_variation', 'save_variation_gallery_images', 10, 2);

function save_variation_gallery_images($variation_id, $i) {
    if (isset($_POST['variation_gallery'][$variation_id])) {
        update_post_meta($variation_id, '_variation_gallery', sanitize_text_field($_POST['variation_gallery'][$variation_id]));
    }
}

add_action('admin_enqueue_scripts', 'enqueue_custom_variation_gallery_script');

function enqueue_custom_variation_gallery_script($hook) {
    if ($hook === 'post.php' || $hook === 'post-new.php') { // Solo en la edición de productos
        wp_enqueue_media(); // Necesario para abrir la Biblioteca de Medios
        wp_enqueue_script('deemamurad-variation-gallery', get_template_directory_uri() . '/assets/javascript/production/variation-gallery.js', array('jquery'), filemtime(get_template_directory() . '/assets/javascript/production/variation-gallery.js'), true);
    }
}

add_action('woocommerce_before_single_product', 'output_variation_gallery_json');

function output_variation_gallery_json() {
    global $product;

    if ($product->is_type('variable')) {
        $variations = $product->get_available_variations();
        $variation_images = [];

        foreach ($variations as $variation) {
            $variation_id = $variation['variation_id'];
            $gallery_ids = get_post_meta($variation_id, '_variation_gallery', true);
            if (!empty($gallery_ids)) {
                $variation_images[$variation_id] = explode(',', $gallery_ids);
            }
        }

        echo '<script>var variationGalleryData = ' . json_encode($variation_images) . ';</script>';
    }
}