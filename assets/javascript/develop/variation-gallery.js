jQuery(document).ready(function ($) {
    var mainImageContainer = jQuery('.woocommerce-product-gallery__wrapper');

    jQuery('form.variations_form').on('change', 'select', function () {
        setTimeout(function () {
            var selectedVariation = jQuery('input.variation_id').val();
            if (selectedVariation && variationGalleryData[selectedVariation]) {
                var images = variationGalleryData[selectedVariation];

                mainImageContainer.empty(); // Vaciar galería actual
                images.forEach(function (imageId) {
                    var imageUrl = wp.media.attachment(imageId).attributes.url;
                    mainImageContainer.append('<div class="woocommerce-product-gallery__image"><img src="' + imageUrl + '" /></div>');
                });
            }
        }, 500);
    });
});

jQuery(document).ready(function ($) {
    jQuery(document).on('click', '.upload_variation_gallery', function (e) {
        e.preventDefault();

        // Obtén el botón que fue clickeado
        let button = jQuery(this);

        // Encuentra el input y la vista previa asociados con este botón
        let galleryInput = button.siblings('.variation_gallery_ids');
        let galleryPreview = button.siblings('.variation-gallery-preview');

        // Abre la biblioteca de medios
        let frame = wp.media({
            title: 'Seleccionar imágenes',
            button: { text: 'Usar estas imágenes' },
            multiple: true
        });

        // Cuando se seleccionen imágenes
        frame.on('select', function () {
            let selection = frame.state().get('selection');
            let imageIds = [];

            galleryPreview.empty(); // Limpiar la vista previa antes de agregar nuevas imágenes

            // Itera sobre las imágenes seleccionadas
            selection.each(function (attachment) {
                imageIds.push(attachment.id); // Guarda el ID de cada imagen
                let imgUrl = attachment.attributes.sizes.thumbnail.url;

                // Añade una miniatura de la imagen seleccionada a la vista previa
                galleryPreview.append('<li style="display:inline-block; margin-right:10px;"><img src="' + imgUrl + '" width="50" height="50" /></li>');
            });

            // Actualiza el campo de entrada con los IDs de las imágenes seleccionadas
            galleryInput.val(imageIds.join(','));
        });

        // Abre la ventana de medios
        frame.open();
    });
});