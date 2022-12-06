<?php
/**
 * Agora Folio custom tree comment walker
 *
 * @package AgoraFolio
 */

namespace AgoraFolio\Walker;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

class Tree_Walker_Comment extends \Walker_Comment {

/**
     * Traverse elements to create list from elements.
     *
     * Display one element if the element doesn't have any children otherwise,
     * display the element and its children. Will only traverse up to the max
     * depth and no ignore elements under that depth. It is possible to set the
     * max depth to include all depths, see walk() method.
     *
     * This method should not be called directly, use the walk() method instead.
     *
     * @since 2.5.0
     *
     * @param object $element           Data object.
     * @param array  $children_elements List of elements to continue traversing (passed by reference).
     * @param int    $max_depth         Max depth to traverse.
     * @param int    $depth             Depth of current element.
     * @param array  $args              An array of arguments.
     * @param string $output            Used to append additional content (passed by reference).
     */
    public function display_element( $element, &$children_elements, $max_depth, $depth, $args, &$output ) {
        if ( ! $element ) {
            return;
        }
 
        $id_field = $this->db_fields['id'];
        $id       = $element->$id_field;

        $args[0]['subtree_id'] = $id;
 
        // Display this element.
        $this->has_children = ! empty( $children_elements[ $id ] );
        if ( isset( $args[0] ) && is_array( $args[0] ) ) {
            $args[0]['has_children'] = $this->has_children; // Back-compat.
        }
 
        $this->start_el( $output, $element, $depth, ...array_values( $args ) );
 
        // Descend only when the depth is right and there are children for this element.
        if ( ( 0 == $max_depth || $max_depth > $depth + 1 ) && isset( $children_elements[ $id ] ) ) {
 
            foreach ( $children_elements[ $id ] as $child ) {
 
                if ( ! isset( $newlevel ) ) {
                    $newlevel = true;
                    // Start the child delimiter.
                    $this->start_lvl( $output, $depth, ...array_values( $args ) );
                }
                $this->display_element( $child, $children_elements, $max_depth, $depth + 1, $args, $output );
            }
            unset( $children_elements[ $id ] );
        }
 
        if ( isset( $newlevel ) && $newlevel ) {
            // End the child delimiter.
            $this->end_lvl( $output, $depth, ...array_values( $args ) );
        }
 
        // End this element.
        $this->end_el( $output, $element, $depth, ...array_values( $args ) );
    }

     /**
     * Starts the list before the elements are added.
     *
     * @since 2.7.0
     *
     * @see Walker::start_lvl()
     * @global int $comment_depth
     *
     * @param string $output Used to append additional content (passed by reference).
     * @param int    $depth  Optional. Depth of the current comment. Default 0.
     * @param array  $args   Optional. Uses 'style' argument for type of HTML list. Default empty array.
     */
    public function start_lvl( &$output, $depth = 0, $args = array() ) {
        $GLOBALS['comment_depth'] = $depth + 1;
        switch ( $args['style'] ) {
            case 'div':
                break;
            case 'ol':
                $output .= '<ol class="tree-list list--unstyled collapse show" role="region" id="node_list_' . get_the_ID() . '_' . $args['subtree_id'] . '">' . "\n";
                break;
            case 'ul':
            default:
                $output .= '<ul class="tree-list list--unstyled collapse show" role="region" id="node_list_' . get_the_ID() . '_' . $args['subtree_id'] . '">' . "\n";
                break;
        }
    }

}