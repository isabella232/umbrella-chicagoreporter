<?php
include_once get_template_directory() . '/homepages/homepage-class.php';

class ChicagoReporter extends Homepage {
	var $name = 'Chicago Reporter';
	var $type = 'chicagoreporter';
	var $description = 'A modified version of "Top Stories" template created for Chicago Reporter by Cornershop Creative';
	var $sidebars = array(
		'Homepage Left Rail (An optional widget area that, when enabled, appears to the left of the main content area on the homepage)'
	);
	var $rightRail = true;

	function __construct($options=array()) {
		$defaults = array(
			'template' => get_stylesheet_directory() . '/homepages/templates/chicagoreporter.php',
			'assets' => array(
				array('homepage-slider', get_stylesheet_directory_uri() . '/homepages/assets/css/cr_homepage.min.css', array())
			)
		);
		$options = array_merge($defaults, $options);
		$this->init($options);
		$this->load($options);
	}

	public function init($options=array()) {
		$this->prominenceTerms = array(
			array(
				'name' => __('Homepage Featured', 'largo'),
				'description' => __('If you are using the Newspaper or Carousel optional homepage layout, add this label to posts to display them in the featured area on the homepage.', 'largo'),
				'slug' => 'homepage-featured'
			),
		);
	}
}

/**
 * Register this layout
 */
function cr_custom_homepage_layouts() {
	register_homepage_layout( 'ChicagoReporter' );
}
add_action( 'init', 'cr_custom_homepage_layouts' );

// Homepage widget region
function cr_widets() {
	// for Homepage upper right "Donate" section
	register_sidebar( array(
		'name' => 'Home Right Top',
		'id' => 'home_right_top',
		'description'   => 'Region atop the homepage in the upper right.',
		'before_widget' => '<div id="home-upper-right">',
		'after_widget' => '</div>',
		'before_title' => '<h4>',
		'after_title' => '</h4>',
	) );
}
add_action( 'widgets_init', 'cr_widets' );

/**
 * For simplicity's sake, keep the sidebar name and just output it in the same place that Largo does the one with the other name.
 */
function cr_largo_header_after_largo_header() {
	dynamic_sidebar( 'home_right_top' );
}
add_action( 'largo_header_after_largo_header', 'cr_largo_header_after_largo_header' );
