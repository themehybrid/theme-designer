<?php
/**
 * Theme management admin screen.
 *
 * @package    ThemeDesigner
 * @subpackage Admin
 * @author     Justin Tadlock <justin@justintadlock.com>
 * @copyright  Copyright (c) 2015-2016, Justin Tadlock
 * @link       http://themehybrid.com/plugins/theme-designer
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/**
 * Adds additional columns and features to the themes admin screen.
 *
 * @since  1.0.0
 * @access public
 */
final class THDS_Manage_Themes {

	/**
	 * Sets up the needed actions.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	private function __construct() {

		add_action( 'load-edit.php', array( $this, 'load' ) );

		// Hook the handler to the manage themes load screen.
		add_action( 'thds_load_manage_themes', array( $this, 'handler' ), 0 );

		// Add the help tabs.
		add_action( 'thds_load_manage_themes', array( $this, 'add_help_tabs' ) );
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

		// Custom action for loading the manage themes screen.
		do_action( 'thds_load_manage_themes' );

		// Filter the posts query.
		add_action( 'pre_get_posts', array( $this, 'pre_get_posts' ) );

		// Add custom views.
		add_filter( "views_edit-{$theme_type}", array( $this, 'views' ) );

		// Category and tag table filters.
		add_action( 'restrict_manage_posts', array( $this, 'subjects_dropdown' ) );
		add_action( 'restrict_manage_posts', array( $this, 'features_dropdown' ) );

		// Custom columns on the edit portfolio items screen.
		add_filter( "manage_edit-{$theme_type}_columns",          array( $this, 'columns' )              );
		add_filter( "manage_edit-{$theme_type}_sortable_columns", array( $this, 'sortable_columns' )     );
		add_action( "manage_{$theme_type}_posts_custom_column",   array( $this, 'custom_column' ), 10, 2 );

		// Print custom styles.
		add_action( 'admin_head', array( $this, 'print_styles' ) );

		// Filter post states (shown next to post title).
		add_filter( 'display_post_states', array( $this, 'display_post_states' ), 0, 2 );

		// Filter the row actions (shown below title).
		add_filter( 'post_row_actions', array( $this, 'row_actions' ), 10, 2 );
	}

	/**
	 * Filter on the `pre_get_posts` hook to change what posts are loaded.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  object  $query
	 */
	public function pre_get_posts( $query ) {

		$new_vars = array();

		// If viewing sticky themes.
		if ( isset( $_GET['sticky'] ) && 1 == $_GET['sticky'] ) {

			$query->set( 'post__in', thds_get_sticky_themes() );

		} else if ( isset( $_GET['orderby'] ) && 'download_count' === $_GET['orderby'] ) {

			$query->set( 'orderby',  'meta_value_num' );
			$query->set( 'meta_key', 'download_count' );

		} else if ( isset( $_GET['orderby'] ) && 'install_count' === $_GET['orderby'] ) {

			$query->set( 'orderby',  'meta_value_num' );
			$query->set( 'meta_key', 'install_count'  );

		} else if ( isset( $_GET['orderby'] ) && 'rating' === $_GET['orderby'] ) {

			$query->set( 'orderby',  'meta_value_num' );
			$query->set( 'meta_key', 'rating'         );

		// Default ordering by post title.
		} else if ( ! isset( $_GET['order'] ) && ! isset( $_GET['orderby'] ) ) {

			$query->set( 'order',   'ASC'        );
			$query->set( 'orderby', 'post_title' );
		}
	}

	/**
	 * Print styles.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  string  $hook_suffix
	 * @return void
	 */
	public function print_styles() { ?>

		<style type="text/css">@media only screen and (min-width: 783px) {
			.fixed .column-screenshot,
			.fixed .column-downloads { width: 110px; }
			.fixed .column-rating { width: 120px; }
			.fixed .column-installs { width: 100px; }
			.fixed .column-taxonomy-<?php echo esc_attr( thds_get_subject_taxonomy() ); ?>,
			.fixed .column-taxonomy-<?php echo esc_attr( thds_get_feature_taxonomy() ); ?> { width: 115px; }
		}</style>
	<?php }

	/**
	 * Add custom views (status list).
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  array  $views
	 * @return array
	 */
	public function views( $views ) {

		$count = count( thds_get_sticky_themes() );

		if ( 0 < $count ) {
			$post_type = thds_get_theme_post_type();

			$noop = _n( 'Sticky <span class="count">(%s)</span>', 'Sticky <span class="count">(%s)</span>', $count, 'theme-designer' );
			$text = sprintf( $noop, number_format_i18n( $count ) );

			$views['sticky'] = sprintf( '<a href="%s">%s</a>', add_query_arg( array( 'post_type' => $post_type, 'sticky' => 1 ), admin_url( 'edit.php' ) ), $text );
		}

		return $views;
	}

	/**
	 * Renders a subjects dropdown below the table nav.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function subjects_dropdown() {

		$this->terms_dropdown( thds_get_subject_taxonomy() );
	}

	/**
	 * Renders a feature dropdown below the table nav.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function features_dropdown() {

		$this->terms_dropdown( thds_get_feature_taxonomy() );
	}

	/**
	 * Renders a terms dropdown based on the given taxonomy.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function terms_dropdown( $taxonomy ) {

		wp_dropdown_categories(
			array(
				'show_option_all' => false,
				'show_option_none'    => get_taxonomy( $taxonomy )->labels->all_items,
				'option_none_value'  => '',
				'orderby'            => 'name',
				'order'              => 'ASC',
				'show_count'         => true,
				'selected'           => isset( $_GET[ $taxonomy ] ) ? esc_attr( $_GET[ $taxonomy ] ) : '',
				'hierarchical'       => true,
				'name'               => $taxonomy,
				'id'                 => '',
				'class'              => 'postform',
				'taxonomy'           => $taxonomy,
				'hide_if_empty'      => true,
				'value_field'	     => 'slug',
			)
		);
	}

	/**
	 * Sets up custom columns on the themes edit screen.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  array  $columns
	 * @return array
	 */
	public function columns( $columns ) {

		$new_columns = array(
			'cb'    => $columns['cb'],
			'title' => __( 'Theme', 'theme-designer' )
		);

		if ( current_theme_supports( 'post-thumbnails' ) )
			$new_columns['screenshot'] = __( 'Screenshot', 'theme-designer' );

		$columns = array_merge( $new_columns, $columns );

		$columns['title'] = $new_columns['title'];

		if ( thds_use_wporg_api() ) {
			$columns['downloads'] = __( 'Downloads', 'theme-designer' );
			$columns['installs']  = __( 'Installs',  'theme-designer' );
			$columns['rating']    = __( 'Rating',    'theme-designer' );
		}

		if ( isset( $columns['date'] ) ) {

			$date = $columns['date'];
			unset( $columns['date'] );

			$columns['date'] = $date;
		}

		return $columns;
	}

	/**
	 * Adds sortable columns.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  array   $columns
	 * @return array
	 */
	public function sortable_columns( $columns ) {

		if ( thds_use_wporg_api() ) {

			// Need variables b/c of https://core.trac.wordpress.org/ticket/34479
			$meta_key = get_query_var( 'meta_key' );
			$order    = strtolower( get_query_var( 'order' ) );

			$d_order = 'download_count' === $meta_key && 'desc' === $order ? false : true;
			$r_order = 'rating'         === $meta_key && 'desc' === $order ? false : true;
			$i_order = 'installs'       === $meta_key && 'desc' === $order ? false : true;

			$columns['downloads'] = array( 'download_count', $d_order );
			$columns['rating']    = array( 'rating',         $r_order );
			$columns['installs']  = array( 'install_count',  $i_order );
		}

		return $columns;
	}

	/**
	 * Displays the content of custom theme columns on the edit screen.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  string  $column
	 * @param  int     $post_id
	 * @return void
	 */
	public function custom_column( $column, $post_id ) {

		if ( 'screenshot' === $column ) {

			if ( has_post_thumbnail() )
				the_post_thumbnail( array( 75, 75 ) );

			else if ( function_exists( 'get_the_image' ) )
				get_the_image( array( 'scan' => true, 'width' => 75, 'link' => false ) );

		} else if ( 'downloads' === $column ) {

			$count = thds_get_theme_download_count( $post_id );

			$count ? thds_theme_download_count( $post_id ) : print( '&ndash;' );

		} else if ( 'installs' === $column ) {

			$count = thds_get_wporg_theme_active_installs( $post_id );

			$count ? thds_theme_install_count( $post_id ) : print( '&ndash;' );

		} else if ( 'rating' === $column ) {

			$rating = thds_get_theme_rating( $post_id );
			$number = thds_get_theme_rating_count( $post_id );

			wp_star_rating( array( 'type' => 'rating', 'rating' => floatval( $rating ), 'number' => absint( $number ) ) );
		}
	}

	/**
	 * Filter for the `post_states` hook.  We're going to add the theme type.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  array   $states
	 * @param  object  $post
	 */
	public function display_post_states( $states, $post ) {

		if ( thds_is_theme_sticky( $post->ID ) )
			$states['sticky'] = esc_html__( 'Sticky', 'theme-designer' );

		return $states;
	}

	/**
	 * Custom row actions below the post title.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  array   $actions
	 * @param  object  $post
	 * @return array
	 */
	function row_actions( $actions, $post ) {

		$post_type_object = get_post_type_object( thds_get_theme_post_type() );
		$theme_id         = thds_get_theme_id( $post->ID );

		if ( 'trash' === get_post_status( $theme_id ) || ! current_user_can( $post_type_object->cap->publish_posts ) )
			return $actions;

		$current_url = remove_query_arg( array( 'theme_id', 'thds_theme_notice' ) );

		// Build text.
		$text = thds_is_theme_sticky( $theme_id ) ? esc_html__( 'Unstick', 'theme-designer' ) : esc_html__( 'Stick', 'theme-designer' );

		// Build toggle URL.
		$url = add_query_arg( array( 'theme_id' => $theme_id, 'action' => 'thds_toggle_sticky' ), $current_url );
		$url = wp_nonce_url( $url, "thds_toggle_sticky_{$theme_id}" );

		// Add sticky action.
		$actions['sticky'] = sprintf( '<a href="%s" class="%s">%s</a>', esc_url( $url ), 'sticky', esc_html( $text ) );

		// Move view action to the end.
		if ( isset( $actions['view'] ) ) {
			$view_action = $actions['view'];
			unset( $actions['view'] );

			$actions['view'] = $view_action;
		}

		return $actions;
	}

	/**
	 * Callback function for handling post status changes.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function handler() {

		// Checks if the sticky toggle link was clicked.
		if ( isset( $_GET['action'] ) && 'thds_toggle_sticky' === $_GET['action'] && isset( $_GET['theme_id'] ) ) {

			$theme_id = absint( thds_get_theme_id( $_GET['theme_id'] ) );

			// Verify the nonce.
			check_admin_referer( "thds_toggle_sticky_{$theme_id}" );

			if ( thds_is_theme_sticky( $theme_id ) )
				thds_remove_sticky_theme( $theme_id );
			else
				thds_add_sticky_theme( $theme_id );

			// Redirect to correct admin page.
			$redirect = add_query_arg( array( 'updated' => 1 ), remove_query_arg( array( 'action', 'theme_id', '_wpnonce' ) ) );
			wp_safe_redirect( esc_url_raw( $redirect ) );

			// Always exit for good measure.
			exit();
		}

		return;
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

		// Overview help tab.
		$screen->add_help_tab(
			array(
				'id'       => 'overview',
				'title'    => esc_html__( 'Overview', 'theme-designer' ),
				'callback' => array( $this, 'help_tab_overview' )
			)
		);

		// Screen content help tab.
		$screen->add_help_tab(
			array(
				'id'       => 'screen_content',
				'title'    => esc_html__( 'Screen Content', 'theme-designer' ),
				'callback' => array( $this, 'help_tab_screen_content' )
			)
		);

		// Available actions help tab.
		$screen->add_help_tab(
			array(
				'id'       => 'available_actions',
				'title'    => esc_html__( 'Available Actions', 'theme-designer' ),
				'callback' => array( $this, 'help_tab_available_actions' )
			)
		);

		// Set the help sidebar.
		$screen->set_help_sidebar( thds_get_help_sidebar_text() );
	}

	/**
	 * Displays the overview help tab.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function help_tab_overview() { ?>

		<p>
			<?php esc_html_e( 'This screen provides access to all of your theme projects. You can customize the display of this screen to suit your workflow.', 'theme-designer' ); ?>
		</p>
	<?php }

	/**
	 * Displays the screen content help tab.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function help_tab_screen_content() { ?>

		<p>
			<?php esc_html_e( "You can customize the display of this screen's contents in a number of ways:", 'theme-designer' ); ?>
		</p>

		<ul>
			<li><?php esc_html_e( 'You can hide/display columns based on your needs and decide how many themes to list per screen using the Screen Options tab.', 'theme-designer' ); ?></li>
			<li><?php esc_html_e( 'You can filter the list of themes by post status using the text links in the upper left to show All, Published, Draft, or Trashed themes. The default view is to show all themes.', 'theme-designer' ); ?></li>
			<li><?php esc_html_e( 'You can view themes in a simple title list or with an excerpt. Choose the view you prefer by clicking on the icons at the top of the list on the right.', 'theme-designer' ); ?></li>
			<li><?php esc_html_e( 'You can refine the list to show only themes with a specific subject, with a specific feature, or from a specific month by using the dropdown menus above the themes list. Click the Filter button after making your selection. You also can refine the list by clicking on the theme author or subject in the posts list.', 'theme-designer' ); ?></li>
		</ul>
	<?php }

	/**
	 * Displays the available actions help tab.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function help_tab_available_actions() { ?>

		<p>
			<?php esc_html_e( 'Hovering over a row in the themes list will display action links that allow you to manage your theme. You can perform the following actions:', 'theme-designer' ); ?>
		</p>

		<ul>
			<li><?php _e( '<strong>Edit</strong> takes you to the editing screen for that theme. You can also reach that screen by clicking on the theme title.', 'theme-designer' ); ?></li>
			<li><?php _e( '<strong>Quick Edit</strong> provides inline access to the metadata of your theme, allowing you to update theme details without leaving this screen.', 'theme-designer' ); ?></li>
			<li><?php _e( '<strong>Trash</strong> removes your theme from this list and places it in the trash, from which you can permanently delete it.', 'theme-designer' ); ?></li>
			<li><?php _e( '<strong>Stick</strong> puts your theme in the list of "sticky" themes, which are shown first on the theme archive page.', 'theme-designer' ); ?></li>
			<li><?php _e( "<strong>Preview</strong> will show you what your draft theme will look like if you publish it. View will take you to your live site to view the theme. Which link is available depends on your theme's status.", 'theme-designer' ); ?></li>
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

THDS_Manage_Themes::get_instance();
