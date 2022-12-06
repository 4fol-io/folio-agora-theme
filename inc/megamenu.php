<?php
/**
 * Agora Folio mega menu config
 *
 * @package AgoraFolio
 */

namespace AgoraFolio\Megamenu;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

function megamenu_add_custom_theme ($themes) {
    $themes["uoc_gef_agora"] = array(
        'title' => 'UOC GEF Agora',
        'container_background_from' => 'rgb(255, 255, 255)',
        'container_background_to' => 'rgb(255, 255, 255)',
        'arrow_up' => 'dash-f343',
        'arrow_down' => 'dash-f347',
        'arrow_left' => 'dash-f341',
        'arrow_right' => 'dash-f345',
        'menu_item_background_hover_from' => 'rgba(0, 0, 0, 0)',
        'menu_item_background_hover_to' => 'rgba(0, 0, 0, 0)',
        'menu_item_link_font_size' => '18px',
        'menu_item_link_height' => '68px',
        'menu_item_link_color' => 'rgb(0, 0, 120)',
        'menu_item_link_color_hover' => 'rgb(0, 0, 120)',
        'menu_item_link_padding_left' => '4px',
        'menu_item_link_padding_right' => '4px',
        'menu_item_link_padding_top' => '4px',
        'menu_item_link_padding_bottom' => '4px',
        'menu_item_border_color' => 'rgb(208, 208, 208)',
        'menu_item_border_top' => '4px',
        'menu_item_border_bottom' => '4px',
        'menu_item_border_color_hover' => 'rgb(0, 0, 120)',
        'menu_item_divider_color' => 'rgba(0, 0, 0, 0)',
        'menu_item_divider_glow_opacity' => '0',
        'panel_background_from' => 'rgb(240, 240, 240)',
        'panel_background_to' => 'rgb(240, 240, 240)',
        'panel_width' => '.header',
        'panel_border_color' => 'rgb(0, 0, 120)',
        'panel_border_top' => '4px',
        'panel_border_bottom' => '4px',
        'panel_header_color' => 'rgb(0, 0, 120)',
        'panel_header_font_size' => '18px',
        'panel_header_padding_right' => '4px',
        'panel_header_padding_bottom' => '12px',
        'panel_header_padding_left' => '4px',
        'panel_padding_left' => '4px',
        'panel_padding_right' => '4px',
        'panel_padding_top' => '16px',
        'panel_padding_bottom' => '12px',
        'panel_widget_padding_left' => '8px',
        'panel_widget_padding_right' => '8px',
        'panel_widget_padding_top' => '0px',
        'panel_widget_padding_bottom' => '0px',
        'panel_font_size' => '17px',
        'panel_font_color' => 'rgb(0, 0, 120)',
        'panel_font_family' => 'inherit',
        'panel_second_level_font_color' => 'rgb(0, 0, 120)',
        'panel_second_level_font_color_hover' => 'rgb(112, 111, 111)',
        'panel_second_level_text_transform' => 'none',
        'panel_second_level_font' => 'inherit',
        'panel_second_level_font_size' => '18px',
        'panel_second_level_font_weight' => 'normal',
        'panel_second_level_font_weight_hover' => 'normal',
        'panel_second_level_text_decoration' => 'none',
        'panel_second_level_text_decoration_hover' => 'none',
        'panel_second_level_padding_left' => '4px',
        'panel_second_level_padding_right' => '4px',
        'panel_second_level_padding_top' => '4px',
        'panel_second_level_padding_bottom' => '12px',
        'panel_second_level_border_color' => 'rgb(208, 208, 208)',
        'panel_second_level_border_color_hover' => 'rgb(208, 208, 208)',
        'panel_second_level_border_top' => '1px',
        'panel_third_level_font_color' => 'rgb(0, 0, 120)',
        'panel_third_level_font_color_hover' => 'rgb(112, 111, 111)',
        'panel_third_level_font' => 'inherit',
        'panel_third_level_font_size' => '18px',
        'panel_third_level_padding_left' => '4px',
        'panel_third_level_padding_right' => '4px',
        'panel_third_level_padding_top' => '4px',
        'panel_third_level_padding_bottom' => '12px',
        'panel_third_level_border_color' => 'rgb(208, 208, 208)',
        'panel_third_level_border_color_hover' => 'rgb(208, 208, 208)',
        'panel_third_level_border_top' => '1px',
        'flyout_width' => '100%',
        'flyout_menu_background_from' => 'rgb(240, 240, 240)',
        'flyout_menu_background_to' => 'rgb(240, 240, 240)',
        'flyout_border_color' => 'rgb(0, 0, 120)',
        'flyout_border_top' => '4px',
        'flyout_border_bottom' => '4px',
        'flyout_menu_item_divider_color' => 'rgba(255, 255, 255, 0)',
        'flyout_padding_top' => '16px',
        'flyout_padding_right' => '12px',
        'flyout_padding_bottom' => '12px',
        'flyout_padding_left' => '12px',
        'flyout_link_padding_left' => '4px',
        'flyout_link_padding_right' => '4px',
        'flyout_link_padding_top' => '4px',
        'flyout_link_padding_bottom' => '12px',
        'flyout_link_height' => 'inherit',
        'flyout_background_from' => 'rgba(255, 255, 255, 0)',
        'flyout_background_to' => 'rgba(255, 255, 255, 0)',
        'flyout_background_hover_from' => 'rgba(255, 255, 255, 0)',
        'flyout_background_hover_to' => 'rgba(251, 251, 251, 0)',
        'flyout_link_size' => '18px',
        'flyout_link_color' => 'rgb(0, 0, 120)',
        'flyout_link_color_hover' => 'rgb(112, 111, 111)',
        'flyout_link_family' => 'inherit',
        'line_height' => '1.25',
        'z_index' => '1000',
        'toggle_background_from' => 'rgb(208, 208, 208)',
        'toggle_background_to' => 'rgb(208, 208, 208)',
        'toggle_bar_height' => '54px',
        'toggle_bar_border_radius_top_left' => '0px',
        'toggle_bar_border_radius_top_right' => '0px',
        'toggle_bar_border_radius_bottom_left' => '0px',
        'toggle_bar_border_radius_bottom_right' => '0px',
        'mobile_menu_item_height' => 'auto',
        'mobile_menu_force_width_selector' => '.header',
        'mobile_background_from' => 'rgb(255, 255, 255)',
        'mobile_background_to' => 'rgb(255, 255, 255)',
        'mobile_menu_item_link_font_size' => '20px',
        'mobile_menu_item_link_color' => 'rgb(0, 0, 120)',
        'mobile_menu_item_link_text_align' => 'left',
        'mobile_menu_item_link_color_hover' => 'rgb(0, 0, 120)',
        'mobile_menu_item_background_hover_from' => 'rgb(255, 255, 255)',
        'mobile_menu_item_background_hover_to' => 'rgb(255, 255, 255)',
        'mobile_menu_off_canvas_width' => '340px',
        'custom_css' => '/** Push menu onto new line **/ 
#{$wrap} { 
    clear: both; 
}

#{$wrap}.mega-keyboard-navigation .mega-menu-toggle:focus, 
#{$wrap}.mega-keyboard-navigation .mega-toggle-block:focus, 
#{$wrap}.mega-keyboard-navigation .mega-toggle-block a:focus, 
#{$wrap}.mega-keyboard-navigation .mega-toggle-block .mega-search input[type=text]:focus, 
#{$wrap}.mega-keyboard-navigation .mega-toggle-block button.mega-toggle-animated:focus, 
#{$wrap}.mega-keyboard-navigation #{$menu} a:focus, 
#{$wrap}.mega-keyboard-navigation #{$menu} input:focus, 
#{$wrap}.mega-keyboard-navigation #{$menu} li.mega-menu-item a.mega-menu-link:focus {
  outline: 2px solid #000078;
  outline-offset: 0;
}

#{$wrap} #{$menu}, 
#{$wrap} #{$menu} ul.mega-sub-menu,
#{$wrap} #{$menu} li.mega-menu-item, 
#{$wrap} #{$menu} li.mega-menu-row, 
#{$wrap} #{$menu} li.mega-menu-column, 
#{$wrap} #{$menu} a.mega-menu-link{
	line-height: 1.125;
}

#{$wrap} #{$menu} > li.mega-menu-item {
	position: relative;
}

#{$wrap} #{$menu} > li.mega-menu-item > a.mega-menu-link {
	line-height: 1.2;
}

#{$wrap} #{$menu} > li.mega-menu-item > ul.mega-sub-menu {
	max-width: 100%;
    max-height: 50vh;
    overflow-y: auto;
    overflow-x: hidden;
}

#{$wrap} #{$menu} > li.mega-menu-item > ul.mega-sub-menu li.mega-menu-item-type-widget {
	margin-top: .25rem;
	margin-bottom: .75rem;
}

#{$wrap} #{$menu} > li.mega-menu-item > ul.mega-sub-menu li.widget_search{
	margin-bottom: 1.5rem;
}
#{$wrap} #{$menu} > li.mega-menu-item > ul.mega-sub-menu li.widget_search .form-group {
	margin-bottom: 0;
}

#{$wrap} #{$menu} > li.mega-menu-item-has-children > a.mega-menu-link{
	position: relative;
}

#{$wrap} #{$menu} > li.mega-menu-flyout ul.mega-sub-menu li.mega-menu-item a.mega-menu-link {
	border-top: 1px solid #d0d0d0;
}

#{$wrap} #{$menu} > li.mega-menu-flyout ul.mega-sub-menu li.mega-menu-item.mega-current-menu-item a.mega-menu-link{
	color: #706f6f;
}

#{$wrap} #{$menu} .mega-menu-link[target=_blank] {
	 position: relative;
     padding-right: 1.5rem !important;
}

#{$wrap} #{$menu} .mega-menu-link[target=_blank] .icon--external-link {
     position: absolute;
     top: .3rem;
     right: 0;
}

@include desktop {
	#{$wrap} #{$menu} {
		display: flex !important;
		flex-wrap: nowrap;
		-moz-justify-content: space-between;
		justify-content: space-between;
		margin-left: -0.25rem;
		margin-right: -0.25rem;
	}

	#{$wrap} #{$menu} > li.mega-menu-item {
		flex-basis: 0;
		flex-grow: 1;
		max-width: 100%;
		padding: 0;
		margin: 0 0.25rem;
	}
	
	#{$wrap} #{$menu} li.mega-menu-item > ul.mega-sub-menu {
		margin-top: -4px;
	}

	#{$wrap} #{$menu} > li.mega-menu-item-has-children > a.mega-menu-link > span.mega-indicator {
		display: none;
	}

	#{$wrap} #{$menu} > li.mega-menu-item-has-children.mega-toggle-on > a.mega-menu-link > span.mega-indicator {
		display: block;
		position: absolute;
		border: 16px solid transparent;
		border-bottom-color: #000078;
		height: 0;
		width: 1px;
		left: 50%;
		bottom: -4px;
		margin-left: -16px;
		margin-top: -32px;
		z-index: 1001;
	}

	#{$wrap} #{$menu} > li.mega-menu-item-has-children.mega-toggle-on > a.mega-menu-link > span.mega-indicator:after {
		content: \"\";
		display: block;
		position: absolute;
		border: 12px solid transparent;
		border-top: none;
		border-bottom-color: #f0f0f0;
		height: 0;
		width: 1px;
		left: 50%;
		bottom: -16px;
		margin-left: -12px;
		margin-top: -12px;
	}
	
	#{$wrap} #{$menu} .tag-cloud-link,
	#{$wrap} #{$menu} .form-item {
		background-color: #fff;
	}
}

@include mobile {

	#{$wrap} #{$menu} {
		//padding-bottom: 0.25rem !important;
		border-bottom: 3px solid #000078;
	}
	
	#{$wrap} .mega-menu-toggle .mega-toggle-block .mega-toggle-animated-inner, 
	#{$wrap} .mega-menu-toggle .mega-toggle-block .mega-toggle-animated-inner::before, 
	#{$wrap} .mega-menu-toggle .mega-toggle-block .mega-toggle-animated-inner::after{
		background: #000078;
		border-radius: 0;
	}
	
	#{$wrap} #{$menu} > li.mega-menu-flyout ul.mega-sub-menu,
	#{$wrap} #{$menu} > li.mega-menu-megamenu > ul.mega-sub-menu {
		background: #fff;
		padding: 0;
        padding-bottom: 1rem;
		position: static;
		float: none;
	}
	
	#{$wrap} #{$menu} > li.mega-menu-item > ul.mega-sub-menu  li.mega-menu-item-type-widget {
		margin-top: 0;
		margin-bottom: 1.5rem;
	}
	
	#{$wrap} #{$menu} > li.mega-menu-flyout ul.mega-sub-menu li.mega-menu-item,
	#{$wrap} #{$menu} > li.mega-menu-megamenu > ul.mega-sub-menu li.mega-menu-item{
		float: none;
	}
	
	
	#{$wrap} #{$menu} > li.mega-menu-megamenu > ul.mega-sub-menu  li.mega-menu-item {
		padding: 0 !important;
	}
	
	#{$wrap} #{$menu} > li.mega-menu-item > a.mega-menu-link  {
		border-top: 3px solid #D0D0D0;
		padding: .25rem .25rem 1rem .25rem;
		font-weight: 600 !important;
		font-size: 1.25rem;
	}
	
	#{$wrap} #{$menu} > li.mega-menu-item > a.mega-menu-link:hover,
	#{$wrap} #{$menu} > li.mega-menu-item > a.mega-menu-link:focus{
		border-color: #000078;
	}
	
	#{$wrap} #{$menu} > li.mega-menu-item-has-children > a.mega-menu-link {
		padding-right: 2rem;
		height: auto;
	}
	
	#{$wrap} #{$menu} > li.mega-menu-flyout ul.mega-sub-menu li.mega-menu-item > a.mega-menu-link,
	#{$wrap} #{$menu} > li.mega-menu-megamenu > ul.mega-sub-menu li.mega-menu-item > a.mega-menu-link {
		font-size: 1.25rem;
	}
	
	#{$wrap} #{$menu} > li.mega-menu-item-has-children > a.mega-menu-link > span.mega-indicator {
		position: absolute;
		right: 0;
		top: .25rem;
	    font-size: 26px;
		padding: 0;
		margin: 0;
		line-height: 1;
	}
	
	#{$wrap} #{$menu}[data-effect-mobile=\'slide_right\'],
	#{$wrap} #{$menu}[data-effect-mobile=\'slide_left\']{
		padding: 40px .5rem .5rem !important;
		border-bottom: 0;
	}
	
	#{$wrap} #{$menu}[data-effect-mobile=\'slide_right\'] > li.mega-menu-item > ul.mega-sub-menu,
	#{$wrap} #{$menu}[data-effect-mobile=\'slide_left\'] > li.mega-menu-item > ul.mega-sub-menu {
		max-height: initial;
		overflow-y: initial;
		overflow-x: initial;
	}

	#{$wrap} .mega-menu-toggle{
		position: absolute;
		top: -56px;
		right: 0;
	}
	
	#{$wrap} .mega-menu-toggle .mega-toggle-blocks-right .mega-toggle-block:only-child,
	#{$wrap} .mega-menu-toggle .mega-toggle-blocks-right .mega-toggle-block{
		margin-left: 7px;
		margin-right: 7px;
	}
	
	#{$wrap} .mega-menu-toggle .mega-toggle-block .mega-toggle-animated-box,
	#{$wrap} .mega-menu-toggle .mega-toggle-block .mega-toggle-animated-slider .mega-toggle-animated-inner,
	#{$wrap} .mega-menu-toggle .mega-toggle-block .mega-toggle-animated-slider .mega-toggle-animated-inner:before,
	#{$wrap} .mega-menu-toggle .mega-toggle-block .mega-toggle-animated-slider .mega-toggle-animated-inner:after{
		width: 32px;
	}
	
	#{$wrap} .btn-menu-close {
		width: 340px;
		max-width: 90%;
		transition: all .4s linear;
	}
	
	.site-menu { 
		display: block !important;
	}
		
	.site-menu ul.nav ul.dropdown-menu {
		position: static;
		float: none;
	}
	
	.site-header .btn-menu-toggle{
        display: none;
    }

}',
    );
    return $themes;
}

add_filter('megamenu_themes', __NAMESPACE__ . '\\megamenu_add_custom_theme');



function megamenu_override_default_theme($value) {
  if ( !isset($value['primary-menu']['theme']) ) {
    $value['primary-menu']['theme'] = 'uoc_gef_agora';
  }
  return $value;
}

add_filter('default_option_megamenu_settings', __NAMESPACE__ . '\\megamenu_override_default_theme');


/*
//Pruebas para obtener la configuración de megamenu

$options = get_option('megamenu_settings');
$blocks = get_option('megamenu_toggle_blocks');
$mega = get_option('megamenu_themes');

$file = get_template_directory() . '/megamenu/config.json';
$json = json_decode(file_get_contents($file), true);

print_r($options);
print_r($blocks);

print_r($mega);
print_r($json);
*/
