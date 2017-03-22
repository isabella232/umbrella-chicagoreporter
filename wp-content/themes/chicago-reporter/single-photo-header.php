<?php
/**
 * Single Post Template: Photo Header Layout
 * Template Name: Photo Header Layout
 * Description: Shows the post with a full-width header image and a small right sidebar 
 */

global $shown_ids;

add_filter( 'body_class', function( $classes ) {
	$classes[] = 'photo-header';
	return $classes;
} );

// todo benlk: may need to change this to use a different header if we're gonna force sticky
get_header();
?>

<div id="content" role="main">
	<?php
		while ( have_posts() ) : the_post();

			$shown_ids[] = get_the_ID();

			// this is the primary difference, for now
			$partial = ( is_page() ) ? 'page' : 'single-photo-header';

			get_template_part( 'partials/content', $partial );

			if ( $partial === 'single' ) {

				do_action( 'largo_before_post_bottom_widget_area' );

				do_action( 'largo_post_bottom_widget_area' );

				do_action( 'largo_after_post_bottom_widget_area' );

				do_action( 'largo_before_comments' );

				comments_template( '', true );

				do_action( 'largo_after_comments' );
			}

		endwhile;
	?>
</div>

<?php do_action( 'largo_after_content' ); ?>

<?php get_footer();
