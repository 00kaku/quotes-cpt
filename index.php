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
				grid-template-columns:1fr;
				grid-row-gap: 10px;
			}
			.meta_field{
				display: contents;
			}
		</style>
			<label for="quote"><?php esc_html_e( 'Quote:', 'quotes-cpt-plugin' ); ?></label>
			<textarea
			id="quote"
			name="quote"
			> <?php echo esc_attr( get_post_meta( $post->ID, 'quote', true ) ); ?></textarea>

			<label for="citation"><?php esc_html_e( 'Citation:', 'quotes-cpt-plugin' ); ?></label>
			<input
			type="text"
			id="citation"
			name="citation"
			value= "<?php echo esc_attr( get_post_meta( $post->ID, 'citation', true ), ); ?>"
			/>
			<label for="author"><?php esc_html_e( 'Author:', 'quotes-cpt-plugin' ); ?></label>
			<input
			type="text"
			id="author"
			name="author"
			value= "<?php echo esc_attr( get_post_meta( $post->ID, 'author', true ) ); ?>"
		/>
	</div>
	<?php
	wp_nonce_field( 'Quotes_nonce_action', 'Quotes_nonce' );
};
/**
 * Function to register the custom post type.
 *
 * @param integer $post_id The current post id.
 * @return void
 */
function cpt_quote_details_save( $post_id ) {
	$fields      = array(
		'quote',
		'citation',
		'author',
	);
	$quote_nonce = filter_input( INPUT_POST, 'Quotes_nonce', FILTER_SANITIZE_STRING );
	if ( ! isset( $quote_nonce ) ||
	! wp_verify_nonce( sanitize_text_field( wp_unslash( $quote_nonce ) ), 'Quotes_nonce_action' ) ) {
		return;
	}
	foreach ( $fields as $field ) {
		if ( array_key_exists( $field, $_POST ) ) {
			update_post_meta( $post_id, $field, sanitize_text_field( wp_unslash( $_POST[ $field ] ) ) );
		}
	}
};
/**
 * Function to register the custom meta fields to show in rest api.
 *
 * @return void
 */
function register_quotes_meta_fields() {
	register_meta(
		'post',
		'quote',
		array(
			'type'         => 'string',
			'description'  => 'Quote to be displayed',
			'single'       => true,
			'show_in_rest' => true,
		)
	);
	register_meta(
		'post',
		'author',
		array(
			'type'         => 'string',
			'description'  => 'Author of the quote',
			'single'       => true,
			'show_in_rest' => true,
		)
	);
	register_meta(
		'post',
		'citation',
		array(
			'type'         => 'string',
			'description'  => 'Citation of the quote',
			'single'       => true,
			'show_in_rest' => true,
		)
	);
}
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
				'name'          => __( 'Quotes', 'quotes-cpt-plugin' ),
				'singular_name' => __( 'Quote', 'quotes-cpt-plugin' ),
			),
			'description'          => __( 'A custom quotes post type to add quote and its author with other details.', 'quotes-cpt-plugin' ),
			'public'               => true,
			'show_in_rest'         => true,
			'menu_icon'            => 'dashicons-format-quote',
			'menu_position'        => 6,
			'has_archive'          => true,
			'supports'             => array(
				'editor',
				'title',
				'thumbnail',
				'custom-fields',
			),
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
add_action( 'rest_api_init', 'register_quotes_meta_fields' );
