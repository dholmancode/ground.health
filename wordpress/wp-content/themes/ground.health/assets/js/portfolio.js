(function(){
    document.querySelectorAll('.portfolio-item').forEach(portfolioItem => {
      const tabs = portfolioItem.querySelectorAll('.project-detail-tab');
      const mainImage = portfolioItem.querySelector('.project-main-image');
      const contentBox = portfolioItem.querySelector('.project-detail-content');
  
      const detailsData = JSON.parse(portfolioItem.getAttribute('data-details'));
  
      // Store the original image for tab 0
      const initialImageSrc = mainImage.getAttribute('src');
      const initialImageAlt = mainImage.getAttribute('alt');
  
      function setActiveTab(index) {
        tabs.forEach((tab, i) => {
          if (i === index) {
            tab.classList.add('is-active', 'text-brand-lightTeal');
            tab.classList.remove('text-white');
          } else {
            tab.classList.remove('is-active', 'text-brand-lightTeal');
            tab.classList.add('text-white');
          }
        });
      }
  
      function fadeOutIn(element, newContent) {
        element.style.opacity = 0;
        setTimeout(() => {
          if (element.tagName === 'IMG') {
            element.src = newContent.src || initialImageSrc;
            element.alt = newContent.alt || initialImageAlt;
          } else {
            element.innerHTML = newContent.html;
          }
          element.style.opacity = 1;
        }, 300);
      }
  
      tabs.forEach(tab => {
        tab.addEventListener('click', () => {
          const idx = parseInt(tab.dataset.index);
          if (isNaN(idx) || !detailsData[idx]) return;
  
          setActiveTab(idx);
  
          // Determine image: use tab image or fallback to initial
          const tabImage = detailsData[idx].image || {};
          const newImage = (idx === 0 || !tabImage.url)
            ? { src: initialImageSrc, alt: initialImageAlt }
            : { src: tabImage.url, alt: tabImage.alt || '' };
  
          fadeOutIn(mainImage, newImage);
          fadeOutIn(contentBox, {
            html: detailsData[idx].content
          });
        });
      });
  
      // Initialize first tab
      setActiveTab(0);
    });
  })();
  