 <?php

/**
 * Environment
 *
 * development / production
 */



/**
 * Post types that are used in the theme
 */

$post_types = array(
	// 'gallery' => array(
	// 	'config' => array(
	// 		'public' => true,
	// 		'exclude_from_search' => true,
	// 		'menu_position' => 20,
	// 		'has_archive'   => true,
	// 		'supports'=> array(
	// 			'title',
	// 			'editor',
	// 			'page-attributes',
	// 			),
	// 		'show_in_nav_menus' => true,
	// 		),
	// 	'singular' => 'Gallery',
	// 	'multiple' => 'Galleries',
	// ),

	'vendor' => array(
		'config' => array(
			'public' => true,
			'exclude_from_search' => true,
			'menu_position' => 20,
			'has_archive'   => true,
			'supports'=> array(
				'title',
				'thumbnail',
				'comments'
				),
			'show_in_nav_menus' => true,
			),
		'singular' => 'Vendor',
		'multiple' => 'Vendors',
	),

	'article' => array(
		'config' => array(
			'public' => true,
			'exclude_from_search' => true,
			'menu_position' => 20,
			'has_archive'   => true,
			'supports'=> array(
				'title',
				'editor',
				'thumbnail',
				'comments'
				),
			'show_in_nav_menus' => true,
			),
		'singular' => 'Article',
		'multiple' => 'Articles',
	),

);

/**
 * Taxonomies that are used in theme
 */

$taxonomies = array(
	// 'gallery-category'    => array(
	// 	'for'        => array('gallery'),
	// 	'config'    => array(
	// 		'sort'        => true,
	// 		'args'        => array('orderby' => 'term_order'),
	// 		'hierarchical' => true,
	// 		),
	// 	'singular'    => 'Category',
	// 	'multiple'    => 'Categories',
	// ),

	'post-style'    => array(
		'for'        => array('post'),
		'config'    => array(
			'sort'        => true,
			'args'        => array('orderby' => 'term_order'),
			'hierarchical' => true,
			),
		'singular'    => 'Style',
		'multiple'    => 'Styles',
	),

	'post-season'    => array(
		'for'        => array('post'),
		'config'    => array(
			'sort'        => true,
			'args'        => array('orderby' => 'term_order'),
			'hierarchical' => true,
			),
		'singular'    => 'Season',
		'multiple'    => 'Seasons',
	),

	'post-color'    => array(
		'for'        => array('post'),
		'config'    => array(
			'sort'        => true,
			'args'        => array('orderby' => 'term_order'),
			'hierarchical' => false,
			),
		'singular'    => 'Color',
		'multiple'    => 'Colors',
	),

	'post-settings'    => array(
		'for'        => array('post'),
		'config'    => array(
			'sort'        => true,
			'args'        => array('orderby' => 'term_order'),
			'hierarchical' => true,
			),
		'singular'    => 'Setting',
		'multiple'    => 'Settings',
	),

	'vendor-profession'    => array(
		'for'        => array('vendor'),
		'config'    => array(
			'sort'        => true,
			'args'        => array('orderby' => 'term_order'),
			'hierarchical' => true,
			),
		'singular'    => 'Profession',
		'multiple'    => 'Professions',
	),

	'vendor-region'    => array(
		'for'        => array('vendor'),
		'config'    => array(
			'sort'        => true,
			'args'        => array('orderby' => 'term_order'),
			'hierarchical' => true,
			),
		'singular'    => 'Region',
		'multiple'    => 'Regions',
	),

	'vendor-city'    => array(
		'for'        => array('vendor'),
		'config'    => array(
			'sort'        => true,
			'args'        => array('orderby' => 'term_order'),
			'hierarchical' => true,
			),
		'singular'    => 'City',
		'multiple'    => 'Cities',
	),

	'article-category'    => array(
		'for'        => array('article'),
		'config'    => array(
			'sort'        => true,
			'args'        => array('orderby' => 'term_order'),
			'hierarchical' => true,
			),
		'singular'    => 'Articles Category',
		'multiple'    => 'Articles Categories',
	),
);


/**
 * Add post formats that are used in theme
 */

$post_formats = array(
	// 'aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat'
);



/**
 * Sidebars list
 */

$sidebars = array(
	// 'general-sidebar' => 'General Sidebar'
);
