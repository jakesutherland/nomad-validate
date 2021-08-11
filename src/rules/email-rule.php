<?php
/**
 * Nomad Validate Email Rule class file.
 *
 * @since 1.0.0
 *
 * @package Nomad/Validate
 */

namespace Nomad\Validate\Rules;

if ( ! defined( 'ABSPATH' ) ) exit; // Prevent direct access.

if ( ! class_exists( __NAMESPACE__ . '\\Email_Rule' ) ) {

	class Email_Rule implements Rule {

		function __construct( $argument ) {

			// No argument.

		}

		public function check( $value ) {

			// @see https://www.php.net/manual/en/filter.filters.validate.php
			// @see https://www.php.net/manual/en/filter.filters.flags.php
			return ( filter_var( $value, FILTER_VALIDATE_EMAIL, FILTER_FLAG_EMAIL_UNICODE ) ) ? true : false;

		}

		public function error_message( $label ) {

			return sprintf( '%s is not a valid email.', $label );

		}

	}

}
