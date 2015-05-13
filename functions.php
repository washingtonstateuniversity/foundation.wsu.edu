<?php

add_filter( 'wsu_color_palette_values', 'wsu_foundation_color_palette' );
function wsu_foundation_color_palette( $palletes ) {
	$new_palettes = array(
		'gray2' => array( 'name' => 'Gray (two)',   'hex' => '#8d959a' ),
		'gray3' => array( 'name' => 'Gray (three)', 'hex' => '#464e54' ),
		'gray4' => array( 'name' => 'Gray (four)',  'hex' => '#2a3033' ),
	);
	$palletes = array_merge( $palletes, $new_palettes );

	return $palletes;
}