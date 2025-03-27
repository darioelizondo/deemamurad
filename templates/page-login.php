<?php

/**
 * Template Name: Login
 *
 * @package Darío Elizondo
 */

if ( isset($_POST['login']) ) {
    $username = sanitize_text_field( $_POST['username'] );
    $password = $_POST['password']; 
    $remember = isset($_POST['remember']) ? true : false;

    $creds = array(
        'user_login'    => $username,
        'user_password' => $password,
        'remember'      => $remember
    );

    $user = wp_signon( $creds, false );

    if ( !is_wp_error($user) ) {
        wp_redirect( wc_get_page_permalink('myaccount') );
        exit; // 🔥 IMPORTANTE: detiene la ejecución para evitar más salida de contenido
    } else {
        $login_error = $user->get_error_message();
    }
}

get_header();

?>

<div class="login-form">
    <div class="login-form__inner container">
        <!-- Form -->
        <div class="login-form__wrapper-form">
            <div class="login-form__inner-form">
                <?php if ( is_user_logged_in() ) : ?>
                    <div class="login-form__already-logged">
                        <p class="login-form__already-logged-text">
                            <span>You are already logged in.</span>
                            <a href="<?php echo esc_url( wc_get_page_permalink('myaccount') ); ?>">Go to my account</a>
                        </p>
                    </div>
                <?php else : ?>
                    <div class="login-form__wrapper-title">
                        <h2 class="login-form__title">Login</h2>
                    </div>

                    <?php if ( !empty($login_error) ) : ?>
                        <div class="login-form__error">
                            <p style="color: red;"><?php echo $login_error; ?></p>
                        </div>
                    <?php endif; ?>

                    <form class="login-form__form" method="post">
                        <div class="login-form__wrapper-input">
                            <input type="text" name="username" id="username" placeholder="Username or Email*" required>
                        </div>

                        <div class="login-form__wrapper-input">
                            <input type="password" name="password" id="password" placeholder="Password*" required>
                        </div>

                        <div class="login-form__wrapper-input">
                            <label>
                                <input type="checkbox" name="remember"> Remember me
                            </label>
                        </div>

                        <div class="login-form__wrapper-input">
                            <input class="login-form__submit" type="submit" name="login" value="Sign in">
                        </div>
                    </form>

                    <div class="login-form__forgot-password">
                        <a href="<?php echo wp_lostpassword_url(); ?>">Forgot your password?</a>
                    </div>

                    <div class="login-form__no-account">
                        <div class="login-form__no-account-inner">
                            <span class="login-form__no-account-text">No account yet?</span>
                            <a class="login-form__create-account" href="<?php echo get_site_url() . '/register/'; ?>">
                                Create an account
                            </a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Image -->
        <div class="login-form__wrapper-image">
            <picture class="login-form__picture">
                <source srcset="<?php echo TDU . '/assets/images/login/login-image-desktop.jpg'; ?>" media="(min-width: 768px)">
                <img class="login-form__image image--fluid" src="<?php echo TDU . '/assets/images/login/login-image-mobile-v2.jpg'; ?>" alt="Login Deema Murad">
            </picture>
        </div>
    </div>
</div>

<?php get_footer(); ?>