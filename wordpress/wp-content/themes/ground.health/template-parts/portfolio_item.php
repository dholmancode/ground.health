<?php
// ACF layout: portfolio_item inside flexible content: page_builder_sections

$project_title   = get_sub_field('project_title');
$project_date    = get_sub_field('project_date');
$project_tools   = get_sub_field('project_tools');
$project_image   = get_sub_field('project_image');
$initial_image_url = $project_image['url'] ?? '';
$initial_image_alt = $project_image['alt'] ?? '';

// Collect project details for rendering and JS
$details_data = [];
if (have_rows('project_details')) {
  while (have_rows('project_details')): the_row();
    $details_data[] = [
      'subject' => get_sub_field('subject'),
      'content' => wpautop(get_sub_field('content')), // WYSIWYG formatting
      'image'   => get_sub_field('image')
    ];
  endwhile;
}

// Collect up to 3 link buttons
$buttons = [];
for ($i = 1; $i <= 3; $i++) {
  $btn = get_sub_field("button_{$i}");
  if (!empty($btn) && !empty($btn['url']) && !empty($btn['title'])) {
    $buttons[] = $btn;
  }
}
?>

<section
  class="fade-in-up portfolio-item max-w-6xl mx-auto px-4 py-[90px]"
  data-details='<?php echo json_encode($details_data, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP); ?>'
>
  <div class="flex flex-col md:flex-row md:gap-12">

    <!-- Left: Image -->
    <div class="md:w-1/2 relative h-[450px] rounded-lg shadow-lg overflow-hidden mb-8 md:mb-0">
      <?php if ($initial_image_url): ?>
        <img
          class="project-main-image absolute inset-0 w-full h-full object-cover transition-opacity duration-500 opacity-100"
          src="<?php echo esc_url($initial_image_url); ?>"
          alt="<?php echo esc_attr($initial_image_alt); ?>"
          loading="lazy"
        />
      <?php endif; ?>
    </div>

    <!-- Right: Text Content -->
    <div class="md:w-1/2 flex flex-col">
      <?php if ($project_title): ?>
        <h2 class="text-4xl text-white font-bold mb-2"><?php echo esc_html($project_title); ?></h2>
      <?php endif; ?>

      <?php if ($project_date): ?>
        <p class="italic text-brand-accent mb-2"><?php echo esc_html($project_date); ?></p>
      <?php endif; ?>

      <?php if ($project_tools): ?>
        <p class="font-semibold text-brand-tealLight mb-4">Tools: <?php echo esc_html($project_tools); ?></p>
      <?php endif; ?>

      <?php if (!empty($details_data)): ?>
        <!-- Detail Tabs -->
        <div class="detail-tabs flex flex-wrap gap-2 mb-6">
          <?php foreach ($details_data as $index => $detail): ?>
            <button
              type="button"
              data-index="<?php echo esc_attr($index); ?>"
              class="project-detail-tab px-4 py-2 border border-brand-accent rounded-full text-sm font-semibold bg-brand-dark
                shadow-[0_4px_0_0_#E59C59]
                hover:translate-y-[2px] hover:shadow-[0_2px_0_0_#E59C59]
                active:translate-y-[3px] active:shadow-none
                transition-all duration-150 ease-in-out
                focus:outline-none
                <?php echo $index === 0 ? 'is-active !text-brand-lightTeal' : 'text-white'; ?>"
            >
              <?php echo esc_html($detail['subject']); ?>
            </button>
          <?php endforeach; ?>
        </div>

        <!-- Detail Content -->
        <div class="project-detail-content prose bg-[#444] p-4 overflow-y-scroll overflow-x-hidden h-[250px] rounded-[20px] max-w-none text-white custom-scroll transition-opacity duration-300">
          <?php echo $details_data[0]['content']; ?>
        </div>

<!-- Buttons BELOW content -->
<?php if (!empty($buttons)): ?>
  <div class="mt-6 flex flex-wrap gap-4">
    <?php foreach ($buttons as $button): ?>
      <a
        href="<?php echo esc_url($button['url']); ?>"
        target="<?php echo esc_attr($button['target'] ?: '_self'); ?>"
        rel="<?php echo $button['target'] === '_blank' ? 'noopener noreferrer' : ''; ?>"
        class="inline-block px-10 py-2 rounded-lg font-semibold no-underline text-brand-tealDark bg-brand-tealLight
               hover:bg-brand-dark hover:text-brand-accent transition-colors duration-300"
      >
        <?php echo esc_html($button['title']); ?>
      </a>
    <?php endforeach; ?>
  </div>
<?php endif; ?>


      <?php endif; ?>
    </div>
  </div>
</section>
