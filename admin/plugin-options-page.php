<?php
class Promote_My_Extensions_Options_Page {
	
	var $page_slug = 'edit.php?post_type=gs_pmp_event&page=promote_my_extensions';
	var $option_group = 'promote_my_extensions';
	
	function __construct() {
		add_action('admin_menu', array( &$this, 'addOptionsPage'));
		add_action('admin_init', array( &$this, 'addOptionsFields'));
		add_action('admin_notices', array( &$this, 'adminNotice' ));
	}
	
	public function addOptionsPage()
	{
		add_submenu_page(
			'edit.php?post_type=gs_pmp_extension',
			'Promote My Extensions Settings',
			'Settings',
			'manage_options',
			'promote_my_extensions', array(&$this, 'addOptionsPagecallback')
		);
	}
	
	public function addOptionsPagecallback()
	{
		?>
		<div class="wrap" style="width:49%; float:left">
			<h1><?php echo get_admin_page_title() ?></h1>
			<form method="post" action="options.php">
				<?php
				settings_errors('promote_my_extensions_errors');
				settings_fields('promote_my_extensions');
				do_settings_sections('edit.php?post_type=gs_pmp_event&page=promote_my_extensions');
				submit_button();
				?>
			</form>
		</div>
		<div class="wrap gs_pmp_float_right" style="width: 45%; float:right; padding-top: 55px">
			<?php include(dirname(dirname(__FILE__)) . '/includes/admin-footer.php'); ?>
		</div>
		<?php
	}
	
	public function addOptionsFields()
	{
		$this->addPostTypeOptions();
		$this->addFeaturesOptions();
		$this->addSupportsOptions();
		$this->addDetailsOptions();
	}
	
	public function addPostTypeHeader() {
		_e('The information here will apply only to the primary post type and will be used in menus and admin areas.', 'gs-promote-my-extensions');
	}
	
	public function addPostTypeOptions() {
		add_settings_section('gs_pmp_post_type', __('Post Type Settings', 'gs-promote-my-extensions'), array(&$this, 'addPostTypeHeader'), $this->page_slug);
		
		$args = array(
			'type' => 'string',
			'sanitize_callback' => 'sanitize_text_field',
			'default' => __('My Plugins', 'gs-promote-my-extensions'),
		);
		
		// Handle plural label for post type.
		register_setting( $this->option_group, 'gs_pmp_plural_label', $args );
		add_settings_field('gs_pmp_plural_label', __('Plural Label', 'gs-promote-my-extensions'), array(&$this, 'createTextField'), $this->page_slug, 'gs_pmp_post_type', 
			array(
				'option' => 'gs_pmp_plural_label',
				'help-text' => __('This will be used in the admin menu.', 'gs-promote-my-extensions')
			)
		);
		
		// Handle singular label for post type.
		$args['default'] = __('My Plugin', 'gs-promote-my-extensions');
		register_setting( $this->option_group, 'gs_pmp_singular_label', $args );
		add_settings_field('gs_pmp_singular_label', __('Singular Label', 'gs-promote-my-extensions'), array(&$this, 'createTextField'), $this->page_slug, 'gs_pmp_post_type', 
			array(
				'option' => 'gs_pmp_singular_label',
				'help-text' => __('This will be used in the admin screens.', 'gs-promote-my-extensions')
			)
		);
		
		// Handle index slug for post type.
		$args['default'] = __('plugins', 'gs-promote-my-extensions');
		register_setting( $this->option_group, 'gs_pmp_index_slug', $args );
		add_settings_field('gs_pmp_index_slug', __('Permalink Prefix', 'gs-promote-my-extensions'), array(&$this, 'createTextField'), $this->page_slug, 'gs_pmp_post_type', 
			array(
				'option' => 'gs_pmp_index_slug',
				'help-text' => __('This is used in the extension URL.', 'gs-promote-my-extensions') . ' ' .
					'<a href="' . get_site_url(). '/' . get_option('gs_pmp_index_slug') . '" target="_blank">'. __('View on site.', 'gs-promote-my-extensions').'</a>'
			)
		);
	}
	
	public function addSupportsHeader() {
		_e('Indicate which features you want your post types to support. This will be used for both the plugin and documenation post types.', 'promote-my-plugins');
	}
	
	public function addSupportsOptions() {
		add_settings_section('gs_pmp_supports', __('Post Type Supports', 'gs-promote-my-extensions'), array(&$this, 'addSupportsHeader'), $this->page_slug);
		
		// Add support for excerpt.
		register_setting($this->option_group, 'gs_pmp_use_excerpt', array(&$this, 'sanitizeCheckbox'));
		add_settings_field('gs_pmp_use_excerpt', __('Use Excerpts', 'gs-promote-my-extensions'), array(&$this,'createCheckbox'), $this->page_slug, 'gs_pmp_supports', array('option' => 'gs_pmp_use_excerpt'));
		
		// Add support for post thumbnails.
		register_setting($this->option_group, 'gs_pmp_use_thumbnails', array(&$this, 'sanitizeCheckbox'));
		add_settings_field('gs_pmp_use_thumbnails', __('Use Post Thumbnails', 'gs-promote-my-extensions'), array(&$this,'createCheckbox'), $this->page_slug, 'gs_pmp_supports', array('option' => 'gs_pmp_use_thumbnails'));
		
		// Add support for custom fields.
		register_setting($this->option_group, 'gs_pmp_use_custom_fields', array(&$this, 'sanitizeCheckbox'));
		add_settings_field('gs_pmp_use_custom_fields', __('Use Custom Fields', 'gs-promote-my-extensions'), array(&$this,'createCheckbox'), $this->page_slug, 'gs_pmp_supports', array('option' => 'gs_pmp_use_custom_fields'));
		
		// Add support for comments.
		register_setting($this->option_group, 'gs_pmp_use_comments', array(&$this, 'sanitizeCheckbox'));
		add_settings_field('gs_pmp_use_comments', __('Allow Comments', 'gs-promote-my-extensions'), array(&$this,'createCheckbox'), $this->page_slug, 'gs_pmp_supports', array('option' => 'gs_pmp_use_comments'));
		
		// Add support for trackbacks.
		register_setting($this->option_group, 'gs_pmp_use_trackbacks', array(&$this, 'sanitizeCheckbox'));
		add_settings_field('gs_pmp_use_trackbacks', __('Allow Trackbacks', 'gs-promote-my-extensions'), array(&$this,'createCheckbox'), $this->page_slug, 'gs_pmp_supports', array('option' => 'gs_pmp_use_trackbacks'));
		
		// Add support for revisions.
		register_setting($this->option_group, 'gs_pmp_use_revisions', array(&$this, 'sanitizeCheckbox'));
		add_settings_field('gs_pmp_use_revisions', __('Show Revisions', 'gs-promote-my-extensions'), array(&$this,'createCheckbox'), $this->page_slug, 'gs_pmp_supports', array('option' => 'gs_pmp_use_revisions'));
	}
	
	public function addFeaturesHeader() {
		_e('Indicate which options you wish to use.', 'promote-my-plugins');
	}
	
	public function addFeaturesOptions() {
		add_settings_section('gs_pmp_features', __('Plugin Features', 'gs-promote-my-extensions'), array(&$this, 'addFeaturesHeader'), $this->page_slug);

		// Handle the archive display order. 
		register_setting($this->option_group, 'gs_pmp_display_order', 'sanitize_text_field');
		add_settings_field(
			'gs_pmp_display_order', 
			__('Archive Display Order', 'gs_pmp_extensions'),
			array(&$this,'createSelectBox'), 
			$this->page_slug,
			'gs_pmp_features', 
			array(
				'option' => 'gs_pmp_display_order',
				'values' => array(
					'post_title' => __('Extension Title', 'gs-promote-my-extensions'),
					'post_modified' => __('Order Created', 'gs-promote-my-extensions'),
					'menu_order' => __('Page Order', 'gs-promote-my-extensions')
				),
				'help-text' => __('Determines the diplay order on the post type index page.', 'gs-promote-my-extensions')
			)
		);
		register_setting($this->option_group, 'gs_pmp_display_asc', 'sanitize_text_field');
		add_settings_field(
			'gs_pmp_display_asc',
			__('Direction', 'gs-promote-my-extensions'),
			array(&$this, 'createSelectBox'),
			$this->page_slug,
			'gs_pmp_features',
			array(
				'option' => 'gs_pmp_display_asc',
				'values' => array(
					'asc' => __('Ascending', 'gs-promote-my-extensions'),
					'desc' => __('Descending', 'gs-promote-my-extensions')
				)
			)
		);
		
		
		// Handle the Use Documentation option.
		register_setting($this->option_group, 'gs_pmp_use_documentation', array(&$this, 'sanitizeCheckbox'));
		add_settings_field('gs_pmp_use_documentation', __('Use Documentation Post Type', 'gs-promote-my-extensions'), array(&$this,'createCheckbox'), $this->page_slug, 'gs_pmp_features', array('option' => 'gs_pmp_use_documentation'));
		
		// Handle the Use Taxonomies option.
		register_setting($this->option_group, 'gs_pmp_use_taxonomies', array(&$this, 'sanitizeCheckbox'));
		add_settings_field('gs_pmp_use_taxonomies', __('Use Plugin Taxonomies', 'gs-promote-my-extensions'), array(&$this,'createCheckbox'), $this->page_slug, 'gs_pmp_features', array('option' => 'gs_pmp_use_taxonomies'));
	}
	
	public function addDetailsHeader() {
		_e('Indiate which detail fields you wish to use.', 'promote-my-plugins');
	}
	
	public function addDetailsOptions() {
		add_settings_section('gs_pmp_details', __('Details', 'gs-promote-my-extensions'), array(&$this, 'addDetailsHeader'), $this->page_slug);
		
		// Handle the Use Documentation option.
		register_setting($this->option_group, 'gs_pmp_use_details', array(&$this, 'sanitizeCheckbox'));
		add_settings_field('gs_pmp_use_details', __('Use Details', 'gs-promote-my-extensions'), array(&$this,'createCheckbox'), $this->page_slug, 'gs_pmp_details', 
			array(
				'option' => 'gs_pmp_use_details',
				'help-text' => __('If this is turned off, no details fields will show.', 'gs-promote-my-extensions')
			)
		);
		
		// Handle the Use Documentation option.
		register_setting($this->option_group, 'gs_pmp_use_download', array(&$this, 'sanitizeCheckbox'));
		add_settings_field('gs_pmp_use_download', __('Use Download Field', 'gs-promote-my-extensions'), array(&$this,'createCheckbox'), $this->page_slug, 'gs_pmp_details', array('option' => 'gs_pmp_use_download'));
		
		// Handle the Use Documentation option.
		register_setting($this->option_group, 'gs_pmp_use_faq', array(&$this, 'sanitizeCheckbox'));
		add_settings_field('gs_pmp_use_faq', __('Use FAQ Field', 'gs-promote-my-extensions'), array(&$this,'createCheckbox'), $this->page_slug, 'gs_pmp_details', array('option' => 'gs_pmp_use_faq'));
		
		// Handle the Use Documentation option.
		register_setting($this->option_group, 'gs_pmp_use_support', array(&$this, 'sanitizeCheckbox'));
		add_settings_field('gs_pmp_use_support', __('Use Support Field', 'gs-promote-my-extensions'), array(&$this,'createCheckbox'), $this->page_slug, 'gs_pmp_details', array('option' => 'gs_pmp_use_support'));
		
		// Handle the Use Documentation option.
		register_setting($this->option_group, 'gs_pmp_use_reviews', array(&$this, 'sanitizeCheckbox'));
		add_settings_field('gs_pmp_use_reviews', __('Use Reviews Field', 'gs-promote-my-extensions'), array(&$this,'createCheckbox'), $this->page_slug, 'gs_pmp_details', array('option' => 'gs_pmp_use_reviews'));
		
		// Handle the Use Documentation option.
		register_setting($this->option_group, 'gs_pmp_use_donate', array(&$this, 'sanitizeCheckbox'));
		add_settings_field('gs_pmp_use_donate', __('Use Donate Field', 'gs-promote-my-extensions'), array(&$this,'createCheckbox'), $this->page_slug, 'gs_pmp_details', array('option' => 'gs_pmp_use_donate'));
		
		
	}
	
	public function createTextField($args)
	{
		$value = get_option($args['option']);
		?>
		<input type="text" name="<?php echo esc_attr($args['option']); ?>" value="<?php echo esc_attr($value); ?>" />
		<?php if (isset($args['help-text']) && $args['help-text']) echo '<p class="description">' . wp_kses_post($args['help-text']) , '</p>';
		
	}

	public function createCheckbox($args)
	{
		$value = get_option($args['option']);
		?>
		<input type="checkbox" name="<?php echo esc_attr($args['option']); ?>" <?php checked($value, 'yes') ?> value="on" />
		<?php if (isset($args['help-text']) && $args['help-text']) echo '<p class="description">' . wp_kses_post($args['help-text']) , '</p>';
	}
	
	public function createSelectBox($args) {
		$value = get_option($args['option']);
		?>
		<select name="<?php echo esc_attr($args['option']); ?>">
			<?php foreach ($args['values'] as $key => $label) : ?>
			<option value="<?php echo esc_attr($key); ?>" <?php selected($value, $key); ?>>
				<?php echo esc_attr($label); ?>
			</option>
			<?php endforeach; ?>
		</select>
		<?php if (isset($args['help-text']) && $args['help-text']) echo '<p class="description">' . wp_kses_post($args['help-text']) , '</p>';
	}

	// custom sanitization function for a checkbox field
	function sanitizeCheckbox($value)
	{
		//wp_die('Value = ' . $value);
		return 'on' === $value ? 'yes' : 'no';
	}
	
	public function adminNotice() {
		if(
			isset( $_GET[ 'page' ] )
			&& 'promote_my_extensions' == $_GET[ 'page' ]
			&& isset( $_GET[ 'settings-updated' ] )
			&& true == $_GET[ 'settings-updated' ]
			) {
			?>
			<div class="notice notice-success is-dismissible">
				<p>
					<strong><?php _e('Promote My Extensions Settings saved successfully.', 'gs-promote-my-extensions'); ?></strong>
				</p>
			</div>
			<?php
		}
	}
}
