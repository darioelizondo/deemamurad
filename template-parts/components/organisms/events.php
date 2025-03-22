<?php

    /**
     * Component: Organism: Events
     * 
     * @package Darío Elizondo
     * 
     */
    $group= get_sub_field( 'events' );

?>

<!-- Events -->
<div class="events module-<?php echo $module_count; ?>" style="padding-top: <?php echo $group[ 'padding_top' ]; ?>; padding-bottom: <?php echo $group[ 'padding_bottom' ]; ?>;">
    <div class="events__inner container">
        <!-- Title -->
        <div class="events__wrapper-title">
            <h2 class="events__title">
                <?php echo esc_html( $group[ 'title' ] ); ?>
            </h2>
        </div>
        <!-- Items -->
        <div class="events__wrapper-items">
            <?php foreach( $group[ 'items' ] as $nitem => $item ) : ?>
                <div class="events__item">
                    <div class="events__item-wrapper-title">
                        <h4 class="events__item-title">
                            <?php echo esc_html( $item[ 'item_title' ] ); ?>
                        </h4>
                    </div>
                    <div class="events__wrapper-item-content">
                        <p class="events__item-content">
                            <?php echo $item[ 'content' ]; ?>
                        </p>
                    </div>                 
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<!-- End events -->