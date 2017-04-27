<?php
/**
 * Template Name: Series Landing Page, Photo Header
 * Description: The default template for a series landing page. Many display options are set via admin. This has a full-width featured image header.
 *
 * Things that don't work in this template:
 * - the layout chooser
 * - the posts-per-page chooser (9 is forced)
 */

add_filter( 'body_class', function( $classes ) {
	$classes[] = 'photo-header';
	return $classes;
} );

get_header( 'longform' );
$subhead = get_post_meta( $post->ID, '_cr_subhead', true );

// Load up our meta data and whatnot
the_post();

//make sure it's a landing page.
if ( 'cftl-tax-landing' == $post->post_type ) {
	$opt = get_post_custom( $post->ID );
	foreach( $opt as $key => $val ) {
		$opt[ $key ] = $val[0];
	}
	$opt['show'] = maybe_unserialize($opt['show']);	//make this friendlier
	if ( 'all' == $opt['per_page'] ) $opt['per_page'] = -1;
	/**
	 * $opt will look like this:
	 *
	 *	Array (
	 *		[header_enabled] => boolean
	 *		[show_series_byline] => boolean
	 *		[show_sharebar] => boolean
	 *		[header_style] => standard|alternate
	 *		[cftl_layout] => one-column|two-column|three-column
	 *		[per_page] => integer|all
	 *		[post_order] => ASC|DESC|top, DESC|top, ASC
	 *		[footer_enabled] => boolean
	 *		[footerhtml] => {html}
	 *		[show] => array with boolean values for keys byline|excerpt|image|tags
	 *	)
	 *
	 * The post description is stored in 'excerpt' and the custom HTML header is the post content
	 */
}

?>

<?php if ( $opt['header_enabled'] ) : ?>
	<?php
			cr_ph_header_tag( get_post_thumbnail_id() );
		?>		
	</header><!-- / entry header -->
<?php endif; ?>

<header class="page-title">
	<div class="inner">
		<section id="series-header" class="span12">
			<h1 class="entry-title"><?php the_title(); ?></h1>
			<?php
			if ( $opt['show_series_byline'] )
				echo '<h5 class="byline">' . largo_byline( false ) . '</h5>';
			?>
			<div class="series-subhead">
				<?php echo $subhead; ?>
			</div>
		</section>
	</div>
</header>
<div id="wrapper">
	<div id="page" class="hfeed clearfix">
		<div class="series-social">
			<?php if ( $opt['show_sharebar'] ) {
					largo_post_social_links(); 
				}
			?>
			<?php if ( isset( $rss_link ) ) {
		   		printf( '<a class="rss-link rss-subscribe-link" href="%1$s">%2$s <i class="icon-rss"></i></a>', $rss_link, __( 'Subscribe', 'largo' ) );
		   		}
		    ?>
	    </div>
		<div id="series-intro">
			<div class="series-description">
				<?php echo apply_filters( 'the_content', $post->post_excerpt ); ?>
			</div>
			<div class="series-action">
			<?php echo do_shortcode('[action-box message="Want the latest from the reporter delivered straight to your inbox? Subscribe to our free email newsletter."]'); ?>
			</div>
		</div>

		<div class="series-divider">
			<div class="divider-line"></div>
		</div>

		<?php 
			
			get_template_part( 'partials/nav', 'sticky' ); 
			
			if ( of_get_option( 'leaderboard_enabled' ) == TRUE ) {
				get_template_part( 'partials/header-ad-zone' );
			}

			/**
			 * Fires before the Largo header content.
			 *
			 * @since 0.4
			 */
			do_action( 'largo_before_header' );

			get_template_part( 'partials/largo-header' );

			/**
			 * Fires after the Largo header content.
			 *
			 * @since 0.4
			 */
			do_action( 'largo_after_header' );

			get_template_part( 'partials/nav', 'main' );

			if ( SHOW_SECONDARY_NAV === TRUE ) {
				get_template_part( 'partials/nav', 'secondary' );
			}

			get_template_part('partials/homepage-alert'); 

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
		/**
		 * The header HTML field, labeled "Custom HTML" in the series landing page editor.
		 * If it doesn't exist, remove it.
		 */
		if ( 'standard' == $opt['header_style'] ) {
			//need to set a size, make this responsive, etc
		} else { ?>
			<div id="embedded-html" class="stories" role="main">
				<section class="entry-content">
					<?php the_content(); ?>
				</section>
			</div>

			<div class="series-divider">
				<div class="divider-line"></div>
			</div>
		<?php }
	?>

	<div id="series-main" class="clearfix">

	<?php

	global $wp_query, $post;

	// Make sure we're actually a series page, and pull posts accordingly
	if ( isset( $wp_query->query_vars['term'] )
			&& isset( $wp_query->query_vars['taxonomy'] )
			&& 'series' == $wp_query->query_vars['taxonomy'] ) {

		$series = $wp_query->query_vars['term'];

		//default query args: by date, descending
		$args = array(
			'p' 				=> '',
			'post_type' 		=> 'post',
			'taxonomy' 			=> 'series',
			'term' 				=> $series,
			'order' 			=> 'DESC',
			'posts_per_page' 	=> 6 // should be 9
		);

		//stores original 'paged' value in 'pageholder'
		global $cftl_previous;
		if ( isset($cftl_previous['pageholder']) && $cftl_previous['pageholder'] > 1 ) {
			$args['paged'] = $cftl_previous['pageholder'];
			global $paged;
			$paged = $args['paged'];
		}

		//change args as needed
		//these unusual WP_Query args are handled by filters defined in cftl-series-order.php
		switch ( $opt['post_order'] ) {
			case 'ASC':
				$args['orderby'] = 'ASC';
				break;
			case 'custom':
				$args['orderby'] = 'series_custom';
				break;
			case 'featured, DESC':
			case 'featured, ASC':
				$args['orderby'] = $opt['post_order'];
				break;
		}

		$series_query = new WP_Query($args);
		$counter = 1;
		while ( $series_query->have_posts() ) : $series_query->the_post();
			get_template_part( 'partials/content', 'series' );
			do_action( 'largo_loop_after_post_x', $counter, $context = 'archive' );
			$counter++;
		endwhile;
		wp_reset_postdata();

		// Enqueue the LMP data
		$posts_term = of_get_option('posts_term_plural');
		largo_render_template('partials/load-more-posts', array(
			'nav_id' => 'nav-below',
			'the_query' => $series_query,
			'posts_term' => ($posts_term)? $posts_term : 'Posts'
		));
	} ?>
		</div><!-- /.row inner div -->
	</div><!-- /.grid_8 #content -->

	</div> <!-- #main -->
</div><!-- #page -->

<?php // display left rail

//display series footer
if ( 'none' != $opt['footer_style'] ) : ?>
	<section id="series-footer">
		<?php
			/*
			 * custom footer html
			 * If we don't reset the post meta here, then the footer HTML is from the wrong post. This doesn't mess with LMP, because it happens after LMP is enqueued in the main column.
			 */
			wp_reset_postdata();
			if ( 'custom' == $opt['footer_style']) {
				echo apply_filters( 'the_content', $opt['footerhtml'] );
			} else if ( 'widget' == $opt['footer_style'] && is_active_sidebar( $post->post_name . "_footer" ) ) { ?>
				<aside id="sidebar-bottom">
				<?php dynamic_sidebar( $post->post_name . "_footer" ); ?>
				</aside>
			<?php }
		?>
	</section>
<?php endif; ?>

<!-- /.grid_4 -->
<?php get_footer();
