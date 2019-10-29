<?php

namespace Analog\Elementor;

defined( 'ABSPATH' ) || exit;

use Elementor\Controls_Manager;
use Elementor\Controls_Stack;
use Elementor\Core\Settings\Manager;
use Elementor\Core\Base\Module;
use Elementor\Element_Base;

/**
 * Class Colors.
 *
 * @package Analog\Elementor
 */
class Colors extends Module {
	use Document;

	/**
	 * Colors constructor.
	 */
	public function __construct() {
		add_action( 'elementor/element/after_section_end', [ $this, 'register_color_settings' ], 170, 2 );
		add_action( 'elementor/element/divider/section_divider_style/before_section_end', [ $this, 'tweak_divider_style' ] );
		add_action( 'elementor/element/icon-box/section_style_content/before_section_end', [ $this, 'tweak_icon_box' ] );
		add_action( 'elementor/element/image-box/section_style_content/before_section_end', [ $this, 'tweak_image_box' ] );
		add_action( 'elementor/element/heading/section_title_style/before_section_end', [ $this, 'tweak_heading' ] );
		add_action( 'elementor/element/nav-menu/section_style_main-menu/before_section_end', [ $this, 'tweak_nav_menu' ] );
	}

	/**
	 * Get module name.
	 *
	 * @return string
	 */
	public function get_name() {
		return 'ang-colors';
	}

	/**
	 * Tweak default Divider color to be SKs Primary accent color.
	 *
	 * @since 1.3.9
	 * @param Element_Base $element Element base.
	 */
	public function tweak_divider_style( Element_Base $element ) {
		if ( 'popup' === $this->get_document_type() ) {
			return;
		}

		$page_settings_manager = Manager::get_settings_managers( 'page' );
		$page_settings_model   = $page_settings_manager->get_model( get_the_ID() );
		$default_color         = $page_settings_model->get_settings( 'ang_color_accent_primary' );

		if ( $default_color ) {
			$element->update_control(
				'color',
				[
					'default' => $default_color,
				]
			);
		}
	}

	/**
	 * Tweak Elementor Icon Box widget.
	 *
	 * @since 1.3.10
	 * @param Element_Base $element Element base.
	 */
	public function tweak_icon_Box( Element_Base $element ) {
		$page_settings_manager = Manager::get_settings_managers( 'page' );
		$page_settings_model   = $page_settings_manager->get_model( get_the_ID() );
		$remove_link           = $page_settings_model->get_settings( 'ang_remove_title_link_color' );

		if ( ! $remove_link ) {
			$element->update_control(
				'title_color',
				[
					'selectors' => [
						'{{WRAPPER}} .elementor-icon-box-content .elementor-icon-box-title, {{WRAPPER}} .elementor-icon-box-content .elementor-icon-box-title a' => 'color: {{VALUE}};',
					],
				]
			);
		}
	}

	/**
	 * Tweak Elementor Image Box widget.
	 *
	 * @since 1.3.10
	 * @param Element_Base $element Element base.
	 */
	public function tweak_image_Box( Element_Base $element ) {
		$page_settings_manager = Manager::get_settings_managers( 'page' );
		$page_settings_model   = $page_settings_manager->get_model( get_the_ID() );
		$remove_link           = $page_settings_model->get_settings( 'ang_remove_title_link_color' );

		if ( ! $remove_link ) {
			$element->update_control(
				'title_color',
				[
					'selectors' => [
						'{{WRAPPER}} .elementor-image-box-content .elementor-image-box-title, {{WRAPPER}} .elementor-image-box-content .elementor-image-box-title a' => 'color: {{VALUE}};',
					],
				]
			);
		}
	}

	/**
	 * Tweak Elementor Heading widget.
	 *
	 * @since 1.3.10
	 * @param Element_Base $element Element base.
	 */
	public function tweak_heading( Element_Base $element ) {
		$page_settings_manager = Manager::get_settings_managers( 'page' );
		$page_settings_model   = $page_settings_manager->get_model( get_the_ID() );
		$remove_link           = $page_settings_model->get_settings( 'ang_remove_title_link_color' );

		if ( ! $remove_link ) {
			$element->update_control(
				'title_color',
				[
					'selectors' => [
						'{{WRAPPER}}.elementor-widget-heading .elementor-heading-title, {{WRAPPER}}.elementor-widget-heading .elementor-heading-title.elementor-heading-title a' => 'color: {{VALUE}};',
					],
				]
			);
		}
	}

	/**
	 * Tweak Elementor Nav Menu widget.
	 *
	 * @since 1.3.10
	 * @param Element_Base $element Element base.
	 */
	public function tweak_nav_menu( Element_Base $element ) {
		$element->update_control(
			'color_menu_item',
			[
				'selectors' => [
					'{{WRAPPER}} .elementor-nav-menu--main .elementor-item.elementor-item' => 'color: {{VALUE}}',
				],
			]
		);
	}

	/**
	 * Register Analog Color controls.
	 *
	 * @param Controls_Stack $element Elementor element.
	 * @param string         $section_id Section ID.
	 */
	public function register_color_settings( Controls_Stack $element, $section_id ) {
		if ( 'section_page_style' !== $section_id || 'popup' === $this->get_document_type() ) {
			return;
		}

		$element->start_controls_section(
			'ang_colors',
			[
				'label' => _x( 'Global Colors', 'Section Title', 'ang' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$element->add_control(
			'ang_colors_description',
			[
				/* translators: %1$s: Link to documentation, %2$s: Link text. */
				'raw'             => __( 'Set the colors for Typography, accents and more.', 'ang' ) . sprintf( ' <a href="%1$s" target="_blank">%2$s</a>', 'https://docs.analogwp.com/article/574-working-with-colours', __( 'Learn more.', 'ang' ) ),
				'type'            => Controls_Manager::RAW_HTML,
				'content_classes' => 'elementor-descriptor',
			]
		);

		$page_settings_manager = Manager::get_settings_managers( 'page' );
		$page_settings_model   = $page_settings_manager->get_model( get_the_ID() );
		$remove_link           = $page_settings_model->get_settings( 'ang_remove_title_link_color' );

		$selectors = [
			'{{WRAPPER}} .sk-accent-1'              => 'color: {{VALUE}}',
			'{{WRAPPER}} .elementor-icon-box-icon .elementor-icon, {{WRAPPER}} .elementor-icon-list-icon' => 'color: {{VALUE}}',
			'{{WRAPPER}} .elementor-icon-list-icon' => 'color: {{VALUE}}',
			'{{WRAPPER}} .elementor-view-stacked .elementor-icon' => 'background-color: {{VALUE}};',
			'{{WRAPPER}} .elementor-view-framed .elementor-icon, {{WRAPPER}} .elementor-view-default .elementor-icon' => 'color: {{VALUE}}; border-color: {{VALUE}};',
			'{{WRAPPER}} .elementor-progress-bar'   => 'background-color: {{VALUE}}',
			'{{WRAPPER}} .sk-primary-accent'        => 'color: {{VALUE}}',

			'{{WRAPPER}} .sk-primary-accent.sk-primary-accent h1,
			{{WRAPPER}} .sk-primary-accent.sk-primary-accent h2,
			{{WRAPPER}} .sk-primary-accent.sk-primary-accent h3,
			{{WRAPPER}} .sk-primary-accent.sk-primary-accent h4,
			{{WRAPPER}} .sk-primary-accent.sk-primary-accent h5,
			{{WRAPPER}} .sk-primary-accent.sk-primary-accent h6' => 'color: {{VALUE}}',

			'{{WRAPPER}} .sk-primary-bg:not(.elementor-column)' => 'background-color: {{VALUE}}',

			'{{WRAPPER}} .elementor-nav-menu--main:not(.e--pointer-framed) .elementor-item:before,
			{{WRAPPER}} .elementor-nav-menu--main:not(.e--pointer-framed) .elementor-item:after' => 'background-color: {{VALUE}}',
			'{{WRAPPER}} .e--pointer-framed .elementor-item:before,
			{{WRAPPER}} .e--pointer-framed .elementor-item:after' => 'border-color: {{VALUE}}',
			'{{WRAPPER}} .elementor-sub-item:hover' => 'background-color: {{VALUE}}; color: #fff !important;',
			'{{WRAPPER}} .sk-primary-bg.elementor-column > .elementor-element-populated' => 'background-color: {{VALUE}};',
		];

		if ( ! $remove_link ) {
			$selectors += [
				'{{WRAPPER}} *:not(.elementor-tab-title):not(.elementor-image-box-title):not(.elementor-icon-box-title) > a:not([role=button]),
				{{WRAPPER}} .elementor-tab-title.elementor-active,
				{{WRAPPER}} .elementor-image-box-title a,
				{{WRAPPER}} .elementor-icon-box-title a' => 'color: {{VALUE}};',
			];
		}

		$element->add_control(
			'ang_color_accent_primary',
			[
				'label'       => __( 'Primary Accent', 'ang' ),
				'type'        => Controls_Manager::COLOR,
				'description' => __( 'The primary accent color applies on Links.', 'ang' ),
				'classes'     => 'ang-description-wide',
				'selectors'   => $selectors,
			]
		);

		$element->add_control(
			'ang_color_accent_secondary',
			[
				'label'       => __( 'Secondary Accent', 'ang' ),
				'type'        => Controls_Manager::COLOR,
				'description' => __( 'The default Button color. You can also set button colors in the Buttons tab.', 'ang' ),
				'classes'     => 'ang-description-wide',
				'selectors'   => [
					'{{WRAPPER}} .elementor-button, {{WRAPPER}} .button, {{WRAPPER}} button, {{WRAPPER}} .sk-accent-2' => 'background-color: {{VALUE}}',
					'{{WRAPPER}} .sk-secondary-accent' => 'color: {{VALUE}}',

					'{{WRAPPER}} .sk-secondary-accent.sk-secondary-accent h1,
					{{WRAPPER}} .sk-secondary-accent.sk-secondary-accent h2,
					{{WRAPPER}} .sk-secondary-accent.sk-secondary-accent h3,
					{{WRAPPER}} .sk-secondary-accent.sk-secondary-accent h4,
					{{WRAPPER}} .sk-secondary-accent.sk-secondary-accent h5,
					{{WRAPPER}} .sk-secondary-accent.sk-secondary-accent h6' => 'color: {{VALUE}}',

					'{{WRAPPER}} .sk-secondary-bg:not(.elementor-column)' => 'background-color: {{VALUE}}',

					'{{WRAPPER}} .sk-secondary-bg.elementor-column > .elementor-element-populated' => 'background-color: {{VALUE}};',
				],
			]
		);

		$element->add_control(
			'ang_color_text_light',
			[
				'label'       => __( 'Text and Headings Color', 'ang' ),
				'type'        => Controls_Manager::COLOR,
				'description' => __( 'Applies on the text and headings in the layout.', 'ang' ),
				'classes'     => 'ang-description-wide',
				'selectors'   => [
					'{{WRAPPER}},{{WRAPPER}} h1, {{WRAPPER}} h2, {{WRAPPER}} h3, {{WRAPPER}} h4, {{WRAPPER}} h5, {{WRAPPER}} h6' => 'color: {{VALUE}}',
					':root, {{WRAPPER}} .sk-text-light' => '--ang_color_text_light: {{VALUE}}',
					'{{WRAPPER}} .sk-text-light'        => 'color: {{VALUE}}',
					'{{WRAPPER}} .sk-text-light .elementor-heading-title' => 'color: {{VALUE}}',
				],
			]
		);

		$element->add_control(
			'ang_color_background_light',
			[
				'label'       => __( 'Light Background', 'ang' ),
				'type'        => Controls_Manager::COLOR,
				'description' => __( 'Apply this color to sections or columns, using the <code>sk-light-bg</code>. The text inside will inherit the Text and titles color.', 'ang' ),
				'classes'     => 'ang-description-wide',
				'selectors'   => [
					'{{WRAPPER}} .sk-light-bg:not(.elementor-column)' => 'background-color: {{VALUE}}; color: var(--ang_color_text_light)',
					'{{WRAPPER}} .sk-dark-bg .sk-light-bg h1,
					{{WRAPPER}} .sk-dark-bg .sk-light-bg h2,
					{{WRAPPER}} .sk-dark-bg .sk-light-bg h3,
					{{WRAPPER}} .sk-dark-bg .sk-light-bg h4,
					{{WRAPPER}} .sk-dark-bg .sk-light-bg h5,
					{{WRAPPER}} .sk-dark-bg .sk-light-bg h6' => 'color: var(--ang_color_text_light)',
					'{{WRAPPER}} .sk-dark-bg .elementor-counter .elementor-counter-title, {{WRAPPER}} .sk-dark-bg .elementor-counter .elementor-counter-number-wrapper' => 'color: currentColor',

					'{{WRAPPER}} .sk-light-bg.elementor-column > .elementor-element-populated' => 'background-color: {{VALUE}}; color: var(--ang_color_text_light)',
				],
			]
		);

		$element->add_control(
			'ang_color_background_dark',
			[
				'label'       => __( 'Dark Background', 'ang' ),
				'type'        => Controls_Manager::COLOR,
				'description' => __( 'Apply this color to sections or columns, using the <code>sk-dark-bg</code>. The text inside will inherit the <em>Text over Dark Background</em> color that can be set below.', 'ang' ),
				'classes'     => 'ang-description-wide',
				'selectors'   => [
					'{{WRAPPER}} .sk-dark-bg:not(.elementor-column)' => 'background-color: {{VALUE}}; color: var(--ang_color_text_dark)',
					'{{WRAPPER}} .sk-dark-bg h1,
					{{WRAPPER}} .sk-dark-bg h2,
					{{WRAPPER}} .sk-dark-bg h3,
					{{WRAPPER}} .sk-dark-bg h4,
					{{WRAPPER}} .sk-dark-bg h5,
					{{WRAPPER}} .sk-dark-bg h6' => 'color: var(--ang_color_text_dark)',
					'{{WRAPPER}} .sk-light-bg .sk-dark-bg h1,
					{{WRAPPER}} .sk-light-bg .sk-dark-bg h2,
					{{WRAPPER}} .sk-light-bg .sk-dark-bg h3,
					{{WRAPPER}} .sk-light-bg .sk-dark-bg h4,
					{{WRAPPER}} .sk-light-bg .sk-dark-bg h5,
					{{WRAPPER}} .sk-light-bg .sk-dark-bg h6' => 'color: var(--ang_color_text_dark)',
					'{{WRAPPER}} .sk-light-bg .elementor-counter .elementor-counter-title, {{WRAPPER}} .sk-light-bg .elementor-counter .elementor-counter-number-wrapper' => 'color: currentColor',

					'{{WRAPPER}} .sk-dark-bg.elementor-column > .elementor-element-populated' => 'background-color: {{VALUE}}; color: var(--ang_color_text_dark)',
				],
			]
		);

		$element->add_control(
			'ang_color_text_dark',
			[
				'label'       => __( 'Text over dark background', 'ang' ),
				'type'        => Controls_Manager::COLOR,
				'description' => __( 'This color will apply on the text in a section or column with the Dark Background Color, as it has been set above.', 'ang' ),
				'classes'     => 'ang-description-wide',
				'selectors'   => [
					':root, {{WRAPPER}} .sk-text-dark' => '--ang_color_text_dark: {{VALUE}}',
					'{{WRAPPER}} .sk-text-dark'        => 'color: {{VALUE}}',
					'{{WRAPPER}} .sk-text-dark .elementor-heading-title' => 'color: {{VALUE}}',
				],
			]
		);

		$element->end_controls_section();
	}
}

new Colors();
