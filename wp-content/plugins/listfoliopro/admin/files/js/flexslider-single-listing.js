"use strict";


(function ($) {
  'use strict';
  jQuery(document).ready(function () {
		jQuery("#listfoliopro-listing-details-slider").slick({
		  slidesToShow: 1,
		  slidesToScroll: 1,
		  autoplay: true,
		  autoplaySpeed: 4000, //interval
		  speed: 1500, // slide speed
		  dots: true,
		  arrows: true,
		  infinite: true,
		  fade: true,
		  pauseOnHover: false,
		  centerMode: false,		
		prevArrow: '<button type="button" class="slick-arrow slick-prev"><i class="fa fa-chevron-left"></i><span class="textnav">Previous</span></button>',
		nextArrow: '<button type="button" class="slick-arrow slick-next"><span class="textnav">Next</span><i class="fa fa-chevron-right"></i></button>'
		  
		});
  });
})(jQuery);