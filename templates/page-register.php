<?php

    /**
     * Template Name: Register
     *
     * @package Darío Elizondo
     */

    get_header();

    ?>

    <div class="register-form">
        <div class="register-form__inner container">
            <!-- Form -->
            <div class="register-form__wrapper-form">
                <div class="register-form__inner-form">
                    <?php
                        if ( is_user_logged_in() ) {
                            echo '<div class="register-form__already-logged"><p class="register-form__already-logged-text"><span>You are already logged in.</span> <a href="'. esc_url( wc_get_page_permalink( 'myaccount' ) ) .'">Go to my account</a></p></div>';
                        } else {
                            ?>
                                <div class="register-form__wrapper-title">
                                    <h2 class="register-form__title">Create account</h2>
                                </div>

                                <?php wc_print_notices(); // Show error if exist ?>

                                <form class="register-form__form" method="post" action="">
                                    <?php wp_nonce_field( 'custom_register_action', 'custom_register_nonce' ); ?>

                                    <div class="register-form__wrapper-input">
                                        <input type="text" name="first_name" id="first_name" placeholder="First name*" required>
                                    </div>

                                    <div class="register-form__wrapper-input">
                                        <input type="text" name="last_name" id="last_name" placeholder="Last name*" required>
                                    </div>

                                    <div class="register-form__wrapper-input">
                                        <input type="email" name="email" id="email" placeholder="E-mail*" required>
                                    </div>

                                    <div class="register-form__wrapper-input">
                                        <input type="password" name="password" id="password" placeholder="Password*" required>
                                    </div>

                                    <div class="register-form__wrapper-input">
                                        <input type="password" name="password_confirm" id="password_confirm" placeholder="Confirm password*" required>
                                    </div>

                                    <div class="register-form__wrapper-input">
                                        <input class="register-form__submit" type="submit" name="register" value="Registrarse">
                                    </div>
                                </form>
                                <div class="register-form__no-account">
                                    <div class="register-form__no-account-inner">
                                        <span class="register-form__no-account-text">
                                            You already have an account?
                                        </span>
                                        <a class="register-form__create-account" href="<?php echo get_site_url() . '/login/'; ?>">
                                            Log in here
                                        </a>
                                    </div>
                                </div>
                            <?php
                        }
                    ?>
                </div>
            </div>
            <!-- Image -->
             <div class="register-form__wrapper-image">
                <picture class="register-form__picture">
                    <source srcset="<?php echo TDU . '/assets/images/login/login-image-desktop.jpg'; ?>" media="(min-width: 768px)">
                    <img class="register-form__image image--fluid" src="<?php echo TDU . '/assets/images/login/login-image-mobile.jpg'; ?>" alt="Login Deema Murad" >
                </picture>
             </div>
        </div>
    </div>

    <?php

    get_footer();
