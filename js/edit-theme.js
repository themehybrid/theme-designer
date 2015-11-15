jQuery( document ).ready( function() {

	/* === Edit sticky status in the "Publish" meta box. === */

	var sticky_checkbox = jQuery( 'input[name=thds_theme_sticky]' );
	var is_sticky       = jQuery( sticky_checkbox ).prop( 'checked' );

	// When user clicks the "Edit" sticky link.
	jQuery( 'a.thds-edit-sticky' ).click(
		function( j ) {
			j.preventDefault();

			// Grab the original status again in case user clicks "OK" or "Cancel" more than once.
			is_sticky = jQuery( sticky_checkbox ).prop( 'checked' );

			// Hide this link.
			jQuery( this ).hide();

			// Open the sticky edit.
			jQuery( '#thds-sticky-edit' ).slideToggle();
		}
	);

	/* When the user clicks the "OK" post status button. */
	jQuery( 'a.thds-save-sticky' ).click(
		function( j ) {
			j.preventDefault();

			// Close the sticky edit.
			jQuery( '#thds-sticky-edit' ).slideToggle();

			// Show the hidden "Edit" link.
			jQuery( 'a.thds-edit-sticky' ).show();
		}
	);

	// When the user clicks the "Cancel" edit sticky link.
	jQuery( 'a.thds-cancel-sticky' ).click(
		function( j ) {
			j.preventDefault();

			// Close the sticky edit.
			jQuery( '#thds-sticky-edit' ).slideToggle();

			// Show the hidden "Edit" link.
			jQuery( 'a.thds-edit-sticky' ).show();

			// Set the original checked/not-checked since we're canceling.
			jQuery( sticky_checkbox ).prop( 'checked', is_sticky ).trigger( 'change' );
		}
	);

	// When the sticky status changes.
	jQuery( sticky_checkbox ).change(
		function() {
			jQuery( 'strong.thds-sticky-status' ).text(
				jQuery( sticky_checkbox ).prop( 'checked' ) ? thds_i18n.label_sticky : thds_i18n.label_not_sticky
			);
		}
	);

	/* ====== Tabs ====== */

	// Hides the tab content.
	jQuery( '.thds-fields-section' ).hide();

	// Shows the first tab's content.
	jQuery( '.thds-fields-section:first-child' ).show();

	// Makes the 'aria-selected' attribute true for the first tab nav item.
	jQuery( '.thds-fields-nav :first-child' ).attr( 'aria-selected', 'true' );

	// Copies the current tab item title to the box header.
	jQuery( '.thds-which-tab' ).text( jQuery( '.thds-fields-nav :first-child a' ).text() );

	// When a tab nav item is clicked.
	jQuery( '.thds-fields-nav li a' ).click(
		function( j ) {

			// Prevent the default browser action when a link is clicked.
			j.preventDefault();

			// Get the `href` attribute of the item.
			var href = jQuery( this ).attr( 'href' );

			// Hide all tab content.
			jQuery( this ).parents( '.thds-fields-manager' ).find( '.thds-fields-section' ).hide();

			// Find the tab content that matches the tab nav item and show it.
			jQuery( this ).parents( '.thds-fields-manager' ).find( href ).show();

			// Set the `aria-selected` attribute to false for all tab nav items.
			jQuery( this ).parents( '.thds-fields-manager' ).find( '.thds-fields-nav li' ).attr( 'aria-selected', 'false' );

			// Set the `aria-selected` attribute to true for this tab nav item.
			jQuery( this ).parent().attr( 'aria-selected', 'true' );

			// Copy the current tab item title to the box header.
			jQuery( '.thds-which-tab' ).text( jQuery( this ).text() );
		}
	); // click()

} ); // ready()
