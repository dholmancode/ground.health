<?php
$title = get_sub_field('title');
$content = get_sub_field('content');
?>

<section class="container mx-auto px-4 py-16">
  <?php if ($title): ?>
    <h2 class="text-3xl font-semibold mb-6 text-white text-center">
      <?php echo esc_html($title); ?>
    </h2>
  <?php endif; ?>

  <?php if ($content): ?>
    <div class="prose max-w-3xl mx-auto text-white">
      <?php echo wp_kses_post($content); ?>
    </div>
  <?php endif; ?>
</section>
