<?php
$cards = get_sub_field('cards');
if (empty($cards)) return;
?>

<section class="card-section py-24 bg-white">
  <div class="container mx-auto px-4">
    <div class="card-grid grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
      <?php foreach ($cards as $index => $card):
        $bg_url = '';
        if (is_array($card['card_background'])) {
          $bg_url = $card['card_background']['url'] ?? '';
        } elseif (is_numeric($card['card_background'])) {
          $bg_url = wp_get_attachment_url($card['card_background']);
        }

        $link = get_sub_field('card_link') ?: $card['card_link'] ?? null;
        $link_url = $link['url'] ?? '';
        $link_target = $link['target'] ?? '_self';
        $aria_label = $link['title'] ? esc_attr($link['title']) : 'View details';
      ?>

        <?php if ($link_url): ?>
          <a href="<?php echo esc_url($link_url); ?>"
             target="<?php echo esc_attr($link_target); ?>"
             aria-label="<?php echo $aria_label; ?>"
             class="card group block rounded-xl shadow-lg overflow-hidden relative text-white p-6 h-[300px] flex flex-col justify-end bg-cover bg-center no-underline"
             style="background-image: url('<?php echo esc_url($bg_url); ?>');">
             
            <!-- Text content bottom-left -->
            <div class="z-10">
              <h3 class="text-2xl font-bold mb-2 drop-shadow-lg"><?php echo esc_html($card['card_title']); ?></h3>
              <p class="text-md drop-shadow-lg"><?php echo esc_html($card['card_subtitle']); ?></p>
            </div>

            <!-- Arrow vertically centered on right -->
            <div class="absolute top-1/2 right-6 transform -translate-y-1/2 pointer-events-none">
              <svg class="arrow w-6 h-10 text-white transition-transform duration-300 group-hover:translate-x-1"
                   viewBox="0 0 24 24" fill="none" stroke="currentColor"
                   stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                   aria-hidden="true">
                <path d="M9 6l6 6-6 6" />
              </svg>
            </div>

            <!-- Hover background overlay -->
            <div class="pointer-events-none absolute inset-0 bg-black bg-opacity-20 opacity-0 transition-opacity duration-300 group-hover:opacity-10 rounded-xl"></div>
          </a>
        <?php else: ?>
          <div class="card rounded-xl shadow-lg overflow-hidden relative text-white p-6 h-[300px] flex flex-col justify-end bg-cover bg-center"
               style="background-image: url('<?php echo esc_url($bg_url); ?>');">
            <h3 class="text-2xl font-bold mb-2 drop-shadow-lg"><?php echo esc_html($card['card_title']); ?></h3>
            <p class="text-md drop-shadow-lg"><?php echo esc_html($card['card_subtitle']); ?></p>
          </div>
        <?php endif; ?>

      <?php endforeach; ?>
    </div>
  </div>
</section>
