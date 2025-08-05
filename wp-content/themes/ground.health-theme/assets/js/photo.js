document.addEventListener('DOMContentLoaded', function () {
    // ==== SLIDESHOW LOGIC ====
    const slides = document.querySelectorAll('.slide-img');
    const track = document.getElementById('slide-track');
    const prevSlideBtn = document.getElementById('prev-slide');
    const nextSlideBtn = document.getElementById('next-slide');
    const slideOverlay = document.getElementById('slide-overlay');
    const slideOverlayImg = document.getElementById('overlay-image');
    const closeSlideOverlayBtn = document.getElementById('close-overlay');
  
    if (!track || slides.length === 0) {
      // Essential elements missing, do not run slideshow logic
      return;
    }
  
    let slideIndex = 0;
    const totalSlides = slides.length;
  
    function updateSlidePosition() {
      if (!track) return;  // Extra safety
      track.style.transform = `translateX(-${slideIndex * 100}%)`;
    }
  
    function prevSlide() {
      slideIndex = (slideIndex === 0) ? totalSlides - 1 : slideIndex - 1;
      updateSlidePosition();
    }
  
    function nextSlide() {
      slideIndex = (slideIndex + 1) % totalSlides;
      updateSlidePosition();
    }
  
    slides.forEach(slide => {
      slide.addEventListener('click', () => {
        if (!slideOverlayImg || !slideOverlay) return;
        slideOverlayImg.src = slide.src;
        slideOverlayImg.alt = slide.alt;
        slideOverlay.classList.remove('hidden');
        requestAnimationFrame(() => {
          slideOverlay.classList.add('active');
        });
        document.body.style.overflow = 'hidden';
      });
    });
  
    function closeSlideOverlay() {
      if (!slideOverlay) return;
      slideOverlay.classList.remove('active');
      setTimeout(() => {
        slideOverlay.classList.add('hidden');
        document.body.style.overflow = '';
      }, 300);
    }
  
    closeSlideOverlayBtn?.addEventListener('click', closeSlideOverlay);
    slideOverlay?.addEventListener('click', (e) => {
      if (e.target === slideOverlay) closeSlideOverlay();
    });
  
    prevSlideBtn?.addEventListener('click', () => {
      prevSlide();
      resetAutoplay();
    });
  
    nextSlideBtn?.addEventListener('click', () => {
      nextSlide();
      resetAutoplay();
    });
  
    let autoplay = setInterval(nextSlide, 5000);
    function resetAutoplay() {
      clearInterval(autoplay);
      autoplay = setInterval(nextSlide, 5000);
    }
  
    updateSlidePosition();
  
    // ==== PHOTO GALLERY OVERLAY LOGIC ====
    const items = document.querySelectorAll('#photo-gallery .group');
    const galleryOverlay = document.getElementById('gallery-overlay');
    const galleryImg = document.getElementById('gallery-overlay-img');
    const galleryClose = document.getElementById('close-gallery-overlay');
    const galleryNext = document.getElementById('next-gallery-image');
    const galleryPrev = document.getElementById('prev-gallery-image');
    const overlayTitle = document.getElementById('gallery-overlay-title');
  
    let galleryIndex = 0;
    let touchStartX = 0;
    let touchEndX = 0;
  
    function showGalleryOverlay(index) {
      const img = items[index].querySelector('img');
      const title = items[index].querySelector('span.photo-title')?.textContent || '';
  
      galleryImg.src = img.src;
      galleryImg.alt = img.alt;
  
      overlayTitle.textContent = title;
      overlayTitle.classList.toggle('hidden', !title);
  
      galleryOverlay.classList.remove('pointer-events-none', 'opacity-0');
      galleryOverlay.classList.add('opacity-100');
  
      setTimeout(() => {
        galleryImg.classList.remove('opacity-0', 'scale-95');
      }, 20);
  
      document.body.style.overflow = 'hidden';
    }
  
    function hideGalleryOverlay() {
      galleryImg.classList.add('opacity-0', 'scale-95');
      galleryOverlay.classList.remove('opacity-100');
      galleryOverlay.classList.add('opacity-0');
  
      galleryOverlay.addEventListener('transitionend', function handler(e) {
        if (e.propertyName === 'opacity' && galleryOverlay.classList.contains('opacity-0')) {
          galleryOverlay.classList.add('pointer-events-none');
          galleryImg.src = '';
          document.body.style.overflow = '';
          galleryOverlay.removeEventListener('transitionend', handler);
        }
      });
    }
  
    function nextGalleryImage() {
      galleryIndex = (galleryIndex + 1) % items.length;
      showGalleryOverlay(galleryIndex);
    }
  
    function prevGalleryImage() {
      galleryIndex = (galleryIndex - 1 + items.length) % items.length;
      showGalleryOverlay(galleryIndex);
    }
  
    items.forEach((item, index) => {
      item.addEventListener('click', () => {
        galleryIndex = index;
        showGalleryOverlay(index);
      });
    });
  
    galleryClose?.addEventListener('click', hideGalleryOverlay);
    galleryOverlay?.addEventListener('click', (e) => {
      if (e.target === galleryOverlay) hideGalleryOverlay();
    });
  
    galleryNext?.addEventListener('click', (e) => {
      e.stopPropagation();
      nextGalleryImage();
    });
  
    galleryPrev?.addEventListener('click', (e) => {
      e.stopPropagation();
      prevGalleryImage();
    });
  
    // Keyboard Navigation
    document.addEventListener('keydown', (e) => {
      if (!galleryOverlay.classList.contains('pointer-events-none')) {
        if (e.key === 'Escape') hideGalleryOverlay();
        else if (e.key === 'ArrowRight') nextGalleryImage();
        else if (e.key === 'ArrowLeft') prevGalleryImage();
      }
  
      if (slideOverlay && slideOverlay.classList.contains('active')) {
        if (e.key === 'Escape') closeSlideOverlay();
      }
    });
  
    // Touch Swipe Support for gallery overlay
    galleryOverlay?.addEventListener('touchstart', e => {
      touchStartX = e.changedTouches[0].screenX;
    });
  
    galleryOverlay?.addEventListener('touchend', e => {
      touchEndX = e.changedTouches[0].screenX;
      if (touchEndX < touchStartX - 50) nextGalleryImage();
      if (touchEndX > touchStartX + 50) prevGalleryImage();
    });
  });
  