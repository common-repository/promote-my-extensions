<?php
	/**
	 * Code to display the extension details meta box.
	 *
	 * @package Promote My Extensions
	 */

	// Add an nonce field so we can check for it later.
	wp_nonce_field('gs_pmp_box','gs_pmp_box_nonce');
?>

	<div class="wpeplugin-box-label">
		<label for="gs_pmp_extension_type"><?php echo __('Extension Type', 'gs-promote-my-extensions'); ?></label>
		<label>
			<input type="radio" name="type" value="plugin" <?php checked($details['type'], 'plugin'); ?>>
			<?php _e('Plugin', 'gs-promote-my-extensions'); ?>
		</label>
		<label>
			<input type="radio" name="type" value="theme" <?php checked($details['type'], 'theme'); ?>>
			<?php _e('Theme', 'gs-promote-my-extensions'); ?>
		</label>
	</div>

	<?php if (get_option('gs_pmp_use_documentation') === 'yes') : ?>
	<div class="wpeplugin-box-label">
	<label for="gs_pmp_documentation"><?php echo __('Documentation Page', 'gs-promote-my-extensions'); ?></label>
		<?php wp_dropdown_pages(array(
		'name' => 'documentation',
		'id' => 'gs_pmp_documentation',
		'selected' => $details['documentation'],
		'post_type' => 'gs_pmp_documentation',
		'show_option_none' => __('Choose a Documentation Page', 'gs-promote-my-extensions'),
	)); ?>
</div>
<?php endif; ?>

<?php if (get_option('gs_pmp_use_download') === 'yes') : ?>
<div class="wpeplugin-box-label">
	<label for="gs_pmp_downloads"><?php echo __('Downloads URL', 'gs-promote-my-extensions'); ?></label>
	<input type="text" id="gs_pmp_downloads" class="widefat" size="4" name="downloads" value="<?php echo esc_attr($details['downloads']); ?>" />
</div>
<?php endif; ?>

<?php if (get_option('gs_pmp_use_faq') === 'yes') : ?>
<div class="wpeplugin-box-label">
	<label for="gs_pmp_faq"><?php echo __('FAQ URL', 'gs-promote-my-extensions'); ?></label>
	<input type="text" id="gs_pmp_faq" class="widefat" size="4" name="faq" value="<?php echo esc_attr($details['faq']); ?>" />
</div>
<?php endif;?>

<?php if (get_option('gs_pmp_use_support') === 'yes') : ?>
<div class="wpeplugin-box-label">
	<label for="gs_pmp_support"><?php echo __('Support URL', 'gs-promote-my-extensions'); ?></label>
	<input type="text" id="gs_pmp_support" class="widefat" size="4" name="support" value="<?php echo esc_attr($details['support']); ?>" />
</div>
<?php endif; ?>

<?php if (get_option('gs_pmp_use_reviews') === 'yes') : ?>
<div class="wpeplugin-box-label">
	<label for="gs_pmp_reviews"><?php echo __('Reviews URL', 'gs-promote-my-extensions'); ?></label>
	<input type="text" id="gs_pmp_reviews" class="widefat" size="4" name="reviews" value="<?php echo esc_attr($details['reviews']); ?>" />
</div>
<?php endif; ?>

<?php if (get_option('gs_pmp_use_donate') === 'yes') : ?>
<div class="wpeplugin-box-label">
	<label for="gs_pmp_donate"><?php echo __('Donate URL', 'gs-promote-my-extensions'); ?></label>
	<input type="text" id="gs_pmp_donate" class="widefat" size="4" name="donate" value="<?php echo esc_attr($details['donate']); ?>" />
</div>
<?php endif; ?>
