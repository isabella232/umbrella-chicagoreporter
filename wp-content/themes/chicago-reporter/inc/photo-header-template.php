<?php
/**
 * functions for the "photo header" templates:
 * - single-photo-header
 * - series-landing-photo-header
 *
 * Functions here should be namespaced cr_ph_
 * @since March 2017
 */

/**
 * Given an attachment ID, generate an opening <header> tag with an inline style attribute
 * The inline style="" contains the background-image information for the photo header.
 * The closing </header> tag is assumed to be present elsewhere in the markup.
 * @param WP_Post|int the attachment image's post or ID
 * @return string HTML
 */
function cr_ph_header_tag( $post ) {
	var_log( $post );
	
	echo '<header style="';
		echo 'background-image:url(http://placekitten.com/4000/3000)';
	echo '">';
}
