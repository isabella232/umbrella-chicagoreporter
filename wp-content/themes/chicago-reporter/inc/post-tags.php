<?php
/**
 * Functions modifying the function of Largo's functions in Largo's inc/post-tags.php
 */

/**
 * Remove largo_after_hero_largo_edited_date
 * @link https://github.com/INN/Largo/pull/1343/files#diff-f455f0ca1903cb74b64f07a3b236ce46R388
 */
function cc_remove_largo_after_hero_largo_edited_date() {
	remove_action( 'largo_after_hero', 'largo_after_hero_largo_edited_date', 5 );
}
add_action( 'largo_after_hero', 'cc_remove_largo_after_hero_largo_edited_date', 4 );
