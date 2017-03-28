<?php
/**
 * Compatibility functions for the Developer-Driven Custom Post Classes plugin
 */
function cr_ddcpc_options( $options ) {
	return $options;
}
add_action( 'developer_driven_custom_post_classes_options', 'cr_ddcpc_options' );
