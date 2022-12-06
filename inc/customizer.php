<?php
/**
 * Agora Folio Theme Customizer
 *
 * @package AgoraFolio
 */

namespace AgoraFolio\Customizer;

use AgoraFolio\Assets\AssetResolver;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;


/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial( 'blogname', array(
			'selector'        => '.site-title a',
			'render_callback' => 'AgoraFolio\Customizer\customize_partial_blogname',
		) );
		$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
			'selector'        => '.site-description',
			'render_callback' => 'AgoraFolio\Customizer\customize_partial_blogdescription',
		) );
	}

	$wp_customize->add_setting( 'header_image', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw'
    ));
 
    $wp_customize->add_control( new \WP_Customize_Image_Control( $wp_customize, 'header_image_control', array(
        'label' => __('Featured header image', 'agora-folio' ),
        'priority' => 20,
        'section' => 'title_tagline',
        'settings' => 'header_image',
    )));

}
add_action( 'customize_register', __NAMESPACE__ . '\\customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function customize_preview_js() {
	wp_enqueue_script( 'agora-folio-customizer', AssetResolver::resolve( 'js/customizer.js' ), [ 'customize-preview' ], NULL, true );
}
add_action( 'customize_preview_init', __NAMESPACE__ . '\\customize_preview_js' );

