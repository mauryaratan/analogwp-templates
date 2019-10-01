<?php
/**
 * Analog Miscelleneous Settings
 *
 * @package Analog/Admin
 */

namespace Analog\settings;

defined( 'ABSPATH' ) || exit;

if ( class_exists( 'Settings_Misc', false ) ) {
	return new Settings_Misc();
}

/**
 * Admin_Settings_Misc.
 */
class Settings_Misc extends Settings_Page {

	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->id    = 'misc';
		$this->label = __( 'Misc', 'ang' );

		parent::__construct();
	}

	/**
	 * Get settings array.
	 *
	 * @return array
	 */
	public function get_settings() {

		$settings = apply_filters(
			'ang_misc_settings',
			array(
				array(
					'title' => __( 'Opt-in for usage Data Tracking', 'ang' ),
					'type'  => 'title',
					'id'    => 'usage_tracking',
				),
				array(
					'title'   => __( 'Data Tracking', 'ang' ),
					'desc'    => __( 'Opt-in to our anonymous plugin data collection and to updates. We guarantee no sensitive data is collected.', 'ang' ),
					'id'      => 'usage_tracking_option',
					'default' => 'no',
					'type'    => 'checkbox',
				),
				array(
					'type' => 'sectionend',
					'id'   => 'usage_tracking',
				),
				array(
					'title' => __( 'Rollback Version', 'ang' ),
					'type'  => 'title',
					'id'    => 'plugin_rollback_version',
					'desc'     => __( 'If you are having issues with current version of Style Kits for Elementor, you can rollback to a previous stable version.', 'ang' ),
				),
				array(
					'desc'     => __( 'Select version number to which rollback should happen.', 'ang' ),
					'id'       => 'plugin_rollback_version_select',
					'default'  => '',
					'type'     => 'select',
					'class'    => 'ang-enhanced-select',
					'desc_tip' => true,
					'options'  => array(
						'1.3.6'         => __( '1.3.6', 'ang' ),
						'1.3.4'      => __( '1.3.4', 'ang' ),
						'1.3.0'      => __( '1.3.0', 'ang' ),
					),
				),
				array(
					'type' => 'sectionend',
					'id'   => 'plugin_rollback',
				),
				array(
					'title' => __( 'Remove Data on Uninstall', 'ang' ),
					'type'  => 'title',
					'id'    => 'remove_data_uninstall',
				),
				array(
					'title'   => __( 'Data Removal', 'ang' ),
					'desc'    => __( 'Check this box to remove all data stored by Style Kit for Elementor plugin, including license info, user settings, import history etc. Any imported or manually saved Style Kits are not removed.', 'ang' ),
					'id'      => 'remove_data_uninstall_option',
					'default' => 'no',
					'type'    => 'checkbox',
				),
				array(
					'type' => 'sectionend',
					'id'   => 'remove_data_uninstall',
				),
			)
		);

		return apply_filters( 'ang_get_settings_' . $this->id, $settings );
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

return new Settings_Misc();
