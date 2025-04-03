<?php

    /**
     * Component: Organism: Footer
     * 
     * @package Darío Elizondo
     * 
     */

    $footer = get_field( 'footer', 'option' );

?>

<?php
    // Cart popup
    wp_enqueue_script( 'deemamurad.cart-popup' );
    include TD . '/template-parts/components/molecules/cart-popup.php';
?>


<!-- Footer -->
<footer class="footer <?php if( !is_front_page() ) echo 'footer--with-line'; ?>">
    <!-- Footer top -->
    <div class="footer__inner container">
        <!-- Logo -->
        <div class="footer__wrapper-logo">
            <?php include TD . '/template-parts/components/atoms/logo-footer.php'; ?>
            <?php include TD . '/template-parts/components/atoms/currency-switcher.php'; ?>
        </div>
        <!-- Footer menu -->
        <div class="footer__wrapper-menu">
            <?php include TD . '/template-parts/components/molecules/menu-footer.php'; ?>
        </div>
        <!-- Form & social -->
        <div class="footer__wrapper-form-and-social">
            <?php
                include TD . '/template-parts/components/atoms/subscription-form.php';
                include TD . '/template-parts/components/atoms/social-footer.php';
            ?>
        </div>
    </div>
    <!-- Footer bottom -->
    <div class="footer__footer-bottom">
        <div class="footer__footer-bottom-inner container">
            <!-- Copyright -->
            <p class="footer__copyright">
                <?php echo esc_html( $footer[ 'copyright' ] ); ?>
            </p>
        </div>
    </div>
</footer>
<!-- End footer -->