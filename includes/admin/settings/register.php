<?php
/**
 * Register settings
 *
 * @package     Beacon\Admin\Settings\Register
 * @since       1.0.0
 */


// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/**
 * Register the menu item
 *
 * @since       1.1.0
 * @param       array $menu The existing menu settings
 * @return      array $menu The updated menu settings
 */
function beacon_add_menu( $menu ) {
	$menu['type']       = 'submenu';
	$menu['parent']     = 'options-general.php';
	$menu['page_title'] = __( 'Beacon For Help Scout Settings', 'beacon-for-helpscout' );
	$menu['show_title'] = true;
	$menu['menu_title'] = __( 'Beacon', 'beacon-for-helpscout' );
	$menu['capability'] = 'manage_options';

	return $menu;
}
add_filter( 'beacon_menu', 'beacon_add_menu' );


/**
 * Register the settings tabs
 *
 * @since       1.1.0
 * @param       array tabs The existing settings tabs
 * @return      array tabs The updated settings tabs
 */
function beacon_settings_tabs( $tabs ) {
	$tabs['general']   = __( 'General', 'beacon-for-helpscout' );
	$tabs['customize'] = __( 'Customize', 'beacon-for-helpscout' );
	$tabs['strings']   = __( 'Text Strings', 'beacon-for-helpscout' );

	return $tabs;
}
add_filter( 'beacon_settings_tabs', 'beacon_settings_tabs' );


/**
 * Retrieve the array of plugin settings
 *
 * @since       1.0.0
 * @return      array $beacon_settings The registered settings
 */
function beacon_settings( $settings ) {
	$beacon_settings = array(
		// Settings
		'general' => apply_filters( 'beacon_settings_general', array(
			array(
				'id'   => 'general_header',
				'name' => __( 'General Settings', 'beacon-for-helpscout' ),
				'desc' => '',
				'type' => 'header'
			),
			array(
				'id'   => 'enable_docs',
				'name' => __( 'Enable Docs Search', 'beacon-for-helpscout' ),
				'desc' => __( 'Display the docs search form in Beacon', 'beacon-for-helpscout' ),
				'type' => 'checkbox'
			),
			array(
				'id'   => 'enable_contact',
				'name' => __( 'Enable Contact Form', 'beacon-for-helpscout' ),
				'desc' => __( 'Display a contact form in Beacon', 'beacon-for-helpscout' ),
				'type' => 'checkbox'
			),
			array(
				'id'   => 'helpscout_url',
				'name' => __( 'HelpScout Subdomain', 'beacon-for-helpscout' ),
				'desc' => sprintf( __( 'Enter the subdomain for your HelpScout Docs instance found <a href="%s" target="_blank">here</a>', 'beacon-for-helpscout' ), 'https://secure.helpscout.net/settings/docs/site' ),
				'type' => 'text'
			),
			array(
				'id'   => 'form_id',
				'name' => __( 'Form ID', 'beacon-for-helpscout' ),
				'desc' => sprintf( __( 'Enter the form ID for your Beacon found <a href="%s" target="_blank">here</a>', 'beacon-for-helpscout' ), 'https://secure.helpscout.net/settings/beacons/' ),
				'type' => 'text'
			),
			array(
				'id'   => 'visibility_header',
				'name' => __( 'Visibility Settings', 'beacon-for-helpscout' ),
				'desc' => '',
				'type' => 'header'
			),
			array(
				'id'      => 'visibility',
				'name'    => __( 'Page Visibility', 'beacon-for-helpscout' ),
				'desc'    => __( 'Select whether to hide or show on the below pages', 'beacon-for-helpscout' ),
				'type'    => 'select',
				'std'     => 'hide',
				'options' => array(
					'hide' => __( 'Hide', 'beacon-for-helpscout' ),
					'show' => __( 'Show', 'beacon-for-helpscout' )
				)
			),
			array(
				'id'       => 'visibility_pages',
				'name'     => __( 'Pages', 'beacon-for-helpscout' ),
				'desc'     => __( 'Select the page(s) to hide or show beacon on', 'beacon-for-helpscout' ),
				'type'     => 'select',
				'select2'  => true,
				'multiple' => true,
				'size'     => '25em',
				'options'  => beacon_get_pages()
			),
			array(
				'id'   => 'show_on_dashboard',
				'name' => __( 'Show On Dashboard', 'beacon-for-helpscout' ),
				'desc' => __( 'Specify whether or not to show beacon on the WordPress dashboard', 'beacon-for-helpscout' ),
				'type' => 'checkbox'
			)
		) ),
		'customize' => apply_filters( 'beacon_settings_customize', array(
			array(
				'id'      => 'display_type',
				'name'    => __( 'Display Type', 'beacon-for-helpscout' ),
				'desc'    => __( 'Specify whether to display the standard beacon popover, or display beacon through a modal triggered by a link with the class \'show-beacon\'', 'beacon-for-helpscout' ),
				'type'    => 'select',
				'std'     => 'popover',
				'options' => array(
					'popover' => __( 'Popover', 'beacon-for-helpscout' ),
					'modal'   => __( 'Modal', 'beacon-for-helpscout' ),
				)
			),
			array(
				'id'   => 'display_note',
				'name' => '',
				'desc' => sprintf( __( '%s When using the Popover display type, you can also trigger the popover through buttons with the %s, %s and %s IDs', 'beacon-for-helpscout' ), '<strong>' . __( 'Note:', 'beacon-for-helpscout' ) . '</strong>', '<code>beacon-open</code>', '<code>beacon-close</code>', '<code>beacon-toggle</code>' ),
				'type' => 'descriptive_text'
			),
			array(
				'id'   => 'default_color',
				'name' => __( 'Default Color', 'beacon-for-helpscout' ),
				'desc' => __( 'Specify the default color for Beacon elements', 'beacon-for-helpscout' ),
				'type' => 'color',
				'std'  => '#31A8D9'
			),
			array(
				'id'      => 'icon',
				'name'    => __( 'Icon', 'beacon-for-helpscout' ),
				'desc'    => __( 'Select the icon for the popup button', 'beacon-for-helpscout' ),
				'type'    => 'select',
				'std'     => 'bouy',
				'options' => array(
					'bouy'     => __( 'Bouy', 'beacon-for-helpscout' ),
					'beacon'   => __( 'Beacon', 'beacon-for-helpscout' ),
					'message'  => __( 'Message', 'beacon-for-helpscout' ),
					'question' => __( 'Question', 'beacon-for-helpscout' ),
					'search'   => __( 'Search', 'beacon-for-helpscout' )
				)
			),
			array(
				'id'      => 'position',
				'name'    => __( 'Position', 'beacon-for-helpscout' ),
				'desc'    => __( 'Specify the location for the popup button', 'beacon-for-helpscout' ),
				'type'    => 'select',
				'std'     => 'br',
				'options' => array(
					'br' => __( 'Bottom/Right', 'beacon-for-helpscout' ),
					'bl' => __( 'Bottom/Left', 'beacon-for-helpscout' )
				)
			),
			array(
				'id'   => 'top_articles',
				'name' => __( 'Display Top Articles', 'beacon-for-helpscout' ),
				'desc' => __( 'Check to display top articles automatically instead of just the search box', 'beacon-for-helpscout' ),
				'type' => 'checkbox'
			),
			array(
				'id'   => 'attachments',
				'name' => __( 'Enable Attachments', 'beacon-for-helpscout' ),
				'desc' => __( 'Check to enable attachments in the contact form', 'beacon-for-helpscout' ),
				'type' => 'checkbox',
				'std'  => true
			),
			array(
				'id'   => 'powered_by',
				'name' => __( 'Hide Powered By Text', 'beacon-for-helpscout' ),
				'desc' => __( 'By default, beacons display a \'Powered By Help Scout\' line on the contact form confirmation dialog. Select this to disable it.', 'beacon-for-helpscout' ),
				'type' => 'checkbox'
			),
			array(
				'id'   => 'instructions',
				'name' => __( 'Instructions', 'beacon-for-helpscout' ),
				'desc' => __( 'Enter custom text to display on top of the contact form', 'beacon-for-helpscout' ),
				'type' => 'text'
			),
			array(
				'id'   => 'topic_list',
				'name' => __( 'Help Scout Topics', 'beacon-for-helpscout' ),
				'desc' => __( 'Enter Beacon Topics above. Topics must be formatted using key : value pairs. Key represents the tag that gets applied to the email in Help Scout and the Value is the label that users see on the form. (NOTE: Space on both sides of the colon is important, and new pairs must be added on a new line.)', 'beacon-for-helpscout' ),
				'type' => 'textarea'
			),
		) ),
		'strings' => apply_filters( 'beacon_settings_strings', array(
			array(
				'id'   => 'search_label',
				'name' => __( 'Search Label', 'beacon-for-helpscout' ),
				'desc' => __( 'Enter the text for the Search label', 'beacon-for-helpscout' ),
				'type' => 'text',
				'std'  => __( 'What can we help you with?', 'beacon-for-helpscout' )
			),
			array(
				'id'   => 'search_error_label',
				'name' => __( 'Search Error Label', 'beacon-for-helpscout' ),
				'desc' => __( 'Enter the text for the Search error label', 'beacon-for-helpscout' ),
				'type' => 'text',
				'std'  => __( 'Your search timed out. Please double-check your internet connection and try again.', 'beacon-for-helpscout' )
			),
			array(
				'id'   => 'no_results_label',
				'name' => __( 'No Results Label', 'beacon-for-helpscout' ),
				'desc' => __( 'Enter the text for the No Results label', 'beacon-for-helpscout' ),
				'type' => 'text',
				'std'  => __( 'No results found for', 'beacon-for-helpscout' ),
			),
			array(
				'id'   => 'contact_label',
				'name' => __( 'Contact Label', 'beacon-for-helpscout' ),
				'desc' => __( 'Enter the text for the Contact label', 'beacon-for-helpscout' ),
				'type' => 'text',
				'std'  => __( 'Send a Message', 'beacon-for-helpscout' ),
			),
			array(
				'id'   => 'attach_file_label',
				'name' => __( 'Attach File Label', 'beacon-for-helpscout' ),
				'desc' => __( 'Enter the text for the Attach File label', 'beacon-for-helpscout' ),
				'type' => 'text',
				'std'  => __( 'Attach a file', 'beacon-for-helpscout' ),
			),
			array(
				'id'   => 'attach_file_error',
				'name' => __( 'Attach File Error', 'beacon-for-helpscout' ),
				'desc' => __( 'Enter the text for the Attach File error', 'beacon-for-helpscout' ),
				'type' => 'text',
				'std'  => __( 'The maximum file size is 10mb', 'beacon-for-helpscout' ),
			),
			array(
				'id'   => 'name_label',
				'name' => __( 'Name Label', 'beacon-for-helpscout' ),
				'desc' => __( 'Enter the text for the Name label', 'beacon-for-helpscout' ),
				'type' => 'text',
				'std'  => __( 'Your Name', 'beacon-for-helpscout' ),
			),
			array(
				'id'   => 'name_error',
				'name' => __( 'Name Error Label', 'beacon-for-helpscout' ),
				'desc' => __( 'Enter the text for the Name error label', 'beacon-for-helpscout' ),
				'type' => 'text',
				'std'  => __( 'Please enter your name', 'beacon-for-helpscout' ),
			),
			array(
				'id'   => 'email_label',
				'name' => __( 'Email Label', 'beacon-for-helpscout' ),
				'desc' => __( 'Enter the text for the Email label', 'beacon-for-helpscout' ),
				'type' => 'text',
				'std'  => __( 'Email address', 'beacon-for-helpscout' ),
			),
			array(
				'id'   => 'email_error',
				'name' => __( 'Email Error Label', 'beacon-for-helpscout' ),
				'desc' => __( 'Enter the text for the Email error label', 'beacon-for-helpscout' ),
				'type' => 'text',
				'std'  => __( 'Please enter a valid email address', 'beacon-for-helpscout' ),
			),
			array(
				'id'   => 'topic_label',
				'name' => __( 'Topic Label', 'beacon-for-helpscout' ),
				'desc' => __( 'Enter the text for the Topic label', 'beacon-for-helpscout' ),
				'type' => 'text',
				'std'  => __( 'Select a topic', 'beacon-for-helpscout' )
			),
			array(
				'id'   => 'topic_error',
				'name' => __( 'Topic Error', 'beacon-for-helpscout' ),
				'desc' => __( 'Enter the text for the Topic error label', 'beacon-for-helpscout' ),
				'type' => 'text',
				'std'  => __( 'Please select a topic from the list', 'beacon-for-helpscout' )
			),
			array(
				'id'   => 'subject_label',
				'name' => __( 'Subject Label', 'beacon-for-helpscout' ),
				'desc' => __( 'Enter the text for the Subject label', 'beacon-for-helpscout' ),
				'type' => 'text',
				'std'  => __( 'Subject', 'beacon-for-helpscout' ),
			),
			array(
				'id'   => 'subject_error',
				'name' => __( 'Subject Error Label', 'beacon-for-helpscout' ),
				'desc' => __( 'Enter the text for the Subject error label', 'beacon-for-helpscout' ),
				'type' => 'text',
				'std'  => __( 'Please enter a subject', 'beacon-for-helpscout' ),
			),
			array(
				'id'   => 'message_label',
				'name' => __( 'Message Label', 'beacon-for-helpscout' ),
				'desc' => __( 'Enter the text for the Message label', 'beacon-for-helpscout' ),
				'type' => 'text',
				'std'  => __( 'How can we help you?', 'beacon-for-helpscout' ),
			),
			array(
				'id'   => 'message_error',
				'name' => __( 'Message Error Label', 'beacon-for-helpscout' ),
				'desc' => __( 'Enter the text for the Message error label', 'beacon-for-helpscout' ),
				'type' => 'text',
				'std'  => __( 'Please enter a message', 'beacon-for-helpscout' ),
			),
			array(
				'id'   => 'send_label',
				'name' => __( 'Send Button Label', 'beacon-for-helpscout' ),
				'desc' => __( 'Enter the text for the Send button', 'beacon-for-helpscout' ),
				'type' => 'text',
				'std'  => __( 'Send', 'beacon-for-helpscout' )
			),
			array(
				'id'   => 'success_label',
				'name' => __( 'Contact Success Label', 'beacon-for-helpscout' ),
				'desc' => __( 'Enter the text for the Contact success label', 'beacon-for-helpscout' ),
				'type' => 'text',
				'std'  => __( 'Message sent!', 'beacon-for-helpscout' ),
			),
			array(
				'id'   => 'success_desc',
				'name' => __( 'Contact Success Description', 'beacon-for-helpscout' ),
				'desc' => __( 'Enter the text for the Contact success description', 'beacon-for-helpscout' ),
				'type' => 'text',
				'std'  => __( 'Thanks for reaching out! Someone from our team will get back to you soon.', 'beacon-for-helpscout' )
			)
		) )
	);

	return $beacon_settings;
}
add_filter( 'beacon_registered_settings', 'beacon_settings' );
