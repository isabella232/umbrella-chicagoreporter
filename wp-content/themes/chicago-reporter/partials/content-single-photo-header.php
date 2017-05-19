<?php
/**
 * The template for displaying content in the single-photo-header.php template
 * - moves byline down
 * - 
 * @since March 2017
 */
?>
<header></header>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'hnews item' ); ?> itemscope itemtype="http://schema.org/Article">

	<?php do_action('largo_before_post_header'); ?>

	

	<?php
		do_action('largo_after_post_header');

		do_action('largo_after_hero');
	?>

	<?php get_sidebar(); ?>

	<header class="entry-header">
		
		<?php 
			$thumb_custom = get_post_custom(get_post_thumbnail_id()); 
			
			if ( $thumb_custom['_media_credit'][0] ) {
				echo '<p class="wp-media-credit">' . $thumb_custom['_media_credit'][0] . '</p>';
			}
		?>
		<figcaption class="series-featured-caption"><?php echo get_post(get_post_thumbnail_id())->post_excerpt; ?></figcaption>

		<h5 class="byline"><?php largo_byline(); ?></h5>
		<?php echo do_shortcode('[action-box message="Want the latest from the Reporter delivered straight to your inbox? Subscribe to our free email newsletter."]'); ?>
	</header>

	<section class="entry-content clearfix" itemprop="articleBody">

		<?php largo_entry_content( $post ); ?>

	</section>

	<div class="series-divider">
		<div class="divider-line"></div>
	</div>

	<?php do_action('largo_after_post_content'); ?>

</article>
