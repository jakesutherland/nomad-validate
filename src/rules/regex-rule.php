<?php
/**
 * Nomad Validate Regex Rule class file.
 *
 * @since 1.0.0
 *
 * @package Nomad/Validate
 */

namespace Nomad\Validate\Rules;

if ( ! defined( 'ABSPATH' ) ) exit; // Prevent direct access.

if ( ! class_exists( __NAMESPACE__ . '\\Regex_Rule' ) ) {

	class Regex_Rule implements Rule {

		private $regex;

		function __construct( $argument ) {

			$this->regex = $argument;

		}

		public function check( $value ) {

			return ( preg_match( $this->regex, $value ) ) ? true : false;

		}

		public function error_message( $label ) {

			return sprintf( '%s is not properly formatted.', $label );

		}

	}

}
