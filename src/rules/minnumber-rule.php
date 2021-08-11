<?php
/**
 * Nomad Validate Min Number Rule class file.
 *
 * @since 1.0.0
 *
 * @package Nomad/Validate
 */

namespace Nomad\Validate\Rules;

if ( ! defined( 'ABSPATH' ) ) exit; // Prevent direct access.

if ( ! class_exists( __NAMESPACE__ . '\\Minnumber_Rule' ) ) {

	class Minnumber_Rule implements Rule {

		private $minnumber;

		function __construct( $argument ) {

			$this->minnumber = intval( $argument );

		}

		public function check( $value ) {

			return ( intval( $value ) >= $this->minnumber ) ? true : false;

		}

		public function error_message( $label ) {

			return sprintf( '%s is too low. Minimum number is %s.', $label, $this->minnumber );

		}

	}

}
