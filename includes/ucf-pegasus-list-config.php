<?php
/**
 * Handles UCF Pegasus List Settings
 **/
if ( ! class_exists( 'UCF_Pegasus_List_Config' ) ) {
	class UCF_Pegasus_List_Config {
		public static
			$option_prefix = 'ucf_pegasus_list_',
			$option_defaults = array(
				'layout'               => 'default',
				'url'                  => 'https://www.ucf.edu/pegasus/',
				'limit'                => 5,
				'offset'               => 0,
				'feed_url'             => 'https://www.ucf.edu/pegasus/wp-json/wp/v2/',
				'cache_feed'           => true,
				'transient_expiration' => 3 // hours
			);

		/**
		 * Gets the registered layouts
		 * @author Jim Barnes
		 * @since 1.0.0
		 * @return Array | The array of layouts
		 **/
		public static function get_layouts() {
			$layouts = array(
				'default' => 'Default Layout'
			);

			$layouts = apply_filters( self::$option_prefix . 'get_layouts', $layouts );

			return $layouts;
		}

		/**
		 * Creates options via the WP Options API that are utilized by the
		 * plugin. Intented to be run on plugin activation.
		 * @author Jim Barnes
		 * @since 1.0.0
		 **/
		public static function add_options() {
			$defaults = self::$option_defaults;

			add_option( self::$option_prefix . 'url', $defaults['url'] );
			add_option( self::$option_prefix . 'feed_url', $defaults['feed_url'] );
			add_option( self::$option_prefix . 'limit', $defaults['limit'] );
			add_option( self::$option_prefix . 'cache_feed', $defaults['cache_feed'] );
			add_option( self::$option_prefix . 'transient_expiration', $defaults['transient_expiration'] );
		}

		/**
		 * Deletes options via the WP Options API that are utilized by the
		 * plugin. Intended to be run on plugin uninstallation.
		 * @author Jim Barnes
		 * @since 1.0.0
		 **/
		public static function delete_option() {
			delete_option( self::$option_prefix . 'url' );
			delete_option( self::$option_prefix . 'feed_url' );
			delete_option( self::$option_prefix . 'limit' );
			delete_option( self::$option_prefix . 'cache_feed' );
			delete_option( self::$option_prefix . 'transient_expiration' );
		}

		/**
		 * Returns a list of defaults plugin options. Applies any overridden
		 * default values set within the options page.
		 * @author Jim Barnes
		 * @since 1.0.0
		 * @return array | The array of options and their defaults.
		 **/
		public static function get_option_defaults() {
			$defaults = self::$option_defaults;

			$configurable_defaults = array(
				'url'                  => get_option( self::$option_prefix . 'url', $defaults['url'] ),
				'feed_url'             => get_option( self::$option_prefix . 'feed_url', $defaults['feed_url'] ),
				'limit'                => get_option( self::$option_prefix . 'limit', $defaults['limit'] ),
				'cache_feed'           => get_option( self::$option_prefix . 'cache_feed', $defaults['cache_feed'] ),
				'transient_expiration' => get_option( self::$option_prefix . 'transient_expiration', $defaults['transient_expiration'] )
			);

			// Force configurable options to override $defaults, even if they are empty:
			$defaults = array_merge( $defaults, $configurable_defaults );

			$defaults = self::format_options( $defaults );

			return $defaults;
		}

		/**
		 * Performs typecasting, sanitization, etc on an array of plugin options.
		 * @author Jim Barnes
		 * @since 1.0.0
		 * @param $list Array | Array of plugin options.
		 * @return Array | The array of plugin options.
		 **/
		public static function format_options( $list ) {
			foreach( $list as $key => $val ) {
				switch( $key ) {
					case 'cache_feed':
						$list[$key] = filter_var( $val, FILTER_VALIDATE_BOOLEAN );
						break;
					case 'transient_expiration':
					case 'limit':
					case 'offset':
						$list[$key] = intval( $val );
						break;
					default:
						break;
				}
			}

			return $list;
		}

		/**
		 * Applies formatting toa single option. Intended to be passed to the 'option_{$option}' hook.
		 * @author Jo Dickson
		 * @since 1.0.0
		 * @param $value Mixed | The value to be formatted
		 * @param $option_name string | The option being formatted
		 * @return Mixed | The formatted value
		 **/
		public static function format_option( $value, $option_name ) {
			$option_formatted = self::format_options( array( $options_name => $value ) );
			return $option_formatted[$option_name];
		}

		/**
		 * Applies formatting to an array of shortcode attributes. Intended to
		 * be passed to the 'shortcode_atts_sc_ucf_pegasus_list' hook.
		 * @author Jo Dickson
		 * @since 1.0.0
		 * @param $out Array | The output array
		 * @param $pairs Array | The supported attributes and defaults
		 * @param $atts Array | The user defined shortcode atts
		 * @param $shortcode string | The shortcode name
		 **/
		public static function format_sc_atts( $out, $pairs, $atts, $shortcode ) {
			return self::format_options( $out );
		}

		/**
		 * Adds filters for the shortcode and plugin options that apply our
		 * formatting rules to attribute/option values.
		 * @author Jo Dickson
		 * @since 1.0.0
		 **/
		public static function add_option_formatting_filters() {
			$defaults = self::$option_defaults;
			foreach( $defaults as $option => $default ) {
				add_filter( "option_{$option}", array( 'UCF_Pegasus_List_Config', 'format_option' ), 10, 2 );
			}

			add_filter( 'shortcode_atts_sc_ucf_pegasus_list', array( 'UCF_Pegasus_List_Config', 'format_sc_atts'), 10, 4 );
		}

		/**
		 * Convenience method for returning an option from the WP Options API
		 * or plugin option default.
		 * @author Jo Dickson
		 * @since 1.0.0
		 * @param $option_name string | The name of the option to be retrieved
		 * @return Mixed | The option value
		 **/
		public static function get_option_or_default( $option_name ) {
			$option_name_no_prefix = str_replace( self::$option_prefix, '', $option_name );
			$option_name = self::$option_prefix . $option_name_no_prefix;
			$defaults = self::get_option_defaults();

			$retval = get_option( $option_name, $defaults[$option_name_no_prefix] );

			$retval = self::format_options( array( $option_name_no_prefix => $retval ) );

			return $retval[$option_name_no_prefix];
		}

		/**
		 * Initializes setting registration with Settings API.
		 * @author Jim Barnes
		 * @since 1.0.0
		 **/
		public static function settings_init() {
			$setting_prefix = 'ucf_pegasus_list';

			register_setting( $setting_prefix, self::$option_prefix . 'url' );
			register_setting( $setting_prefix, self::$option_prefix . 'feed_url' );
			register_setting( $setting_prefix, self::$option_prefix . 'limit' );
			register_setting( $setting_prefix, self::$option_prefix . 'cache_feed' );
			register_setting( $setting_prefix, self::$option_prefix . 'transient_expiration' );

			// Register General Section
			add_settings_section(
				$setting_prefix . '_section_general',
				'General Settings',
				'',
				$setting_prefix
			);

			// Register Cache Section
			add_settings_section(
				$setting_prefix . '_section_cache',
				'Cache Settings',
				'',
				$setting_prefix
			);

			// Register General Fields
			add_settings_field(
				self::$option_prefix . 'url',
				'Pegasus Website URL',
				array( 'UCF_Pegasus_List_Config', 'display_settings_field' ),
				$setting_prefix,
				$setting_prefix . '_section_general',
				array(
					'label_for'   => self::$option_prefix . 'url',
					'description' => 'The url to the UCF Pegasus website.',
					'type'        => 'text'
				)
			);

			add_settings_field(
				self::$option_prefix . 'feed_url',
				'Pegasus API URL',
				array( 'UCF_Pegasus_List_Config', 'display_settings_field' ),
				$setting_prefix,
				$setting_prefix . '_section_general',
				array(
					'label_for'   => self::$option_prefix . 'feed_url',
					'description' => 'The url to the UCF Pegasus JSON API.',
					'type'        => 'text'
				)
			);

			add_settings_field(
				self::$option_prefix . 'limit',
				'Issue Display Limit (Default)',
				array( 'UCF_Pegasus_List_Config', 'display_settings_field' ),
				$setting_prefix,
				$setting_prefix . '_section_general',
				array(
					'label_for'   => self::$option_prefix . 'limit',
					'description' => 'The number of issues to display by default when using the shortcode.',
					'type'        => 'number'
				)
			);

			// Register Cache Fields
			add_settings_field(
				self::$option_prefix . 'cache_feed',
				'Cache Issue Feed',
				array( 'UCF_Pegasus_List_Config', 'display_settings_field' ),
				$setting_prefix,
				$setting_prefix . '_section_general',
				array(
					'label_for'   => self::$option_prefix . 'cache_feed',
					'description' => 'When checked, the results from the issue feed will be cached.',
					'type'        => 'checkbox'
				)
			);

			add_settings_field(
				self::$option_prefix . 'transient_expiration',
				'Cache Expiration',
				array( 'UCF_Pegasus_List_Config', 'display_settings_field' ),
				$setting_prefix,
				$setting_prefix . '_section_general',
				array(
					'label_for'   => self::$option_prefix . 'transient_expiration',
					'description' => 'The amount of time (in hours) the feed will be cached.',
					'type'        => 'number'
				)
			);
		}

		/**
		 * Displays an individual setting's field markup.
		 * @author Jo Dickson
		 * @since 1.0.0
		 * @param $args Array | An array of arguments for displaying the field
		 * @return string | The markup of the field.
		 **/
		public static function display_settings_field( $args ) {
			$option_name   = $args['label_for'];
			$description   = $args['description'];
			$field_type    = $args['type'];
			$current_value = self::get_option_or_default( $option_name );
			$markup        = '';
			switch ( $field_type ) {
				case 'checkbox':
					ob_start();
				?>
					<input type="checkbox" id="<?php echo $option_name; ?>" name="<?php echo $option_name; ?>" <?php echo ( $current_value == true ) ? 'checked' : ''; ?>>
					<p class="description">
						<?php echo $description; ?>
					</p>
				<?php
					$markup = ob_get_clean();
					break;
				case 'number':
					ob_start();
				?>
					<input type="number" id="<?php echo $option_name; ?>" name="<?php echo $option_name; ?>" value="<?php echo $current_value; ?>">
					<p class="description">
						<?php echo $description; ?>
					</p>
				<?php
					$markup = ob_get_clean();
					break;
				case 'text':
				default:
					ob_start();
				?>
					<input type="text" id="<?php echo $option_name; ?>" name="<?php echo $option_name; ?>" value="<?php echo $current_value; ?>">
					<p class="description">
						<?php echo $description; ?>
					</p>
				<?php
					$markup = ob_get_clean();
					break;
			}
		?>

		<?php
			echo $markup;
		}

		/**
		 * Registers the settings page to display in the WordPress admin.
		 * @author Jim Barnes
		 * @since 1.0.0
		 **/
		public static function add_options_page() {
			$page_title = 'UCF Pegasus List Settings';
			$menu_title = 'UCF Pegasus List';
			$capability = 'manage_options';
			$menu_slug  = 'ucf_pegasus_list';
			$callback   = array( 'UCF_Pegasus_List_Config', 'options_page_html' );

			return add_options_page(
				$page_title,
				$menu_title,
				$capability,
				$menu_slug,
				$callback
			);
		}

		/**
		 * Displays the plugin's settings page form.
		 * @author Jim Barnes
		 * @since 1.0.0
		 * @return string | Returns the settings page markup.
		 **/
		public static function options_page_html() {
			ob_start();
		?>

		<div class="wrap">
			<h1><?php echo get_admin_page_title(); ?></h1>
			<form method="post" action="options.php">
				<?php
				settings_fields( 'ucf_pegasus_list' );
				do_settings_sections( 'ucf_pegasus_list' );
				submit_button();
				?>
			</form>
		</div>

		<?php
			echo ob_get_clean();
		}
	}

	// Register settings and options.
	add_action( 'admin_init', array( 'UCF_Pegasus_List_Config', 'settings_init' ) );
	add_action( 'admin_menu', array( 'UCF_Pegasus_List_Config', 'add_options_page' ) );

	UCF_Pegasus_List_Config::add_option_formatting_filters();
}
