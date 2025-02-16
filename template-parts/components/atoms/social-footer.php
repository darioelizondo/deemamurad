<?php

    /**
     * Component: Atom: Social footer
     * 
     * @package Darío Elizondo
     * 
     */

    $social_footer = get_field( 'social_footer', 'option' );

?>

<!-- Social footer -->
<div class="social-footer">
    <div class="social-footer__inner">
        <!-- Links -->
        <?php if( $social_footer[ 'links' ] ) : ?>
            <div class="social-footer__wrapper-links">
                <?php foreach( $social_footer[ 'links' ] as $nlink => $item ) : ?>
                    <a id="<?php echo 'link-' . $nlink; ?>" class="social-footer__link" href="<?php echo esc_attr( $item[ 'link' ][ 'url' ] ); ?>" target="<?php echo $item[ 'link' ][ 'target' ] ? $item[ 'link' ][ 'target' ] : '_self'; ?>">
                        <?php echo esc_html( $item[ 'link' ][ 'title' ] ); ?>
                    </a>
                <?php endforeach; ?>
            </div>       
        <?php endif; ?>
        <!-- Get in touch -->
        <?php if( $social_footer[ 'get_in_touch' ] ) : ?>
            <div class="social-footer__wrapper-get-in-touch">
                <a class="social-footer__get-in-touch" href="<?php echo esc_attr( $social_footer[ 'get_in_touch' ][ 'url' ] ) ?>" target="<?php echo $link[ 'target' ] ? $link[ 'target' ] : '_self'; ?>">
                    <?php echo esc_html( $social_footer[ 'get_in_touch' ][ 'title' ] ) ?>
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>
<!-- End social footer -->