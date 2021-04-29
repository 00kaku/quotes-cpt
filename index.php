<?php
/**
 * Plugin Name:       Quotes CPT plugin.
 * Plugin URI:        https://github.com/00kaku
 * Description:       A custom post type plugin that lets user enter quote, its author, citation and author image.
 * Version:           1.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Akash Sharma
 * Author URI:        https://github.com/00kaku
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html

 * @package           QuotesCpt
 * @author            Akash Sharma
 * @copyright         2019 Akash Sharma
 * @license           GPL-2.0-or-later
 */

/**
 * Function to register the custom post type.

 * @return void
 */
function register_quotes_post_type() {
	register_post_type(
		'quotes',
		array(
			'labels'        => array(
				'name'          => __( 'quotes' ),
				'singular_name' => __( 'quote' ),
			),
			'description'   => 'A custom quotes post type to add quote and its author with other details.',
			'public'        => true,
			'show_in_rest'  => true,
			'menu_icon'     => 'dashicons-format-quote',
			'menu_position' => 6,
			'has_archive'   => true,
		)
	);
};

add_action( 'init', 'register_quotes_post_type' );
