<?php

/*
Plugin Name: galleryGrid
Plugin URI:
Description: Shows a simple gallery grid from your media, use the shortcode [gallerygrid] in your post or pages to see a grid view of your media images
Version: 1.0
Author: Peter Wraae Marino
Author URI: http://marino.dk
License: GPL2
*/

require_once 'galleryGridOptions.php';

add_shortcode( 'gallerygrid', 'shortcodeGalleryGrid' );

function shortcodeGalleryGrid( $atts )
{
	global $wpdb;

	$options = get_option('plugin_options');

	$ignore_ids = $options["ignore_ids"];

	$post_ids = $wpdb->get_col( "SELECT ID FROM $wpdb->posts WHERE post_type='attachment' AND post_status != 'trash' AND ID not in (".$ignore_ids.")" );

	$s = "<table style='width:100%;table-layout:fixed;'>";
	
	$col = $options["col_count"];
	$c = 0;

	/*
	$image_attributes = wp_get_attachment_image_src( 80, 250  ); // returns an array
	var_dump( $image_attributes );
	*/

	$width_percent = 100/$col;

	foreach ( $post_ids as $id )
	{
		$image_attributes = wp_get_attachment_image_src( $id, "full" ); // returns an array
		
		if ( $c==0 ) $s.= "<tr>";

		$s.= "<td style='border: solid black 1px;vertical-align:bottom;text-align:center; width:".$width_percent."%;'>";
		//$s.= "<img src=".$image_attributes[0]." width=".$image_attributes[1]." height=".$image_attributes[2]." alt='' />";
		$s.= "<img src='".$image_attributes[0]."' alt='' />";

		if ( isset( $options['show_id'] ) )
			$s.= "<br/>ID: ".$id;

		$s.= "</td>";

		if ( $c==$col-1 ) $s.= "</tr>";

		$c++;
		if ( $c==$col )
			$c = 0;
	}

	$s.= "</table>";

	return $s;
}

?>
