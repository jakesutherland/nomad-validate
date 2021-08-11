<?php
/**
 * Nomad Validate Max Length Rule class file.
 *
 * @since 1.0.0
 *
 * @package Nomad/Validate
 */

namespace Nomad\Validate\Rules;

if ( ! defined( 'ABSPATH' ) ) exit; // Prevent direct access.

if ( ! class_exists( __NAMESPACE__ . '\\Maxlength_Rule' ) ) {

	class Maxlength_Rule implements Rule {

		private $maxlength;

		function __construct( $argument ) {

			$this->maxlength = intval( $argument );

		}

		public function check( $value ) {

			return ( strlen( $value ) <= $this->maxlength ) ? true : false;

		}

		public function error_message( $label ) {

			return sprintf( '%s is too long. Maximum length is %s characters.', $label, $this->maxlength );

		}

	}

}
