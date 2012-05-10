<?php

// 248,350,412,444,463,570,646,28,29,30,31,663,664,665,666,714,753,811,843,889,972,1255,1313,1314,1468,1903,2148,2455,2660

add_action( 'admin_menu', 'galleryGridOptions_Init' );

function galleryGridOptions_Init()
{
	register_setting(
		'gallerygridoptions-group',	// same as what you used in the settings_fields function call
		'plugin_options'			// name of the options
	);

	add_settings_section(
		'section_id',				// unique id
		'Setup',					// a title shown on page
		'galleryGridOptions_displaySectionContent',	// a callback to display content
		'gallerygridoptions-group'	// page name (must match do_settings_sections function call)
	);

	add_settings_field(
		'idColCount',				// unique id
		'Col Count',				// title of field
		'galleryGridOptions_displayColCount',			// callback to display the input box
		'gallerygridoptions-group',	// page name (same as the do_settings_sections function call)
		'section_id'				// id of the settings section, same as the first argument to add_settings_section
	);

	add_settings_field(
		'idShowId',								// unique id
		'Show ID',								// title of field
		'galleryGridOptions_displayShowId',		// callback to display the input box
		'gallerygridoptions-group',				// page name (same as the do_settings_sections function call)
		'section_id'							// id of the settings section, same as the first argument to add_settings_section
	);

	add_settings_field(
		'idIgnoreIds',							// unique id
		'Ignore Ids',							// title of field
		'galleryGridOptions_displayIgnoreIds',	// callback to display the input box
		'gallerygridoptions-group',				// page name (same as the do_settings_sections function call)
		'section_id'							// id of the settings section, same as the first argument to add_settings_section
	);

	////////////////////////////////////////////////
	// create a menu option in the settings menu
	////////////////////////////////////////////////
	$mypage = add_options_page(
		'galleryGrid',				// test to be displayed in the title tags of te page when the menu is selected
		'galleryGrid',				// text to be usded for the menu
		'manage_options',			// capability
		'gallerygrid',
		'galleryGridOptions_outputContent' );
}

function galleryGridOptions_outputContent()
{
	?>

	<div class="wrap">
	<h2>galleryGrid</h2>

	<form action="options.php" method="post">
	<?php settings_fields( 'gallerygridoptions-group' ); ?>
	<?php do_settings_sections( 'gallerygridoptions-group' ); ?>
	<?php submit_button(); ?>
	</form>
	</div>

	<?php
}

function galleryGridOptions_displaySectionContent()
{
}

function galleryGridOptions_displayColCount()
{
	$options = get_option('plugin_options');
	echo "<input id='idColCount' name='plugin_options[col_count]' size='10' type='text' value='{$options['col_count']}' />";
}

function galleryGridOptions_displayShowId()
{
	$options = get_option('plugin_options');

	echo "<input id='idShowId' name='plugin_options[show_id]' type='checkbox' value='1' ".checked( isset( $options['show_id'] ), true, false )."  />";
}

function galleryGridOptions_displayIgnoreIds()
{
	$options = get_option('plugin_options');

	echo "<input id='idIgnoreIds' name='plugin_options[ignore_ids]' size='160' type='text' value='{$options['ignore_ids']}' />";
	echo "<br/><i>comma seperated</i>";
}

?>