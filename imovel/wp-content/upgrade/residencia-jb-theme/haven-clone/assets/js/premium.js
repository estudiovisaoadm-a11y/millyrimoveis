/* ===================================================================
   HAVEN CLONE — PREMIUM JAVASCRIPT v2
   Gallery Lightbox, Carousel, Video Modal, Scroll Reveal, Counters
   =================================================================== */

document.addEventListener('DOMContentLoaded', () => {
  // ---- PRELOADER ----
  const preloader = document.querySelector('.hv-preloader');
  if (preloader) {
    window.addEventListener('load', () => {
      setTimeout(() => preloader.classList.add('loaded'), 600);
    });
    setTimeout(() => preloader.classList.add('loaded'), 3000);
  }

  // ---- NAVIGATION SCROLL ----
  const nav = document.querySelector('.hv-nav');
  if (nav) {
    const onScroll = () => {
      nav.classList.toggle('scrolled', window.scrollY > 80);
    };
    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();
  }

  // ---- HERO SLIDER ----
  const slides = document.querySelectorAll('.hv-hero-slide');
  const dots = document.querySelectorAll('.hv-hero-dot');
  let currentSlide = 0;
  let slideInterval;

  function goToSlide(n) {
    slides.forEach(s => s.classList.remove('active'));
    dots.forEach(d => d.classList.remove('active'));
    currentSlide = (n + slides.length) % slides.length;
    if (slides[currentSlide]) slides[currentSlide].classList.add('active');
    if (dots[currentSlide]) dots[currentSlide].classList.add('active');
  }

  if (slides.length > 1) {
    slideInterval = setInterval(() => goToSlide(currentSlide + 1), 5000);
    dots.forEach((dot, i) => {
      dot.addEventListener('click', () => {
        clearInterval(slideInterval);
        goToSlide(i);
        slideInterval = setInterval(() => goToSlide(currentSlide + 1), 5000);
      });
    });
  }

  // ---- PHOTO CAROUSEL ----
  const track = document.querySelector('.hv-carousel-track');
  const prevBtn = document.querySelector('.hv-carousel-prev');
  const nextBtn = document.querySelector('.hv-carousel-next');

  if (track && prevBtn && nextBtn) {
    let carouselPos = 0;

    function getCardWidth() {
      const card = track.querySelector('.hv-carousel-card');
      if (!card) return 400;
      const gap = parseFloat(getComputedStyle(track).gap) || 24;
      return card.offsetWidth + gap;
    }

    function getVisibleCount() {
      if (window.innerWidth <= 768) return 1;
      if (window.innerWidth <= 1024) return 2;
      return 3;
    }

    function getMaxPos() {
      return Math.max(0, track.querySelectorAll('.hv-carousel-card').length - getVisibleCount());
    }

    function updateCarousel() {
      track.style.transform = `translateX(-${carouselPos * getCardWidth()}px)`;
    }

    prevBtn.addEventListener('click', () => { carouselPos = Math.max(0, carouselPos - 1); updateCarousel(); });
    nextBtn.addEventListener('click', () => { carouselPos = Math.min(getMaxPos(), carouselPos + 1); updateCarousel(); });
    window.addEventListener('resize', () => { carouselPos = Math.min(carouselPos, getMaxPos()); updateCarousel(); });
  }

  // ---- VIDEO MODAL ----
  const playBtn = document.querySelector('.hv-video-play');
  const videoModal = document.querySelector('.hv-modal');
  const videoClose = document.querySelector('.hv-modal-close');

  if (playBtn && videoModal) {
    playBtn.addEventListener('click', () => {
      videoModal.classList.add('active');
      document.body.style.overflow = 'hidden';
      const iframe = videoModal.querySelector('iframe');
      if (iframe && iframe.dataset.src) iframe.src = iframe.dataset.src;
    });

    function closeVideoModal() {
      videoModal.classList.remove('active');
      document.body.style.overflow = '';
      const iframe = videoModal.querySelector('iframe');
      if (iframe) iframe.src = '';
    }

    if (videoClose) videoClose.addEventListener('click', closeVideoModal);
    videoModal.addEventListener('click', (e) => { if (e.target === videoModal) closeVideoModal(); });
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape' && videoModal.classList.contains('active')) closeVideoModal();
    });
  }

  // ==================================================================
  // GALLERY — THUMBNAIL CLICK + LIGHTBOX FULLSCREEN
  // ==================================================================

  // ---- Detail Section: Thumbnail Click to Swap Main Image ----
  const galleryMainImg = document.querySelector('#detail-main-img');
  const galleryThumbs = document.querySelectorAll('.hv-details-gallery-thumb');

  if (galleryMainImg && galleryThumbs.length > 0) {
    galleryThumbs.forEach((thumb, index) => {
      thumb.addEventListener('click', () => {
        // Remove active from all
        galleryThumbs.forEach(t => t.classList.remove('active'));
        // Add active to clicked
        thumb.classList.add('active');
        // Get the src from thumb's img
        const thumbImg = thumb.querySelector('img');
        if (thumbImg) {
          // Animate transition
          galleryMainImg.style.opacity = '0';
          galleryMainImg.style.transform = 'scale(1.02)';
          setTimeout(() => {
            galleryMainImg.src = thumbImg.src;
            galleryMainImg.style.opacity = '1';
            galleryMainImg.style.transform = 'scale(1)';
          }, 200);
        }
      });
    });

    // Add smooth transition to main image
    galleryMainImg.style.transition = 'opacity 0.3s ease, transform 0.4s ease';
  }

  // ---- LIGHTBOX: Click on main image or carousel card to open fullscreen ----
  initLightbox();

  function initLightbox() {
    // Collect all lightbox-able images
    const lightboxImages = [];

    // From detail gallery
    galleryThumbs.forEach(thumb => {
      const img = thumb.querySelector('img');
      if (img) lightboxImages.push(img.src);
    });

    // From carousel cards
    document.querySelectorAll('.hv-carousel-card-img img').forEach(img => {
      if (img.src && lightboxImages.indexOf(img.src) === -1) {
        lightboxImages.push(img.src);
      }
    });

    if (lightboxImages.length === 0) return;

    // Create lightbox DOM
    const lightbox = document.createElement('div');
    lightbox.className = 'hv-lightbox';
    lightbox.innerHTML = `
      <div class="hv-lightbox-overlay"></div>
      <button class="hv-lightbox-close" aria-label="Fechar">&times;</button>
      <button class="hv-lightbox-prev" aria-label="Anterior">&#8592;</button>
      <button class="hv-lightbox-next" aria-label="Próximo">&#8594;</button>
      <div class="hv-lightbox-container">
        <img class="hv-lightbox-img" src="" alt="Foto ampliada">
      </div>
      <div class="hv-lightbox-counter"></div>
      <div class="hv-lightbox-thumbstrip"></div>
    `;
    document.body.appendChild(lightbox);

    const lbImg = lightbox.querySelector('.hv-lightbox-img');
    const lbCounter = lightbox.querySelector('.hv-lightbox-counter');
    const lbThumbstrip = lightbox.querySelector('.hv-lightbox-thumbstrip');
    let lbIndex = 0;

    // Build thumbstrip
    lightboxImages.forEach((src, i) => {
      const thumb = document.createElement('div');
      thumb.className = 'hv-lightbox-thumb' + (i === 0 ? ' active' : '');
      thumb.innerHTML = `<img src="${src}" alt="Miniatura ${i+1}">`;
      thumb.addEventListener('click', () => showLbImage(i));
      lbThumbstrip.appendChild(thumb);
    });

    function showLbImage(idx) {
      lbIndex = (idx + lightboxImages.length) % lightboxImages.length;
      lbImg.style.opacity = '0';
      lbImg.style.transform = 'scale(0.95)';
      setTimeout(() => {
        lbImg.src = lightboxImages[lbIndex];
        lbImg.style.opacity = '1';
        lbImg.style.transform = 'scale(1)';
      }, 150);
      lbCounter.textContent = `${lbIndex + 1} / ${lightboxImages.length}`;
      // Update thumbstrip active
      lbThumbstrip.querySelectorAll('.hv-lightbox-thumb').forEach((t, i) => {
        t.classList.toggle('active', i === lbIndex);
      });
      // Scroll thumbstrip to show active
      const activeThumb = lbThumbstrip.querySelector('.hv-lightbox-thumb.active');
      if (activeThumb) activeThumb.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
    }

    function openLightbox(imgSrc) {
      // Find index
      let idx = lightboxImages.indexOf(imgSrc);
      if (idx === -1) idx = 0;
      lightbox.classList.add('active');
      document.body.style.overflow = 'hidden';
      showLbImage(idx);
    }

    function closeLightbox() {
      lightbox.classList.remove('active');
      document.body.style.overflow = '';
    }

    // Navigation
    lightbox.querySelector('.hv-lightbox-close').addEventListener('click', closeLightbox);
    lightbox.querySelector('.hv-lightbox-overlay').addEventListener('click', closeLightbox);
    lightbox.querySelector('.hv-lightbox-prev').addEventListener('click', () => showLbImage(lbIndex - 1));
    lightbox.querySelector('.hv-lightbox-next').addEventListener('click', () => showLbImage(lbIndex + 1));

    // Keyboard
    document.addEventListener('keydown', (e) => {
      if (!lightbox.classList.contains('active')) return;
      if (e.key === 'Escape') closeLightbox();
      if (e.key === 'ArrowLeft') showLbImage(lbIndex - 1);
      if (e.key === 'ArrowRight') showLbImage(lbIndex + 1);
    });

    // Touch swipe
    let touchStartX = 0;
    lightbox.addEventListener('touchstart', (e) => { touchStartX = e.changedTouches[0].screenX; }, { passive: true });
    lightbox.addEventListener('touchend', (e) => {
      const diff = e.changedTouches[0].screenX - touchStartX;
      if (Math.abs(diff) > 50) {
        if (diff > 0) showLbImage(lbIndex - 1);
        else showLbImage(lbIndex + 1);
      }
    }, { passive: true });

    // ---- Attach click handlers ----

    // Click main detail gallery image
    if (galleryMainImg) {
      galleryMainImg.style.cursor = 'zoom-in';
      galleryMainImg.addEventListener('click', () => openLightbox(galleryMainImg.src));
    }

    // Click carousel card images
    document.querySelectorAll('.hv-carousel-card-img').forEach(cardImg => {
      cardImg.style.cursor = 'zoom-in';
      cardImg.addEventListener('click', (e) => {
        e.stopPropagation();
        const img = cardImg.querySelector('img');
        if (img) openLightbox(img.src);
      });
    });

    // Click on detail thumbs to also open lightbox (double click or single depending on preference)
    // We keep single click as thumb swap, and add a zoom icon
    galleryThumbs.forEach(thumb => {
      const zoomIcon = document.createElement('div');
      zoomIcon.className = 'hv-thumb-zoom';
      zoomIcon.innerHTML = '🔍';
      zoomIcon.title = 'Ampliar';
      zoomIcon.addEventListener('click', (e) => {
        e.stopPropagation();
        const img = thumb.querySelector('img');
        if (img) openLightbox(img.src);
      });
      thumb.style.position = 'relative';
      thumb.appendChild(zoomIcon);
    });
  }

  // ---- SCROLL REVEAL ----
  const reveals = document.querySelectorAll('.hv-reveal');
  const revealObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('revealed');
        revealObserver.unobserve(entry.target);
      }
    });
  }, { threshold: 0.15, rootMargin: '0px 0px -40px 0px' });
  reveals.forEach(el => revealObserver.observe(el));

  // ---- ANIMATED COUNTERS ----
  const counters = document.querySelectorAll('.hv-stat-number[data-target]');
  const counterObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        const el = entry.target;
        const target = parseInt(el.dataset.target, 10);
        const suffix = el.dataset.suffix || '';
        const duration = 2000;
        const startTime = performance.now();

        function update(currentTime) {
          const elapsed = currentTime - startTime;
          const progress = Math.min(elapsed / duration, 1);
          const eased = 1 - (1 - progress) * (1 - progress);
          el.textContent = Math.floor(eased * target).toLocaleString() + suffix;
          if (progress < 1) requestAnimationFrame(update);
          else el.textContent = target.toLocaleString() + suffix;
        }

        requestAnimationFrame(update);
        counterObserver.unobserve(el);
      }
    });
  }, { threshold: 0.5 });
  counters.forEach(c => counterObserver.observe(c));

  // ---- SMOOTH SCROLL ----
  document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', (e) => {
      const target = document.querySelector(anchor.getAttribute('href'));
      if (target) {
        e.preventDefault();
        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
      }
    });
  });
});
