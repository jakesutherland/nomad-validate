<?php
/**
 * Nomad Validate Date Rule class file.
 *
 * @since 1.0.0
 *
 * @package Nomad/Validate
 */

namespace Nomad\Validate\Rules;

if ( ! defined( 'ABSPATH' ) ) exit; // Prevent direct access.

if ( ! class_exists( __NAMESPACE__ . '\\Date_Rule' ) ) {

	class Date_Rule implements Rule {

		private $format;

		function __construct( $argument ) {

			$this->format = $argument;

		}

		public function check( $value ) {

			// @see https://www.php.net/manual/en/datetime.format.php
			$DateTime = \DateTime::createFromFormat( $this->format, $value );

			return ( $DateTime && $DateTime->format( $this->format ) === $value ) ? true : false;

		}

		public function error_message( $label ) {

			return sprintf( '%s is not a properly formatted date.', $label );

		}

	}

}
