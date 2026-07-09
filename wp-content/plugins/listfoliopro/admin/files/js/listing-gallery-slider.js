"use strict";


(function ($) {
  'use strict';
  jQuery(document).ready(function () {
    jQuery("#listfoliopro-listing-details-slider").slick({
      slidesToShow: 1,
      slidesToScroll: 1,
      autoplay: false,
      autoplaySpeed: 4000, //interval
      speed: 1500, // slide speed
      dots: false,
      arrows: false,
      infinite: true,
      fade: true,
      pauseOnHover: false,
      centerMode: false,
      asNavFor: '#listfoliopro-listing-slider-nav'
    });


    var $gallery_slider = $('#listfoliopro-listing-slider-nav');
    var $gallery_progressBar = $('.gallery-slider-progress');
    var $gallery_progressBarLabel = $( '.gallery_slider_label' );

    $gallery_slider.on('beforeChange', function(event, slick, currentSlide, nextSlide) {
      var calc = ( (nextSlide) / (slick.slideCount-1) ) * 100;

      $gallery_progressBar
          .css('background-size', calc + '% 100%')
          .attr('aria-valuenow', calc );

      $gallery_progressBarLabel.text( calc + '% completed' );
    });

    $gallery_slider.slick({
      slidesToShow: 3,
      slidesToScroll: 1,
      autoplay: false,
      autoplaySpeed: 4000, //interval
      speed: 1500, // slide speed
      dots: false,
      arrows: false,
      infinite: true,
      pauseOnHover: false,
      centerMode: false,
      asNavFor: '#listfoliopro-listing-details-slider',
    });
  });
})(jQuery);