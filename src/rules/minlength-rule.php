<?php
/**
 * Nomad Validate Min Length Rule class file.
 *
 * @since 1.0.0
 *
 * @package Nomad/Validate
 */

namespace Nomad\Validate\Rules;

if ( ! defined( 'ABSPATH' ) ) exit; // Prevent direct access.

if ( ! class_exists( __NAMESPACE__ . '\\Minlength_Rule' ) ) {

	class Minlength_Rule implements Rule {

		private $minlength;

		function __construct( $argument ) {

			$this->minlength = intval( $argument );

		}

		public function check( $value ) {

			return ( strlen( $value ) >= $this->minlength ) ? true : false;

		}

		public function error_message( $label ) {

			return sprintf( '%s is not long enough. Minimum length is %s characters.', $label, $this->minlength );

		}

	}

}
