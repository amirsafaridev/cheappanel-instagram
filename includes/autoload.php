<?php

add_action('init', 'arta_cheappanel_register_style_and_scripts');
function arta_cheappanel_register_style_and_scripts()
{
    wp_register_script('arta_cheappanel_jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js', array('jquery'), '3.6.0', true);
    wp_register_script('arta_cheappanel_scripts', plugin_dir_url(__DIR__) . 'assets/js/scripts.js', array('jquery'), time(), true);
    wp_register_style('arta_cheappanel_styles', plugin_dir_url(__DIR__) . 'assets/css/styles.css', false, time(), 'all');
    wp_register_script('arta_select2_scripts', plugin_dir_url(__DIR__) . 'assets/js/select2.js', array('jquery'), time(), true);
    wp_register_style('arta_select2_styles', plugin_dir_url(__DIR__) . 'assets/css/select2.css', false, time(), 'all');

}


add_action('wp_enqueue_scripts', 'arta_cheappanel_enqueue_scripts');
function arta_cheappanel_enqueue_scripts()
{
    //javascript
    wp_enqueue_script('arta_cheappanel_jquery');
    wp_enqueue_script('arta_cheappanel_scripts');
    wp_enqueue_script('arta_select2_scripts');
    wp_enqueue_style('arta_select2_styles');

    wp_localize_script('arta_cheappanel_scripts', 'arta_cheappanel_object',
        array(
            'ajaxurl' => admin_url('admin-ajax.php'),
        )
    );

    //css
    wp_enqueue_style('arta_cheappanel_styles');

}


add_action('admin_enqueue_scripts', 'arta_cheappanel_enqueue_admin');
function arta_cheappanel_enqueue_admin()
{
    //wp_register_script('arta_cheappanel_jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js', array('jquery'), '3.6.0', true);
    wp_register_script('arta_cheappanel_scripts', plugin_dir_url(__DIR__) . 'assets/js/scripts.js', array('jquery'), time(), true);
    wp_register_script('arta_select2_scripts', plugin_dir_url(__DIR__) . 'assets/js/select2.js', array('jquery'), time(), true);
    wp_register_style('arta_select2_styles', plugin_dir_url(__DIR__) . 'assets/css/select2.css', false, time(), 'all');

    //wp_enqueue_script('arta_cheappanel_jquery');
    wp_enqueue_script('arta_cheappanel_scripts');
    wp_enqueue_script('arta_select2_scripts');
    wp_enqueue_style('arta_select2_styles');

    wp_localize_script('arta_cheappanel_scripts', 'arta_cheappanel_object',
        array(
            'ajaxurl' => admin_url('admin-ajax.php'),
        )
    );

}

