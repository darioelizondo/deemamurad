<?php

    /**
     * Header
     * 
     * @package Darío Elizondo & Andra Estudio
     * 
     */

?>
    <!DOCTYPE HTML>
    <html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo( 'charset' ); ?>">
        <link href="<?php echo esc_attr( TDU ); ?>/favicon.ico" rel="shortcut icon">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Favicon -->
        <!-- <link rel="apple-touch-icon" sizes="180x180" href="<?php // echo TDU . '/assets/images/favicon/complacer'; ?>/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="<?php // echo TDU . '/assets/images/favicon/complacer'; ?>/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="<?php // echo TDU . '/assets/images/favicon/complacer'; ?>/favicon-16x16.png">
        <link rel="manifest" href="<?php // echo TDU . '/assets/images/favicon/complacer'; ?>/site.webmanifest"> -->

        <?php wp_head(); ?>
    </head>

    <?php include TD . '/template-parts/components/molecules/terms-and-conditions-popup.php'; ?>
    
    <body <?php body_class(); ?>>
        <main class="main">
            <?php include TD . '/template-parts/components/organisms/header.php'; ?>