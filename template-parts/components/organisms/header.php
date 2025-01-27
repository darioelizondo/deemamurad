<?php

    /**
     * Component: Organism: Header
     * 
     * @package Darío Elizondo
     * 
     */

     wp_enqueue_script( 'complacer.header' );

?>

<!-- Header -->
<header class="header">
   <div class="header__inner container">
        <!-- Left -->
        <div class="header__left">
            <!-- Logo -->
            <div class="header__wrapper-logo">
                <?php include TD . '/template-parts/components/atoms/logo.php'; ?> 
            </div>
        </div>
        <!-- Center -->
        <div class="header__center">
            <!-- Menu -->
            <div class="header__wrapper-menu">
                <?php include TD . '/template-parts/components/molecules/menu.php'; ?>
            </div>
            <!-- Currency -->
            <div class="header__wrapper-currency">
                <?php include TD . '/template-parts/components/atoms/currency.php'; ?>
            </div>
            <!-- Account -->
            <div class="header__wrapper-account">
                <?php include TD . '/template-parts/components/atoms/account.php'; ?>
            </div>
        </div>
        <!-- Right -->
        <div class="header__right">
            <!-- Hamburger Icon -->
            <div class="header__wrapper-hamburger-icon">
                <?php include TD . '/template-parts/components/atoms/hamburger-icon.php'; ?>
            </div>
            <!-- Cart header -->
            <div class="header__wrapper-cart-header">
                <?php do_action( 'deemamurad_header_cart' ); ?>
            </div>
        </div>
    </div>

   <!-- Messages -->
   <?php // include TD . '/template-parts/components/atoms/success-message.php'; ?>
   <?php // include TD . '/template-parts/components/atoms/error-message.php'; ?>

</header>