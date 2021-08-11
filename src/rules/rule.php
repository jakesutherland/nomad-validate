<?php
/**
 * Nomad Validate Base Rule class file.
 *
 * @since 1.0.0
 *
 * @package Nomad/Validate
 */

namespace Nomad\Validate\Rules;

if ( ! defined( 'ABSPATH' ) ) exit; // Prevent direct access.

if ( ! class_exists( __NAMESPACE__ . '\\Rule' ) ) {

	interface Rule {

		function __construct( $argument );

		public function check( $value );

		public function error_message( $label );

	}

}
