<?php
// ACF fields
$left_content = get_sub_field('left_wysiwyg');
$right_title = get_sub_field('right_title');
$right_subtitle = get_sub_field('right_subtitle');
$contact_email = get_sub_field('contact_email');
$contact_phone = get_sub_field('contact_phone');
?>

<section class="max-w-6xl mx-auto px-4 py-[90px]">
  <div class="grid grid-cols-1 md:grid-cols-2 gap-12 bg-[#1d1d1d] rounded-[20px] p-8 md:p-12 shadow-xl border border-brand-tealDark">

    <!-- Left Column: WYSIWYG / Contact Form -->
    <div class="prose max-w-none text-white prose-a:text-brand-lightTeal prose-a:no-underline prose-a:hover:text-brand-accent prose-a:transition-all">
      <?php echo $left_content; ?>
    </div>

    <!-- Right Column: Info -->
    <div class="text-white space-y-8">
      <?php if ($right_title): ?>
        <h2 class="text-4xl font-extrabold text-brand-lightTeal"><?php echo esc_html($right_title); ?></h2>
      <?php endif; ?>

      <?php if ($right_subtitle): ?>
        <p class="text-lg text-gray-300"><?php echo esc_html($right_subtitle); ?></p>
      <?php endif; ?>

      <div class="space-y-5">
        <?php if ($contact_email): ?>
          <div class="flex items-center gap-4">
            <svg class="w-6 h-6 text-brand-accent" fill="none" stroke="currentColor" stroke-width="2"
                 viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round"
                    d="M16 12h2a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v4a2 2 0 002 2h2m4 0v6m0 0l-2-2m2 2l2-2"/>
            </svg>
            <a href="mailto:<?php echo antispambot($contact_email); ?>"
               class="text-brand-lightTeal hover:text-brand-accent font-medium transition">
              <?php echo antispambot($contact_email); ?>
            </a>
          </div>
        <?php endif; ?>

        <?php if ($contact_phone): ?>
          <div class="flex items-center gap-4">
            <svg class="w-6 h-6 text-brand-accent" fill="none" stroke="currentColor" stroke-width="2"
                 viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round"
                    d="M3 5a2 2 0 012-2h2.28a1 1 0 01.95.68l1.3 3.9a1 1 0 01-.21.98L8.5 10.5a11.037 11.037 0 005 5l1.94-1.94a1 1 0 01.98-.21l3.9 1.3a1 1 0 01.68.95V19a2 2 0 01-2 2h-1C10.4 21 3 13.6 3 5z"/>
            </svg>
            <a href="tel:<?php echo preg_replace('/\D+/', '', $contact_phone); ?>"
               class="text-brand-lightTeal hover:text-brand-accent font-medium transition">
              <?php echo esc_html($contact_phone); ?>
            </a>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>
