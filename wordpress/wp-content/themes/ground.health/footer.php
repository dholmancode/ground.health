<footer class="bg-gray-900 text-gray-400 py-8 mt-12">
  <div class="container mx-auto px-4 text-center">
    <nav class="mb-4">
      <?php
      wp_nav_menu([
        'theme_location' => 'footer',
        'menu_class'     => 'flex justify-center space-x-6 list-none',
        'container'      => false,
        'fallback_cb'    => false,
        'depth'          => 1,
      ]);
      ?>
    </nav>
  </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
