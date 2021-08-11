<?php
/**
 * Nomad Validate Equals Rule class file.
 *
 * @since 1.0.0
 *
 * @package Nomad/Validate
 */

namespace Nomad\Validate\Rules;

if ( ! defined( 'ABSPATH' ) ) exit; // Prevent direct access.

if ( ! class_exists( __NAMESPACE__ . '\\Equals_Rule' ) ) {

	class Equals_Rule implements Rule {

		private $equals;

		function __construct( $argument ) {

			$this->equals = $argument;

		}

		public function check( $value ) {

			return ( $value === $this->equals ) ? true : false;

		}

		public function error_message( $label ) {

			return sprintf( '%s is invalid.', $label );

		}

	}

}
