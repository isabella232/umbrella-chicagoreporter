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
				'top' => 'Top',
				'middle' => 'Middle',
				'bottom' => 'Bottom',
			),
		),
		array(
			'description' => 'Horizontal Alignment',
			'name' => 'horiz-alignment',
			'options' => array(
				// class string as output in HTML => display text
				'left' => 'Left',
				'center' => 'Center',
				'right' => 'Right',
			),
		),
		array(
			'description' => 'Color Options',
			'name' => 'color-option',
			'options' => array(
				// class string as output in HTML => display text
				'dark' => 'Dark text',
				'light' => 'Light text',
			),
		),
	));
	return $options;
}
add_action( 'developer_driven_custom_post_classes_options', 'cr_ddcpc_options' );
