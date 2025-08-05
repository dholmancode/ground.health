<?php
$title = get_sub_field('title');

$cta_1 = get_sub_field('cta_1'); // Link array
$cta_1_desc = get_sub_field('cta_1_description');

$cta_2 = get_sub_field('cta_2');
$cta_2_desc = get_sub_field('cta_2_description');

$cta_3 = get_sub_field('cta_3');
$cta_3_desc = get_sub_field('cta_3_description');

$bg_images = get_sub_field('background_images'); // repeater field for background images
?>

<div class="home-animation w-[100vw] h-[100vh] justify-center items-center flex flex-col">
  <div class="home-logo-wrapper">
    <img src="<?php echo get_template_directory_uri(); ?>/images/DGH_Elipse.svg"
         alt="Ellipse"
         class="home-logo-ellipse" />
    <img src="<?php echo get_template_directory_uri(); ?>/images/DGH_Tri.svg"
         alt="Triangle Logo"
         class="home-logo-triangle" />
  </div>
</div>

<section class="relative h-[100vh] text-white flex items-center justify-center text-center transition duration-[1500ms] overflow-hidden">
  <!-- Background Slideshow -->
  <div id="bg-slideshow" class="absolute inset-0 -z-10">
    <?php if ($bg_images): ?>
      <?php foreach ($bg_images as $index => $bg): 
        $img_url = esc_url($bg['image']['url'] ?? '');
        $active_class = $index === 0 ? 'opacity-100' : 'opacity-0';
      ?>
        <div 
          class="bg-slide absolute inset-0 bg-center bg-cover bg-no-repeat transition-opacity duration-[1500ms] ease-in-out <?php echo $active_class; ?>"
          style="background-image: url('<?php echo $img_url; ?>');"
          data-index="<?php echo $index; ?>"
        ></div>
      <?php endforeach; ?>
    <?php endif; ?>
    <div class="absolute inset-0 bg-black bg-opacity-40 pointer-events-none"></div>
  </div>

  <!-- Hero Content -->
  <div class="zoom-in animate-in container dgh-hero-cta mx-auto px-4 relative z-10 max-w-4xl">
    <?php if ($title): ?>
      <h1 class="text-4xl md:text-6xl font-extrabold mb-10 drop-shadow-lg"><?php echo esc_html($title); ?></h1>
    <?php endif; ?>

    <!-- CTA Buttons -->
    <div class="flex flex-col md:flex-row justify-center items-center gap-8">
      <?php foreach ([
        ['link' => $cta_1, 'desc' => $cta_1_desc],
        ['link' => $cta_2, 'desc' => $cta_2_desc],
        ['link' => $cta_3, 'desc' => $cta_3_desc]
      ] as $cta): ?>
        <?php if (!empty($cta['link'])): ?>
          <div class="max-w-xs text-center">
            <a
              href="<?php echo esc_url($cta['link']['url']); ?>"
              target="<?php echo esc_attr($cta['link']['target'] ?? '_self'); ?>"
              rel="<?php echo $cta['link']['target'] === '_blank' ? 'noopener noreferrer' : ''; ?>"
              class="inline-block px-6 py-3 border border-brand-accent rounded-full font-medium text-white bg-brand-dark
                     shadow-[0_4px_0_0_#E59C59]
                     hover:translate-y-[2px] hover:shadow-[0_2px_0_0_#E59C59] hover:text-brand-accent
                     active:translate-y-[3px] active:shadow-none
                     transition-all duration-150 ease-in-out no-underline"
            >
              <?php echo esc_html($cta['link']['title']); ?>
            </a>
            <?php if (!empty($cta['desc'])): ?>
              <p class="m-5 text-sm text-white-300"><?php echo esc_html($cta['desc']); ?></p>
            <?php endif; ?>
          </div>
        <?php endif; ?>
      <?php endforeach; ?>
    </div>
  </div>
</section>
