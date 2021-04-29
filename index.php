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
 * Function to add the custom metabox.

 * @param array $args The argument array containing $post of the metabox.
 * @return void
 */
function wpt_quote_details( $args ) {
	?>
	<div class="meta_box">
		<style scoped>
			.meta_box{
				display: grid;
				grid-template-columns: max-content 1fr;
				grid-row-gap: 10px;
				grid-column-gap: 10px;
			}
			.meta_field{
				display: contents;
			}
		</style>
			<p class="meta_field">
			<label for="citation">Quote:</label>
			<textarea id="citation" name="citation"></textarea>
		</p>
		<p class="meta_field">
			<label for="citation">Citation:</label>
			<input type="text" id="citation" name="citation" />
		</p>
		<p class="meta_field">
			<label for="author">Author:</label>
			<input type="text" id="author" name="author" />
		</p>
	</div>
	<?php
}

/**
 * Function to register the custom post type.

 * @return void
 */
function register_quotes_post_type() {
	register_post_type(
		'quotes',
		array(
			'labels'               => array(
				'name'          => __( 'Quotes' ),
				'singular_name' => __( 'Quote' ),
			),
			'description'          => __( 'A custom quotes post type to add quote and its author with other details.' ),
			'public'               => true,
			'show_in_rest'         => true,
			'menu_icon'            => 'dashicons-format-quote',
			'menu_position'        => 6,
			'has_archive'          => true,
			'register_meta_box_cb' => function ( $post ) {
					$args = array(
						'post' => $post,
					);
				add_meta_box(
					'wpt_quote_details',
					'Quote details',
					'wpt_quote_details',
					'quotes',
					'side',
					'default',
					$args,
				);
			},
		)
	);
};

add_action( 'init', 'register_quotes_post_type' );
