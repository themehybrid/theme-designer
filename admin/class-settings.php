<?php
/**
 * Plugin settings screen.
 *
 * @package    ThemeDesigner
 * @subpackage Admin
 * @author     Justin Tadlock <justin@justintadlock.com>
 * @copyright  Copyright (c) 2015, Justin Tadlock
 * @link       http://themehybrid.com/plugins/theme-designer
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/**
 * Sets up and handles the plugin settings screen.
 *
 * @since  1.0.0
 * @access public
 */
final class THDS_Settings_Page {

	/**
	 * Settings page name.
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    string
	 */
	public $settings_page = '';

	/**
	 * Sets up the needed actions for adding and saving the meta boxes.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	private function __construct() {
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );
	}

	/**
	 * Sets up custom admin menus.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function admin_menu() {

		// Create the settings page.
		$this->settings_page = add_submenu_page(
			'edit.php?post_type=' . thds_get_theme_post_type(),
			esc_html__( 'Theme Designer Settings', 'theme-designer' ),
			esc_html__( 'Settings', 'theme-designer' ),
			apply_filters( 'thds_settings_capability', 'manage_options' ),
			'thds-settings',
			array( $this, 'settings_page' )
		);

		if ( $this->settings_page ) {

			// Register settings.
			add_action( 'admin_init', array( $this, 'register_settings' ) );

			// Add help tabs.
	///		add_action( "load-{$this->settings_page}", array( $this, 'add_help_tabs' ) );
		}
	}

	/**
	 * Registers the plugin settings.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	function register_settings() {

		// Register the setting.
		register_setting( 'thds_settings', 'thds_settings', array( $this, 'validate_settings' ) );

		/* === Settings Sections === */

		add_settings_section( 'general',     esc_html__( 'General',     'theme-designer' ), array( $this, 'section_general'     ), $this->settings_page );
		add_settings_section( 'reading',     esc_html__( 'Reading',     'theme-designer' ), array( $this, 'section_reading'     ), $this->settings_page );
		add_settings_section( 'integration', esc_html__( 'Integration', 'theme-designer' ), array( $this, 'section_integration' ), $this->settings_page );
		add_settings_section( 'permalinks',  esc_html__( 'Permalinks',  'theme-designer' ), array( $this, 'section_permalinks'  ), $this->settings_page );

		/* === Settings Fields === */

		// General section fields.
		add_settings_field( 'menu_title',          esc_html__( 'Menu Title',          'theme-designer' ), array( $this, 'field_menu_title',         ), $this->settings_page, 'general' );
		add_settings_field( 'archive_title',       esc_html__( 'Archive Title',       'theme-designer' ), array( $this, 'field_archive_title'       ), $this->settings_page, 'general' );
		add_settings_field( 'archive_description', esc_html__( 'Archive Description', 'theme-designer' ), array( $this, 'field_archive_description' ), $this->settings_page, 'general' );

		// Reading section fields.
		add_settings_field( 'themes_per_page', esc_html__( 'Themes Per Page', 'theme-designer' ), array( $this, 'field_themes_per_page' ), $this->settings_page, 'reading' );
		add_settings_field( 'themes_orderby',  esc_html__( 'Sort By',         'theme-designer' ), array( $this, 'field_themes_orderby'  ), $this->settings_page, 'reading' );
		add_settings_field( 'themes_order',    esc_html__( 'Order',           'theme-designer' ), array( $this, 'field_themes_order'    ), $this->settings_page, 'reading' );

		// Integration section fields.
		add_settings_field( 'wporg_integration', esc_html__( 'WordPress.org',           'theme-designer' ), array( $this, 'field_wporg_integration' ), $this->settings_page, 'integration' );
		add_settings_field( 'wporg_transient',   esc_html__( 'WordPress.org Transient', 'theme-designer' ), array( $this, 'field_wporg_transient'   ), $this->settings_page, 'integration' );

		// Permalinks section fields.
		add_settings_field( 'rewrite_base',          esc_html__( 'Rewrite Base', 'theme-designer' ), array( $this, 'field_rewrite_base'         ), $this->settings_page, 'permalinks' );
		add_settings_field( 'theme_rewrite_base',    esc_html__( 'Theme Slug',   'theme-designer' ), array( $this, 'field_theme_rewrite_base'   ), $this->settings_page, 'permalinks' );
		add_settings_field( 'subject_rewrite_base',  esc_html__( 'Subject Slug', 'theme-designer' ), array( $this, 'field_subject_rewrite_base' ), $this->settings_page, 'permalinks' );
		add_settings_field( 'feature_rewrite_base',  esc_html__( 'Feature Slug', 'theme-designer' ), array( $this, 'field_feature_rewrite_base' ), $this->settings_page, 'permalinks' );
		add_settings_field( 'author_rewrite_base',   esc_html__( 'Author Slug',  'theme-designer' ), array( $this, 'field_author_rewrite_base'  ), $this->settings_page, 'permalinks' );
	}

	/**
	 * Validates the plugin settings.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  array  $input
	 * @return array
	 */
	function validate_settings( $settings ) {

		// Text boxes.
		$settings['rewrite_base']         = $settings['rewrite_base']         ? trim( strip_tags( $settings['rewrite_base']         ), '/' ) : 'themes';
		$settings['theme_rewrite_base']   = $settings['theme_rewrite_base']   ? trim( strip_tags( $settings['theme_rewrite_base']   ), '/' ) : '';
		$settings['subject_rewrite_base'] = $settings['subject_rewrite_base'] ? trim( strip_tags( $settings['subject_rewrite_base'] ), '/' ) : '';
		$settings['feature_rewrite_base'] = $settings['feature_rewrite_base'] ? trim( strip_tags( $settings['feature_rewrite_base'] ), '/' ) : 'features';
		$settings['author_rewrite_base']  = $settings['author_rewrite_base']  ? trim( strip_tags( $settings['author_rewrite_base']  ), '/' ) : '';

		$settings['menu_title']    = $settings['menu_title']    ? strip_tags( $settings['menu_title'] )    : esc_html__( 'Themes', 'theme-designer' );
		$settings['archive_title'] = $settings['archive_title'] ? strip_tags( $settings['archive_title'] ) : esc_html__( 'Themes', 'theme-designer' );

		// Kill evil scripts.
		$settings['archive_description'] = stripslashes( wp_filter_post_kses( addslashes( $settings['archive_description'] ) ) );

		// Numbers.
		$expire = absint( $settings['wporg_transient'] );
		$settings['wporg_transient'] = 0 < $expire && 91 < $expire ? $expire : 3;

		$themes_per_page = intval( $settings['themes_per_page'] );
		$settings['themes_per_page'] = -2 < $themes_per_page ? $themes_per_page : 10;

		// Select boxes.
		$settings['themes_orderby'] = isset( $settings['themes_orderby'] ) ? strip_tags( $settings['themes_orderby'] ) : 'date';
		$settings['themes_order']   = isset( $settings['themes_order'] )   ? strip_tags( $settings['themes_order']   ) : 'DESC';

		// Checkboxes.
		$settings['wporg_integration'] = ! empty( $settings['wporg_integration'] );

		/* === Handle Permalink Conflicts ===*/

		// No theme or subject base, themes win.
		if ( ! $settings['theme_rewrite_base'] && ! $settings['subject_rewrite_base'] )
			$settings['subject_rewrite_base'] = 'subjects';

		// No theme or author base, themes win.
		if ( ! $settings['theme_rewrite_base'] && ! $settings['author_rewrite_base'] )
			$settings['author_rewrite_base'] = 'authors';

		// No subject or author base, subjects win.
		if ( ! $settings['subject_rewrite_base'] && ! $settings['author_rewrite_base'] )
			$settings['author_rewrite_base'] = 'authors';

		// Return the validated/sanitized settings.
		return $settings;
	}

	/**
	 * General section callback.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function section_general() { ?>

		<p class="description">
			<?php esc_html_e( 'General settings for the themes section of your site.', 'theme-designer' ); ?>
		</p>
	<?php }

	/**
	 * Menu title field callback.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function field_menu_title() { ?>

		<label>
			<input type="text" class="regular-text" name="thds_settings[menu_title]" value="<?php echo esc_attr( thds_get_menu_title() ); ?>" />
			<br />
			<span class="description"><?php esc_html_e( 'The title for the themes admin menu.', 'theme-designer' ); ?></span>
		</label>
	<?php }

	/**
	 * Archive title field callback.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function field_archive_title() { ?>

		<label>
			<input type="text" class="regular-text" name="thds_settings[archive_title]" value="<?php echo esc_attr( thds_get_archive_title() ); ?>" />
			<br />
			<span class="description"><?php esc_html_e( 'The title used for theme archive.', 'theme-designer' ); ?></span>
		</label>
	<?php }

	/**
	 * Archive description field callback.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function field_archive_description() {

		wp_editor(
			thds_get_archive_description(),
			'thds_archive_description',
			array(
				'textarea_name'    => 'thds_settings[archive_description]',
				'drag_drop_upload' => true,
				'editor_height'    => 150
			)
		); ?>

		<p>
			<span class="description"><?php esc_html_e( 'Your theme archive description. This may or may not be shown by your theme.', 'theme-designer' ); ?></span>
		</p>
	<?php }

	/**
	 * Reading section callback.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function section_reading() { ?>

		<p class="description">
			<?php esc_html_e( 'Reading settings for the front end of your site.', 'theme-designer' ); ?>
		</p>
	<?php }

	/**
	 * Themes per page field callback.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function field_themes_per_page() { ?>

		<label>
			<input type="number" class="small-text" min="-1" name="thds_settings[themes_per_page]" value="<?php echo esc_attr( thds_get_themes_per_page() ); ?>" />
		</label>
	<?php }

	/**
	 * Themes orderby field callback.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function field_themes_orderby() {

		$orderby = array(
			'author'   => __( 'Author',           'theme-designer' ),
			'date'     => __( 'Date (Published)', 'theme-designer' ),
			'modified' => __( 'Date (Modified)',  'theme-designer' ),
			'ID'       => __( 'ID',               'theme-designer' ),
			'rand'     => __( 'Random',           'theme-designer' ),
			'name'     => __( 'Slug',             'theme-designer' ),
			'title'    => __( 'Title',            'theme-designer' )
		); ?>

		<label>
			<select name="thds_settings[themes_orderby]">

			<?php foreach ( $orderby as $option => $label ) : ?>
				<option value="<?php echo esc_attr( $option ); ?>" <?php selected( $option, thds_get_themes_orderby() ); ?>><?php echo esc_html( $label ); ?></option>
			<?php endforeach; ?>

			</select>
		<label>
	<?php }

	/**
	 * Themes order field callback.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function field_themes_order() {

		$order = array(
			'ASC'  => __( 'Ascending',  'theme-designer' ),
			'DESC' => __( 'Descending', 'theme-designer' )
		); ?>

		<label>
			<select name="thds_settings[themes_order]">

			<?php foreach ( $order as $option => $label ) : ?>
				<option value="<?php echo esc_attr( $option ); ?>" <?php selected( $option, thds_get_themes_order() ); ?>><?php echo esc_html( $label ); ?></option>
			<?php endforeach; ?>

			</select>
		<label>
	<?php }

	/**
	 * Integration section callback.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function section_integration() { ?>

		<p class="description">
			<?php esc_html_e( 'Integrate your themes with third-party sites.', 'theme-designer' ); ?>
		</p>
	<?php }

	/**
	 * WordPress.org integration field callback.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function field_wporg_integration() { ?>

		<label>
			<input type="checkbox" name="thds_settings[wporg_integration]" value="true" <?php checked( thds_use_wporg_api() ); ?> />
			<?php esc_html_e( 'Use the WordPress.org themes API?', 'theme-designer' ); ?>
		</label>
	<?php }

	/**
	 * WordPress.org integration transient expiration field callback.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function field_wporg_transient() { ?>

		<label>
			<input type="number" class="small-text" min="1" max="90" name="thds_settings[wporg_transient]" value="<?php echo esc_attr( thds_get_setting( 'wporg_transient' ) ); ?>" />
			<br />
			<span class="description"><?php esc_html_e( 'How often (in days) to update theme data from the WordPress.org API.', 'theme-designer' ); ?></span>
		</label>
	<?php }

	/**
	 * Permalinks section callback.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function section_permalinks() { ?>

		<p class="description">
			<?php esc_html_e( 'Set up custom permalinks for the themes section on your site.', 'theme-designer' ); ?>
		</p>
	<?php }

	/**
	 * Rewrite base field callback.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function field_rewrite_base() { ?>

		<label>
			<code><?php echo esc_url( home_url( '/' ) ); ?></code>
			<input type="text" class="regular-text code" name="thds_settings[rewrite_base]" value="<?php echo esc_attr( thds_get_rewrite_base() ); ?>" />
		</label>
	<?php }

	/**
	 * Theme rewrite base field callback.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function field_theme_rewrite_base() { ?>

		<label>
			<code><?php echo esc_url( home_url( thds_get_rewrite_base() . '/' ) ); ?></code>
			<input type="text" class="regular-text code" name="thds_settings[theme_rewrite_base]" value="<?php echo esc_attr( thds_get_theme_rewrite_base() ); ?>" />
		</label>
	<?php }

	/**
	 * Subject rewrite base field callback.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function field_subject_rewrite_base() { ?>

		<label>
			<code><?php echo esc_url( home_url( thds_get_rewrite_base() . '/' ) ); ?></code>
			<input type="text" class="regular-text code" name="thds_settings[subject_rewrite_base]" value="<?php echo esc_attr( thds_get_subject_rewrite_base() ); ?>" />
		</label>
	<?php }

	/**
	 * Feature rewrite base field callback.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function field_feature_rewrite_base() { ?>

		<label>
			<code><?php echo esc_url( home_url( thds_get_rewrite_base() . '/' ) ); ?></code>
			<input type="text" class="regular-text code" name="thds_settings[feature_rewrite_base]" value="<?php echo esc_attr( thds_get_feature_rewrite_base() ); ?>" />
		</label>
	<?php }

	/**
	 * Author rewrite base field callback.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function field_author_rewrite_base() { ?>

		<label>
			<code><?php echo esc_url( home_url( thds_get_rewrite_base() . '/' ) ); ?></code>
			<input type="text" class="regular-text code" name="thds_settings[author_rewrite_base]" value="<?php echo esc_attr( thds_get_author_rewrite_base() ); ?>" />
		</label>
	<?php }

	/**
	 * Renders the settings page.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function settings_page() {

		// Flush the rewrite rules if the settings were updated.
		if ( isset( $_GET['settings-updated'] ) )
			flush_rewrite_rules(); ?>

		<div class="wrap">
			<h1><?php esc_html_e( 'Theme Designer Settings', 'theme-designer' ); ?></h1>

			<?php settings_errors(); ?>

			<form method="post" action="options.php">
				<?php settings_fields( 'thds_settings' ); ?>
				<?php do_settings_sections( $this->settings_page ); ?>
				<?php submit_button( esc_attr__( 'Update Settings', 'theme-designer' ), 'primary' ); ?>
			</form>

		</div><!-- wrap -->
	<?php }

	/**
	 * Adds help tabs.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function add_help_tabs() {

		// Get the current screen.
		$screen = get_current_screen();

		// General settings help tab.
		$screen->add_help_tab(
			array(
				'id'       => 'general',
				'title'    => esc_html__( 'General Settings', 'theme-designer' ),
				'callback' => array( $this, 'help_tab_general' )
			)
		);

		// Permalinks settings help tab.
		$screen->add_help_tab(
			array(
				'id'       => 'permalinks',
				'title'    => esc_html__( 'Permalinks', 'theme-designer' ),
				'callback' => array( $this, 'help_tab_permalinks' )
			)
		);

		// Set the help sidebar.
		$screen->set_help_sidebar( thds_get_help_sidebar_text() );
	}

	/**
	 * Displays the general settings help tab.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function help_tab_general() { ?>

		<ul>
			<li><?php _e( '<strong>Title:</strong> Allows you to set the title for the portfolio section on your site. This is general shown on the portfolio themes archive, but themes and other plugins may use it in other ways.', 'theme-designer' ); ?></li>
			<li><?php _e( '<strong>Description:</strong> This is the description for your portfolio. Some themes may display this on the portfolio themes archive.', 'theme-designer' ); ?></li>
		</ul>
	<?php }

	/**
	 * Displays the permalinks help tab.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function help_tab_permalinks() { ?>

		<ul>
			<li><?php _e( '<strong>Portfolio Base:</strong> The primary URL for the portfolio section on your site. It lists your portfolio themes.', 'theme-designer' ); ?></li>
			<li>
				<?php _e( '<strong>Project Slug:</strong> The slug for single portfolio themes. You can use something custom, leave this field empty, or use one of the following tags:', 'theme-designer' ); ?>
				<ul>
					<li><?php printf( esc_html__( '%s - The theme author name.', 'theme-designer' ), '<code>%author%</code>' ); ?></li>
					<li><?php printf( esc_html__( '%s - The theme subject.', 'theme-designer' ), '<code>%' . thds_get_subject_taxonomy() . '%</code>' ); ?></li>
					<li><?php printf( esc_html__( '%s - The theme tag.', 'theme-designer' ), '<code>%' . thds_get_feature_taxonomy() . '%</code>' ); ?></li>
				</ul>
			</li>
			<li><?php _e( '<strong>Category Slug:</strong> The base slug used for portfolio subject archives.', 'theme-designer' ); ?></li>
			<li><?php _e( '<strong>Tag Slug:</strong> The base slug used for portfolio tag archives.', 'theme-designer' ); ?></li>
			<li><?php _e( '<strong>Author Slug:</strong> The base slug used for portfolio author archives.', 'theme-designer' ); ?></li>
		</ul>
	<?php }

	/**
	 * Returns the instance.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return object
	 */
	public static function get_instance() {

		static $instance = null;

		if ( is_null( $instance ) )
			$instance = new self;

		return $instance;
	}
}

THDS_Settings_Page::get_instance();
