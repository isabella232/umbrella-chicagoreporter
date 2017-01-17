<?php
/*
 * The default template for displaying content
 *
 * @package Largo
 */
$values = get_post_custom( $post->ID );
?>
<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix content-tiny'); ?>>

	<?php 
		if ( get_the_post_thumbnail() ) {
			echo '<a href="' . get_permalink() . '">' . get_the_post_thumbnail( $post_id, 'thumbnail', array( 'class' => 'alignleft thumb' ) ) . '</a>'; 
		}
	?>
	<h3 class="entry-title">
	 	<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute( array( 'before' => __( 'Permalink to', 'largo' ) . ' ' ) )?>" rel="bookmark"><?php the_title(); ?></a>
	</h3>
	<h5 class="byline"><?php largo_byline( true, false, $post->ID ); ?></h5>

</article><!-- #post-<?php the_ID(); ?> -->