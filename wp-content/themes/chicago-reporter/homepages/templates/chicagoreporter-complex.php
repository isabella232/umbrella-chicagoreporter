<?php
/**
 * Home Template: Chicago Reporter
 * Description: A modified version of "Top Stories" template created for Chicago Reporter by Cornershop Creative
 * Sidebars: Homepage Left Rail (An optional widget area that, when enabled, appears to the left of the main content area on the homepage)
 */

global $largo, $shown_ids, $tags;
?>
<div class="row clearfix">
	<div class="span8">
		<?php echo $topStory; ?>
	</div>
	<div class="span4">
		<?php if ( !dynamic_sidebar( 'Homepage Top Sidebar' ) ) { ?>
			<p><?php _e('Please add widgets to this content area in the WordPress admin area under Appearance > Widgets.', 'largo'); ?></p>
		<?php } ?>
	</div>
</div>
<div class="row clearfix">
	<?php echo $featStories; ?>
	<div class="span4">
		<?php if ( !dynamic_sidebar( 'Homepage Middle Image' ) ) { ?>
			<p><?php _e('Please add widgets to this content area in the WordPress admin area under Appearance > Widgets.', 'largo'); ?></p>
		<?php } ?>
	</div>
</div>
<div class="row clearfix">
	<div class="span12">
		<?php echo $beatsMenu; ?>
	</div>
</div>
<div class="row clearfix">
	<div class="span8">
	</div>
	<?php get_sidebar(); ?>
</div>
