<?php
/**
 * Analog Version Control Settins.
 *
 * @package Analog/Admin
 * @since 1.3.8
 */

namespace Analog\Settings;

use Analog\Utils;

defined( 'ABSPATH' ) || exit;

/**
 * Version Control.
 */
class Version_Control extends Settings_Page {

	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->id    = 'version-control';
		$this->label = __( 'Version Control', 'ang' );
		parent::__construct();

	}

	/**
	 * Get settings array.
	 *
	 * @return array
	 */
	public function get_settings() {
		$settings = apply_filters(
			'ang_version_control_settings',
			array(
				array(
					'title' => __( 'Rollback Version', 'ang' ),
					'type'  => 'title',
					'id'    => 'ang_plugin_rollback_version',
					'desc'  => __( 'If you are having issues with current version of Style Kits for Elementor, you can rollback to a previous stable version.', 'ang' ),
				),
				array(
					'id'       => 'ang_rollback_version_select_option',
					'default'  => '',
					'type'     => 'select',
					'class'    => 'ang-enhanced-select',
					'desc_tip' => true,
					'options'  => $this->get_rollback_versions(),
				),
				array(
					'id'    => 'ang_rollback_version_button',
					'type'  => 'button',
					'class' => 'ang-rollback-version-button ang-button',
					'value' => __( 'Reinstall this version', 'ang' ),
				),
				array(
					'type' => 'sectionend',
					'id'   => 'ang_plugin_rollback',
				),
				array(
					'title' => __( 'Become a beta tester', 'ang' ),
					'type'  => 'title',
					'id'    => 'ang_beta_tester',
				),
				array(
					'desc'          => __( 'Check this box to turn on beta updates for Style Kits and Style Kits Pro. The update will not be installed automatically, you always have the option to ignore it.', 'ang' ),
					'id'            => 'beta_tester',
					'default'       => false,
					'type'          => 'checkbox',
					'checkboxgroup' => 'start',
				),
				array(
					'type' => 'sectionend',
					'id'   => 'ang_beta_tester',
				),
			)
		);

		return apply_filters( 'ang_get_settings_' . $this->id, $settings );
	}

	/**
	 * Get recent rollback versions in key/value pair.
	 *
	 * @uses \Analog\Utils::get_rollback_versions()
	 * @return array
	 */
	public function get_rollback_versions() {
		$keys = Utils::get_rollback_versions();
		$data = [];
		foreach ( $keys as $key => $value ) {
			$data[ $value ] = $value;
		}

		return $data;
	}

	/**
	 * Output the settings.
	 */
	public function output() {
		$settings = $this->get_settings();

		Admin_Settings::output_fields( $settings );
	}

	/**
	 * Save settings.
	 */
	public function save() {
		$settings = $this->get_settings();

		Admin_Settings::save_fields( $settings );
	}
}

return new Version_Control();
