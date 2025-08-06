<?php
$hero_type     = get_sub_field('hero_type');
$background    = get_sub_field('background_image');
$overlay_color = get_sub_field('hero_overlay');
$button_1      = get_sub_field('button_1_link');
$button_2      = get_sub_field('button_2_link');

// Background image URL
$background_url = '';
if (is_array($background)) {
  $background_url = $background['url'] ?? '';
} elseif (is_numeric($background)) {
  $background_url = wp_get_attachment_url($background);
}

// Button colors
$button_1_bg   = get_sub_field('button_1_bg_color') ?: '#fff';
$button_1_text = get_sub_field('button_1_text_color') ?: '#000';
$button_2_bg   = get_sub_field('button_2_bg_color') ?: '#ddd';
$button_2_text = get_sub_field('button_2_text_color') ?: '#000';

if ($hero_type === 'basic') {
  $title          = get_sub_field('title');
  $subtitle       = get_sub_field('subtitle');
  $h1_color       = get_sub_field('h1_color') ?: '#fff';
  $subtitle_color = get_sub_field('subtitle_color') ?: '#eee';
}

if ($hero_type === 'cta') {
  $cta_content = get_sub_field('cta_content');
  $cta_image   = get_sub_field('cta_image');

  if (is_array($cta_image)) {
    $cta_image_url = $cta_image['url'] ?? '';
    $cta_image_alt = $cta_image['alt'] ?? '';
  } elseif (is_numeric($cta_image)) {
    $cta_image_url = wp_get_attachment_url($cta_image);
    $cta_image_alt = get_post_meta($cta_image, '_wp_attachment_image_alt', true);
  }
}
?>

<section class="zoom-in relative bg-cover bg-center lg:h-[800px] py-40 md:py-40 flex items-center" style="background-image: url('<?php echo esc_url($background_url); ?>');">  <?php if ($overlay_color): ?>
    <div class="absolute inset-0" style="background-color: <?php echo esc_attr($overlay_color); ?>; opacity: 0.5; pointer-events: none;"></div>
  <?php endif; ?>

  <div class="relative container pt-[100px] mx-auto px-4 max-w-5xl">
    <?php if ($hero_type === 'basic'): ?>
      <div class="text-center">
        <?php if (!empty($title)): ?>
          <h1 class="font-extrabold mb-4 text-4xl md:text-5xl lg:text-6xl" style="color: <?php echo esc_attr($h1_color); ?>;">
            <?php echo esc_html($title); ?>
          </h1>
        <?php endif; ?>

        <?php if (!empty($subtitle)): ?>
          <p class="text-lg md:text-xl mb-6" style="color: <?php echo esc_attr($subtitle_color); ?>;">
            <?php echo esc_html($subtitle); ?>
          </p>
        <?php endif; ?>

        <div class="mt-4 space-x-4">
          <?php if (!empty($button_1)): ?>
            <a href="<?php echo esc_url($button_1['url']); ?>"
               class="inline-block px-6 py-3 rounded-full font-semibold text-lg transition duration-300 hover:opacity-90"
               target="<?php echo esc_attr($button_1['target'] ?? '_self'); ?>"
               style="background-color: <?php echo esc_attr($button_1_bg); ?>; color: <?php echo esc_attr($button_1_text); ?>;">
              <?php echo esc_html($button_1['title']); ?>
            </a>
          <?php endif; ?>
          <?php if (!empty($button_2)): ?>
            <a href="<?php echo esc_url($button_2['url']); ?>"
               class="inline-block px-6 py-3 rounded-full font-semibold text-lg transition duration-300 hover:opacity-90"
               target="<?php echo esc_attr($button_2['target'] ?? '_self'); ?>"
               style="background-color: <?php echo esc_attr($button_2_bg); ?>; color: <?php echo esc_attr($button_2_text); ?>;">
              <?php echo esc_html($button_2['title']); ?>
            </a>
          <?php endif; ?>
        </div>
      </div>

    <?php elseif ($hero_type === 'cta'): ?>
      <div class="flex flex-col md:flex-row items-center gap-8">
        <!-- Mobile: image with overlayed content -->
        <div class="w-full relative md:hidden">
          <?php if (!empty($cta_image_url)): ?>
            <img src="<?php echo esc_url($cta_image_url); ?>"
                 alt="<?php echo esc_attr($cta_image_alt); ?>"
                 class="w-full h-[500px] object-cover rounded shadow-lg" />
          <?php endif; ?>
          <div class="absolute inset-0 flex flex-col justify-center items-center text-center px-4 rounded-full">
            <div class="prose prose-lg prose-invert max-w-none">
              <?php echo wp_kses_post($cta_content); ?>
            </div>
            <div class="mt-4 space-x-4">
              <?php if (!empty($button_1)): ?>
                <a href="<?php echo esc_url($button_1['url']); ?>"
                   class="inline-block px-6 py-2 rounded-full font-semibold btn"
                   target="<?php echo esc_attr($button_1['target'] ?? '_self'); ?>"
                   style="background-color: <?php echo esc_attr($button_1_bg); ?>; color: <?php echo esc_attr($button_1_text); ?>;">
                  <?php echo esc_html($button_1['title']); ?>
                </a>
              <?php endif; ?>
              <?php if (!empty($button_2)): ?>
                <a href="<?php echo esc_url($button_2['url']); ?>"
                   class="inline-block px-6 py-2 rounded-full font-semibold btn"
                   target="<?php echo esc_attr($button_2['target'] ?? '_self'); ?>"
                   style="background-color: <?php echo esc_attr($button_2_bg); ?>; color: <?php echo esc_attr($button_2_text); ?>;">
                  <?php echo esc_html($button_2['title']); ?>
                </a>
              <?php endif; ?>
            </div>
          </div>
        </div>

        <!-- Desktop: content left, image right -->
        <div class="hidden md:block md:w-1/2 prose prose-lg prose-invert max-w-none">
          <?php echo wp_kses_post($cta_content); ?>
          <div class="mt-4 space-x-4">
            <?php if (!empty($button_1)): ?>
              <a href="<?php echo esc_url($button_1['url']); ?>"
                 class="inline-block px-6 py-2 rounded-full font-semibold btn"
                 target="<?php echo esc_attr($button_1['target'] ?? '_self'); ?>"
                 style="background-color: <?php echo esc_attr($button_1_bg); ?>; color: <?php echo esc_attr($button_1_text); ?>;">
                <?php echo esc_html($button_1['title']); ?>
              </a>
            <?php endif; ?>
            <?php if (!empty($button_2)): ?>
              <a href="<?php echo esc_url($button_2['url']); ?>"
                 class="inline-block px-6 py-2 rounded-full font-semibold btn"
                 target="<?php echo esc_attr($button_2['target'] ?? '_self'); ?>"
                 style="background-color: <?php echo esc_attr($button_2_bg); ?>; color: <?php echo esc_attr($button_2_text); ?>;">
                <?php echo esc_html($button_2['title']); ?>
              </a>
            <?php endif; ?>
          </div>
        </div>

        <div class="hidden md:block md:w-3/4">
          <?php if (!empty($cta_image_url)): ?>
            <img src="<?php echo esc_url($cta_image_url); ?>"
                 alt="<?php echo esc_attr($cta_image_alt); ?>"
                 class="w-full rounded shadow-lg" />
          <?php endif; ?>
        </div>
      </div>
    <?php endif; ?>
  </div>
</section>
