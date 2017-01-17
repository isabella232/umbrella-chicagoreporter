<?php
/**
 * Implements a shortcode for showing an archive of landing pages
 * Usage: [landing-archive] will output a basic archive of 10 per page
 * Common attributes/settings (there are more):
 * - text: can be set to 'content', 'excerpt' or the name of a custom meta field
 * - thumb: whether or not to show thumbnails
 * - thumbsize: if showing thumbnails, what size to display
 * - per_page: how many items to show on each page
 * - term: the word to use in the Older/Newer archive nav links
 * - taxonomy: Allows you to limit this to landing pages with a term in the specified taxonomy
 *
 * Example: [landing-archive text='excerpt' thumb='false' per_page='8' term='Series']
 *
 * This is used for the page at /archive/
 * Historical note: this file created May 2016, but the functionality is much older than that.
 */
function landing_archive( $atts ) {

	ob_start();

	$options = shortcode_atts( array(
		'post_type' => 'cftl-tax-landing',
		'text'      => 'content',
		'sort'      => 'date',
		'sortdir'   => 'DESC',
		'thumb'     => 'true',
		'thumbsize' => 'thumbnail',
		'per_page'  => get_option('posts_per_page'),
		'term'      => 'Issues',
		'taxonomy'  => '',
		'exclude'   => '',
	), $atts );

	global $paged, $post;

	$query_opts = array(
		'post_type'           => $options['post_type'],
		'posts_per_page'      => $options['per_page'],
		'paged'               => $paged,
		'ignore_sticky_posts' => true,
		'orderby'             => $options['sort'],
		'order'               => $options['sortdir'],
		'post__not_in'        => explode(',', $options['exclude'] ),
	);

	if ( !empty( $options[ 'taxonomy' ] ) ) {
		$terms = get_terms( $options[ 'taxonomy' ] );
		$term_ids = wp_list_pluck( $terms, 'term_id' );

		$query_opts['tax_query'] = array(
			array(
				'taxonomy' => $options[ 'taxonomy' ],
				'terms' => $term_ids
			)
		);
	}

	//querystring goodness
	if ( isset($_GET['issue-year']) ) {
		$query_opts['year'] = absint( $_GET['issue-year'] );
		$query_opts['posts_per_page'] = 999;
	}

	//select menu
	if ( $paged < 2 ) {
	?><div class="year-select">
			<label for="landing-year">Select Year:</label>
			<select name="landing-year" id="landing-year">
				<option value="">- All - </option>
				<?php
				for ( $i = date('Y'); $i >= 2003; $i-- ) {
					echo '<option value="' . $i . '" ' . selected($_GET['issue-year'], $i, false) . '>' . $i . "</option>";
				}
			?></select>
			<script>
				// select year for landing pages
				jQuery('#landing-year').on('change', function() {
					if ( jQuery(this).val() != '' ) {
						window.location.search = "?issue-year=" + jQuery(this).val();
					} else {
						window.location.search = '';
					}
				});
			</script>
		</div>
	<?php
	}


	$issues = new WP_Query( $query_opts );

	echo '<ul class="landing-archive stories">';
	while ( $issues->have_posts() ) {
		$issues->the_post();
		?>
		<li class="landing-page-<?php the_ID(); ?>">
			<article id="post-<?php the_ID(); ?>" <?php post_class( 'hnews item' ); ?> itemscope itemtype="http://schema.org/Article">
				<?php
					if ( $options['thumb'] == 'true' ) {
						the_post_thumbnail( $options['thumbsize'] );
					}
				?>
		 		<h1 class="entry-title" itemprop="headline"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
				<div class="entry-content clearfix" itemprop="articleBody">
					<?php
						if ( $options['text'] == 'content' ) {
							the_content();
						} else if ( $options['text'] == 'excerpt' ) {
							the_excerpt();
						} else {
							$text = get_post_meta( get_the_ID(), $options['text'], true );
							echo apply_filters( 'the_content', $text );
						}
					?>
				</div>
			</article>
		</li>
		<?php
	} // end while

	echo '</ul>';

	wp_reset_postdata();

	//render paged links
	if ( $issues->found_posts > $issues->post_count ) {
		echo '<nav id="landing-archive-nav" class="pager">';
		// if we're not on the first page, show a link to move toward it
		if ( $paged > 1 ) {
			$page = ( $paged == 2 ) ? "" : "page/" . ($paged - 1); // no need to output "/page/1"
			echo '<div class="next"><a href="' . get_permalink() . $page . '">Newer ' . $options['term'] . ' →</a></div>';
		}
		// if there are more pages than the one we're on, show a link
		if ( $paged < $issues->max_num_pages ) {
			if ( $paged == 0 ) $paged = 1;  // no page specified makes $paged = null/0... which is actually equivalent to 1 and means next page is 2
			echo '<div class="previous"><a href="' . get_permalink() . 'page/' . ($paged + 1) . '">← Older ' . $options['term'] . '</a>';
		}
		echo "</nav>";
	}

	return apply_filters('landing-archive-output', ob_get_clean() );

}
add_shortcode( 'landing-archive', 'landing_archive' );
