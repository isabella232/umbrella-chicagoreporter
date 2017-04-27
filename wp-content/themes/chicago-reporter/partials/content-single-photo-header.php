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

	<caption><?php echo get_post(get_post_thumbnail_id())->post_excerpt; ?></caption>

	<section class="entry-content clearfix" itemprop="articleBody">

		<h5 class="byline"><?php largo_byline(); ?></h5>

		<?php largo_entry_content( $post ); ?>

	</section>

	<?php do_action('largo_after_post_content'); ?>

</article>
