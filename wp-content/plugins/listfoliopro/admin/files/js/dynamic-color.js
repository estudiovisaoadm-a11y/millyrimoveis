"use strict";
var listfoliopro_primary_color =listfoliopro_color.listfoliopro_primary_color;
var listfoliopro_second_color =listfoliopro_color.listfoliopro_second_color;
var listfoliopro_third_color =listfoliopro_color.listfoliopro_third_color;
var listfoliopro_bg_color =listfoliopro_color.listfoliopro_bg_color;


jQuery( function() { 	
		document.documentElement.style.setProperty('--prime-color', listfoliopro_primary_color);
		document.documentElement.style.setProperty('--second-color', listfoliopro_second_color);
		document.documentElement.style.setProperty('--third-color', listfoliopro_third_color);	
		document.documentElement.style.setProperty('--bg-color', listfoliopro_bg_color);
}); 