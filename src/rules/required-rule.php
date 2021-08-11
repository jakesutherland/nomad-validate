<?php
/**
 * Nomad Validate Required Rule class file.
 *
 * @since 1.0.0
 *
 * @package Nomad/Validate
 */

namespace Nomad\Validate\Rules;

if ( ! defined( 'ABSPATH' ) ) exit; // Prevent direct access.

if ( ! class_exists( __NAMESPACE__ . '\\Required_Rule' ) ) {

	class Required_Rule implements Rule {

		function __construct( $argument ) {

			// No argument.

		}

		public function check( $value ) {

			return ( ! empty( $value ) ) ? true : false;

		}

		public function error_message( $label ) {

			return sprintf( '%s is required.', $label );

		}

	}

}
