<?php
$slides = get_sub_field('slides');
if (!$slides || count($slides) === 0) return;
?>

<section class="container mx-auto px-4 py-16 animate-in animate-out">
  <div id="slideshow" class="relative max-w-4xl mx-auto select-none">
    <!-- Slides Wrapper -->
    <div class="animate-in zoom-in relative overflow-hidden h-[500px]">
      <div id="slide-track" class="flex transition-transform duration-700 ease-in-out" style="width: 100%;">
        <?php foreach ($slides as $slide): 
          $img = $slide['image'];
          if (!$img) continue;
        ?>
          <div class="w-full flex-shrink-0 h-[500px] flex items-center justify-center bg-transparent">
            <img 
              src="<?php echo esc_url($img['url']); ?>" 
              alt="<?php echo esc_attr($img['alt']); ?>" 
              class="h-[500px] w-auto object-contain cursor-pointer mx-auto slide-img"
            >
          </div>
        <?php endforeach; ?>
      </div>
    </div>

    <!-- Arrows BELOW the image -->
    <div class="mt-4 flex justify-center space-x-6">
    <button
  id="prev-slide"
  aria-label="Previous Slide"
  class="bg-black bg-opacity-50 text-white rounded-full p-3 shadow-md hover:bg-opacity-60 hover:scale-105 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-white"
>
  &#8592;
</button>
<button
  id="next-slide"
  aria-label="Next Slide"
  class="bg-black bg-opacity-50 text-white rounded-full p-3 shadow-md hover:bg-opacity-60 hover:scale-105 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-white"
>
  &#8594;
</button>
    </div>
  </div>

  <!-- Fullscreen Overlay -->
  <div id="slide-overlay" class="fixed inset-0 bg-black bg-opacity-80 flex items-center justify-center p-4 z-50 hidden">
    <button id="close-overlay" aria-label="Close" class="absolute top-4 right-4 text-white text-3xl font-bold focus:outline-none">&times;</button>
    <img id="overlay-image" src="" alt="" class="max-h-full max-w-full rounded-lg shadow-lg" />
  </div>
</section>
