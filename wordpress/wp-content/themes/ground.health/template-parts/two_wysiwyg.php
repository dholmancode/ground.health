<?php
$content_left = get_sub_field('content_left');
$content_right = get_sub_field('content_right');
?>

<section class="container mx-auto px-4 py-16 flex flex-col md:flex-row gap-12">
  <div class="md:w-1/2 prose text-white max-w-none">
    <?php echo wp_kses_post($content_left); ?>
  </div>

  <div class="md:w-1/2 prose text-white max-w-none">
    <?php echo wp_kses_post($content_right); ?>
  </div>
</section>
