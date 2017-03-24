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
function cr_ph_header_tag( $post = null ) {
	$element_id = 'photo-header-' . (string) $post;
	$selector = '#' . $element_id;

	if ( $post ) {
		echo '<style type="text/css">';

		// this could be done with:
		// 1. use get_intermediate_image_sizes to loop through all images with wp_get_attachment_image_src
		// 2. Sort images by width ( $return[1] )
		// 3. procedurally generate the media queries
		// why we're not doing that:
		// - wp_get_attachment_image_src hits the filesystem with each call
		// - there's no reason to use half those image sizes
		$sizes = array(
			// registered image size name => width in pixels
			'medium' => '336',
			'large' => '771',
			'two-third-full' => '780',
			'rect_thumb' => '800', // this is 800x400 exact, we may not want to keep it
			'full' => '1170',
		);

		// loop through the image sizes and generate media queries!
		$prior_size = 0;
		foreach ( $sizes as $slug => $width ) {
			$media_query = <<<'EOF'
				@media (min-width: %1$spx) and (max-width: %2$spx) {
					%3$s {
						background-image: url(%4$s);
					}
				}
EOF;
			$return = wp_get_attachment_image_src( $post, $slug, false );
			printf(
				$media_query,
				$prior_size,
				$width,
				$selector,
				$return[0]
			);
			$prior_size = (int) $width + 1;
		}

		// and now the upper size case of media query
		$media_query_biggest = <<<'EOF'
			@media (min-width: %1$spx) {
				%2$s {
					background-image: url(%3$s);
				}
			}
EOF;
		$return = wp_get_attachment_url( $post );
		printf(
			$media_query_biggest,
			$prior_size,
			$selector,
			$return
		);

		echo '</style>';
	}

	printf(
		'<header id="%1$s" class="%2$s">',
		$element_id,
		$post ? "photo-header-background" : "photo-header-no-background"
	);
}
