<?php
/**
 * Nomad Validate URL Rule class file.
 *
 * @since 1.0.0
 *
 * @package Nomad/Validate
 */

namespace Nomad\Validate\Rules;

if ( ! defined( 'ABSPATH' ) ) exit; // Prevent direct access.

if ( ! class_exists( __NAMESPACE__ . '\\Url_Rule' ) ) {

	class Url_Rule implements Rule {

		function __construct( $argument ) {

			// No argument.

		}

		public function check( $value ) {

			// @see https://www.php.net/manual/en/filter.filters.validate.php
			return ( filter_var( $value, FILTER_VALIDATE_URL ) ) ? true : false;

		}

		public function error_message( $label ) {

			return sprintf( '%s is not a valid URL.', $label );

		}

	}

}
