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
 * Function to add the custom metabox with fields.
 *
 * @param object $post WP Post object.
 * @return void
 */
function cpt_quote_details( $post ) {
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
			<label for="quote">Quote:</label>
			<textarea
			id="quote"
			name="quote"
			> <?php echo esc_attr( get_post_meta( $post->ID, 'quote', true ) ); ?></textarea>
		</p>
		<p class="meta_field">
			<label for="citation">Citation:</label>
			<input
			type="text"
			id="citation"
			name="citation"
			value= <?php echo esc_attr( get_post_meta( $post->ID, 'citation', true ) ); ?>
			/>
		</p>
		<p class="meta_field">
			<label for="author">Author:</label>
			<input
			type="text"
			id="author"
			name="author"
			value= <?php echo esc_attr( get_post_meta( $post->ID, 'author', true ) ); ?>
		/>
		</p>
	</div>
	<?php
};
/**
 * Function to register the custom post type.
 *
 * @param integer $post_id The current post id.
 * @return void
 */
function cpt_quote_details_save( $post_id ) {
	$fields = array(
		'quote',
		'citation',
		'author',
	);
	foreach ( $fields as $field ) {
		if ( array_key_exists( $field, $_POST ) ) {
			update_post_meta( $post_id, $field, sanitize_text_field( wp_unslash( $_POST[ $field ] ) ) );
		}
	}
};

/**
 * Function to register the custom post type.
 *
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
			'register_meta_box_cb' => function () {
				add_meta_box(
					'cpt_quote_details',
					'Quote details',
					'cpt_quote_details',
					'quotes',
					'side',
					'default',
				);
			},
		)
	);
};

add_action( 'init', 'register_quotes_post_type' );
add_action( 'save_post', 'cpt_quote_details_save' );
