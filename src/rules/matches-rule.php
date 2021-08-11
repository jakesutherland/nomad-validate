<?php
/**
 * Nomad Validate Matches Rule class file.
 *
 * @since 1.0.0
 *
 * @package Nomad/Validate
 */

namespace Nomad\Validate\Rules;

if ( ! defined( 'ABSPATH' ) ) exit; // Prevent direct access.

if ( ! class_exists( __NAMESPACE__ . '\\Matches_Rule' ) ) {

	class Matches_Rule implements Rule {

		private $matches;

		function __construct( $argument ) {

			$this->matches = $argument;

		}

		public function check( $value ) {

			return ( $value === $this->matches ) ? true : false;

		}

		public function error_message( $label ) {

			return sprintf( '%s does not match.', $label );

		}

	}

}
