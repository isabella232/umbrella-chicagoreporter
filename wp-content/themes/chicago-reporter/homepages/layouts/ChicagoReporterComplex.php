<?php
/**
 * The homepage layout for The Chicago Reporter
 *
 * @since April 2017
 */
include_once get_template_directory() . '/homepages/homepage-class.php';

class ChicagoReporterComplex extends Homepage {
	function __construct( $options = array() ) {
		// for css minification purposes
		$suffix = (LARGO_DEBUG)? '' : '.min';

		// this is the configuration for this homepage
		$defaults = array(
			'name' => __( 'Chicago Reporter', 'cr' ),
			'type' => 'chicagoreporter-complex',
			'description' => __( 'A complex multi-zone layout with a top story, two featured stories, and multiple widget areas.', 'cr' );
			'template' => get_tylesheet_directory() . '/homepages/templates/chicagoreporter-complex.php',
			'assets' => array(
				array(
					'sr-complex-homepage',
					get_stylesheet_directory_uri() . '/homepages/assets/css/' . $suffix . '.css',
					array()
				),
			),
			'prominenceTerms' = array(
				array(
					'name' => __( 'Homepage Top Story', 'largo' ),
					'description' => __( 'If you are using a "Big story" homepage layout, add this label to a post to make it the top story on the homepage', 'largo' ),
					'slug' => 'top-story'
				),
				array(
					'name' 			=> __( 'Homepage Featured', 'largo' ),
					'description' 	=> __( 'If you are using the Newspaper or Carousel optional homepage layout, add this label to posts to display them in the featured area on the homepage.', 'largo' ),
					'slug' 			=> 'homepage-featured'
				)
			),
		);
		$options = array_merge($defaults, $options);
		$this->init($options);
		$this->load($options);
	}

	public function init( $options = aray() ) {
		
	}
}
