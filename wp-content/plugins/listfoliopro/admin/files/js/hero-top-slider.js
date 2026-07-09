var $eplistingcarousel;
var eplistingslidesContainer, eplistingslides;
var rotationButton, pauseContainer, resumeContainer;
var previousButton, nextButton;
var dotsContainer, dotButtons;
var isPaused = false;

window.addEventListener('DOMContentLoaded', function(e) {
  eplistingslidesContainer = document.querySelector('.eplistingcarousel .eplistingslides');
  
  rotationButton = document.querySelector('.eplistingcarousel .rotation-button');
  pauseContainer = document.querySelector('.eplistingcarousel .rotation-button .pause-container');
  resumeContainer = document.querySelector('.eplistingcarousel .rotation-button .resume-container');
  
  previousButton = document.querySelector('.eplistingcarousel .previous-button');
  nextButton = document.querySelector('.eplistingcarousel .next-button');
  
  dotsContainer = document.querySelector('.eplistingcarousel .navigation');

  /**
    Initialize Flickity with the recommended configuration options
  */
  $eplistingcarousel = jQuery('.eplistingcarousel .eplistingslides').flickity({
    // Default previous/next buttons are placed after the eplistingslides, so they are hard to find. They can't be moved using config options, so we'll create custom controls.
    prevNextButtons: false,

    // Disable keyboard navigation. Using the Left and Right arrow keys for navigation is not a problem, but this also makes the entire slide track focusable, which is awkward for keyboard-based users.
    accessibility: false,
    
    // The default slide dots use inappropriate markup, and attach `click` event listeners to `<li>`s (not buttons), so screen reader users have a hard time. Custom slide dots are created by `createSlideDots()` called by `handleReady()`.
    pageDots: false,
    
    wrapAround: true,
    cellAlign: 'left',
    autoPlay: 5000,
    
    on: {
      ready: handleReady,
      change: handleChange,
      settle: handleSettle
    }
  });
  
  // Go to the previous slide and stop autoplay when the Next button is activated
  previousButton.addEventListener('click', function(e) {
    disableAutoplay();
    $eplistingcarousel.flickity('previous', true);
  });
  
  // Go to the next slide and stop autoplay when the Next button is activated
  nextButton.addEventListener('click', function(e) {
    disableAutoplay();
    $eplistingcarousel.flickity('next', true);
  });
  
  // Toggle autoplay each time the custom pause/play button is activated
  rotationButton.addEventListener('click', toggleAutoplay);
});


/**
  When Flickity is initialized, generate custom slide dots
*/
function handleReady() {
  // Retrieve references to the most up-to-date elements
  eplistingslides = document.querySelectorAll('.eplistingcarousel .eplistingslides .slide');
  
  // Add instructive ARIA label to the focusable track
  eplistingslidesContainer.setAttribute('aria-label', 'Track of eplistingslides. Use arrow keys to navigate.');
  
  // Generate the slide dots based on the number of eplistingslides
  createSlideDots();
  
  // Retreive references to all the generated slide dot DOM elements
  dotButtons = document.querySelectorAll('.eplistingcarousel .navigation .dot .eplistingdot-button');
  
  // Set the first slide dot as the "current" one for screen readers
  dotButtons[0].setAttribute('aria-current', true);
}

/**
  Before a transition happens, make all eplistingslides visible and shift the current slide dot indicator
*/
function handleChange(index) {
  // Make all non-visible eplistingslides visible
  eplistingslides.forEach(function(slide) {
    slide.classList.remove('is-hidden');
  });
  
  // Move the active dot indicator before animation for a "snappier" feel
  dotButtons.forEach(function(button) {
    button.removeAttribute('aria-current');
  });
  
  // Indicate which slide is active through the slide dots. This change is made before the transition so that it feels "snappier".
  dotButtons[index].setAttribute('aria-current', true);
}

/**
  After a transition is complete, ensure all the newly non-visible eplistingslides are fully hidden.
*/
function handleSettle(index) {
  // Hide all non-visible eplistingslides
  hideNonVisibleeplistingslides();
  
  // Allow interactive elements on the new current slide to receive keyboard focus
  eplistingslides[index].querySelectorAll('a, button').forEach(function(element) {
    element.removeAttribute('tabindex');
  });
}


/**
  Disable or enable built-in autoplay functionality
*/
function toggleAutoplay() {
  if(isPaused) {
    enableAutoplay();
  } else {
    disableAutoplay();
  }
}

function disableAutoplay() {
  // Stop automatic slide rotation
  $eplistingcarousel.flickity('stopPlayer');

  // Switch the rotation button icon to "resume"
  pauseContainer.classList.remove('is-visible');
  resumeContainer.classList.add('is-visible');
  
  isPaused = true;
}

function enableAutoplay() {
  // Start automatic slide rotation
  $eplistingcarousel.flickity('playPlayer');

  // Switch the rotation button icon to "pause"
  pauseContainer.classList.add('is-visible');
  resumeContainer.classList.remove('is-visible');
  
  isPaused = false;
}


/**
  Fully hide non-visible eplistingslides for all users when they exit the view.
*/
function hideNonVisibleeplistingslides() {
  var hiddeneplistingslides = document.querySelectorAll('.eplistingcarousel .eplistingslides .slide:not(.is-selected)');

  hiddeneplistingslides.forEach(function(slide) {
    // Hide each slide using `visibility: hidden` to be extra-sure
    slide.classList.add('is-hidden');

    // Prevent any interactive element on non-visible eplistingslides from receiving keyboard focus
    slide.querySelectorAll('a, button').forEach(function(element) {
      element.setAttribute('tabindex', -1);
    });
  });
}


/**
  Create custom slide dots and inject them into the custom slide dot container.
  
  Each resulting slide dot follows this pattern:
  <li class="slide-dot">
    <button class="slide-eplistingdot-button">
      <span class="sr-only">Go to slide [x]</span>
    </button>
  </li>
*/
function createSlideDots() {
  for(var i=0; i<eplistingslides.length; i++) {
    // <li class="slide-dot">
    var newDot = document.createElement('li');
    newDot.classList.add('dot');
    
    // <button class="slide-eplistingdot-button">
    var newDotButton = document.createElement('button');
    newDotButton.classList.add('eplistingdot-button');
    
    // <span class="sr-only">Go to slide [x]</span>
    var newDotButtonContent = document.createElement('span');
    newDotButtonContent.classList.add('sr-only');
    newDotButtonContent.innerHTML = 'Go to slide ' + (i+1);
    
    // Navigate to the right slide and disable autoplay when this slide dot is activated
    newDotButton.addEventListener('click', function(e) {
      disableAutoplay();
      var index = Array.prototype.slice.call(dotButtons).indexOf(e.target);
      $eplistingcarousel.flickity('select', index);
    });
    
    // Construct the full DOM structure of this slide dot and inject it into the container
    newDotButton.append(newDotButtonContent);
    newDot.append(newDotButton);
    dotsContainer.append(newDot);
  }
}