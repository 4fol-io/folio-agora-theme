<?php
/**
 * Agora Folio gutenberg blocks utilities
 *
 * @package AgoraFolio
 */

namespace AgoraFolio\Blocks;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;


/**
 * Applies wrapper div around aligned blocks.
 *
 *
 * @see   https://developer.wordpress.org/reference/hooks/render_block/
 * @link  https://codepen.io/webmandesign/post/gutenberg-full-width-alignment-in-wordpress-themes
 *
 * @param  string $block_content  The block content about to be appended.
 * @param  array  $block          The full block, including name and attributes.
 */
function wrap_alignment( $block_content, $block ) {
	if ( isset( $block['attrs']['align'] ) && in_array( $block['attrs']['align'], array( 'wide', 'full' ) ) ) {
		$block_content = sprintf(
			'<div class="%1$s">%2$s</div>',
			'align-wrap align-wrap-' . esc_attr( $block['attrs']['align'] ),
			$block_content
		);
	}
	return $block_content;
}

add_filter( 'render_block',  __NAMESPACE__ . '\\wrap_alignment', 10, 2 );