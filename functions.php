<?php
/**
 * Nomad Validate Composer Package Autoload file.
 *
 * Nomad Validate provides you with an easy to use way to validate data against
 * a set of rules and generate error messages.
 *
 * @since 1.0.0
 *
 * @package Nomad/Validate
 */

namespace Nomad\Validate;

use function Nomad\Helpers\register_nomad_package;

if ( ! defined( 'ABSPATH' ) ) exit; // Prevent direct access.

// Composer Autoload.
require_once dirname( __FILE__ ) . '/vendor/autoload.php';

/**
 * Nomad Validate Version.
 *
 * @since 1.0.0
 */
if ( ! defined( 'NOMAD_VALIDATE_VERSION' ) ) {
	define( 'NOMAD_VALIDATE_VERSION', '1.1.0' );
}

/**
 * Nomad Validate Path.
 *
 * @since 1.0.0
 */
if ( ! defined( 'NOMAD_VALIDATE_PATH' ) ) {
	define( 'NOMAD_VALIDATE_PATH', dirname( __FILE__ ) . '/' );

	register_nomad_package( 'nomad-validate', NOMAD_VALIDATE_PATH );
}

/**
 * Nomad Validate Source Path.
 *
 * @since 1.0.0
 */
if ( ! defined( 'NOMAD_VALIDATE_SRC_PATH' ) ) {
	define( 'NOMAD_VALIDATE_SRC_PATH', NOMAD_VALIDATE_PATH . 'src/' );
}

/**
 * Nomad Validate Rules Path.
 *
 * @since 1.0.0
 */
if ( ! defined( 'NOMAD_VALIDATE_RULES_PATH' ) ) {
	define( 'NOMAD_VALIDATE_RULES_PATH', NOMAD_VALIDATE_SRC_PATH . 'rules/' );
}

// Include the Nomad Validate class.
if ( ! class_exists( __NAMESPACE__ . '\\Nomad_Validate' ) ) {
	require_once NOMAD_VALIDATE_SRC_PATH . 'class-nomad-validate.php';
}

// Include the Base Rule class.
if ( ! class_exists( __NAMESPACE__ . '\\Rules\\Rule' ) ) {
	require_once NOMAD_VALIDATE_RULES_PATH . 'rule.php';
}

if ( ! function_exists( __NAMESPACE__ . '\\nomad_validate' ) ) {

	/**
	 * Nomad Validate function.
	 *
	 * Validates the data items provided based on rules provided.
	 *
	 * @since 1.0.0
	 *
	 * @param array $data The data to be validated. Contains key value pairs.
	 *                    The key is a unique identifier for the data item.
	 *                    The value is an array of the following arguments:
	 *     {
	 *         @type string $key            Unique identifier for the data item.
	 *         @type string $label          The label for the data item, used in error messages.
	 *         @type mixed  $value          The value for the data item to be validated.
	 *         @type array  $rules          An array of rules to test the value against.
	 *         @type array  $error_messages Custom error messages for individual rule keys.
	 *     }
	 *
	 * For a list of available rules and examples, see `$registered_rules` in the
	 * `Nomad_Validate` class.
	 *
	 * Usage:
	 *
	 *     ```
	 *     $validated = nomad_validate( array(
	 *         'first_name' => array(
	 *             'key'   => 'first_name',
	 *             'label' => 'First Name',
	 *             'value' => $_POST['first_name'],
	 *             'rules' => array( 'required', 'minlength:2', 'maxlength:20' ),
	 *         ),
	 *         'last_name' => array(
	 *             'key'   => 'last_name',
	 *             'label' => 'Last Name',
	 *             'value' => $_POST['last_name'],
	 *             'rules' => array( 'required', 'minlength:2', 'maxlength:50' ),
	 *         ),
	 *         'email_address' => array(
	 *             'key'   => 'email_address',
	 *             'label' => 'Email Address',
	 *             'value' => $_POST['email_address'],
	 *             'rules' => array( 'required', 'email' ),
	 *         ),
	 *         'terms' => array(
	 *             'key'            => 'terms',
	 *             'label'          => 'Terms and Conditions',
	 *             'value'          => $_POST['terms'],
	 *             'rules'          => array( 'required' ),
	 *             'error_messages' => array(
	 *                 'required' => 'You must agree to the terms and conditions.',
	 *             ),
	 *         ),
	 *     ) );
	 *
	 *     if ( $validated->is_valid() ) {
	 *         // Do something if everything is valid.
	 *     } else {
	 *         // Do something if there was an error. Display error messages.
	 *         $messages = $validated->get_all_error_messages();
	 *     }
	 *     ```
	 *
	 * @return Nomad_Validate
	 */
	function nomad_validate( $data ) {

		return new Nomad_Validate( $data );

	}

}
