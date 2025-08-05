<?php
$gallery_items = get_sub_field('gallery');
if (!$gallery_items || count($gallery_items) === 0) return;
?>

<section class="w-full bg-[#333] p-4 font-['Work_Sans',sans-serif]">
  <div id="photo-gallery" class="columns-1 md:columns-2 lg:columns-3 gap-4 space-y-4">
    <?php foreach ($gallery_items as $index => $item): 
      $img = $item['image'];
      $title = $item['photo_title'];
      if (!$img) continue;
    ?>
      <div class="relative group cursor-pointer break-inside-avoid mb-4 overflow-hidden" data-index="<?php echo $index; ?>">
        <img
          src="<?php echo esc_url($img['url']); ?>" 
          alt="<?php echo esc_attr($img['alt']); ?>" 
          class="w-full object-cover shadow-lg transition-transform duration-500 group-hover:scale-105"
        >
        <?php if ($title): ?>
          <!-- Hidden title for JS to read -->
          <span class="hidden photo-title"><?php echo esc_html($title); ?></span>

          <!-- Dark overlay + visible title on hover -->
          <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition duration-300"></div>
          <h2 class="absolute bottom-0 left-1/2 transform -translate-x-1/2 mb-4 text-white text-center text-lg px-4 opacity-0 group-hover:opacity-100 transition duration-300 font-semibold z-10">
          <?php echo esc_html($title); ?>
          </h2>
        <?php endif; ?>
      </div>
    <?php endforeach; ?>
  </div>

  <!-- Lightbox Overlay -->
  <div id="gallery-overlay" class="fixed inset-0 bg-black bg-opacity-80 opacity-0 pointer-events-none z-50 flex items-center justify-center p-4 transition-opacity duration-500">
    <button id="close-gallery-overlay" class="absolute top-4 right-4 text-white text-3xl font-bold focus:outline-none z-50">&times;</button>

    <!-- Image -->
    <img 
      id="gallery-overlay-img" 
      src="" alt="" 
      class="rounded-lg shadow-lg transition-transform duration-500 transform scale-95 opacity-0 max-h-[80vh] max-w-[90vw]" 
    />

    <!-- Title -->
    <div id="gallery-overlay-title"
         class="fixed bottom-10 left-1/2 font-heading transform -translate-x-1/2 text-white text-center px-4 py-2 rounded hidden z-50 max-w-[80%]">
    </div>

    <!-- Arrows -->
    <button 
      id="prev-gallery-image"
      class="fixed left-10 bottom-10 text-white bg-black bg-opacity-50 p-3 rounded-full hover:bg-opacity-75 transition-all duration-300 select-none z-50"
      aria-label="Previous Image"
    >&#8592;</button>

    <button 
      id="next-gallery-image"
      class="fixed right-10 bottom-10 text-white bg-black bg-opacity-50 p-3 rounded-full hover:bg-opacity-75 transition-all duration-300 select-none z-50"
      aria-label="Next Image"
    >&#8594;</button>
  </div>
</section>
