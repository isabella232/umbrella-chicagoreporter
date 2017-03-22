<?php
/**
 * The template for displaying content in the single-photo-header.php template
 * - moves byline down
 * - 
 * @since March 2017
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'hnews item' ); ?> itemscope itemtype="http://schema.org/Article">

	<?php do_action('largo_before_post_header'); ?>

	<?php
		printf (
			'<header style="background-image:url(%1$s)">',
			"http://placekitten.com/4000/3000" // this needs to be set to something real
		);

	?>

		<?php largo_maybe_top_term(); ?>

		<h1 class="entry-title" itemprop="headline"><?php the_title(); ?></h1>
		<?php if ( $subtitle = get_post_meta( $post->ID, 'subtitle', true ) ) : ?>
			<h2 class="subtitle"><?php echo $subtitle ?></h2>
		<?php endif; ?>

		<?php largo_post_metadata( $post->ID ); ?>

	</header><!-- / entry header -->

	<?php
		do_action('largo_after_post_header');

		do_action('largo_after_hero');
	?>

	<?php get_sidebar(); ?>

	<section class="entry-content clearfix" itemprop="articleBody">

		<h5 class="byline"><?php largo_byline(); ?></h5>

		<?php largo_entry_content( $post ); ?>

	</section>

	<?php do_action('largo_after_post_content'); ?>

</article>
