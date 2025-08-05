<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500&family=Montserrat:wght@500;600&family=Raleway:wght@400;500;600;700&display=swap" rel="stylesheet">
  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<header id="site-header" class="px-3 fixed left-0 w-full z-50 transition-all duration-500 bg-transparent">
  <div class="fade-in-up animate-in container mx-auto flex items-center justify-between p-6 transition-all duration-500 flex-wrap lg:flex-nowrap" id="header-inner">

    <!-- Site Logo -->
    <a href="<?php echo esc_url(home_url('/')); ?>" class="shrink-0">
      <?php 
      $custom_logo = get_field('site_logo', 'option');
      if ($custom_logo) {
        echo wp_get_attachment_image($custom_logo, 'full', false, [
          'id' => 'site-logo',
          'class' => 'h-auto transition-all duration-500 max-w-[120px] sm:max-w-[160px] lg:max-w-[200px]',
          'alt' => get_bloginfo('name')
        ]);
      } elseif (has_custom_logo()) {
        the_custom_logo();
      } else {
        bloginfo('name');
      }
      ?>
    </a>

    <!-- Hamburger Button -->
    <button id="mobile-menu-toggle" class="lg:hidden flex flex-col justify-center items-center space-y-2 z-50 relative w-8 h-8 focus:outline-none">
      <span id="bar1" class="block w-[30px] h-[2px] transition-all duration-300 origin-center transform"></span>
      <span id="bar2" class="block w-[30px] h-[2px] transition-all duration-300"></span>
      <span id="bar3" class="block w-[30px] h-[2px] transition-all duration-300 origin-center transform"></span>
    </button>

    <!-- Desktop Nav -->
    <nav class="main-nav shadow-lg hidden lg:flex">
      <?php
      wp_nav_menu([
        'theme_location' => 'primary',
        'menu_class'     => 'flex space-x-6 list-none',
        'container'      => false,
        'fallback_cb'    => false,
        'depth'          => 1,
      ]);
      ?>
    </nav>
  </div>

  <!-- Mobile Slide-In Menu -->
  <div id="mobile-menu" class="fixed top-0 left-0 w-[80%] max-w-md h-full bg-[#053332] transform -translate-x-full transition-transform duration-500 z-40 shadow-xl lg:hidden flex items-center justify-center">
  <nav class="p-6">
      <?php
      wp_nav_menu([
        'theme_location' => 'primary',
        'menu_class'     => 'flex flex-col space-y-4 list-none text-[90px]',
        'container'      => false,
        'fallback_cb'    => false,
        'depth'          => 1,
      ]);
      ?>
    </nav>
  </div>
</header>
