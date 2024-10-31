<?php
/**
 * Code to display the extension details on a page.
 *
 * @package Promote My Extensions
 */

?>
<h2><?php _e('Details', 'gs-promote-my-extensions'); ?></h2>
<ul>
	<?php if (!empty($meta['documentation']) && get_option('gs_pmp_use_documentation') === 'yes') : ?>
	<li><a href="<?php echo get_permalink($meta['documentation']); ?>"><?php _e('Documentation', 'gs-promote-my-extensions'); ?></a></li>
	<?php endif; ?>
	<?php if (!empty($meta['downloads']) && get_option('gs_pmp_use_download') === 'yes') : ?>
	<li><a href="<?php echo esc_attr($meta['downloads']); ?>" target="_blank"><?php _e('Download', 'gs-promote-my-extensions'); ?></a></li>
	<?php endif; ?>
	<?php if (!empty($meta['faq']) && get_option('gs_pmp_use_faq') === 'yes') : ?>
	<li><a href="<?php echo esc_attr($meta['faq']); ?>" target="_blank"><?php _e('Frequently Asked Questions', 'gs-promote-my-extensions'); ?></a></li>
	<?php endif; ?>
	<?php if (!empty($meta['support']) && get_option('gs_pmp_use_support') === 'yes') : ?>
	<li><a href="<?php echo esc_attr($meta['support']); ?>" target="_blank"><?php _e('Support', 'gs-promote-my-extensions'); ?></a></li>
	<?php endif; ?>
	<?php if (!empty($meta['reviews']) && get_option('gs_pmp_use_reviews') === 'yes') : ?>
	<li><a href="<?php echo esc_attr($meta['reviews']); ?>" target="_blank"><?php _e('Reviews', 'gs-promote-my-extensions'); ?></a></li>
	<?php endif; ?>
	<?php if (!empty($meta['donate']) && get_option('gs_pmp_use_donate') === 'yes') : ?>
		<li><a href="<?php echo esc_attr($meta['donate']); ?>" target="_blank"><?php _e('Donate', 'gs-promote-my-extensions'); ?></a></li>
	<?php endif; ?>
</ul>
