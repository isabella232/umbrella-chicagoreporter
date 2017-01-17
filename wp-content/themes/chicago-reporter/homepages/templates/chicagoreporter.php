<?php
/**
 * Home Template: Chicago Reporter
 * Description: A modified version of "Top Stories" template created for Chicago Reporter by Cornershop Creative
 * Sidebars: Homepage Left Rail (An optional widget area that, when enabled, appears to the left of the main content area on the homepage)
 */

global $largo, $shown_ids, $tags;
?>
<div id="homepage-featured" class="row-fluid clearfix">
	<?php if ( is_active_sidebar('homepage-left-rail') ) { ?>
	<div class="top-story span12">
	<?php } else { ?>
	<div class="top-story span12">
	<?php }
		$topstory = largo_get_featured_posts( array(
			'tax_query' => array(
				array(
					'taxonomy' 	=> 'prominence',
					'field' 	=> 'slug',
					'terms' 	=> 'top-story'
				)
			),
			'showposts' => 1
		) );
		if ( $topstory->have_posts() ) :
			while ( $topstory->have_posts() ) : $topstory->the_post(); $shown_ids[] = get_the_ID();

				$featured_media = largo_get_featured_media( get_the_ID() );
				if (in_array($featured_media['type'], array('embed-code', 'video'))) { ?>
					<div class="embed-container">
						<?php echo $featured_media['embed']; ?>
					</div>
				<?php } else { ?>
					<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'large' ); ?></a>
				<?php } ?>

				<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
			    <h5 class="byline"><?php largo_byline(); ?></h5>
			    <?php largo_excerpt( get_the_ID(), 4, false );
			endwhile;
		endif; // end top story ?>
	</div>

	<?php if ( !is_active_sidebar('homepage-left-rail') ) { ?>
	<div class="sub-stories stories">
		<?php $substories = largo_get_featured_posts( array(
			'tax_query' => array(
				array(
					'taxonomy' 	=> 'prominence',
					'field' 	=> 'slug',
					'terms' 	=> 'homepage-featured'
				)
			),
			'showposts'		=> 6,
			'post__not_in' 	=> $shown_ids
		) );
		if ( $substories->have_posts() ) :
			$count = 1;

			while ( $substories->have_posts() ) : $substories->the_post(); $shown_ids[] = get_the_ID();
				?>
					<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?>>
						<div class="entry-content">
						<?php
							largo_maybe_top_term( $args = array( 'echo' => FALSE ) );
						?>
							<?php echo '<a href="' . get_permalink() . '">' . get_the_post_thumbnail( get_the_ID(), 'list-thumbnail', array('class'=>'attachment-post-thumbnail') ) . '</a>'; ?>
							<h2 class="entry-title">
								<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute( array( 'before' => __( 'Permalink to', 'largo' ) . ' ' ) )?>" rel="bookmark"><?php the_title(); ?></a>
							</h2>

							<h5 class="byline"><?php largo_byline(); ?></h5>

							<?php largo_excerpt( get_the_ID(), 5, true, __('Continue&nbsp;Reading', 'largo'), true, false ); ?>

							<?php if ( !is_home() && largo_has_categories_or_tags() && $tags === 'btm' ) { ?>
								<h5 class="tag-list"><strong><?php _e('More about:', 'largo'); ?></strong> <?php largo_categories_and_tags( 8 ); ?></h5>
							<?php } ?>
						</div>
					</article>
				<?php
			endwhile;
		endif; // end more featured posts ?>
	</div>
	<?php } ?>
</div>
