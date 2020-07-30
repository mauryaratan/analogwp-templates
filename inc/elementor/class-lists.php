<?php
/**
 * Class Analog\Elementor\Lists.
 *
 * @package AnalogWP
 */

namespace Analog\Elementor;

defined( 'ABSPATH' ) || exit;

use Elementor\Core\Base\Module;

/**
 * Class Lists.
 *
 * @package Analog\Elementor
 */
class Lists extends Module {

	/**
	 * Get module name.
	 *
	 * @return string
	 */
	public function get_name() {
		return 'ang-lists';
	}

}
