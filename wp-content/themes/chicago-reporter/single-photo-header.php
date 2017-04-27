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

$series = wp_get_post_terms($post->ID, 'series', array("fields" => "all"));


get_header( "longform" );

?>


<?php
		cr_ph_header_tag( get_post_thumbnail_id() );
	?>
</header><!-- / entry header -->

<header class="page-title">
	<?php if ( $series[0] ) : ?>
		<div class="series-top-label">
			<h5 class="entry-title"><?php echo $series[0]->name; ?></h5>
		</div>
	<?php endif; ?>
	<div class="inner">
		<div <?php post_class( 'longform-title' ); ?> >
			<?php largo_maybe_top_term(); ?>

			<h1 class="entry-title" itemprop="headline"><?php the_title(); ?></h1>
			<?php if ( $subtitle = get_post_meta( $post->ID, 'subtitle', true ) ) : ?>
				<h2 class="subtitle"><?php echo $subtitle ?></h2>
			<?php endif; ?>

			<?php largo_post_metadata( $post->ID ); ?>
		</div>
	</div>
</header>
<div id="wrapper">
	<div id="page" class="hfeed clearfix">

		<?php 
			
			get_template_part( 'partials/nav', 'sticky' ); 


			/**
			 * Fires after the Largo navigation content.
			 *
			 * @since 0.4
			*/
			do_action( 'largo_after_nav' );

		?>

		<div id="main" class="row-fluid clearfix">

		<?php

		/**
		 * Fires at the top of the Largo id=main DIV element.
		 *
		 * @since 0.4
		 */
		do_action( 'largo_main_top' ); ?>

	<div id="content" role="main">
		<?php
			while ( have_posts() ) : the_post();

				$shown_ids[] = get_the_ID();

				// this is the primary difference, for now
				$partial = ( is_page() ) ? 'page' : 'single-photo-header';

				get_template_part( 'partials/content', $partial );

				if ( $partial === 'single-photo-header' ) {

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
</div><!--#page-->

<?php do_action( 'largo_after_content' ); ?>

<?php get_footer();
