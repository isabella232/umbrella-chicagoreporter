<?php
/**
 * The default template for displaying content in an archive
 *
 * Removes the Homepage Featured special treatment, seen in https://github.com/INN/Largo/blob/v0.5.4/partials/content.php
 */
$tags = of_get_option( 'tag_display' );
$hero_class = largo_hero_class( $post->ID, FALSE );
$values = get_post_custom( $post->ID );
$featured = has_term( 'homepage-featured', 'prominence' )
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?>>
	<div class="entry-content">

	<?php
		largo_maybe_top_term();

		echo '<a href="' . get_permalink() . '">' . get_the_post_thumbnail( get_the_ID(), 'list-thumbnail', array('class'=>'attachment-post-thumbnail') ) . '</a>';
	?>

		<h2 class="entry-title">
			<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute( array( 'before' => __( 'Permalink to', 'largo' ) . ' ' ) )?>" rel="bookmark"><?php the_title(); ?></a>
		</h2>

		<h5 class="byline"><?php largo_byline(); ?></h5>

		<?php largo_excerpt( $post, 5, null, null, null, false ); ?>

		<?php if ( !is_home() && largo_has_categories_or_tags() && $tags === 'btm' ) { ?>
			<h5 class="tag-list"><strong><?php _e('More about:', 'largo'); ?></strong> <?php largo_categories_and_tags( 8 ); ?></h5>
		<?php } ?>

	</div><!-- .entry-content -->

</article><!-- #post-<?php the_ID(); ?> -->
