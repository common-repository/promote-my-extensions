<?php
	/**
	 * Code to display the credits on the settings page
	 *
	 * @package Promote My Extensions
	 */

	// Add an nonce field so we can check for it later.
	wp_nonce_field('wpeplugin_box','wpeplugin_box_nonce');
?>
<div style="clear: both;">
	<div class="postbox">
		<h3 class="handl" style="margin: 0; padding: 3px; cursor: default;"><?php _e('Credits', 'gs-promote-my-extensions'); ?></h3>
		<div style="padding: 8px;">
			<p><?php
				printf(
					__('Thank you for trying the %1$s plugin - I hope you find it useful. For the latest updates on this plugin, vist the %2$s. If you have problems with this plugin, please use our %3$s. For help using this plugin, visit the %4$s.',
									'gs-promote-my-extensions'),
					__(
									'Promote My Extensions',
									'gs-promote-my-extensions'),
					'<a href="https://grandslambert.com/plugins/promote-my-extensions" target="_blank">' .
					__('official site',
									'gs-promote-my-extensions') .
					'</a>',
					'<a href="https://wordpress.org/support/plugin/promote-my-extensions/" target="_blank">' .
					__('Support Forum',
									'gs-promote-my-extensions') .
					'</a>',
					'<a href="https://grandslambert.com/documentation/promote-my-extensions/" target="_blank">' .
					__('Documentation Page',
									'gs-promote-my-extensions') .
					'</a>');
				?>
			</p>
			<p><?php
				printf(
					__(
						'This plugin is &copy; %1$s by %2$s and is released under the %3$s',
						'gs-promote-my-extensions'),
					'2009-' . date("Y"),
					'<a href="http://grandslambert.com" target="_blank">GrandSlambert, Inc.</a>',
					'<a href="http://www.gnu.org/licenses/gpl.html" target="_blank">' .
					__(
						'GNU General Public License',
						'gs-promote-my-extensions') .
					'</a>');
				?>
			</p>
		</div>
	</div>
	<div class="postbox">
		<h3 class="handl" style="margin: 0; padding: 3px; cursor: default;"><?php _e('Donate', 'gs-promote-my-extensions'); ?></h3>
		<div style="padding: 8px">
			<p>
				<a
					href="https://www.paypal.com/donate/?business=ZELD6TZ4T8KAL&no_recurring=0&item_name=Donate+to+the+Promote+My+Extensions+WordPress+plugin+by+GrandSlambert.&currency_code=USD"
					target="_blank"><?php _e('Donate a few bucks!', 'gs-promote-my-extensions'); ?></a>
			</p>
			<p>
				<?php printf(__('If you find this plugin useful, please consider supporting this and our other great %1$s.', 'gs-promote-my-extensions'), '<a href="http://grandslambert.com/plugins" target="_blank">' . __('plugins', 'gs-promote-my-extensions') . '</a>'); ?>
			</p>
		</div>
	</div>
</div>
