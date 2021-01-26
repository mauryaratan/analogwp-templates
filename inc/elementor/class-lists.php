<?php
/**
 * Class Analog\Elementor\Lists.
 *
 * @package AnalogWP
 */

namespace Analog\Elementor;

use Elementor\Core\Base\Module;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Controls_Manager;
use Elementor\Controls_Stack;
use Analog\Utils;

defined( 'ABSPATH' ) || exit;

/**
 * Class Lists.
 *
 * @package Analog\Elementor
 */
class Lists extends Module {

	/**
	 * List constructor.
	 */
	public function __construct() {
		add_action( 'elementor/element/kit/section_buttons/after_section_end', array( $this, 'register_lists' ), 40, 2 );
		add_action( 'elementor/element/icon-list/section_icon_list/after_section_end', array( $this, 'override_icon_list' ), 10, 2 );
		add_action( 'elementor/widget/before_render_content', array( $this, 'list_render' ), 10, 1 );
		add_action( 'elementor/editor/after_enqueue_scripts', array( $this, 'editor_enqueue_scripts' ), 999 );
	}

	/**
	 * Get module name.
	 *
	 * @return string
	 */
	public function get_name() {
		return 'ang-lists';
	}

	/**
	 * Register List controls.
	 *
	 * @param Controls_Stack $element Controls object.
	 * @param string         $section_id Section ID.
	 * @since 1.7.7
	 */
	public function register_lists( Controls_Stack $element, $section_id ) {
		$element->start_controls_section(
			'ang_list',
			array(
				'label' => _x( 'Lists', 'Section Title', 'ang' ),
				'tab'   => Utils::get_kit_settings_tab(),
			)
		);

		$element->start_controls_tabs( 'ang_tabs_list_controls' );

		$element->start_controls_tab(
			'ang_tab_list',
			array( 'label' => __( 'List', 'ang' ) )
		);

		$element->add_control(
			'ang_list_description',
			array(
				'raw'             => __( 'Lists control for your layout.', 'ang' ),
				'type'            => Controls_Manager::RAW_HTML,
				'content_classes' => 'elementor-descriptor',
			)
		);

		$selectors_string = '{{WRAPPER}} .elementor-element  ul.elementor-icon-list-items';

		$element->add_responsive_control(
			'ang_list_margin',
			array(
				'label'      => 'List Margin',
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					$selectors_string
					=> 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$element->add_responsive_control(
			'ang_list_padding',
			array(
				'label'      => 'List Padding',
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					$selectors_string
					=> 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$element->end_controls_tab();

		$element->start_controls_tab(
			'ang_tab_list_item',
			array( 'label' => __( 'List Item', 'ang' ) )
		);

		$element->add_control(
			'ang_list_item_description',
			array(
				'raw'             => __( 'List items control for your layout.', 'ang' ),
				'type'            => Controls_Manager::RAW_HTML,
				'content_classes' => 'elementor-descriptor',
			)
		);

		$element->add_responsive_control(
			'ang_list_item_spacing',
			array(
				'label'     => __( 'Space Between', 'ang' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'max' => 50,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .elementor-element .elementor-widget-container .elementor-icon-list-items:not(.elementor-inline-items) .elementor-icon-list-item:not(:last-child)' => 'padding-bottom: calc({{SIZE}}{{UNIT}}/2)',
					'{{WRAPPER}} .elementor-element .elementor-widget-container .elementor-icon-list-items:not(.elementor-inline-items) .elementor-icon-list-item:not(:first-child)' => 'margin-top: calc({{SIZE}}{{UNIT}}/2)',
					'{{WRAPPER}} .elementor-element .elementor-widget-container .elementor-icon-list-items.elementor-inline-items .elementor-icon-list-item' => 'margin-right: calc({{SIZE}}{{UNIT}}/2); margin-left: calc({{SIZE}}{{UNIT}}/2)',
					'{{WRAPPER}} .elementor-element .elementor-widget-container .elementor-icon-list-items.elementor-inline-items' => 'margin-right: calc(-{{SIZE}}{{UNIT}}/2); margin-left: calc(-{{SIZE}}{{UNIT}}/2)',
					'body.rtl {{WRAPPER}} .elementor-element .elementor-widget-container .elementor-icon-list-items.elementor-inline-items .elementor-icon-list-item:after' => 'left: calc(-{{SIZE}}{{UNIT}}/2)',
					'body:not(.rtl) {{WRAPPER}} .elementor-element .elementor-widget-container .elementor-icon-list-items.elementor-inline-items .elementor-icon-list-item:after' => 'right: calc(-{{SIZE}}{{UNIT}}/2)',
				),
			)
		);

		$element->add_responsive_control(
			'ang_list_item_align',
			array(
				'label'     => __( 'Alignment', 'ang' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
					'flex-start' => array(
						'title' => __( 'Left', 'ang' ),
						'icon'  => 'eicon-h-align-left',
					),
					'center'     => array(
						'title' => __( 'Center', 'ang' ),
						'icon'  => 'eicon-h-align-center',
					),
					'flex-end'   => array(
						'title' => __( 'Right', 'ang' ),
						'icon'  => 'eicon-h-align-right',
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .elementor-element .elementor-widget-container .elementor-icon-list-item' => 'justify-content: {{VALUE}};',
				),
			)
		);

		$element->add_control(
			'ang_list_divider',
			array(
				'label'     => __( 'Divider', 'ang' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_off' => __( 'Off', 'ang' ),
				'label_on'  => __( 'On', 'ang' ),
				'selectors' => array(
					'{{WRAPPER}} .sk-override .elementor-icon-list-item:not(:last-child):after' => 'content: ""',
				),
				'separator' => 'before',
			)
		);

		$element->add_control(
			'ang_list_divider_style',
			array(
				'label'     => __( 'Style', 'ang' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => array(
					'solid'  => __( 'Solid', 'ang' ),
					'double' => __( 'Double', 'ang' ),
					'dotted' => __( 'Dotted', 'ang' ),
					'dashed' => __( 'Dashed', 'ang' ),
				),
				'default'   => 'solid',
				'condition' => array(
					'ang_list_divider' => 'yes',
				),
				'selectors' => array(
					'{{WRAPPER}} .elementor-element .elementor-widget-container .sk-override.elementor-icon-list-items:not(.elementor-inline-items) .elementor-icon-list-item:not(:last-child):after' => 'border-top-style: {{VALUE}}',
					'{{WRAPPER}} .elementor-element .elementor-widget-container .sk-override.elementor-icon-list-items.elementor-inline-items .elementor-icon-list-item:not(:last-child):after' => 'border-left-style: {{VALUE}}',
				),
			)
		);

		$element->add_control(
			'ang_list_divider_weight',
			array(
				'label'     => __( 'Weight', 'ang' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => array(
					'size' => 1,
				),
				'range'     => array(
					'px' => array(
						'min' => 1,
						'max' => 20,
					),
				),
				'condition' => array(
					'ang_list_divider' => 'yes',
				),
				'selectors' => array(
					'{{WRAPPER}} .elementor-element .elementor-widget-container .sk-override.elementor-icon-list-items:not(.elementor-inline-items) .elementor-icon-list-item:not(:last-child):after' => 'border-top-width: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .elementor-element .elementor-widget-container .sk-override.elementor-inline-items .elementor-icon-list-item:not(:last-child):after' => 'border-left-width: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$element->add_control(
			'ang_list_divider_width',
			array(
				'label'     => __( 'Width', 'ang' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => array(
					'unit' => '%',
				),
				'condition' => array(
					'ang_list_divider' => 'yes',
					'view!'            => 'inline',
				),
				'selectors' => array(
					'{{WRAPPER}} .elementor-element .elementor-widget-container .sk-override .elementor-icon-list-item:not(:last-child):after' => 'width: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$element->add_control(
			'ang_list_divider_height',
			array(
				'label'      => __( 'Height', 'ang' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( '%', 'px' ),
				'default'    => array(
					'unit' => '%',
				),
				'range'      => array(
					'px' => array(
						'min' => 1,
						'max' => 100,
					),
					'%'  => array(
						'min' => 1,
						'max' => 100,
					),
				),
				'condition'  => array(
					'ang_list_divider' => 'yes',
					'view'             => 'inline',
				),
				'selectors'  => array(
					'{{WRAPPER}} .elementor-element .elementor-widget-container .sk-override .elementor-icon-list-item:not(:last-child):after' => 'height: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$element->add_control(
			'ang_list_divider_color',
			array(
				'label'     => __( 'Color', 'ang' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ddd',
				'global'    => array(
					'default' => Global_Colors::COLOR_TEXT,
				),
				'condition' => array(
					'ang_list_divider' => 'yes',
				),
				'selectors' => array(
					'{{WRAPPER}} .elementor-element .elementor-widget-container .sk-override .elementor-icon-list-item:not(:last-child):after' => 'border-color: {{VALUE}}',
				),
			)
		);

		$element->add_control(
			'ang_list_icon_options',
			array(
				'label'     => __( 'Icon Options', 'ang' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$element->add_control(
			'ang_list_icon_color',
			array(
				'label'     => __( 'Color', 'ang' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .elementor-element .elementor-widget-container .elementor-icon-list-icon i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .elementor-element .elementor-widget-container .elementor-icon-list-icon svg' => 'fill: {{VALUE}};',
				),
				'global'    => array(
					'default' => Global_Colors::COLOR_PRIMARY,
				),
			)
		);

		$element->add_control(
			'ang_list_icon_color_hover',
			array(
				'label'     => __( 'Hover', 'ang' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .elementor-element .elementor-widget-container .elementor-icon-list-item:hover .elementor-icon-list-icon i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .elementor-element .elementor-widget-container .elementor-icon-list-item:hover .elementor-icon-list-icon svg' => 'fill: {{VALUE}};',
				),
			)
		);

		$element->add_responsive_control(
			'ang_list_icon_size',
			array(
				'label'     => __( 'Size', 'ang' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => array(
					'size' => 14,
				),
				'range'     => array(
					'px' => array(
						'min' => 6,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .elementor-element .elementor-widget-container .elementor-icon-list-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .elementor-element .elementor-widget-container .elementor-icon-list-icon svg' => 'width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$element->add_responsive_control(
			'ang_list_icon_self_align',
			array(
				'label'     => __( 'Alignment', 'ang' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
					'left'   => array(
						'title' => __( 'Left', 'ang' ),
						'icon'  => 'eicon-h-align-left',
					),
					'center' => array(
						'title' => __( 'Center', 'ang' ),
						'icon'  => 'eicon-h-align-center',
					),
					'right'  => array(
						'title' => __( 'Right', 'ang' ),
						'icon'  => 'eicon-h-align-right',
					),
				),
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .elementor-element .elementor-widget-container .elementor-icon-list-icon' => 'text-align: {{VALUE}};',
				),
			)
		);

		$element->end_controls_tab();

		do_action( 'analog_list_control_tab_end', $element );

		$element->end_controls_tabs();

		$element->end_controls_section();
	}

	/**
	 * Override List controls.
	 *
	 * Override the Icon List widget controls.
	 *
	 * @param Controls_Stack $element Controls object.
	 * @param string         $section_id Section ID.
	 * @since 1.7.7
	 */
	public function override_icon_list( Controls_Stack $element, $section_id ) {
		/*
		 * @todo If we call get_controls_settings inside this method error thrown, need to check alternative to get settings value.
		 * https://github.com/elementor/elementor/issues/10686#issuecomment-755174109
		 */
		// $element->get_controls_settings();

		$divider_style_control = $element->get_controls( 'divider_style' );

		$divider_style_options = array_merge(
			array(
				'sk_override' => 'SK Override',
			),
			$divider_style_control['options'],
		);

		$element->update_control(
			'divider_style',
			array(
				'default' => 'sk_override',
				'options' => $divider_style_options,
			)
		);

	}

	/**
	 * Update list rendering.
	 *
	 * Add custom css class to the list when Style Kit override option set
	 *
	 * @param Elementor\Widget_Base $widget Widget object.
	 * @since 1.7.7
	 */
	public function list_render( $widget ) {
		if ( 'icon-list' === $widget->get_name() ) {

			if ( 'sk_override' === $widget->get_settings( 'divider_style' ) &&
				method_exists( $widget, 'add_render_attribute' )
			) {
				$widget->add_render_attribute( 'icon_list', 'class', 'sk-override' );
			}/* @todo: Incase class removal failed we will uncomment this code
			 elseif ( 'sk_override' !== $widget->get_settings( 'divider_style' ) &&
				method_exists( $widget, 'remove_render_attribute' ) ) {
				$widget->remove_render_attribute( 'icon_list', 'class', 'sk-override' );
			} */
		}
	}

	/**
	 * Enqueue editor script.
	 *
	 * @return void
	 */
	public function editor_enqueue_scripts() {
		$script_suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

		wp_enqueue_script(
			'ang_icon_list_editor_script',
			ANG_PLUGIN_URL . "inc/elementor/js/ang-lists-widget-editor{$script_suffix}.js",
			array(
				'jquery',
				'elementor-editor',
			),
			ANG_VERSION,
			true
		);
	}

}

new Lists();
