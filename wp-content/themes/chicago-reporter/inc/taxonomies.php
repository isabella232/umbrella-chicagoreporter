<?php
/**
 * Functionality relating to taxonomies in the Chicago Reporter theme
 *
 * During the 2016 merge of Catalyst Chicago into Chicago Reporter, both sites' terms in the series taxonomy were split into three groups:
 * - series that are series
 * - series that are Catalyst magazine issues
 * - series that are Reporter magazine issues
 *
 * From these three groups, the following transformation was made:
 * - series that were series remained series
 * - series that were Catalyst magazine issues became terms in the 'catalyst-issues' taxonomy
 * - series that were Reporter magazine issues became terms in the 'reporter-issues' taxonomy
 *
 * This migration was handled by the functions in inc/cli.php
 */

/**
 * Register the magazine issue taxonomies for Chicago Reporter and Catalyst Chicago.
 *
 * @since Largo 0.5.4
 * @since September 2016
 */
function cr_custom_taxonomies() {
	if ( ! taxonomy_exists( 'catalyst-issues' ) ) {
		register_taxonomy(
			'catalyst-issues',
			'post',
			array(
				'hierarchical' => true,
				'labels' => array(
					'name' => _x( 'Catalyst Issues', 'taxonomy general name' ),
					'singular_name' => _x( 'Ieeus', 'taxonomy singular name' ),
					'search_items' => __( 'Search Catalyst Issues' ),
					'all_items' => __( 'All Reporter Issues' ),
					'parent_item' => __( 'Parent Issue' ),
					'parent_item_colon' => __( 'Parent Issue:' ),
					'edit_item' => __( 'Edit Issue' ),
					'view_item' => __( 'View Issue' ),
					'update_item' => __( 'Update Issue' ),
					'add_new_item' => __( 'Add New Catalyst Issue' ),
					'new_item_name' => __( 'New Catalyst Issue' ),
					'menu_name' => __( 'Catalyst Issues' ),
					'popular_items' => __( 'Popular Catalyst Issues' ),
					'add_or_remove_items' => __( 'Add or remove from Catalyst Issues' ),
					'choose_from_most_used' => __( 'Choose from most-used Catalyst Issues' ),
					'not_found' => __( 'No Catalyst Issues found' ),
				),
				'query_var' => true,
				'rewrite' => true,
			)
		);
	}

	if ( ! taxonomy_exists( 'reporter-issues' ) ) {
		register_taxonomy(
			'reporter-issues',
			'post',
			array(
				'hierarchical' => true,
				'labels' => array(
					'name' => _x( 'Reporter Issues', 'taxonomy general name' ),
					'singular_name' => _x( 'Issue', 'taxonomy singular name' ),
					'search_items' => __( 'Search Reporter Issues' ),
					'all_items' => __( 'All Reporter Issues' ),
					'parent_item' => __( 'Parent Issue' ),
					'parent_item_colon' => __( 'Parent Issue:' ),
					'edit_item' => __( 'Edit Issue' ),
					'view_item' => __( 'View Issue' ),
					'update_item' => __( 'Update Issue' ),
					'add_new_item' => __( 'Add New Reporter Issue' ),
					'new_item_name' => __( 'New Reporter Issue' ),
					'menu_name' => __( 'Reporter Issues' ),
					'popular_items' => __( 'Popular Reporter Issues' ),
					'add_or_remove_items' => __( 'Add or remove from Reporter Issues' ),
					'choose_from_most_used' => __( 'Choose from most-used Reporter Issues' ),
					'not_found' => __( 'No Reporter Issues found' ),
				),
				'query_var' => true,
				'rewrite' => true,
			)
		);
	}
}
add_action( 'init', 'cr_custom_taxonomies' );

/**
 * Add CR's custom taxonomies to the Largo custom taxonomies list
 * @since Largo 0.5.4
 * @see largo_custom_taxonomy_terms
 * @see cr_custom_taxonomies
 */
function cr_custom_taxonomy_terms( $array ) {
	$array[] = 'catalyst-issues';
	$array[] = 'reporter-issues';
	return $array;
}
add_action( 'largo_custom_taxonomies', 'cr_custom_taxonomy_terms' );

/**
 * About series landing pages for the terms in the issue taxonomies
 *
 * Simply put: There are no landing page post types for these taxonomies.
 * They existed for series, but will not exist anymore. Custom layout bits
 * will be handled by the templates using the existing Largo term
 * featured media
 *
 * @since Largo 0.5.4
 * @see largo_series_landing_link
 * @see lago_get_series_landing_page_by_series
 */

/**
 * Add some taxonomies to the term debt consolidator
 */
function cr_custom_tdc_taxonomies( $taxonomies ) {
	$taxonomies[] = 'series';
	$taxonomies[] = 'reporter-issues';
	$taxonomies[] = 'catalyst-issues';
	$taxonomies[] = 'prominence';
	return $taxonomies;
}
add_filter( 'tdc_enabled_taxonomies', 'cr_custom_tdc_taxonomies', 10, 1 );

/**
 * To prevent post-migration cftl-tax-landing posts from stomping on *-issues taxonomies they belong in, remove the Largo filter that rearranges permalinks to direct traffic to the landing page for the taxonomy.
 *
 * @see cftl_intercept_get_posts
 * @since Largo 0.5.5
 */
function cr_intercept_cftl_intercept_get_posts( &$query_obj ) {
	// cftl_intercept_get_posts checks for is_admin, is_main_query, and so on
	// it does not run then

	// We only need to remove this on the times when cftl_intercept_get_posts would run
	if ( $query_obj->is_tax ) {
		if ( $query_obj->is_tax( 'reporter-issues' ) || $query_obj->is_tax( 'catalyst-issues' ) ) {
			remove_action( 'pre_get_posts', 'cftl_intercept_get_posts', 20 );
		}
	}
}
add_action( 'pre_get_posts', 'cr_intercept_cftl_intercept_get_posts', 10);

/**
 * Make sure we're using the correct partial for the custom taxonomies
 */
function cr_largo_lmp_template_partial( $partial, $query_obj ) {
	if ( $query_obj->is_tax ) {
		if ( $query_obj->is_tax( 'reporter-issues' ) ) {
			$partial = 'reporter-issues';
		}
		if ( $query_obj->is_tax( 'catalyst-issues' ) ) {
			$partial = 'reporter-issues';
		}
	}
	return $partial;
}
add_filter( 'largo_lmp_template_partial', 'cr_largo_lmp_template_partial', 99, 2 );

/**
 * Add the catalyst-issues and reporter-issues taxonomies to the list of taxonomies where the Largo Term Sidebars box is displayed.
 * @filter largo_get_sidebar_taxonomies
 * @since Largo 0.5.5
 */
function cr_largo_get_sidebar_taxonomies( $array ) {
	$array[] = 'catalyst-issues';
	$array[] = 'reporter-issues';
	return $array;
}
add_filter( 'largo_get_sidebar_taxonomies', 'cr_largo_get_sidebar_taxonomies' );
