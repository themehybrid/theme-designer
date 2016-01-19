<?php
/**
 * Edit/New theme admin screen.
 *
 * @package    ThemeDesigner
 * @subpackage Admin
 * @author     Justin Tadlock <justin@justintadlock.com>
 * @copyright  Copyright (c) 2015-2016, Justin Tadlock
 * @link       http://themehybrid.com/plugins/theme-designer
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/**
 * Project edit screen functionality.
 *
 * @since  1.0.0
 * @access public
 */
final class THDS_Theme_Edit {

	/**
	 * Holds the fields manager instance.
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    object
	 */
	public $manager = '';

	/**
	 * Sets up the needed actions.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	private function __construct() {

		add_action( 'load-post.php',     array( $this, 'load' ) );
		add_action( 'load-post-new.php', array( $this, 'load' ) );

		// Add the help tabs.
		add_action( 'thds_load_theme_edit', array( $this, 'add_help_tabs' ) );
	}

	/**
	 * Runs on the page load. Checks if we're viewing the theme post type and adds
	 * the appropriate actions/filters for the page.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function load() {

		$screen     = get_current_screen();
		$theme_type = thds_get_theme_post_type();

		// Bail if not on the themes screen.
		if ( empty( $screen->post_type ) || $theme_type !== $screen->post_type )
			return;

		// Custom action for loading the edit theme screen.
		do_action( 'thds_load_theme_edit' );

		// Load the fields manager.
		require_once( thds_plugin()->dir_path . 'admin/fields-manager/class-manager.php' );

		// Create a new theme details manager.
		$this->manager = new THDS_Fields_Manager( 'theme_details' );

		// Enqueue scripts and styles.
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue' ) );

		// Output the theme details box.
		add_action( 'edit_form_after_editor', array( $this, 'theme_details_box' ) );

		// Add/Remove meta boxes.
		add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );

		// Add custom option to the publish/submit meta box.
		add_action( 'post_submitbox_misc_actions', array( $this, 'submitbox_misc_actions' ) );

		// Save metadata on post save.
		add_action( 'save_post', array( $this, 'update' ) );

		// Filter the post author drop-down.
		add_filter( 'wp_dropdown_users_args', array( $this, 'dropdown_users_args' ), 10, 2 );
	}

	/**
	 * Load scripts and styles.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function enqueue() {

		wp_enqueue_style( 'thds-admin' );
		wp_enqueue_script( 'thds-edit-theme' );
	}

	/**
	 * Adds/Removes meta boxes.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  string  $post_type
	 * @return void
	 */
	public function add_meta_boxes( $post_type ) {

		remove_meta_box( 'postexcerpt', $post_type, 'normal' );
	}

	/**
	 * Callback on the `post_submitbox_misc_actions` hook (submit meta box). This handles
	 * the output of the sticky theme feature.
	 *
	 * @note   Prior to WP 4.4.0, the `$post` parameter was not passed.
	 * @since  1.0.0
	 * @access public
	 * @param  object  $post
	 * @return void
	 */
	public function submitbox_misc_actions( $post = '' ) {

		// Pre-4.4.0 compatibility.
		if ( ! $post ) {
			global $post;
		}

		// Get the post type object.
		$post_type_object = get_post_type_object( thds_get_theme_post_type() );

		// Is the theme sticky?
		$is_sticky = thds_is_theme_sticky( $post->ID );

		// Set the label based on whether the theme is sticky.
		$label = $is_sticky ? esc_html__( 'Sticky', 'theme-designer' ) : esc_html__( 'Not Sticky', 'theme-designer' ); ?>

		<div class="misc-pub-section curtime misc-pub-theme-sticky">

			<?php wp_nonce_field( 'thds_theme_publish_box_nonce', 'thds_theme_publish_box' ); ?>

			<i class="dashicons dashicons-sticky"></i>
			<?php printf( esc_html__( 'Sticky: %s', 'theme-designer' ), "<strong class='thds-sticky-status'>{$label}</strong>" ); ?>

			<?php if ( current_user_can( $post_type_object->cap->publish_posts ) ) : ?>

				<a href="#thds-sticky-edit" class="thds-edit-sticky"><span aria-hidden="true"><?php esc_html_e( 'Edit', 'theme-designer' ); ?></span> <span class="screen-reader-text"><?php esc_html_e( 'Edit sticky status', 'theme-designer' ); ?></span></a>

				<div id="thds-sticky-edit" class="hide-if-js">
					<label>
						<input type="checkbox" name="thds_theme_sticky" id="thds-theme-sticky" <?php checked( $is_sticky ); ?> value="true" />
						<?php esc_html_e( 'Stick to the theme archive', 'theme-designer' ); ?>
					</label>
					<a href="#thds-theme-sticky" class="thds-save-sticky hide-if-no-js button"><?php esc_html_e( 'OK', 'custom-content-portolio' ); ?></a>
					<a href="#thds-theme-sticky" class="thds-cancel-sticky hide-if-no-js button-cancel"><?php esc_html_e( 'Cancel', 'custom-content-portolio' ); ?></a>
				</div><!-- #thds-sticky-edit -->

			<?php endif; ?>

		</div><!-- .misc-pub-theme-sticky -->
	<?php }

	/**
	 * Output the theme details box.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  object  $post
	 * @return void
	 */
	public function theme_details_box( $post ) { ?>

		<div id="thds-theme-tabs" class="postbox">

			<h3><?php printf( esc_html__( 'Details: %s', 'members' ), '<span class="thds-which-tab"></span>' ); ?></h3>

			<div class="inside">
				<?php $this->manager->display( $post->ID ); ?>
			</div><!-- .inside -->

		</div><!-- .postbox -->
	<?php }

	/**
	 * Save theme details settings on post save.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  int     $post_id
	 * @return void
	 */
	public function update( $post_id ) {

		$this->manager->update( $post_id );

		// Verify the nonce.
		if ( ! isset( $_POST['thds_theme_publish_box'] ) || ! wp_verify_nonce( $_POST['thds_theme_publish_box'], 'thds_theme_publish_box_nonce' ) )
			return;

		// Is the sticky checkbox checked?
		$should_stick = ! empty( $_POST['thds_theme_sticky'] );

		// If checked, add the theme if it is not sticky.
		if ( $should_stick && ! thds_is_theme_sticky( $post_id ) )
			thds_add_sticky_theme( $post_id );

		// If not checked, remove the theme if it is sticky.
		elseif ( ! $should_stick && thds_is_theme_sticky( $post_id ) )
			thds_remove_sticky_theme( $post_id );
	}

	/**
	 * Filter on the post author drop-down (used in the "Author" meta box) to only show users
	 * of roles that have the correct capability for editing portfolio themes.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  array   $args
	 * @param  array   $r
	 * @global object  $wp_roles
	 * @global object  $post
	 * @return array
	 */
	function dropdown_users_args( $args, $r ) {
		global $wp_roles, $post;

		// WP version 4.4.0 check. Bail if we can't use the `role__in` argument.
		if ( ! method_exists( 'WP_User_Query', 'fill_query_vars' ) )
			return $args;

		// Check that this is the correct drop-down.
		if ( 'post_author_override' === $r['name'] && thds_get_theme_post_type() === $post->post_type ) {

			$roles = array();

			// Loop through the available roles.
			foreach ( $wp_roles->roles as $name => $role ) {

				// Get the edit posts cap.
				$cap = get_post_type_object( thds_get_theme_post_type() )->cap->edit_posts;

				// If the role is granted the edit posts cap, add it.
				if ( isset( $role['capabilities'][ $cap ] ) && true === $role['capabilities'][ $cap ] )
					$roles[] = $name;
			}

			// If we have roles, change the args to only get users of those roles.
			if ( $roles ) {
				$args['who']      = '';
				$args['role__in'] = $roles;
			}
		}

		return $args;
	}

	/**
	 * Adds custom help tabs.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function add_help_tabs() {

		$screen = get_current_screen();

		// Title and editor help tab.
		$screen->add_help_tab(
			array(
				'id'       => 'title_editor',
				'title'    => esc_html__( 'Title and Editor', 'theme-designer' ),
				'callback' => array( $this, 'help_tab_title_editor' )
			)
		);

		// Details: General help tab.
		$screen->add_help_tab(
			array(
				'id'       => 'details_general',
				'title'    => esc_html__( 'Details: General', 'theme-designer' ),
				'callback' => array( $this, 'help_tab_details_general' )
			)
		);

		// Details: Integration help tab.
		$screen->add_help_tab(
			array(
				'id'       => 'details_integration',
				'title'    => esc_html__( 'Details: Integration', 'theme-designer' ),
				'callback' => array( $this, 'help_tab_details_integration' )
			)
		);

		// Details: Links help tab.
		$screen->add_help_tab(
			array(
				'id'       => 'details_links',
				'title'    => esc_html__( 'Details: Links', 'theme-designer' ),
				'callback' => array( $this, 'help_tab_details_links' )
			)
		);

		// Details: Description help tab.
		$screen->add_help_tab(
			array(
				'id'       => 'details_description',
				'title'    => esc_html__( 'Details: Description', 'theme-designer' ),
				'callback' => array( $this, 'help_tab_details_description' )
			)
		);

		// Set the help sidebar.
		$screen->set_help_sidebar( thds_get_help_sidebar_text() );
	}

	/**
	 * Displays the title and editor help tab.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function help_tab_title_editor() { ?>

		<ul>
			<li><?php _e( "<strong>Title:</strong> Enter the name of your theme. After you enter a name, you'll see the permalink below, which you can edit.", 'theme-designer' ); ?></li>
			<li><?php _e( '<strong>Editor:</strong> The editor allows you to add or edit content for your theme. You can insert text, media, or shortcodes.', 'theme-designer' ); ?></li>
		</ul>
	<?php }

	/**
	 * Displays the general details help tab.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function help_tab_details_general() { ?>

		<p>
			<?php esc_html_e( 'The general section allows you to enter the most common information about your theme.', 'theme-designer' ); ?>
		</p>

		<ul>
			<li><?php _e( '<strong>Version:</strong> The current version number for the theme.', 'theme-designer' ); ?></li>
			<li><?php _e( '<strong>Download URL:</strong> The URL where the theme files can be downloaded.', 'theme-designer' ); ?></li>
			<li><?php _e( '<strong>Demo URL:</strong> The URL to a preview/demo of the theme.', 'theme-designer' ); ?></li>
			<li><?php _e( '<strong>Parent Theme:</strong> Drop-down select to choose a parent theme if the current theme is a child theme.', 'theme-designer' ); ?></li>
		</ul>
	<?php }

	/**
	 * Displays the integration details help tab.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function help_tab_details_integration() { ?>

		<p>
			<?php esc_html_e( 'The integration section is for integration with third-party plugins and APIs.', 'theme-designer' ); ?>
		</p>

		<ul>
			<li><?php _e( '<strong>WordPress.org Slug:</strong> Enter the slug if your theme is hosted on WordPress.org.', 'theme-designer' ); ?></li>
		</ul>
	<?php }

	/**
	 * Displays the theme details help tab.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function help_tab_details_links() { ?>

		<p>
			<?php esc_html_e( 'The links section is for entering custom URLs associated with your theme.', 'theme-designer' ); ?>
		</p>

		<ul>
			<li><?php _e( '<strong>Repository URL:</strong> The URL to version-controlled repository for the theme (e.g., GitHub, BitBucket).', 'theme-designer' ); ?></li>
			<li><?php _e( '<strong>Purchase URL:</strong> The URL where the theme can be purchased.', 'theme-designer' ); ?></li>
			<li><?php _e( '<strong>Support URL:</strong> The URL where users can find support, such as your support forums.', 'theme-designer' ); ?></li>
			<li><?php _e( '<strong>Translation URL:</strong> The URL where the theme can be translated and/or where translations can be found.', 'theme-designer' ); ?></li>
			<li><?php _e( '<strong>Documentation URL:</strong> The URL to the theme documentation.', 'theme-designer' ); ?></li>
		</ul>
	<?php }

	/**
	 * Displays the theme details help tab.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function help_tab_details_description() { ?>

		<p>
			<?php esc_html_e( 'The description section allows you to enter a custom description (i.e., excerpt) of the theme.', 'theme-designer' ); ?>
		</p>
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

THDS_Theme_Edit::get_instance();
