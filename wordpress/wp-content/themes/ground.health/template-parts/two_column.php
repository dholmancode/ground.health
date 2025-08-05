<?php
$image = get_sub_field('image');
$title = get_sub_field('title');
$content = get_sub_field('content');
$image_on_right = get_sub_field('image_position'); // true or false

// Set dynamic order based on image position
$image_order_class = $image_on_right ? 'md:order-2' : 'md:order-1';
$text_order_class  = $image_on_right ? 'md:order-1' : 'md:order-2';
?>

<section class="zoom-in container mx-auto px-4 py-16 flex flex-col md:flex-row items-center gap-8">

  <?php if ($image): ?>
    <div class="md:w-1/2 <?php echo esc_attr($image_order_class); ?>">
      <img src="<?php echo esc_url($image['url']); ?>" 
           alt="<?php echo esc_attr($image['alt']); ?>" 
           class="rounded-lg shadow-lg w-full object-cover">
    </div>
  <?php endif; ?>

  <div class="md:w-1/2 <?php echo esc_attr($text_order_class); ?>">
    <?php if ($title): ?>
      <h2 class="text-3xl font-semibold text-white mb-4">
        <?php echo esc_html($title); ?>
      </h2>
    <?php endif; ?>

    <?php if ($content): ?>
      <div class="prose max-w-none text-white">
        <?php echo wp_kses_post($content); ?>
      </div>
    <?php endif; ?>
  </div>

</section>
