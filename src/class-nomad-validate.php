<?php
/**
 * Nomad Validate class file.
 *
 * @since 1.0.0
 *
 * @package Nomad/Validate
 */

namespace Nomad\Validate;

use Nomad\Helpers\Nomad_Exception;

use function Nomad\Helpers\nomad_error;
use function Nomad\Helpers\nomad_array_keys_exist;
use function Nomad\Helpers\nomad_array_keys_missing;

if ( ! defined( 'ABSPATH' ) ) exit; // Prevent direct access.

if ( ! class_exists( __NAMESPACE__ . '\\Nomad_Validate' ) ) {

	/**
	 * Nomad Validate class.
	 *
	 * Handles validating data values by processing rules and determining its validity.
	 *
	 * @since 1.0.0
	 */
	final class Nomad_Validate {

		/**
		 * List of available validation rules.
		 *
		 * 'key' => 'Class_Name', // Example usage.
		 *
		 * @since 1.0.0
		 * @access private
		 *
		 * @var array
		 */
		private $registered_rules = array(
			'boolean'   => 'Boolean_Rule',   // boolean, boolean:strict, boolean:truthy, boolean:falsey
			'choices'   => 'Choices_Rule',   // choices:value1,value2,value3
			'date'      => 'Date_Rule',      // date:Y-m-d
			'email'     => 'Email_Rule',     // email
			'equals'    => 'Equals_Rule',    // equals:value
			'letters'   => 'Letters_Rule',   // letters
			'matches'   => 'Matches_Rule',   // matches:my_field_key
			'maxlength' => 'Maxlength_Rule', // maxlength:20
			'max'       => 'Max_Rule',       // max:2021
			'maxnumber' => 'Max_Rule',       // maxnumber:2021
			'minlength' => 'Minlength_Rule', // minlength:10
			'min'       => 'Min_Rule',       // min:1900
			'minnumber' => 'Min_Rule',       // minnumber:1900
			'numbers'   => 'Numbers_Rule',   // numbers
			'numeric'   => 'Numeric_Rule',   // numeric
			'regex'     => 'Regex_Rule',     // regex:/^([A-Za-z0-9_\-\.]*)$/
			'required'  => 'Required_Rule',  // required
			'trim'      => '',               // trim
			'url'       => 'Url_Rule',       // url
		);

		/**
		 * Contains the data passed in to be validated.
		 *
		 * @since 1.0.0
		 * @access private
		 *
		 * @var array
		 */
		private $data = array();

		/**
		 * Custom error messages provided for data keys and its rules.
		 *
		 * @since 1.0.0
		 * @access private
		 *
		 * @var array
		 */
		private $custom_error_messages = array();

		/**
		 * Whether or not the data passed in is valid.
		 *
		 * @since 1.0.0
		 * @access private
		 *
		 * @var boolean|null
		 */
		private $is_valid = null;

		/**
		 * Error messages generated during validation.
		 *
		 * Each data item will have its own key and array of error messages.
		 * To get a list of ALL error messages use the `get_error_messages_list() function
		 * which combines all messages into a single array.
		 *
		 * @since 1.0.0
		 * @access private
		 *
		 * @var array
		 */
		private $error_messages = array();

		/**
		 * Initialize the validation process.
		 *
		 * See documentation for `nomad_validate()` function. You should also
		 * use the function and not the class itself.
		 *
		 * @since 1.0.0
		 * @access public
		 *
		 * @param array $data The data to be validated.
		 */
		public function __construct( $data ) {

			$this->data = $data;

			$is_valid = array();

			$required_args = array(
				'key',
				'label',
				'value',
				'rules',
			);

			// Validate each key.
			foreach ( $this->data as $key => $args ) {
				// Make sure that we have the arguments we need.
				if ( ! nomad_array_keys_exist( $required_args, $args ) ) {
					$missing_keys = implode( ',', nomad_array_keys_missing( $args, $required_args ) );
					throw new Nomad_Exception( sprintf( 'Missing required argument(s) <code>%s</code> when validating <code>%s</code>.', $missing_keys, $key ) );
				}

				$this->custom_error_messages[ $key ] = ( isset( $args['error_messages'] ) ) ? $args['error_messages'] : array();

				$is_valid[ $key ] = $this->validate( $key, $args['label'], $args['value'], $args['rules'] );
			}

			$this->is_valid = ( ! in_array( false, $is_valid, true ) ) ? true : false;

		}

		/**
		 * Validates a single data key's value using the rules provided.
		 *
		 * @since 1.0.0
		 * @access private
		 *
		 * @param string $key   The data key.
		 * @param string $label Label used in error messages.
		 * @param mixed  $value The data value.
		 * @param array  $rules Rules to process the value against.
		 *
		 * @return boolean
		 */
		private function validate( $key, $label, $value, $rules ) {

			// If no rules are given, then it automatically passes.
			if ( empty( $rules ) ) {
				$valid = true;
			} else {

				$is_valid = array();

				// Trim is a special rule and does not have a class associated with it.
				if ( in_array( 'trim', $rules, true ) ) {
					// Trim the value before processing individual rules.
					$value = trim( $value );

					// Remove from the $rules array so we don't attempt to include a class file.
					$rules = array_diff( $rules, array( 'trim' ) );
				}

				// Loop through rules and process each individual one.
				foreach ( $rules as $rule ) {
					$is_valid[] = $this->process_rule( $key, $label, $value, $rule );
				}

				// If any rules failed, then the validation for this item failed.
				$valid = ( ! in_array( false, $is_valid, true ) ) ? true : false;

			}

			/**
			 * Filters the validity of a specific key.
			 *
			 * Gives you an opportunity to change whether or not a specific key is valid.
			 *
			 * @since 1.0.0
			 *
			 * @param boolean $valid Whether or not the specific key is valid.
			 * @param string  $key   The data key.
			 * @param string  $label Label used in error messages.
			 * @param mixed   $value The data value.
			 * @param array   $rules Rules to process the value against.
			 */
			$valid = apply_filters( "nomad/validate/{$key}", $valid, $key, $label, $value, $rules );

			return $valid;

		}

		/**
		 * Process an individual rule for a specific key's value.
		 *
		 * @since 1.0.0
		 * @access private
		 *
		 * @param string $key      The data key.
		 * @param string $label    Label used in error messages.
		 * @param mixed  $value    The data value.
		 * @param string $rule_key The rule key to process.
		 *
		 * @return boolean
		 */
		private function process_rule( $key, $label, $value, $rule_key ) {

			$argument = null;

			// Some rules have arguments that are provided after ':' in the $rule_key.
			if ( strpos( $rule_key, ':' ) ) {
				// We set the explode limit to 1 so that we only split the string by the first occurrence, allowing possible regex rules to contain anything.
				list( $rule_key, $argument ) = explode( ':', $rule_key, 2 );
			}

			// Make sure that the $rule_key is one that is in our list of registered rules.
			if ( ! array_key_exists( $rule_key, $this->registered_rules ) ) {
				nomad_error( sprintf( 'Invalid rule <code>%s</code> provided when validating <code>%s</code>.', $rule_key, $key ) );

				return false;
			}

			// The 'matches' rule passes in a key to compare this item against. We need the value of this key as an argument to process the rule.
			if ( 'matches' === $rule_key ) {
				$argument = $this->data[ $argument ]['value'];
			}

			$class_name = __NAMESPACE__ . '\\Rules\\' . $this->registered_rules[ $rule_key ];

			// Include the rule class file if it hasn't been already.
			if ( ! class_exists( $class_name ) ) {
				require_once NOMAD_VALIDATE_RULES_PATH . $rule_key . '-rule.php';
			}

			// Instantiate the rule object, passing in the argument.
			$rule_obj = new $class_name( $argument );

			// Check the rule with the value.
			if ( $rule_obj->check( $value ) ) {

				return true;

			} else {

				if ( array_key_exists( $rule_key, $this->custom_error_messages[ $key ] ) ) {
					$error_message = $this->custom_error_messages[ $key ][ $rule_key ];
				} else {
					$error_message = $rule_obj->error_message( $label );
				}

				/**
				 * Filter the error message for a specific data key and rule key.
				 *
				 * The filter is available if you want to use it, but it is easier
				 * to pass in a custom message through the `error_messages`
				 * argument when building your initial data array.
				 *
				 * @since 1.0.0
				 *
				 * @param string $error_message The error message that was generated.
				 * @param string $key           The data key.
				 * @param string $label         Label used in error messages.
				 * @param mixed  $value         The data value.
				 * @param string $rule_key      Rule key being processed.
				 * @param string $argument      Argument for the rule being processed.
				 */
				$error_message = apply_filters( "nomad/validate/{$key}/{$rule_key}/error_message", $error_message, $key, $label, $value, $rule_key, $argument );

				$this->error_messages[ $key ][] = $error_message;

				return false;

			}

		}

		/**
		 * Whether or not the data is valid after it has been fully processed and validated.
		 *
		 * @since 1.0.0
		 * @access public
		 *
		 * @return boolean
		 */
		public function is_valid() {

			return $this->is_valid;

		}

		/**
		 * Get error messages generated during validation.
		 *
		 * Returns an array of error messages listed by data key.
		 *
		 * @since 1.0.0
		 * @access public
		 *
		 * @param string $key Optional. The specific key to get error messages for.
		 *
		 * @return array
		 */
		public function get_error_messages( $key = '' ) {

			$error_messages = $this->error_messages;

			/**
			 * Filter all error messages generated during validation, listed by data key.
			 *
			 * @since 1.0.0
			 *
			 * @param array Error messages generated during validation, listed by data key.
			 */
			$error_messages = apply_filters( 'nomad/validate/error_messages', $error_messages );

			if ( ! empty( $key ) ) {
				$error_messages = $error_messages[ $key ];
			}

			return $error_messages;

		}

		/**
		 * Get all error messages generated during validation as a single array.
		 *
		 * This combines the arrays of error messages for each data key into a single array.
		 *
		 * @since 1.0.0
		 * @access public
		 *
		 * @return array
		 */
		public function get_all_error_messages() {

			return call_user_func_array( 'array_merge', $this->get_error_messages() );

		}

		/**
		 * Whether the provided data key has any errors.
		 *
		 * @since 1.0.0
		 * @access public
		 *
		 * @param string $key Data key to see if it has any errors.
		 *
		 * @return boolean
		 */
		public function has_error( $key ) {

			return ( array_key_exists( $key, $this->error_messages ) ) ? true : false;

		}

	}

}
