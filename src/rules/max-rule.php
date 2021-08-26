<?php
/**
 * Nomad Validate Max Number Rule class file.
 *
 * @since 1.1.0
 *
 * @package Nomad/Validate
 */

namespace Nomad\Validate\Rules;

if ( ! defined( 'ABSPATH' ) ) exit; // Prevent direct access.

if ( ! class_exists( __NAMESPACE__ . '\\Max_Rule' ) ) {

	class Max_Rule implements Rule {

		private $maxnumber;

		function __construct( $argument ) {

			$this->maxnumber = intval( $argument );

		}

		public function check( $value ) {

			return ( intval( $value ) <= $this->maxnumber ) ? true : false;

		}

		public function error_message( $label ) {

			return sprintf( '%s is too high. Maximum number is %s.', $label, $this->maxnumber );

		}

	}

}
