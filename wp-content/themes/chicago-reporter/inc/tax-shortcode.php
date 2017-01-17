<?php
/**
 * Functions related to the Tax Term List shortcode
 * Note that this was copied from RNS, and was rather heavily modified from there.
 */

/**
 * Output a list of terms in the given taxonomy, using the [tax_term_list] shortcode
 *
 * The output list will be a div.tax-term-listing of div.item elements with the addtional class of the term item's id.
 *
 * Setting 'taxonomy=""' to a taxonomy will set the taxonomy that the terms will be searched for in. This setting is REQUIRED.
 *
 * Setting 'exclude=""' to a list of comma-separated IDs will exclude those term IDs from the listing.
 * Setting 'include=""' to a list of comma-separated IDs will make the shortcode *only* return those term IDs.
 *
 * @link https://developer.wordpress.org/reference/functions/get_terms/
 * @uses cr_get_cftl_landing_page_for_term
 */
function tax_term_archive_shortcode( $atts, $context, $tag ) {
	/*
	 * Gather the terms
	 * For details of how these args work, see get_terms: https://developer.wordpress.org/reference/functions/get_terms/
	 * get_terms is called by get_categories: https://developer.wordpress.org/reference/functions/get_categories/
	 */
	$tax_args = array(
		'orderby' 	=> 'name',
		'taxonomy' 	=> '',
		'hide_empty' => false,
		'orderby' => 'term_id',
		'order' => 'DESC'
	);
	if ( isset($atts['exclude']) ) {
		$tax_args['exclude'] = $atts['exclude'];
	}
	if ( isset($atts['include']) ) {
		$tax_args['include'] = $atts['include'];
	}
	if ( isset($atts['taxonomy']) && taxonomy_exists($atts['taxonomy']) ) {
		$tax_args['taxonomy'] = $atts['taxonomy'];
	} else {
		// if 'taxonomy' isn't set, abort
		$taxonomies = get_taxonomies();
		$tax_list = join(', ', $taxonomies);
		return "<!-- The 'taxonomy' argument of the shortcode was not set or was not set to an existing taxonomy, and so the shortcode is not outputting an archive.
		Available taxonomies: $tax_list
		Example shortcode: [tax_term_list taxonomy='category'] -->";
	}

	$terms = get_categories($tax_args);

	$argarray = array(
		'atts' => $atts,
		'context' => $context,
		'tag' => $tag
	);

	/*
	 * output the terms
	 */
	ob_start();
	
	// this copies the styles from the [landing-archive] shortcode over in inc/landing-archive-shortcode.php
	echo '<div class="tax-term-listing ' . $atts['taxonomy'] . '-list landing-archive stories">';
	foreach ( $terms as $term ) {
		
		// Set up some variables so we can overwrite them later
		$term_name = $term->name;
		$term_description = $term->category_description;

		if ( $term->taxonomy == 'reporter-issues' || $term->taxonomy =='catalyst-issues' ) {
			
			$landing_page = cr_get_cftl_landing_page_for_term( $term );

			if ( !empty ($landing_page) ) {
				$relevant_post = $landing_page;
				$thumbnail = get_the_post_thumbnail( $relevant_post, 'thumbnail' );
				$term_description = get_the_excerpt( $relevant_post );
			} else {
				$relevant_post = largo_get_term_meta_post( $term->taxonomy, $term->term_id );
				$thumbnail = get_the_post_thumbnail( $relevant_post, 'thumbnail' );
			}
		}

		$argarray = array(
			'term' => $term,
			'taxonomy' => $term->taxonomy
		);

		$classes = join( ' ', get_post_class( '', $relevant_post ) );
		?>
			<div class="item <?php echo $classes; ?>">
				<?php echo $thumbnail; ?>
				<?php do_action( 'largo_tax_term_archive_shortcode_before_title', $argarray); ?>
				<h1 class="entry-title"><a href="<?php echo get_term_link( $term, $term->taxonomy ); ?>"><?php echo $term->name; ?></a></h1>
				<?php do_action( 'largo_tax_term_archive_shortcode_after_title', $argarray); ?>
				<?php do_action( 'largo_tax_term_archive_shortcode_before_description', $argarray); ?>
				<div class="entry-content">
					<?php if ($term->category_description) echo '<p>' . $term_description . '</p>'; ?>
				</div>
				<?php do_action( 'largo_tax_term_archive_shortcode_after_description', $argarray); ?>
			</div>
		<?php
	}
	wp_reset_postdata();
	echo '</div>';

	$ret = ob_get_clean();
	return $ret;
}
add_shortcode('tax_term_list', 'tax_term_archive_shortcode');

/**
 * given a term object, return the id of the landing page
 * @see taxt_term_archive_shortcode
 */
function cr_get_cftl_landing_page_for_term( $term ) {
	$args =  array(
		'post_type' => 'cftl-tax-landing',
		'posts_per_page' => 1,
		'post_status' => 'any',
		'tax_query' => array(
			array(
				'taxonomy' => $term->taxonomy,
				'terms' => $term->term_id
			)
		)
	);
	$landing_page_query = new WP_Query( $args );

	$landing_page = $landing_page_query->posts;

	if ( $landing_page ) {
		return get_post($landing_page[0]);
	}

	return false;

}
