<?php 

if ( !defined( 'ABSPATH' ) ) exit;

return [
    [
        'id' => 'dpi_bulletin_id',
        'title' => 'Bulletin ID',
        'section' => 'dpi_bulletins_options',
        'inputType' => 'text'
    ],
    [
        'id' => 'dpi_bulletin_quantity',
        'title' => 'Bulletin Quantity',
        'section' => 'dpi_bulletins_options',
        'inputType' => 'number',
        'min' => 1,
        'max' => 12
    ],
	[
        'id' => 'dpi_bulletin_new_tab',
        'title' => 'Open Links in New Tab',
        'section' => 'dpi_bulletins_options',
        'inputType' => 'checkbox'
    ],
	[
        'id' => 'dpi_bulletin_show_signup',
        'title' => 'Show Signup Section',
        'section' => 'dpi_bulletins_options',
        'inputType' => 'checkbox'
    ],
];