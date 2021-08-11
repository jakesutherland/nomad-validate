<?php
/**
 * Nomad Validate Numbers Rule class file.
 *
 * @since 1.0.0
 *
 * @package Nomad/Validate
 */

namespace Nomad\Validate\Rules;

if ( ! defined( 'ABSPATH' ) ) exit; // Prevent direct access.

if ( ! class_exists( __NAMESPACE__ . '\\Numbers_Rule' ) ) {

	class Numbers_Rule implements Rule {

		function __construct( $argument ) {

			// No argument.

		}

		public function check( $value ) {

			return ( preg_match( '/^([0-9]*)$/', $value ) ) ? true : false;

		}

		public function error_message( $label ) {

			return sprintf( '%s can only be numbers.', $label );

		}

	}

}
