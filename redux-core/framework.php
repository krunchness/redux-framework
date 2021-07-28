<?php // phpcs:ignore WordPress.Files.FileName
/**
 * Redux Framework is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * any later version.
 *
 * Redux Framework is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License
 * along with Redux Framework. If not, see <http://www.gnu.org/licenses/>.
 *
 * @package     Redux_Framework
 * @subpackage  Core
 * @subpackage  Core
 * @author      Redux Framework Team
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

require_once dirname( __FILE__ ) . '/class-redux-core.php';

Redux_Core::$version    = '4.2.10';
Redux_Core::$redux_path = dirname( __FILE__ );
Redux_Core::instance();

// Don't duplicate me!
if ( ! class_exists( 'ReduxFramework', false ) ) {

	/**
	 * Main ReduxFramework class
	 *
	 * @since       1.0.0
	 */
	class ReduxFramework {

		/**
		 * ReduxFramework instance storage.
		 *
		 * @var null
		 * @access public
		 */
		public static $instance = null;

		/**
		 * Redux current version.
		 *
		 * @var string
		 * @access public
		 */
		public static $_version = ''; // phpcs:ignore PSR2.Classes.PropertyDeclaration

		/**
		 * Absolute directory of the Redux instance.
		 *
		 * @var string
		 * @access public
		 */
		public static $_dir = ''; // phpcs:ignore PSR2.Classes.PropertyDeclaration

		/**
		 * Full URL of the Redux instance.
		 *
		 * @var string
		 * @access public
		 */
		public static $_url = ''; // phpcs:ignore PSR2.Classes.PropertyDeclaration

		/**
		 * Current WordPress upload directory.
		 *
		 * @var string
		 * @access public
		 */
		public static $_upload_dir = ''; // phpcs:ignore PSR2.Classes.PropertyDeclaration

		/**
		 * Current WordPress upload URL
		 *
		 * @var string
		 * @access public
		 */
		public static $_upload_url; // phpcs:ignore PSR2.Classes.PropertyDeclaration

		/**
		 * Init
		 *
		 * Backward compatibility for previous version of Redux.
		 */
		public static function init() {

			// Backward compatibility for extensions.
			self::$_version    = Redux_Core::$version;
			self::$_dir        = Redux_Core::$dir;
			self::$_url        = Redux_Core::$url;
			self::$_upload_dir = Redux_Core::$upload_dir;
			self::$_upload_url = Redux_Core::$upload_url;
			self::$_as_plugin  = Redux_Core::$as_plugin;
			self::$_is_plugin  = Redux_Core::$is_plugin;
		}

		/**
		 * Array of field arrays.
		 *
		 * @var array
		 */
		public $fields = array();

		/**
		 * Array of extensions by type used in the panel.
		 *
		 * @var array
		 */
		public $extensions = array();

		/**
		 * Array of sections and fields arrays.
		 *
		 * @var array|mixed|void
		 */
		public $sections = array();

		/**
		 * Array of generated errors from the panel for localization.
		 *
		 * @var array
		 */
		public $errors = array();

		/**
		 * Array of generated warnings from the panel for localization.
		 *
		 * @var array
		 */
		public $warnings = array();

		/**
		 * Array of generated sanitize notices from the panel for localization.
		 *
		 * @var array
		 */
		public $sanitize = array();

		/**
		 * Array of current option values.
		 *
		 * @var array
		 */
		public $options = array();

		/**
		 * Array of option defaults.
		 *
		 * @var null
		 */
		public $options_defaults = null;

		/**
		 * Array of fields set to trigger the compiler hook.
		 *
		 * @var array
		 */
		public $compiler_fields = array();

		/**
		 * Field folding information for localization.
		 *
		 * @var array
		 */
		public $required = array();

		/**
		 * Field child folding information for localization.
		 *
		 * @var array
		 */
		public $required_child = array();

		/**
		 * Array of fonts used by the panel for localization.
		 *
		 * @var array
		 */
		public $fonts = array();

		/**
		 * Array of fields to be folded.
		 *
		 * @var array
		 */
		public $folds = array();

		/**
		 * Array of fields with CSS output selectors.
		 *
		 * @var array
		 */
		public $output = array();

		/**
		 * Autogenerated CSS appended to the header (snake case mantained for backward compatibility).
		 *
		 * @var string
		 */
		public $outputCSS = ''; // phpcs:ignore WordPress.NamingConventions.ValidVariableName

		/**
		 * Autogenerated variables appended to dynamic output.
		 *
		 * @var array
		 */
		public $output_variables = array();

		/**
		 * CSS sent to the compiler hook (snake case maintained for backward compatibility).
		 *
		 * @var string
		 */
		public $compilerCSS = ''; // phpcs:ignore WordPress.NamingConventions.ValidVariableName

		/**
		 * Array of fields that didn't pass the fold dependency test and are hidden.
		 *
		 * @var array
		 */
		public $fields_hidden = array();

		/**
		 * Array of fields to use as pointers in extensions.
		 *
		 * @var array
		 */
		public $field_sections = array();

		/**
		 * Values to generate google font CSS.
		 *
		 * @var string
		 */
		public $typography = array();

		/**
		 * Array of global arguments.
		 *
		 * @var array|mixed
		 */
		public $args = array();

		/**
		 * Used in customizer hooks.
		 *
		 * @var string
		 */
		public $old_opt_name = '';

		/**
		 * File system object usedfor I/O file operations.  DOnr the WordPress way.
		 *
		 * @var null|object
		 */
		public $filesystem = null;

		/**
		 * Array of various font groups used within the typography field.
		 *
		 * @var array
		 */
		public $font_groups = array();

		/**
		 * Pointer to the Redux_Options_Default class.
		 *
		 * @var null|Redux_Options_Defaults
		 */
		public $options_defaults_class = null;

		/**
		 * Pointer to the Redux_Options class.
		 *
		 * @var null|Redux_Options
		 */
		public $options_class = null;

		/**
		 * Pointer to the Redux_Required class
		 *
		 * @var null|Redux_Required
		 */
		public $required_class = null;

		/**
		 * Pointer to the Redux_Output class.
		 *
		 * @var null|Redux_Output
		 */
		public $output_class = null;

		/**
		 * Pointer to the Redux_Page_Render class.
		 *
		 * @var null|Redux_Page_Render
		 */
		public $render_class = null;

		/**
		 * Pointer to the Redux_Enqueue class.
		 *
		 * @var null|Redux_Enqueue
		 */
		public $enqueue_class = null;

		/**
		 * Pointer to the Redux_Transients class.
		 *
		 * @var null|Redux_Transients
		 */
		public $transient_class = null;

		/**
		 * Pointer to the Redux_wordPress_Data class.
		 *
		 * @var null|Redux_WordPress_Data
		 */
		public $wordpress_data = null;

		/**
		 * Poiner to the Redux_Validation class.
		 *
		 * @var null|Redux_Validation
		 */
		public $validate_class = null;

		/**
		 * Poiner to the Redux_Sanitize class.
		 *
		 * @var null|Redux_Validation
		 */
		public $sanitize_class = null;

		/**
		 * Pointer to the Redux_Args class.
		 *
		 * @var null|Redux_Args
		 */
		public $args_class = null;

		/**
		 * Array of active transients used by Redux.
		 *
		 * @var araray
		 */
		public $transients = array();

		/**
		 * Deprecated shim for v3 templates.
		 *
		 * @var array
		 *
		 * @deprecated 4.0.0
		 */
		public $hidden_perm_sections = array();

		/**
		 * Deprecated shim for v3 as plugin check.
		 *
		 * @var bool
		 *
		 * @deprecated 4.0.0
		 */
		public static $_as_plugin = false;  // phpcs:ignore PSR2.Classes.PropertyDeclaration

		/**
		 * Deprecated shim for v3 as plugin check.
		 *
		 * @var bool
		 *
		 * @deprecated 4.0.0
		 */
		public static $_is_plugin = false;  // phpcs:ignore PSR2.Classes.PropertyDeclaration

		/**
		 * Cloning is forbidden.
		 *
		 * @since 4.0.0
		 */
		public function __clone() {
			_doing_it_wrong( __FUNCTION__, esc_html__( 'Cheatin&#8217; eh?', 'redux-framework' ), '4.0' );
		}

		/**
		 * Unserializing instances of this class is forbidden.
		 *
		 * @since 4.0.0
		 */
		public function __wakeup() {
			_doing_it_wrong( __FUNCTION__, esc_html__( 'Cheatin&#8217; eh?', 'redux-framework' ), '4.0' );
		}

		/**
		 * Class Constructor. Defines the args for the theme options class
		 *
		 * @since       1.0.0
		 *
		 * @param       array $sections Panel sections.
		 * @param       array $args     Class constructor arguments.
		 */
		public function __construct( array $sections = array(), array $args = array() ) {
			global $pagenow;

			if ( Redux_Core::is_heartbeat() ) {
				return;
			}

			if ( 'wp-cron.php' === $pagenow || empty( $args ) || ! isset( $args['opt_name'] ) || ( isset( $args['opt_name'] ) && empty( $args['opt_name'] ) ) ) {
				return;
			}

			if ( ! isset( Redux::$init[ $args['opt_name'] ] ) ) {
				// Let's go back to the Redux API instead of having it run directly.
				Redux_Functions_Ex::record_caller( $args['opt_name'] );
				Redux::set_args( $args['opt_name'], $args );
				if ( ! empty( $sections ) ) {
					Redux::set_sections( $args['opt_name'], $sections );
				}
				$sections = Redux::construct_sections( $args['opt_name'] );
				$args     = Redux::construct_args( $args['opt_name'] );
				Redux::set_defaults( $args['opt_name'] );
				Redux::$init[ $args['opt_name'] ] = 1;
			}

			$args             = new Redux_Args( $this, $args );
			$this->args_class = $args;
			$this->args       = $args->get;

			Redux_Core::core_construct( $this, $this->args );

			new Redux_Admin_Notices( $this );

			if ( ! empty( $this->args['opt_name'] ) ) {
				new Redux_Instances( $this );

				$this->filesystem = Redux_Filesystem::get_instance( $this );

				/**
				 * Filter 'redux/options/{opt_name}/sections'
				 *
				 * @param  array $sections field option sections
				 */

				// phpcs:ignore WordPress.NamingConventions.ValidHookName
				$this->sections = apply_filters( "redux/options/{$this->args['opt_name']}/sections", $sections );

				/**
				 * Construct hook
				 * action 'redux/construct'
				 *
				 * @param object $this ReduxFramework
				 */

				// phpcs:ignore WordPress.NamingConventions.ValidHookName
				do_action( 'redux/construct', $this );

				// Internataionalization.
				new Redux_I18n( $this, __FILE__ );

				$this->required_class  = new Redux_Required( $this );
				$this->transient_class = new Redux_Transients( $this );
				$this->wordpress_data  = new Redux_WordPress_Data( $this );
				$this->validate_class  = new Redux_Validation( $this );
				$this->sanitize_class  = new Redux_Sanitize( $this );

				// Register extra extensions.
				new Redux_Extensions( $this );

				// Grab database values.
				$this->options_defaults_class = new Redux_Options_Defaults();
				$this->options_class          = new Redux_Options_Constructor( $this );
				$this->options_class->get();

				$this->output_class  = new Redux_Output( $this );
				$this->render_class  = new Redux_Page_Render( $this );
				$this->enqueue_class = new Redux_Enqueue( $this );

				new Redux_AJAX_Save( $this );
				new Redux_AJAX_Typography( $this );
				new Redux_AJAX_Select2( $this );
			}

			/**
			 * Loaded hook
			 * action 'redux/loaded'
			 *
			 * @param  object $this ReduxFramework
			 */

			// phpcs:ignore WordPress.NamingConventions.ValidHookName
			do_action( 'redux/loaded', $this );
		}

		/**
		 * Begin backward compatibility shims for Redux v3 configs and extensions.
		 */

		/**
		 * SHIM: _register_settings
		 */
		public function _register_settings() { // phpcs:ignore PSR2.Methods.MethodDeclaration.Underscore
			$this->options_class->register();
		}

		/**
		 * SHIM: _field_input
		 *
		 * @param array        $field Field array.
		 * @param string|array $v     Field values.
		 */
		public function _field_input( array $field, $v = null ) { // phpcs:ignore PSR2.Methods.MethodDeclaration.Underscore
			$this->render_class->field_input( $field, $v );
		}

		/**
		 * SHIM: field_default_values
		 *
		 * @param array $field Field array.
		 */
		public function field_default_values( array $field ) {
			$this->options_defaults_class->field_default_values( '', $field );
		}

		/**
		 * SHIM: set_options
		 *
		 * @param string|array $value Option values.
		 */
		public function set_options( $value ) {
			$this->options_class->set( $value );
		}

		/**
		 * SHIM: get_options
		 */
		public function get_options() {
			$this->options_class->get();
		}

		/**
		 * SHIM: _default_values
		 *
		 * @return array
		 */
		public function _default_values(): array { // phpcs:ignore PSR2.Methods.MethodDeclaration.Underscore
			if ( ! isset( $this->options_class ) ) {
				$this->options_defaults_class = new Redux_Options_Defaults();
				$this->options_class          = new Redux_Options_Constructor( $this );
			}

			return $this->options_class->default_values();
		}

		/**
		 * SHIM: check_dependencies
		 *
		 * @param array $field Field array.
		 */
		public function check_dependencies( array $field ) {
			$this->required_class->check_dependencies( $field );
		}

		/**
		 * SHIM: _enqueue_output
		 */
		public function _enqueue_output() { // phpcs:ignore PSR2.Methods.MethodDeclaration.Underscore
			if ( empty( $this->output_class ) ) {
				$obj          = new ReduxFramework( $this->sections, $this->args );
				$obj->options = $this->options;
				$obj->output_class->enqueue();
				$this->outputCSS = $obj->outputCSS; // phpcs:ignore WordPress.NamingConventions.ValidVariableName
			} else {
				$this->output_class->enqueue();
			}
		}

		/**
		 * SHIM: _enqueue
		 */
		public function _enqueue() { // phpcs:ignore PSR2.Methods.MethodDeclaration.Underscore
			$this->enqueue_class->init();
		}

		/**
		 * SHIM: generate_panel
		 *
		 * @since       1.0.0
		 * @access      public
		 * @return      void
		 */
		public function generate_panel() {
			$this->render_class->generate_panel();
		}

		/**
		 * SHIM: get_default_values
		 *
		 * @param string $key       Key value.
		 * @param bool   $array_key Flag to determine array status.
		 *
		 * @return array
		 */
		public function get_default_values( string $key, bool $array_key = false ): array {
			return $this->options_defaults_class->default_values( $key, $array_key );
		}

		/**
		 * SHIM: get_default_value
		 *
		 * @param string $key       Key value.
		 * @param bool   $array_key Flag to determine array status.
		 *
		 * @return array
		 */
		public function get_default_value( string $key, bool $array_key = false ): array {
			return $this->options_defaults_class->default_values( $key, $array_key );
		}

		/**
		 * SHIM: get_wordpress_data
		 *
		 * @param bool         $type data type.
		 * @param array        $args args to pass to WordPress API.
		 * @param string|array $current_value Current value.
		 *
		 * @return array|mixed|string|void
		 */
		public function get_wordpress_data( bool $type = false, array $args = array(), $current_value = null ) {
			return $this->wordpress_data->get( $type, $args, $this->args['opt_name'], $current_value );
		}

		/**
		 * SHIM: _validate_values
		 *
		 * @param array $plugin_options Current panel options.
		 * @param array $options        Options to validate.
		 * @param array $sections       Sections array.
		 *
		 * @return array
		 */
		public function _validate_values( array $plugin_options, array $options, array $sections ): array { // phpcs:ignore PSR2.Methods.MethodDeclaration.Underscore
			if ( ! isset( $this->validate_class ) ) {
				$this->validate_class = new Redux_Validation( $this );
			}
				return $this->validate_class->validate( $plugin_options, $options, $sections );
		}

		/**
		 * SHIM: set_transients
		 *
		 * @return void
		 */
		public function set_transients() {}

		/**
		 * SHIM: section_menu
		 *
		 * @param int    $k        Array Key.
		 * @param array  $section  Section array.
		 * @param string $suffix   Unique string.
		 * @param array  $sections Section array.
		 *
		 * @return string
		 */
		public function section_menu( int $k, array $section, string $suffix = '', array $sections = array() ): string {
			return $this->render_class->section_menu( $k, $section, $suffix, $sections );
		}

		/**
		 * SHIM: get_header_html
		 *
		 * @param array $field Field array.
		 *
		 * @return string
		 */
		public function get_header_html( array $field ): string {
			return $this->render_class->get_header_html( $field );
		}

		/**
		 * SHIM: current_user_can
		 *
		 * @param string $permission User permission.
		 *
		 * @return bool
		 */
		public function current_user_can( string $permission ): bool {
			_deprecated_function( __FUNCTION__, '4.0.0', 'Redux_Helpers::current_user_can' );

			return Redux_Helpers::current_user_can( $permission );
		}

		/**
		 * End backward compatibility shims for Redux v3 configs and extensions.
		 */

		/**
		 * Pointer to the ReduxFramework instance.
		 *
		 * @return ReduxFramework|null
		 */
		public function get_instance(): ?ReduxFramework {
			return self::$instance;
		}

		/**
		 * ->get(); This is used to return and option value from the options array
		 *
		 * @since       1.0.0
		 * @access      public
		 *
		 * @param       string $opt_name The option name to return.
		 * @param       mixed  $default  (null) The value to return if option not set.
		 *
		 * @return      mixed
		 */
		public function get( string $opt_name, $default = null ) {
			return ( ! empty( $this->options[ $opt_name ] ) ) ? $this->options[ $opt_name ] : $this->options_class->get_default( $opt_name, $default );
		}

		/**
		 * ->set(); This is used to set an arbitrary option in the options array
		 *
		 * @since       1.0.0
		 * @access      public
		 *
		 * @param       string $opt_name The name of the option being added.
		 * @param       mixed  $values   The value of the option being added.
		 *
		 * @return      void
		 */
		public function set( string $opt_name = '', $values = array() ) {
			if ( ! empty( $opt_name ) && is_array( $values ) ) {
				$this->options[ $opt_name ] = $values;
				$this->options_class->set( $values );
			}
		}
	}

	ReduxFramework::init();

	/**
	 * Action 'redux/init'
	 *
	 * @param null
	 */
	do_action( 'redux/init' ); // phpcs:ignore WordPress.NamingConventions.ValidHookName
}
