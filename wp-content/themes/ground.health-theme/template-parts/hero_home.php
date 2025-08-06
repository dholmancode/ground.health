<?php
$cta_content = get_sub_field('cta_content');
$overlay_color = get_sub_field('hero_overlay');

// Buttons
$buttons = [];
for ($i = 1; $i <= 3; $i++) {
  $link = get_sub_field("button_{$i}_link");
  $bg = get_sub_field("button_{$i}_bg_color") ?: '#fff';
  $text = get_sub_field("button_{$i}_text_color") ?: '#000';

  if ($link) {
    $buttons[] = [
      'url' => $link['url'],
      'title' => $link['title'],
      'target' => $link['target'] ?? '_self',
      'bg' => $bg,
      'text' => $text,
    ];
  }
}
?>

<section class="zoom-in relative h-[850px] flex bg-black text-white py-32">
  <?php if ($overlay_color): ?>
    <div class="absolute inset-0" style="background-color: <?php echo esc_attr($overlay_color); ?>; opacity: 0.5; pointer-events: none;"></div>
  <?php endif; ?>

  <div class="pt-[230px] flex relative container mx-auto px-4 max-w-4xl text-center">
    <div class="prose prose-lg prose-invert mx-auto max-w-none">
      <?php echo wp_kses_post($cta_content); ?>
    </div>

    <div class="flex flex-col items-center gap-4">
      <?php foreach ($buttons as $btn): ?>
        <a href="<?php echo esc_url($btn['url']); ?>"
           target="<?php echo esc_attr($btn['target']); ?>"
           class="no-underline min-w-[100%] inline-block px-8 py-3 rounded font-semibold text-lg transition duration-300 hover:opacity-90"
           style="background-color: <?php echo esc_attr($btn['bg']); ?>; color: <?php echo esc_attr($btn['text']); ?>;">
          <?php echo esc_html($btn['title']); ?>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>
