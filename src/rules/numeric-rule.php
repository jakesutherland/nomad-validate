<?php
/**
 * Nomad Validate Numeric Rule class file.
 *
 * @since 1.0.0
 *
 * @package Nomad/Validate
 */

namespace Nomad\Validate\Rules;

if ( ! defined( 'ABSPATH' ) ) exit; // Prevent direct access.

if ( ! class_exists( __NAMESPACE__ . '\\Numeric_Rule' ) ) {

	class Numeric_Rule implements Rule {

		function __construct( $argument ) {

			// No argument.

		}

		public function check( $value ) {

			return ( is_numeric( $value ) ) ? true : false;

		}

		public function error_message( $label ) {

			return sprintf( '%s is not a numeric value.', $label );

		}

	}

}
