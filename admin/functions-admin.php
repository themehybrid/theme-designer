<?php

# Register scripts and styles.
add_action( 'admin_enqueue_scripts', 'thds_admin_register_scripts', 0 );
add_action( 'admin_enqueue_scripts', 'thds_admin_register_styles',  0 );

# Registers theme details box sections, controls, and settings.
add_action( 'thds_theme_details_manager_register', 'thds_theme_details_register', 5 );

/**
 * Registers admin scripts.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function thds_admin_register_scripts() {

	$min = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

	wp_register_script( 'thds-edit-theme', thds_plugin()->js_uri . "edit-theme{$min}.js", array( 'jquery' ), '', true );

	// Localize our script with some text we want to pass in.
	$i18n = array(
		'label_sticky'     => esc_html__( 'Sticky',     'theme-designer' ),
		'label_not_sticky' => esc_html__( 'Not Sticky', 'theme-designer' ),
	);

	wp_localize_script( 'thds-edit-theme', 'thds_i18n', $i18n );
}

/**
 * Registers admin styles.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function thds_admin_register_styles() {

	$min = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

	wp_register_style( 'thds-admin', thds_plugin()->css_uri . "admin{$min}.css" );
}

/**
 * Registers the default cap groups.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function thds_theme_details_register( $manager ) {

	/* === Register Sections === */

	// General section.
	$manager->register_section( 'general',
		array(
			'label' => esc_html__( 'General', 'theme-designer' ),
			'icon'  => 'dashicons-admin-generic'
		)
	);

	// Integration section.
	$manager->register_section( 'integration',
		array(
			'label' => esc_html__( 'Integration', 'theme-designer' ),
			'icon'  => 'dashicons-editor-code'
		)
	);

	// Links section.
	$manager->register_section( 'links',
		array(
			'label' => esc_html__( 'Links', 'theme-designer' ),
			'icon'  => 'dashicons-admin-links'
		)
	);

	// Description section.
	$manager->register_section( 'description',
		array(
			'label' => esc_html__( 'Description', 'theme-designer' ),
			'icon'  => 'dashicons-edit'
		)
	);

	/* === Register Controls === */

	$version_args = array(
		'section'     => 'general',
		'attr'        => array( 'placeholder' => '1.0.0' ),
		'label'       => esc_html__( 'Version', 'theme-designer' ),
		'description' => esc_html__( 'The current version of the theme.', 'theme-designer' )
	);

	$download_url_args = array(
		'section'     => 'general',
		'attr'        => array( 'class' => 'widefat', 'placeholder' => 'http://example.com' ),
		'label'       => esc_html__( 'Download URL', 'theme-designer' ),
		'description' => esc_html__( 'URL to ZIP or other type of file to download.', 'theme-designer' )
	);

	$demo_url_args = array(
		'section'     => 'general',
		'attr'        => array( 'class' => 'widefat', 'placeholder' => 'http://example.com' ),
		'label'       => esc_html__( 'Demo URL', 'theme-designer' ),
		'description' => esc_html__( 'Theme demo/preview URL.', 'theme-designer' )
	);

	$parent_theme_args = array(
		'section'     => 'general',
		'label'       => esc_html__( 'Parent Theme', 'theme-designer' ),
		'description' => esc_html__( 'The parent theme if this is a child theme.', 'theme-designer' )
	);

	$repo_url_args = array(
		'section'     => 'links',
		'attr'        => array( 'class' => 'widefat', 'placeholder' => 'http://example.com' ),
		'label'       => esc_html__( 'Repository URL', 'theme-designer' ),
		'description' => esc_html__( 'URL to the code repository.', 'theme-designer' )
	);

	$purchase_url_args = array(
		'section'     => 'links',
		'attr'        => array( 'class' => 'widefat', 'placeholder' => 'http://example.com' ),
		'label'       => esc_html__( 'Purchase URL', 'theme-designer' ),
		'description' => esc_html__( 'URL to where the theme can be purchased.', 'theme-designer' )
	);

	$support_url_args = array(
		'section'     => 'links',
		'attr'        => array( 'class' => 'widefat', 'placeholder' => 'http://example.com' ),
		'label'       => esc_html__( 'Support URL', 'theme-designer' ),
		'description' => esc_html__( 'Theme support or forum URL.', 'theme-designer' )
	);

	$docs_url_args = array(
		'section'     => 'links',
		'attr'        => array( 'class' => 'widefat', 'placeholder' => 'http://example.com' ),
		'label'       => esc_html__( 'Documentation URL', 'theme-designer' ),
		'description' => esc_html__( 'URL to the theme documentation.', 'theme-designer' )
	);

	$translate_url_args = array(
		'section'     => 'links',
		'attr'        => array( 'class' => 'widefat', 'placeholder' => 'http://example.com' ),
		'label'       => esc_html__( 'Translation URL', 'theme-designer' ),
		'description' => esc_html__( 'URL to the theme translations.', 'theme-designer' )
	);

	$wporg_slug_args = array(
		'section'     => 'integration',
		'attr'        => array( 'placeholder' => 'twentyten' ),
		'label'       => esc_html__( 'WordPress.org Slug', 'theme-designer' ),
		'description' => esc_html__( 'Slug (not URL) of the theme on the WordPress.org theme directory.', 'theme-designer' )
	);

	$github_slug_args = array(
		'section'     => 'integration',
		'attr'        => array( 'placeholder' => 'username/repository' ),
		'label'       => esc_html__( 'GitHub Slug', 'theme-designer' ),
		'description' => esc_html__( 'Username and slug of repository on GitHub (e.g., username/repository).', 'theme-designer' )
	);

	$edd_download_id_args = array(
		'section'     => 'integration',
		'attr'        => array( 'placeholder', '1000' ),
		'label'       => esc_html__( 'EDD Download ID', 'theme-designer' ),
		'description' => esc_html__( 'Download ID from Easy Digital Downloads.', 'theme-designer' )
	);

	$excerpt_args = array(
		'section'     => 'description',
		'type'        => 'textarea',
		'attr'        => array( 'id' => 'excerpt', 'name' => 'excerpt' ),
		'label'       => esc_html__( 'Description', 'theme-designer' ),
		'description' => esc_html__( 'Write a short description (excerpt) of the theme.', 'theme-designer' )
	);

	$manager->register_control( 'version',         $version_args         );
	$manager->register_control( 'download_url',    $download_url_args    );
	$manager->register_control( 'demo_url',        $demo_url_args        );
	$manager->register_control( 'repo_url',        $repo_url_args        );
	$manager->register_control( 'purchase_url',    $purchase_url_args    );
	$manager->register_control( 'support_url',     $support_url_args     );
	$manager->register_control( 'translate_url',   $translate_url_args   );
	$manager->register_control( 'docs_url',        $docs_url_args        );
	$manager->register_control( 'wporg_slug',      $wporg_slug_args      );
	//$manager->register_control( 'github_slug',     $github_slug_args     );
	$manager->register_control( 'edd_download_id', $edd_download_id_args );


	$manager->register_control( new THDS_Fields_Control_Parent( $manager, 'parent_id', $parent_theme_args ) );

	$manager->register_control( new THDS_Fields_Control_Excerpt( $manager, 'excerpt',    $excerpt_args    ) );

	/* === Register Settings === */

	$manager->register_setting( 'version',         array( 'sanitize_callback' => '' ) );
	$manager->register_setting( 'download_url',    array( 'sanitize_callback' => 'esc_url_raw' ) );
	$manager->register_setting( 'demo_url',        array( 'sanitize_callback' => 'esc_url_raw' ) );
	$manager->register_setting( 'repo_url',        array( 'sanitize_callback' => 'esc_url_raw' ) );
	$manager->register_setting( 'purchase_url',    array( 'sanitize_callback' => 'esc_url_raw' ) );
	$manager->register_setting( 'support_url',     array( 'sanitize_callback' => 'esc_url_raw' ) );
	$manager->register_setting( 'translate_url',   array( 'sanitize_callback' => 'esc_url_raw' ) );
	$manager->register_setting( 'docs_url',        array( 'sanitize_callback' => 'esc_url_raw' ) );
	$manager->register_setting( 'wporg_slug',      array( 'sanitize_callback' => 'sanitize_title_with_dashes' ) );
	//$manager->register_setting( 'github_slug',     array( 'sanitize_callback' => 'strip_tags' ) );
	$manager->register_setting( 'edd_download_id', array( 'sanitize_callback' => 'absint' ) );

}

/**
 * Help sidebar for all of the help tabs.
 *
 * @since  1.0.0
 * @access public
 * @return string
 */
function thds_get_help_sidebar_text() {

	// Get docs and help links.
	$docs_link = sprintf( '<li><a href="http://themehybrid.com/docs">%s</a></li>', esc_html__( 'Documentation', 'custom-cotent-portfolio' ) );
	$help_link = sprintf( '<li><a href="http://themehybrid.com/board/topics">%s</a></li>', esc_html__( 'Support Forums', 'theme-designer' ) );

	// Return the text.
	return sprintf(
		'<p><strong>%s</strong></p><ul>%s%s</ul>',
		esc_html__( 'For more information:', 'theme-designer' ),
		$docs_link,
		$help_link
	);
}
