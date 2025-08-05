<?php

function mytheme_enqueue_scripts() {
  // Enqueue main theme JavaScript
  wp_enqueue_script(
    'mytheme-theme-js',
    get_template_directory_uri() . '/assets/js/theme.js',
    array(),
    filemtime(get_template_directory() . '/assets/js/theme.js'),
    true
  );

  wp_enqueue_script(
    'mytheme-portfolio-js',
    get_template_directory_uri() . '/assets/js/portfolio.js',
    array(),
    filemtime(get_template_directory() . '/assets/js/portfolio.js'),
    true
  );

  wp_enqueue_script(
    'mytheme-photo-js',
    get_template_directory_uri() . '/assets/js/photo.js',
    array(),
    filemtime(get_template_directory() . '/assets/js/photo.js'),
    true
  );

  // Enqueue photo.css
  wp_enqueue_style(
    'mytheme-photo-css',
    get_template_directory_uri() . '/assets/css/photo.css',
    array(),
    filemtime(get_template_directory() . '/assets/css/photo.css')
  );

  // Enqueue animate.css
  wp_enqueue_style(
    'mytheme-animate-css',
    get_template_directory_uri() . '/assets/css/animate.css',
    array(),
    filemtime(get_template_directory() . '/assets/css/animate.css')
  );
}
add_action('wp_enqueue_scripts', 'mytheme_enqueue_scripts');

function enqueue_hero_scripts() {
  wp_enqueue_script('dgh-hero-js', get_template_directory_uri() . '/assets/js/dgh-hero.js', [], '1.0', true);
}
add_action('wp_enqueue_scripts', 'enqueue_hero_scripts');

function traveltools_enqueue_styles() {
  error_log('Enqueue function ran!');
  wp_enqueue_style(
    'traveltools-style',
    get_template_directory_uri() . '/dist/style.css',
    array(),
    filemtime(get_template_directory() . '/dist/style.css')
  );
}
add_action('wp_enqueue_scripts', 'traveltools_enqueue_styles');

function traveltools_register_menus() {
  register_nav_menus([
    'primary' => __('Primary Menu', 'traveltools'),
    'footer' => __('Footer Menu', 'traveltools'),
  ]);
}
add_action('after_setup_theme', 'traveltools_register_menus');

if( function_exists('acf_add_options_page') ) {
  acf_add_options_page(array(
    'page_title'    => 'Theme Options',
    'menu_title'    => 'Theme Options',
    'menu_slug'     => 'theme-options',
    'capability'    => 'edit_posts',
    'redirect'      => false
  ));
}

function register_theme_menus() {
  register_nav_menus([
    'primary' => __('Main Menu', 'your-theme'),
    'footer'  => __('Footer Menu', 'your-theme'),
  ]);
}
add_action('after_setup_theme', 'register_theme_menus');

function add_tinymce_color_buttons($buttons) {
  // Add the forecolor (text color) and backcolor (background color) buttons
  array_push($buttons, 'forecolor', 'backcolor');
  return $buttons;
}
add_filter('mce_buttons_2', 'add_tinymce_color_buttons');