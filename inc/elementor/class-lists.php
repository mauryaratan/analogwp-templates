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
	 * Typography constructor.
	 */
	public function __construct() {
		add_action( 'elementor/element/kit/section_buttons/after_section_end', array( $this, 'register_lists' ), 40, 2 );
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
	 * @since 1.7
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
				'label'       => __( 'Space Between', 'ang' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 50,
					],
				],
				'selectors'   => array(
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
			[
				'label' => __( 'Alignment', 'ang' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'flex-start' => [
						'title' => __( 'Left', 'ang' ),
						'icon' => 'eicon-h-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'ang' ),
						'icon' => 'eicon-h-align-center',
					],
					'flex-end' => [
						'title' => __( 'Right', 'ang' ),
						'icon' => 'eicon-h-align-right',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-element .elementor-widget-container .elementor-icon-list-item' => 'justify-content: {{VALUE}};',
				],
			]
		);

		$element->add_control(
			'divider',
			[
				'label' => __( 'Divider', 'ang' ),
				'type' => Controls_Manager::SWITCHER,
				'label_off' => __( 'Off', 'ang' ),
				'label_on' => __( 'On', 'ang' ),
				'selectors' => [
					'{{WRAPPER}} .elementor-icon-list-item:not(:last-child):after' => 'content: ""',
				],
				'separator' => 'before',
			]
		);

		$element->add_control(
			'divider_style',
			[
				'label' => __( 'Style', 'ang' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'solid' => __( 'Solid', 'ang' ),
					'double' => __( 'Double', 'ang' ),
					'dotted' => __( 'Dotted', 'ang' ),
					'dashed' => __( 'Dashed', 'ang' ),
				],
				'default' => 'solid',
				'condition' => [
					'divider' => 'yes',
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-element .elementor-widget-container .elementor-icon-list-items:not(.elementor-inline-items) .elementor-icon-list-item:not(:last-child):after' => 'border-top-style: {{VALUE}}',
					'{{WRAPPER}} .elementor-element .elementor-widget-container .elementor-icon-list-items.elementor-inline-items .elementor-icon-list-item:not(:last-child):after' => 'border-left-style: {{VALUE}}',
				],
			]
		);

		$element->add_control(
			'divider_weight',
			[
				'label' => __( 'Weight', 'ang' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 1,
				],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 20,
					],
				],
				'condition' => [
					'divider' => 'yes',
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-element .elementor-widget-container .elementor-icon-list-items:not(.elementor-inline-items) .elementor-icon-list-item:not(:last-child):after' => 'border-top-width: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .elementor-element .elementor-widget-container .elementor-inline-items .elementor-icon-list-item:not(:last-child):after' => 'border-left-width: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$element->add_control(
			'divider_width',
			[
				'label' => __( 'Width', 'ang' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'unit' => '%',
				],
				'condition' => [
					'divider' => 'yes',
					'view!' => 'inline',
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-element .elementor-widget-container .elementor-icon-list-item:not(:last-child):after' => 'width: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$element->add_control(
			'divider_height',
			[
				'label' => __( 'Height', 'ang' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ '%', 'px' ],
				'default' => [
					'unit' => '%',
				],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 100,
					],
					'%' => [
						'min' => 1,
						'max' => 100,
					],
				],
				'condition' => [
					'divider' => 'yes',
					'view' => 'inline',
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-element .elementor-widget-container .elementor-icon-list-item:not(:last-child):after' => 'height: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$element->add_control(
			'divider_color',
			[
				'label' => __( 'Color', 'ang' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ddd',
				'global' => [
					'default' => Global_Colors::COLOR_TEXT,
				],
				'condition' => [
					'divider' => 'yes',
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-element .elementor-widget-container .elementor-icon-list-item:not(:last-child):after' => 'border-color: {{VALUE}}',
				],
			]
		);

		$element->add_control(
			'more_options',
			[
				'label' => __( 'Icon Options', 'ang' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$element->add_control(
			'icon_color',
			[
				'label' => __( 'Color', 'elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .elementor-element .elementor-widget-container .elementor-icon-list-icon i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .elementor-element .elementor-widget-container .elementor-icon-list-icon svg' => 'fill: {{VALUE}};',
				],
				'global' => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
			]
		);

		$element->add_control(
			'icon_color_hover',
			[
				'label' => __( 'Hover', 'elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .elementor-element .elementor-widget-container .elementor-icon-list-item:hover .elementor-icon-list-icon i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .elementor-element .elementor-widget-container .elementor-icon-list-item:hover .elementor-icon-list-icon svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$element->add_responsive_control(
			'icon_size',
			[
				'label' => __( 'Size', 'elementor' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 14,
				],
				'range' => [
					'px' => [
						'min' => 6,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-element .elementor-widget-container .elementor-icon-list-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .elementor-element .elementor-widget-container .elementor-icon-list-icon svg' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$element->add_responsive_control(
			'icon_self_align',
			[
				'label' => __( 'Alignment', 'elementor' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'elementor' ),
						'icon' => 'eicon-h-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'elementor' ),
						'icon' => 'eicon-h-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'elementor' ),
						'icon' => 'eicon-h-align-right',
					],
				],
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .elementor-element .elementor-widget-container .elementor-icon-list-icon' => 'text-align: {{VALUE}};',
				],
			]
		);

		$element->end_controls_tab();

		do_action( 'analog_list_control_tab_end', $element );

		$element->end_controls_tabs();

		$element->end_controls_section();
	}

}

new Lists();