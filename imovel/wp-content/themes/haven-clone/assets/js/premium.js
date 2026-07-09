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

  // ---- MOBILE NAV TOGGLE ----
  const navToggle = nav ? nav.querySelector('.hv-nav-toggle') : null;
  const navLinks = nav ? nav.querySelector('.hv-nav-links') : null;

  if (nav && navToggle && navLinks) {
    if (!navLinks.id) navLinks.id = 'hv-nav-links';
    navToggle.setAttribute('aria-controls', navLinks.id);
    navToggle.setAttribute('aria-expanded', 'false');

    let backdrop = document.querySelector('.hv-nav-backdrop');
    if (!backdrop) {
      backdrop = document.createElement('div');
      backdrop.className = 'hv-nav-backdrop';
      document.body.appendChild(backdrop);
    }

    const setOpen = (open) => {
      nav.classList.toggle('is-open', open);
      navLinks.classList.toggle('is-open', open);
      backdrop.classList.toggle('active', open);
      navToggle.setAttribute('aria-expanded', open ? 'true' : 'false');
      document.body.classList.toggle('hv-nav-open', open);
    };

    navToggle.addEventListener('click', (e) => {
      e.preventDefault();
      setOpen(!nav.classList.contains('is-open'));
    });

    backdrop.addEventListener('click', () => setOpen(false));

    navLinks.addEventListener('click', (e) => {
      const link = e.target.closest('a');
      if (link) setOpen(false);
    });

    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape' && nav.classList.contains('is-open')) setOpen(false);
    });

    window.addEventListener('resize', () => {
      if (window.innerWidth > 768 && nav.classList.contains('is-open')) setOpen(false);
    });
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
    let carouselAutoInterval = null;

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

    prevBtn.addEventListener('click', () => {
      carouselPos = Math.max(0, carouselPos - 1);
      updateCarousel();
      restartCarouselAutoplay();
    });
    nextBtn.addEventListener('click', () => {
      carouselPos = Math.min(getMaxPos(), carouselPos + 1);
      updateCarousel();
      restartCarouselAutoplay();
    });
    window.addEventListener('resize', () => { carouselPos = Math.min(carouselPos, getMaxPos()); updateCarousel(); });

    // Autoplay for carousel
    const carouselAutoplay = track.dataset.autoplay === '1';
    const carouselSpeed = parseInt(track.dataset.speed, 10) || 4000;

    function carouselAutoAdvance() {
      if (carouselPos >= getMaxPos()) {
        carouselPos = 0;
      } else {
        carouselPos++;
      }
      updateCarousel();
    }

    function startCarouselAutoplay() {
      if (carouselAutoplay && !carouselAutoInterval) {
        carouselAutoInterval = setInterval(carouselAutoAdvance, carouselSpeed);
      }
    }

    function restartCarouselAutoplay() {
      if (carouselAutoInterval) {
        clearInterval(carouselAutoInterval);
        carouselAutoInterval = null;
      }
      startCarouselAutoplay();
    }

    startCarouselAutoplay();

    // Pause on hover
    track.addEventListener('mouseenter', () => {
      if (carouselAutoInterval) { clearInterval(carouselAutoInterval); carouselAutoInterval = null; }
    });
    track.addEventListener('mouseleave', () => {
      startCarouselAutoplay();
    });
  }

  // ---- DETAIL GALLERY AUTOPLAY ----
  const detailThumbs = document.querySelector('.hv-details-gallery-thumbs');
  if (detailThumbs) {
    const detailAutoplay = detailThumbs.dataset.autoplay === '1';
    const detailSpeed = parseInt(detailThumbs.dataset.speed, 10) || 5000;
    const thumbElements = detailThumbs.querySelectorAll('.hv-details-gallery-thumb');
    const detailMainImg = document.querySelector('#detail-main-img');

    if (detailAutoplay && thumbElements.length > 1 && detailMainImg) {
      let detailIndex = 0;
      let detailInterval = null;

      function advanceDetailGallery() {
        detailIndex = (detailIndex + 1) % thumbElements.length;
        thumbElements.forEach(t => t.classList.remove('active'));
        thumbElements[detailIndex].classList.add('active');
        const thumbImg = thumbElements[detailIndex].querySelector('img');
        if (thumbImg) {
          detailMainImg.style.opacity = '0';
          detailMainImg.style.transform = 'scale(1.02)';
          setTimeout(() => {
            detailMainImg.src = thumbImg.src;
            detailMainImg.style.opacity = '1';
            detailMainImg.style.transform = 'scale(1)';
          }, 200);
        }
      }

      function startDetailAutoplay() {
        if (!detailInterval) {
          detailInterval = setInterval(advanceDetailGallery, detailSpeed);
        }
      }

      function stopDetailAutoplay() {
        if (detailInterval) { clearInterval(detailInterval); detailInterval = null; }
      }

      startDetailAutoplay();

      // Pause on hover
      detailThumbs.closest('.hv-details-gallery')?.addEventListener('mouseenter', stopDetailAutoplay);
      detailThumbs.closest('.hv-details-gallery')?.addEventListener('mouseleave', startDetailAutoplay);

      // Reset autoplay on manual thumb click
      thumbElements.forEach((thumb, idx) => {
        thumb.addEventListener('click', () => {
          detailIndex = idx;
          stopDetailAutoplay();
          startDetailAutoplay();
        });
      });
    }
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

  // ---- MATTERPORT AUTOTOUR ----
  const matterportPlayer = document.querySelector('.hv-matterport-player');

  if (matterportPlayer) {
    const iframe = matterportPlayer.querySelector('iframe');
    const statusNode = matterportPlayer.querySelector('.hv-matterport-status');
    const toggleBtn = matterportPlayer.querySelector('[data-action="toggle"]');
    const restartBtn = matterportPlayer.querySelector('[data-action="restart"]');
    const toggleIcon = toggleBtn ? toggleBtn.querySelector('.hv-matterport-control-icon') : null;
    const toggleText = toggleBtn ? toggleBtn.querySelector('.hv-matterport-control-text') : null;
    const sectionNode = document.getElementById('tour3d');
    const sdkKey = (matterportPlayer.dataset.sdkKey || '').trim();
    const sdkBootstrap = (matterportPlayer.dataset.sdkBootstrap || '').trim();
    const modelId = (matterportPlayer.dataset.modelId || '').trim().toLowerCase();
    const autoEnabled = matterportPlayer.dataset.autotour === '1' && sdkKey !== '';
    const showControls = matterportPlayer.dataset.showControls === '1';
    const routeModeRaw = (matterportPlayer.dataset.autotourMode || 'auto').trim();
    const routeMode = ['auto', 'guided', 'sweeps'].includes(routeModeRaw) ? routeModeRaw : 'auto';
    const startDelay = Math.max(0, parseInt(matterportPlayer.dataset.autotourDelay, 10) || 0) * 1000;
    const stepDuration = Math.max(4, parseInt(matterportPlayer.dataset.autotourStepDuration, 10) || 7) * 1000;
    const transitionMs = Math.max(500, parseInt(matterportPlayer.dataset.autotourTransitionMs, 10) || 2200);

    const state = {
      mpSdk: null,
      isConnecting: false,
      isPlaying: false,
      usingGuided: false,
      userStopped: false,
      completed: false,
      currentTourIndex: 0,
      currentSweepId: '',
      currentRoomLabel: '',
      snapshots: [],
      sweepRoute: [],
      sweepIndex: 0,
      startTimer: null,
      sweepTimer: null,
      connectAttempts: 0,
    };

    const setStatus = (message) => {
      if (statusNode) statusNode.textContent = message;
    };

    const setButtonsDisabled = (disabled) => {
      [toggleBtn, restartBtn].forEach((button) => {
        if (button) button.disabled = disabled;
      });
    };

    const getGuidedStepName = () => {
      const snapshot = state.snapshots[state.currentTourIndex];
      return snapshot && snapshot.name ? snapshot.name : '';
    };

    const withContext = (message) => {
      const guidedName = state.usingGuided ? getGuidedStepName() : '';
      const suffix = guidedName || state.currentRoomLabel;
      return suffix ? `${message} - ${suffix}` : message;
    };

    const clearSweepTimer = () => {
      if (state.sweepTimer) {
        window.clearTimeout(state.sweepTimer);
        state.sweepTimer = null;
      }
    };

    const clearStartTimer = () => {
      if (state.startTimer) {
        window.clearTimeout(state.startTimer);
        state.startTimer = null;
      }
    };

    const updateToggleLabel = () => {
      if (!toggleBtn) return;

      if (state.isPlaying) {
        if (toggleIcon) toggleIcon.innerHTML = '&#10074;&#10074;';
        if (toggleText) toggleText.textContent = 'Pause';
        toggleBtn.setAttribute('aria-label', 'Pause');
      } else if (state.completed) {
        if (toggleIcon) toggleIcon.innerHTML = '&#8635;';
        if (toggleText) toggleText.textContent = 'Replay';
        toggleBtn.setAttribute('aria-label', 'Replay');
      } else if (state.userStopped) {
        if (toggleIcon) toggleIcon.innerHTML = '&#9654;';
        if (toggleText) toggleText.textContent = 'Play';
        toggleBtn.setAttribute('aria-label', 'Play');
      } else {
        if (toggleIcon) toggleIcon.innerHTML = '&#9654;';
        if (toggleText) toggleText.textContent = 'Play';
        toggleBtn.setAttribute('aria-label', 'Play');
      }
    };

    const sortSweeps = (left, right) => {
      const leftFloor = Number.isFinite(left?.floorInfo?.sequence) ? left.floorInfo.sequence : 999;
      const rightFloor = Number.isFinite(right?.floorInfo?.sequence) ? right.floorInfo.sequence : 999;

      if (leftFloor !== rightFloor) return leftFloor - rightFloor;

      const leftZ = left?.position?.z || 0;
      const rightZ = right?.position?.z || 0;
      if (leftZ !== rightZ) return leftZ - rightZ;

      return (left?.position?.x || 0) - (right?.position?.x || 0);
    };

    const buildSweepRoute = (collection) => {
      const sweeps = Object.values(collection || {}).filter((item) => item && item.id && item.enabled !== false);
      if (!sweeps.length) return [];

      const byId = new Map(sweeps.map((item) => [item.id, item]));
      const visited = new Set();
      const ordered = [];
      const startId = state.currentSweepId && byId.has(state.currentSweepId) ? state.currentSweepId : sweeps.sort(sortSweeps)[0].id;
      const queue = [startId];

      while (queue.length) {
        const nextId = queue.shift();
        if (!nextId || visited.has(nextId) || !byId.has(nextId)) continue;

        visited.add(nextId);
        ordered.push(nextId);

        const neighbors = [...(byId.get(nextId).neighbors || [])]
          .filter((neighborId) => byId.has(neighborId) && !visited.has(neighborId))
          .sort((leftId, rightId) => sortSweeps(byId.get(leftId), byId.get(rightId)));

        queue.push(...neighbors);
      }

      sweeps
        .map((item) => item.id)
        .filter((itemId) => !visited.has(itemId))
        .sort((leftId, rightId) => sortSweeps(byId.get(leftId), byId.get(rightId)))
        .forEach((itemId) => ordered.push(itemId));

      return ordered;
    };

    const loadMatterportSdk = async (key, bootstrapUrl) => {
      if (window.__havenMatterportEmbedModule && typeof window.__havenMatterportEmbedModule.connect === 'function') {
        return window.__havenMatterportEmbedModule;
      }

      if (window.__havenMatterportSdkPromise) {
        return window.__havenMatterportSdkPromise;
      }

      const importUrl = bootstrapUrl || `https://api.matterport.com/sdk/bootstrap/3.0.0-0-g0517b8d76c/sdk.es6.js?applicationKey=${encodeURIComponent(key)}`;

      window.__havenMatterportSdkPromise = import(/* webpackIgnore: true */ importUrl)
        .then((sdkModule) => {
          if (sdkModule && typeof sdkModule.connect === 'function') {
            window.__havenMatterportEmbedModule = sdkModule;
            return sdkModule;
          }

          throw new Error('Matterport SDK indisponivel.');
        });

      return window.__havenMatterportSdkPromise;
    };

    const extractMatterportModelId = (url) => {
      if (!url) return '';

      try {
        const absoluteUrl = new URL(url, window.location.href);
        if (!/matterport\.com$/i.test(absoluteUrl.hostname) && !/matterport\.com/i.test(absoluteUrl.hostname)) {
          return '';
        }

        return (absoluteUrl.searchParams.get('m') || '').trim().toLowerCase();
      } catch (error) {
        return '';
      }
    };

    const stopGuidedTour = async (markAsManual) => {
      if (!state.mpSdk || !state.usingGuided) return;

      state.userStopped = markAsManual;
      state.isPlaying = false;
      state.completed = false;
      updateToggleLabel();
      setStatus(withContext(markAsManual ? 'Modo manual' : 'Tour pausado'));

      try {
        await state.mpSdk.Tour.stop();
      } catch (error) {
        console.error(error);
      }
    };

    const moveToSweepIndex = async (index) => {
      if (!state.mpSdk || !state.sweepRoute.length) return;

      const safeIndex = ((index % state.sweepRoute.length) + state.sweepRoute.length) % state.sweepRoute.length;
      state.sweepIndex = safeIndex;

      const options = {
        transitionTime: transitionMs,
      };

      if (state.mpSdk.Camera && state.mpSdk.Camera.Transition && state.mpSdk.Camera.Transition.FLY) {
        options.transition = state.mpSdk.Camera.Transition.FLY;
      }

      try {
        await state.mpSdk.Sweep.moveTo(state.sweepRoute[safeIndex], options);
      } catch (error) {
        console.error(error);
      }

      if (!state.isPlaying) return;

      clearSweepTimer();
      state.sweepTimer = window.setTimeout(() => {
        moveToSweepIndex(state.sweepIndex + 1);
      }, stepDuration);
    };

    const stopSweepTour = (markAsManual) => {
      state.userStopped = markAsManual;
      state.isPlaying = false;
      state.completed = false;
      clearSweepTimer();
      updateToggleLabel();
      setStatus(withContext(markAsManual ? 'Modo manual' : 'Tour pausado'));
    };

    const prepareSweepRoute = () => new Promise((resolve) => {
      if (!state.mpSdk || !state.mpSdk.Sweep || !state.mpSdk.Sweep.data) {
        resolve([]);
        return;
      }

      let latestCollection = {};
      let resolved = false;

      const finish = (collection) => {
        if (resolved) return;
        resolved = true;
        state.sweepRoute = buildSweepRoute(collection);
        resolve(state.sweepRoute);
      };

      try {
        state.mpSdk.Sweep.data.subscribe({
          onAdded(index, item, collection) {
            latestCollection = collection || latestCollection;
          },
          onCollectionUpdated(collection) {
            latestCollection = collection || latestCollection;
            finish(latestCollection);
          },
        });
      } catch (error) {
        console.error(error);
        finish(latestCollection);
        return;
      }

      window.setTimeout(() => finish(latestCollection), 3500);
    });

    const startGuidedTour = async (restart) => {
      if (!state.mpSdk || !state.snapshots.length) return false;

      state.usingGuided = true;
      state.userStopped = false;
      state.completed = false;

      const startIndex = restart ? 0 : Math.min(state.currentTourIndex || 0, Math.max(state.snapshots.length - 1, 0));

      try {
        await state.mpSdk.Tour.start(startIndex);
        state.isPlaying = true;
        updateToggleLabel();
        setStatus(withContext('Autotour guiado ativo'));
        return true;
      } catch (error) {
        console.error(error);
        return false;
      }
    };

    const startSweepTour = async (restart) => {
      if (!state.sweepRoute.length) {
        await prepareSweepRoute();
      }

      if (!state.sweepRoute.length) {
        setStatus('Nao foi possivel montar o percurso automatico.');
        state.isPlaying = false;
        state.usingGuided = false;
        state.completed = false;
        updateToggleLabel();
        return false;
      }

      state.usingGuided = false;
      state.userStopped = false;
      state.completed = false;
      state.isPlaying = true;
      updateToggleLabel();
      setStatus(withContext('Percurso automatico ativo'));

      const currentIndex = restart ? 0 : Math.max(state.sweepRoute.indexOf(state.currentSweepId), 0);
      await moveToSweepIndex(currentIndex >= 0 ? currentIndex : 0);
      return true;
    };

    const startAutotour = async (restart) => {
      if (!state.mpSdk) return;

      clearStartTimer();
      clearSweepTimer();
      setButtonsDisabled(false);

      if (routeMode !== 'sweeps') {
        if (!state.snapshots.length) {
          try {
            state.snapshots = await state.mpSdk.Tour.getData();
          } catch (error) {
            console.error(error);
            state.snapshots = [];
          }
        }

        if (state.snapshots.length) {
          const guidedStarted = await startGuidedTour(restart);
          if (guidedStarted) return;
        }

        if (routeMode === 'guided') {
          state.isPlaying = false;
          state.completed = false;
          state.userStopped = false;
          updateToggleLabel();
          setStatus('Nenhuma parada do Highlight Reel foi encontrada neste modelo.');
          return;
        }
      }

      await startSweepTour(restart);
    };

    const connectMatterport = async () => {
      if (!iframe || !sdkKey || state.mpSdk || state.isConnecting) return;

      state.isConnecting = true;
      state.connectAttempts += 1;
      setStatus('Conectando autotour...');
      setButtonsDisabled(true);

      try {
        const sdkModule = await loadMatterportSdk(sdkKey, sdkBootstrap);
        state.mpSdk = await sdkModule.connect(iframe);
      } catch (error) {
        console.error(error);
        state.isConnecting = false;
        window.__havenMatterportSdkPromise = null;

        if (state.connectAttempts < 8) {
          setStatus(`Tentando conectar o autotour (${state.connectAttempts}/8)...`);
          window.setTimeout(connectMatterport, 1500);
        } else {
          setStatus('Nao foi possivel iniciar o SDK do Matterport neste dominio.');
          setButtonsDisabled(true);
        }
        return;
      }

      state.isConnecting = false;
      state.connectAttempts = 0;

      if (state.mpSdk.Room && state.mpSdk.Room.current && typeof state.mpSdk.Room.current.subscribe === 'function') {
        state.mpSdk.Room.current.subscribe((currentRooms) => {
          const rooms = currentRooms && Array.isArray(currentRooms.rooms) ? currentRooms.rooms : [];
          state.currentRoomLabel = rooms[0] && rooms[0].label ? rooms[0].label : '';

          if (!state.isPlaying && state.userStopped) {
            setStatus(withContext('Modo manual'));
          }
        });
      }

      if (state.mpSdk.Sweep && state.mpSdk.Sweep.current && typeof state.mpSdk.Sweep.current.subscribe === 'function') {
        state.mpSdk.Sweep.current.subscribe((currentSweep) => {
          if (currentSweep && currentSweep.id) {
            state.currentSweepId = currentSweep.id;
          }
        });
      }

      if (state.mpSdk.Tour && state.mpSdk.Tour.currentStep && typeof state.mpSdk.Tour.currentStep.subscribe === 'function') {
        state.mpSdk.Tour.currentStep.subscribe((currentStep) => {
          if (currentStep && typeof currentStep.index === 'number') {
            state.currentTourIndex = currentStep.index;
          }

          if (state.isPlaying && state.usingGuided) {
            setStatus(withContext('Autotour guiado ativo'));
          }
        });
      }

      if (state.mpSdk.Tour && state.mpSdk.Tour.state && typeof state.mpSdk.Tour.state.subscribe === 'function') {
        state.mpSdk.Tour.state.subscribe((tourState) => {
          const currentState = tourState && tourState.current ? String(tourState.current).toUpperCase() : '';

          if (currentState === 'ACTIVE') {
            state.usingGuided = true;
            state.isPlaying = true;
            state.completed = false;
            updateToggleLabel();
            setStatus(withContext('Autotour guiado ativo'));
            return;
          }

          if (currentState === 'STOP_SCHEDULED') {
            state.isPlaying = false;
            state.userStopped = true;
            state.completed = false;
            updateToggleLabel();
            setStatus(withContext('Modo manual'));
            return;
          }

          if (currentState === 'INACTIVE' && state.usingGuided) {
            state.isPlaying = false;
            state.completed = !state.userStopped;
            updateToggleLabel();
            setStatus(state.completed ? 'Percurso finalizado' : withContext('Modo manual'));
          }
        });
      }

      setButtonsDisabled(false);
      updateToggleLabel();

      if (autoEnabled) {
        setStatus('Autotour pronto');
        state.startTimer = window.setTimeout(() => {
          startAutotour(false);
        }, startDelay);
      } else {
        setStatus('Tour 3D pronto para navegacao manual.');
      }
    };

    if (toggleBtn) {
      toggleBtn.addEventListener('click', async () => {
        if (!state.mpSdk) return;

        if (state.isPlaying) {
          if (state.usingGuided) {
            await stopGuidedTour(true);
          } else {
            stopSweepTour(true);
          }
          return;
        }

        if (state.completed) {
          await startAutotour(true);
          return;
        }

        await startAutotour(false);
      });
    }

    if (restartBtn) {
      restartBtn.addEventListener('click', async () => {
        if (!state.mpSdk) return;

        if (state.usingGuided) {
          await stopGuidedTour(false);
        } else {
          stopSweepTour(false);
        }

        await startAutotour(true);
      });
    }

    if (!sdkKey) {
      setButtonsDisabled(true);
      setStatus(showControls ? 'Informe a SDK Key do Matterport para ativar o autotour.' : 'Tour 3D pronto para navegacao manual.');
    } else {
      setButtonsDisabled(true);
      iframe?.addEventListener('load', connectMatterport, { once: true });
      window.setTimeout(connectMatterport, 2500);
    }

    if (sectionNode && modelId) {
      document.addEventListener('click', (event) => {
        if (window.innerWidth > 768) return;

        const link = event.target.closest('a[href]');
        if (!link) return;

        const href = link.getAttribute('href') || '';
        const targetModelId = extractMatterportModelId(href);

        if (!targetModelId || targetModelId !== modelId) return;

        event.preventDefault();

        sectionNode.scrollIntoView({
          behavior: 'smooth',
          block: 'start',
        });
      });
    }
  }

  // ---- CTA LEAD FORM ----
  const leadOpenButtons = document.querySelectorAll('.hv-lead-open');
  const leadModal = document.querySelector('.hv-lead-modal');
  const leadCloseBtn = leadModal ? leadModal.querySelector('.hv-lead-modal-close') : null;
  const leadChat = leadModal ? leadModal.querySelector('.hv-lead-chat') : null;
  const leadThread = leadChat ? leadChat.querySelector('.hv-lead-chat-thread') : null;
  const leadProgress = leadChat ? leadChat.querySelector('.hv-lead-chat-progress') : null;
  const leadInputWrap = leadChat ? leadChat.querySelector('.hv-lead-chat-input') : null;
  const leadNameInput = leadChat ? leadChat.querySelector('.hv-lead-name-input') : null;
  const leadNameSubmit = leadChat ? leadChat.querySelector('.hv-lead-name-submit') : null;
  const leadChoices = leadChat ? leadChat.querySelector('.hv-lead-chat-choices') : null;
  const leadSendBtn = leadChat ? leadChat.querySelector('.hv-lead-send') : null;
  const leadDataNode = leadChat ? leadChat.querySelector('.hv-lead-chat-data') : null;
  const floatingCta = document.querySelector('.hv-floating-cta');

  if (
    leadOpenButtons.length &&
    leadModal &&
    leadChat &&
    leadThread &&
    leadProgress &&
    leadInputWrap &&
    leadNameInput &&
    leadNameSubmit &&
    leadChoices &&
    leadSendBtn &&
    leadDataNode
  ) {
    let leadQuestions = [];
    let leadAnswers = [];
    let leadCurrentIndex = 0;
    let leadContactName = '';
    let leadTimers = [];
    let leadConversationComplete = false;
    let leadIsOpen = false;

    try {
      leadQuestions = JSON.parse(leadDataNode.textContent || '[]');
    } catch (error) {
      leadQuestions = [];
    }

    const scheduleLeadTask = (callback, delay) => {
      const timerId = window.setTimeout(() => {
        leadTimers = leadTimers.filter((currentId) => currentId !== timerId);
        callback();
      }, delay);

      leadTimers.push(timerId);
      return timerId;
    };

    const clearLeadTasks = () => {
      leadTimers.forEach((timerId) => {
        window.clearTimeout(timerId);
      });

      leadTimers = [];
    };

    const scrollLeadThread = () => {
      leadThread.scrollTo({
        top: leadThread.scrollHeight,
        behavior: 'smooth',
      });
    };

    const setLeadProgress = (text) => {
      leadProgress.textContent = text || '';
    };

    const setLeadVisibility = (node, visible, displayMode = '') => {
      if (!node) return;

      if (visible) {
        node.hidden = false;
        node.removeAttribute('hidden');
        node.setAttribute('aria-hidden', 'false');

        if (displayMode) {
          node.style.display = displayMode;
        } else {
          node.style.removeProperty('display');
        }
      } else {
        node.hidden = true;
        node.setAttribute('hidden', 'hidden');
        node.setAttribute('aria-hidden', 'true');
        node.style.display = 'none';
      }
    };

    const createLeadBubble = (type, text, extraClass = '') => {
      const bubble = document.createElement('div');
      bubble.className = 'hv-lead-bubble hv-lead-bubble-' + type + (extraClass ? ' ' + extraClass : '');
      bubble.textContent = text;
      leadThread.appendChild(bubble);
      scrollLeadThread();
      return bubble;
    };

    const createLeadTypingBubble = () => {
      const bubble = document.createElement('div');
      bubble.className = 'hv-lead-bubble hv-lead-bubble-bot hv-lead-bubble-typing';

      for (let index = 0; index < 3; index += 1) {
        const dot = document.createElement('span');
        bubble.appendChild(dot);
      }

      leadThread.appendChild(bubble);
      scrollLeadThread();
      return bubble;
    };

    const runLeadTyping = (delay, callback) => {
      if (!leadIsOpen) return;

      const typingBubble = createLeadTypingBubble();

      scheduleLeadTask(() => {
        typingBubble.remove();

        if (leadIsOpen) {
          callback();
        }
      }, delay);
    };

    const hideLeadNameInput = () => {
      setLeadVisibility(leadInputWrap, false);
      leadNameInput.blur();
      leadNameInput.value = '';
    };

    const showLeadNameInput = () => {
      setLeadVisibility(leadInputWrap, true, 'flex');

      scheduleLeadTask(() => {
        if (leadIsOpen) {
          leadNameInput.focus();
        }
      }, 80);
    };

    const clearLeadChoices = () => {
      leadChoices.innerHTML = '';
    };

    const hideLeadChoices = () => {
      clearLeadChoices();
      setLeadVisibility(leadChoices, false);
    };

    const showLeadChoicesInThread = () => {
      leadThread.appendChild(leadChoices);
      setLeadVisibility(leadChoices, true, 'flex');
      scrollLeadThread();
    };

    const hideLeadSendButton = () => {
      setLeadVisibility(leadSendBtn, false);
      leadSendBtn.disabled = true;
      leadSendBtn.classList.remove('is-visible');
    };

    const showLeadSendButton = () => {
      setLeadVisibility(leadSendBtn, true, 'inline-flex');
      leadSendBtn.disabled = false;
      leadSendBtn.classList.add('is-visible');
      scrollLeadThread();
    };

    const finishLeadConversation = () => {
      leadConversationComplete = true;
      hideLeadChoices();
      hideLeadNameInput();
      setLeadProgress('Mensagem pronta para enviar');

      const summaryLines = [];

      if (leadContactName) {
        summaryLines.push('Nome: ' + leadContactName);
      }

      leadAnswers.forEach((answer) => {
        summaryLines.push(answer.label + ': ' + answer.value);
      });

      runLeadTyping(900, () => {
        const summaryText = summaryLines.length
          ? 'Perfeito. Ja deixei sua mensagem pronta com estas respostas:\n' + summaryLines.join('\n')
          : 'Perfeito. Sua mensagem ja esta pronta para enviar no WhatsApp.';

        createLeadBubble('bot', summaryText, 'is-summary');
        showLeadSendButton();
      });
    };

    const askLeadQuestion = () => {
      hideLeadNameInput();
      hideLeadSendButton();
      hideLeadChoices();

      if (leadCurrentIndex >= leadQuestions.length) {
        finishLeadConversation();
        return;
      }

      const question = leadQuestions[leadCurrentIndex];
      const options = Array.isArray(question.options) ? question.options : [];

      if (!options.length) {
        leadCurrentIndex += 1;
        askLeadQuestion();
        return;
      }

      setLeadProgress('Pergunta ' + (leadCurrentIndex + 1) + ' de ' + leadQuestions.length);

      runLeadTyping(820, () => {
        createLeadBubble('bot', question.label || 'Me conta um pouco mais.');
        hideLeadChoices();
        showLeadChoicesInThread();

        options.forEach((option, optionIndex) => {
          const optionLabel = typeof option === 'string' ? option : (option && option.label ? option.label : '');
          if (!optionLabel) return;

          const choiceButton = document.createElement('button');
          choiceButton.type = 'button';
          choiceButton.className = 'hv-lead-choice';
          choiceButton.textContent = optionLabel;

          choiceButton.addEventListener('click', () => {
            if (choiceButton.disabled || !leadIsOpen) return;

            Array.from(leadChoices.querySelectorAll('.hv-lead-choice')).forEach((button) => {
              button.disabled = true;
              button.classList.add('is-disabled');
            });

            scheduleLeadTask(() => {
              hideLeadChoices();
              leadAnswers.push({
                label: question.label || 'Campo',
                value: optionLabel,
              });
              createLeadBubble('user', optionLabel);
              leadCurrentIndex += 1;
              askLeadQuestion();
            }, 140);
          });

          leadChoices.appendChild(choiceButton);

          scheduleLeadTask(() => {
            choiceButton.classList.add('is-visible');
          }, 50 + (optionIndex * 45));
        });

        scrollLeadThread();
      });
    };

    const askLeadName = () => {
      hideLeadSendButton();
      hideLeadChoices();
      setLeadProgress('Como podemos te chamar?');

      runLeadTyping(720, () => {
        createLeadBubble('bot', 'Antes de tudo, como eu posso te chamar?');
        showLeadNameInput();
      });
    };

    const submitLeadName = () => {
      const typedName = (leadNameInput.value || '').replace(/\s+/g, ' ').trim();

      if (!typedName || !leadIsOpen) {
        leadNameInput.focus();
        return;
      }

      leadContactName = typedName;
      createLeadBubble('user', typedName);
      hideLeadNameInput();
      setLeadProgress('Perfeito, vamos continuar');

      runLeadTyping(660, () => {
        const firstName = typedName.split(' ')[0] || typedName;
        createLeadBubble('bot', 'Prazer, ' + firstName + '. Vou te fazer algumas perguntas rapidas para agilizar seu atendimento.');

        if (leadQuestions.length) {
          askLeadQuestion();
        } else {
          finishLeadConversation();
        }
      });
    };

    const resetLeadConversation = () => {
      clearLeadTasks();
      leadAnswers = [];
      leadCurrentIndex = 0;
      leadContactName = '';
      leadConversationComplete = false;
      leadThread.innerHTML = '';
      hideLeadNameInput();
      hideLeadChoices();
      hideLeadSendButton();
      setLeadProgress('Preparando atendimento');
      askLeadName();
    };

    const openLeadModal = () => {
      leadIsOpen = true;
      leadModal.classList.add('active');
      leadModal.setAttribute('aria-hidden', 'false');
      document.body.style.overflow = 'hidden';
      if (floatingCta) {
        floatingCta.classList.remove('has-badge', 'show-message', 'is-pulsing');
      }
      resetLeadConversation();
    };

    const closeLeadModal = () => {
      leadIsOpen = false;
      clearLeadTasks();
      leadModal.classList.remove('active');
      leadModal.setAttribute('aria-hidden', 'true');
      document.body.style.overflow = '';
    };

    leadOpenButtons.forEach((button) => {
      button.addEventListener('click', (e) => {
        e.preventDefault();
        openLeadModal();
      });
    });

    if (leadCloseBtn) {
      leadCloseBtn.addEventListener('click', closeLeadModal);
    }

    leadModal.addEventListener('click', (e) => {
      if (e.target === leadModal) closeLeadModal();
    });

    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape' && leadModal.classList.contains('active')) closeLeadModal();
    });

    leadNameSubmit.addEventListener('click', submitLeadName);

    leadNameInput.addEventListener('keydown', (event) => {
      if (event.key === 'Enter') {
        event.preventDefault();
        submitLeadName();
      }
    });

    leadSendBtn.addEventListener('click', () => {
      if (!leadConversationComplete) return;

      const phone = leadChat.dataset.phone || '';
      if (!phone) return;

      const intro = leadChat.dataset.messageIntro || '';
      const messageParts = [];

      if (intro) {
        messageParts.push(intro);
      }

      if (leadContactName) {
        messageParts.push('Nome: ' + leadContactName);
      }

      leadAnswers.forEach((answer) => {
        messageParts.push(answer.label + ': ' + answer.value);
      });

      const message = messageParts.join('\n');
      window.open('https://wa.me/' + phone + '?text=' + encodeURIComponent(message), '_blank');
      closeLeadModal();
    });
  }

  if (floatingCta) {
    const showDelay = (parseInt(floatingCta.dataset.showDelay, 10) || 0) * 1000;
    const pulseDelay = (parseInt(floatingCta.dataset.pulseDelay, 10) || 0) * 1000;
    const badgeSection = floatingCta.dataset.badgeSection || '';
    const badgeMessageDelay = (parseInt(floatingCta.dataset.badgeMessageDelay, 10) || 0) * 1000;
    let badgeTriggered = false;

    window.setTimeout(() => {
      floatingCta.classList.add('is-visible');
    }, showDelay);

    if (pulseDelay >= 0) {
      window.setTimeout(() => {
        floatingCta.classList.add('is-pulsing');
      }, pulseDelay);
    }

    if (badgeSection) {
      const sectionNode = document.getElementById(badgeSection);
      if (sectionNode && 'IntersectionObserver' in window) {
        const badgeObserver = new IntersectionObserver((entries) => {
          entries.forEach((entry) => {
            if (entry.isIntersecting && !badgeTriggered) {
              badgeTriggered = true;
              floatingCta.classList.add('has-badge');
              window.setTimeout(() => {
                floatingCta.classList.add('show-message');
              }, badgeMessageDelay);
            }
          });
        }, { threshold: 0.35 });

        badgeObserver.observe(sectionNode);
      }
    }
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
