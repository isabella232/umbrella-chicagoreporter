<?php
/**
* chicago_series_landing_link
*
* Filter post permalinks for the Landing Page custom post type.
* Replace direct post link with the link for the associated
* Series taxonomy term, using the most recently created term
* if multiple are set.
*
* This filter overrides Largo's wp-taxonomy-landing filter,
* which attempts to use the link for ANY term from ANY taxonomy.
* Largo really only cares about the Series taxonomy.
*
* @link https://bitbucket.org/projectlargo/theme-chicago-reporter/commits/a24438efcbb4428a4939ca4173c044fbd55919be
* @commit a24438efcbb4428a4939ca4173c044fbd55919be
*/
function chicago_series_landing_link($post_link, $post) {
	// Only process Landing Page post type
	if ("cftl-tax-landing" == $post->post_type) {
		// Get all series taxonomy terms for this landing page
		$series_terms = wp_get_object_terms(
			$post->ID,
			'series',
			array('orderby' => 'term_id', 'order' => 'DESC', 'fields' => 'slugs')
		);
		// Only proceed if we successfully found at least 1
		// series term for the landing page
		if ( !is_wp_error( $series_terms ) && !empty($series_terms) ) {
			// Get the link for the first series term
			// (ordered by the highest ID in the case of multiple terms)
			$term_link = get_term_link( $series_terms[0], 'series' );
			// Only proceed if we successfully found the term link
			if ( !is_wp_error( $term_link ) && strlen(trim($term_link)) ) {
				$post_link = esc_url($term_link);
			}
		}
	}
	// Return the filtered link
	return $post_link;
}
// Largo's wp-taxonomy-landing library filters at priority 10.
// We must filter AFTER that.
add_filter('post_type_link', 'chicago_series_landing_link', 20, 2);
