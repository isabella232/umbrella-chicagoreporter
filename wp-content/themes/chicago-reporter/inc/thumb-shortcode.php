<?php
/**
 * Featured image shortcode for archives
 * Implemented because all the Landing Page posts have [featured_image] in their body
 *
 * Historical note: This file was created May 2016, but the shortcode is much, much older than that.
 */
function thumb_shortcode( $atts ) {

	$options = shortcode_atts( array(
		'size' => 'medium',
	), $atts );

	global $post;

	the_post_thumbnail( $options['size'] );
}
add_shortcode( 'featured_image', 'thumb_shortcode' );
