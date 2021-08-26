<?php
/**
 * Nomad Validate Choices Rule class file.
 *
 * @since 1.0.0
 *
 * @package Nomad/Validate
 */

namespace Nomad\Validate\Rules;

if ( ! defined( 'ABSPATH' ) ) exit; // Prevent direct access.

if ( ! class_exists( __NAMESPACE__ . '\\Choices_Rule' ) ) {

	class Choices_Rule implements Rule {

		private $array = null;

		function __construct( $argument ) {

			$this->array = explode( ',', $argument );

		}

		public function check( $value ) {

			if ( ! is_null( $value ) ) {

				if ( is_array( $value ) ) {
					return ( array_intersect( $value, $this->array ) === $value ) ? true : false;
				}

				return ( in_array( $value, $this->array, true ) ) ? true : false;

			}

			return true;

		}

		public function error_message( $label ) {

			return sprintf( 'Invalid %s provided.', $label );

		}

	}

}
