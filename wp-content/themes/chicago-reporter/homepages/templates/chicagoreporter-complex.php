<?php
/**
 * Home Template: Chicago Reporter
 * Description: A modified version of "Top Stories" template created for Chicago Reporter by Cornershop Creative
 * Sidebars: Homepage Left Rail (An optional widget area that, when enabled, appears to the left of the main content area on the homepage)
 */

global $largo, $shown_ids, $tags;
?>
<div class="row clearfix">
	<div class="span8" id="homepage-featured">
		<?php echo $topStory; ?>
	</div>
	<div class="span4" id="homepage-top-sidebar">
		<?php if ( !dynamic_sidebar( 'Homepage Top Sidebar' ) ) { ?>
			<p><?php _e('Please add widgets to this content area in the WordPress admin area under Appearance > Widgets.', 'largo'); ?></p>
		<?php } ?>
	</div>
</div>
<div class="row clearfix">
	<?php echo $featStories; ?>
	<div class="span4" id="homepage-middle-image">
		<?php if ( !dynamic_sidebar( 'Homepage Middle Image' ) ) { ?>
			<p><?php _e('Please add widgets to this content area in the WordPress admin area under Appearance > Widgets.', 'largo'); ?></p>
		<?php } ?>
	</div>
</div>
<div class="row clearfix">
	<div class="span12" id="beats_menu">
		<?php echo $beatsMenu; ?>
	</div>
</div>
<div class="row clearfix">
	<div class="span8" id="investigations">
		<h3 class="bar-above">Investigations</h3>
		<?php get_template_part( 'partials/home-post-list' ); ?>
	</div>
	<?php get_sidebar(); ?>
</div>
