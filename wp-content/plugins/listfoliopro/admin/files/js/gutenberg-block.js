"use strict";
var el = wp.element.createElement,
    registerBlockType = wp.blocks.registerBlockType,
    blockStyle = {};

registerBlockType('listfoliopro/price-table', {
	title: 'Pricing Table',
	icon: 'dashicons dashicons-money-alt ',
	category: 'listfoliopro-category',  		  
	edit: function() {
        return el( 'p', '', '[listfoliopro_price_table]' );
    },
    save: function() {
        return el( 'p', '', '[listfoliopro_price_table]' );
    },
});


registerBlockType('listfoliopro/registration-form', {
	title: 'Registration Form',
	icon: 'dashicons dashicons-forms',
	category: 'listfoliopro-category',  		  
	edit: function() {
        return el( 'p', '', '[listfoliopro_form_wizard]' );
    },
    save: function() {
        return el( 'p', '', '[listfoliopro_form_wizard]' );
    },
});

registerBlockType('listfoliopro/my-account', {
	title: 'My Account',
	icon: 'dashicons dashicons-universal-access',
	category: 'listfoliopro-category',  		  
	edit: function() {
        return el( 'p', '', '[listfoliopro_profile_template]' );
    },
    save: function() {
        return el( 'p', '', '[listfoliopro_profile_template]' );
    },
});



registerBlockType('listfoliopro/author-profile-public', {
	title: 'Author profile',
	icon: 'dashicons dashicons-bank',
	category: 'listfoliopro-category',  		  
	edit: function() {
        return el( 'p', '', '[listfoliopro_profile_public]' );
    },
    save: function() {
        return el( 'p', '', '[listfoliopro_profile_public]' );
    },
});

registerBlockType('listfoliopro/login', {
	title: 'Login Form',
	icon: 'dashicons dashicons-unlock',
	category: 'listfoliopro-category',  		  
	edit: function() {
        return el( 'p', '', '[listfoliopro_login]' );
    },
    save: function() {
        return el( 'p', '', '[listfoliopro_login]' );
    },
});

registerBlockType('listfoliopro/author-directory', {
	title: 'Author Directory',
	icon: 'dashicons dashicons-admin-home',
	category: 'listfoliopro-category',  		  
	edit: function() {
        return el( 'p', '', '[listfoliopro_author_directory]' );
    },
    save: function() {
        return el( 'p', '', '[listfoliopro_author_directory]' );
    },
});


registerBlockType('listfoliopro/categories-image', {
	title: 'Categories Block',
	icon: 'dashicons dashicons-category',
	category: 'listfoliopro-category',  		  
	edit: function() {
        return el( 'p', '', '[listfoliopro_categories]' );
    },
    save: function() {
        return el( 'p', '', '[listfoliopro_categories]' );
    },
});

registerBlockType('listfoliopro/featured', {
	title: 'Featured Listing',
	icon: 'dashicons dashicons-sticky',
	category: 'listfoliopro-category',  		  
	edit: function() {
        return el( 'p', '', '[listfoliopro_featured]' );
    },
    save: function() {
        return el( 'p', '', '[listfoliopro_featured]' );
    },
});

registerBlockType('listfoliopro/map-full', {
	title: 'Map Full',
	icon: 'dashicons dashicons-location-alt',
	category: 'listfoliopro-category',  		  
	edit: function() {
        return el( 'p', '', '[listfoliopro_map]' );
    },
    save: function() {
        return el( 'p', '', '[listfoliopro_map]' );
    },
});
registerBlockType('listfoliopro/all-listing', {
	title: 'All Listing With map',
	icon: 'dashicons dashicons-grid-view',
	category: 'listfoliopro-category',  		  
	edit: function() {
        return el( 'p', '', '[listfoliopro_archive_grid]' );
    },
    save: function() {
        return el( 'p', '', '[listfoliopro_archive_grid]' );
    },
});
registerBlockType('listfoliopro/all-listing-without-map', {
	title: 'All Listing Without map',
	icon: 'dashicons dashicons-grid-view',
	category: 'listfoliopro-category',  		  
	edit: function() {
        return el( 'p', '', '[listfoliopro_archive_grid_no_map]' );
    },
    save: function() {
        return el( 'p', '', '[listfoliopro_archive_grid_no_map]' );
    },
});

registerBlockType('listfoliopro/search-form', {
	title: 'Search Form',
	icon: 'dashicons dashicons-search',
	category: 'listfoliopro-category',  		  
	edit: function() {
        return el( 'p', '', '[listfoliopro_search]' );
    },
    save: function() {
        return el( 'p', '', '[listfoliopro_search]' );
    },
});

registerBlockType('listfoliopro/filter', {
	title: 'Filter',
	icon: 'dashicons dashicons-admin-settings',
	category: 'listfoliopro-category',  		  
	edit: function() {
        return el( 'p', '', '[listfoliopro_listing_filter]' );
    },
    save: function() {
        return el( 'p', '', '[listfoliopro_listing_filter]' );
    },
});













