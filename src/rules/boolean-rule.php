<?php
/**
 * Nomad Validate Boolean Rule class file.
 *
 * @since 1.0.0
 *
 * @package Nomad/Validate
 */

namespace Nomad\Validate\Rules;

if ( ! defined( 'ABSPATH' ) ) exit; // Prevent direct access.

if ( ! class_exists( __NAMESPACE__ . '\\Boolean_Rule' ) ) {

	class Boolean_Rule implements Rule {

		private $comparison = null;

		private $truthy = array(
			true,
			1,
			'true',
			'1',
			'yes',
			'on',
			'truthy',
		);

		private $falsey = array(
			false,
			0,
			'false',
			'0',
			'no',
			'off',
			'falsey',
		);

		function __construct( $argument ) {

			$this->comparison = ( empty( $argument ) ) ? 'strict' : $argument;

		}

		public function check( $value ) {

			if ( 'strict' === $this->comparison ) {

				return ( is_bool( $value ) ) ? true : false;

			}

			if ( in_array( $this->comparison, $this->truthy, true ) ) {

				return ( in_array( $value, $this->truthy, true ) ) ? true : false;

			}

			if ( in_array( $this->comparison, $this->falsey, true ) ) {

				return ( in_array( $value, $this->falsey, true ) ) ? true : false;

			}

		}

		public function error_message( $label ) {

			return sprintf( '%s is not formatted properly.', $label );

		}

	}

}
