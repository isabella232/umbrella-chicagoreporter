<?php
/**
 * Template for reporter-issue term archive pages
 *
 * @package Largo
 * @since 0.4
 * @filter largo_partial_by_post_type
 */
get_header();

global $tags, $paged, $post, $shown_ids;

$title = single_cat_title( '', false );
$description = category_description();
$rss_link = get_category_feed_link( get_queried_object_id() );
$posts_term = of_get_option( 'posts_term_plural', 'Stories' );
$queried_object = get_queried_object();


// Here we determine whether to use the series landing page's meta or the term taxonomy's meta
if ( $queried_object->taxonomy == 'reporter-issues' || $queried_object->taxonomy == 'reporter-issues' ) {
	// Assuming that the queried object is an instance of WP_Term here, we proceed to load it.
	$landing_page = cr_get_cftl_landing_page_for_term( $queried_object );
}

if ( isset( $landing_page->ID ) ) {
	$post_id = $landing_page->ID;

	// because there's no other way to do this
	ob_start();
	$backup = $post;
	$post = $landing_page;
	setup_postdata($post);
	the_content();

	$description = ob_get_clean();
	$post = $backup;
	wp_reset_postdata();

	$title = get_the_title( $post_id );
	// the content of these archive pages includes a shortcode that renders the thumbnail; so we'll not use that here
	$thumbnail = '';

	// Because this template is taking the place of Largo's cftl-tax-landing template for these terms
	$edit_link = true;
} else {
	$post_id = largo_get_term_meta_post( $queried_object->taxonomy, $queried_object->term_id );
	$thumbnail = get_the_post_thumbnail( $post_id, 'thumbnail' );
	$edit_link = false;
}


?>

<div class="clearfix">
	<header class="archive-background clearfix">
		<a class="rss-link rss-subscribe-link" href="<?php echo $rss_link; ?>"><?php echo __( 'Subscribe', 'largo' ); ?> <i class="icon-rss"></i></a>
		<h1 class="page-title"><?php echo $title; ?></h1>
		<?php
			echo $thumbnail;
		?>
		<div class="archive-description"><?php echo $description; ?></div>
		<?php
			if ( $edit_link ) {
				edit_post_link(
					__( 'Edit landing page for this issue', 'cr' ),
					null,
					null,
					$post_id
				);
			}
		?>
		<?php do_action( 'largo_category_after_description_in_header' ); ?>
	</header>
</div>

<div class="row-fluid clearfix">
	<div class="stories span8" role="main" id="content">
	<?php
		do_action( 'largo_before_category_river' );
		if ( have_posts() ) {
			$counter = 1;
			while ( have_posts() ) {
				the_post();
				$post_type = get_post_type();
				$partial = largo_get_partial_by_post_type( 'reporter-issues', $post_type, 'reporter-issues' );
				get_template_part( 'partials/content', $partial );
				do_action( 'largo_loop_after_post_x', $counter, $context = 'reporter-issues' );
				$counter++;
			}
			largo_content_nav( 'nav-below' );
		} else {
			get_template_part( 'partials/content', 'not-found' );
		}
		do_action( 'largo_after_category_river' );
	?>
	</div>
	<?php get_sidebar(); ?>
</div>

<?php get_footer();
