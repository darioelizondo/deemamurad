<?php

    /**
     * Component: Atom: Language Switcher
     * 
     * @package Darío Elizondo
     * 
     */

?>

<!-- Language Switcher -->
<div class="language-switcher">
    <?php if (shortcode_exists('gtranslate')) echo do_shortcode('[gtranslate]'); ?>

    <?php 
        $array = trp_custom_language_switcher();  
        $current_lang = substr( get_locale(), 0, 2 );
    ?>

    <ul class="language-switcher__list" data-no-translation>
        <?php if (apply_filters('trp_allow_tp_to_run', true)) : ?>
            <?php $count = 0; ?>
            <?php foreach ($array as $name => $item) : ?>
                <?php 
                    $active_class = ($current_lang === $item['short_language_name']) ? 'active' : '';
                ?>
                <li class="language-switcher__item"> 
                    <a class="language-switcher__link <?php echo esc_attr($active_class); ?>" href="<?php echo esc_url($item['current_page_url']); ?>"> 
                        <span class="language-switcher__span">
                            <?php echo esc_html($item['short_language_name']); ?>
                        </span>
                    </a>
                </li>
                <?php if ($count === 0) : ?>
                    <p class="language-switcher__separator">/</p>
                <?php endif; ?>
                <?php $count++; ?>
            <?php endforeach; ?>
        <?php endif; ?>
    </ul>
</div>
