<?php
/**
 * Compatibility functions for the Developer-Driven Custom Post Classes plugin
 */
function cr_ddcpc_options( $options ) {
	$options = array_merge( $options, array(
		array(
			'description' => 'Vertical Alignment',
			'name' => 'vert-alignment',
			'options' => array(
				// class string as output in HTML => display text
				'ddcpc-top' => 'Top',
				'ddcpc-middle' => 'Middle',
				'ddcpc-bottom' => 'Bottom',
			),
		),
		array(
			'description' => 'Horizontal Alignment',
			'name' => 'horiz-alignment',
			'options' => array(
				// class string as output in HTML => display text
				'ddcpc-left' => 'Left',
				'ddcpc-center' => 'Center',
				'ddcpc-right' => 'Right',
			),
		),
		array(
			'description' => 'Color Options',
			'name' => 'color-option',
			'options' => array(
				// class string as output in HTML => display text
				'ddcpc-dark' => 'Dark text',
				'ddcpc-light' => 'Light text',
			),
		),
	));
	return $options;
}
add_filter( 'developer_driven_custom_post_classes_options', 'cr_ddcpc_options' );
