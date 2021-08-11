# Nomad Validate

A WordPress PHP Composer Package that provides you with an easy way to validate data against a set of rules and generate error messages.

## Installation

You can install Nomad Validate in your project by using composer.

```
$ composer require jakesutherland/nomad-validate
```

## Dependencies

Nomad Validate depends on [Nomad Helpers](https://github.com/jakesutherland/nomad-helpers) for various functions and utilities and needs to be installed in order to run.

If for some reason you didn't install Nomad Validate via Composer as a required package in your project, you will still need to run `composer install` to install it's dependencies as they are not included in the repository.

## Documentation

Nomad Validate has one simple function that you can use to validate data against a set of rules.

### Example Usage

Each data item must have each of the following arguments: `key`, `label`, `value`, and `rules`.

You can optionally overwrite rule error messages through the `error_messages` argument and specify the rule key and your custom message. You can see this in the `terms` example below.

```
<?php

use function Nomad\Validate\nomad_validate;

$validated = nomad_validate( array(
	'first_name' => array(
		'key'   => 'first_name',
		'label' => 'First Name',
		'value' => $_POST['first_name'],
		'rules' => array( 'required', 'minlength:2', 'maxlength:20' ),
	),
	'last_name' => array(
		'key'   => 'last_name',
		'label' => 'Last Name',
		'value' => $_POST['last_name'],
		'rules' => array( 'required', 'minlength:2', 'maxlength:50' ),
	),
	'email_address' => array(
		'key'   => 'email_address',
		'label' => 'Email Address',
		'value' => $_POST['email_address'],
		'rules' => array( 'required', 'email' ),
	),
	'terms' => array(
		'key'            => 'terms',
		'label'          => 'Terms and Conditions',
		'value'          => $_POST['terms'],
		'rules'          => array( 'required' ),
		'error_messages' => array(
			'required' => 'You must agree to the terms and conditions.',
		),
	),
) );

if ( $validated->is_valid() ) {
	// Do something if everything is valid.
} else {
	// Do something if there was an error. Display error messages.
	$messages = $validated->get_all_error_messages();
}
```

## Available Rules

Each rule is added to the `rules` argument individually for each piece of data.

Some rules contain arguments which let you further customize how the data is being compared and validated. To pass in an argument add a colon `:` after your rule key and then provide your argument value (`<rule>:<argument>`). You can see examples of rules with arguments below.

#### `boolean`
Usage: `boolean`, `boolean:strict`, `boolean:truthy`, `boolean:falsey`

Description: Checks that the value is a boolean value (`true` or `false`). You can also have it check for "truthy" (true, 1, 'true', '1', 'yes', 'on', 'truthy') or "falsey" (false, 0, 'false', '0', 'no', 'off', 'falsey') values.

#### `choices`
Usage: `choices:value1,value2,value3`

Description: Checks that the value is one of the provided choices. Each choice is separated by a comma.

#### `date`
Usage: `date:Y-m-d`

Description: Checks that the value is a date in the specified format. See <https://www.php.net/manual/en/datetime.format.php> for DateTime format options.

#### `email`
Usage: `email`

Description: Checks that the value is a valid email address.

#### `equals`
Usage: `equals:value`

Description: Checks that the value equals the provided value.

#### `letters`
Usage: `letters`

Description: Checks that the value only contains letters.

#### `matches`
Usage: `matches:my_field_key`

Description: Checks that the value matches the value of the specified key.

#### `maxlength`
Usage: `maxlength:20`

Description: Checks that the value character length is less than or equal to the provided number.

#### `maxnumber`
Usage: `maxnumber:2021`

Description: Checks that the value is less than or equal to the provided number.

#### `minlength`
Usage: `minlength:10`

Description: Checks that the value character length is greater than or equal to the provided number.

#### `minnumber`
Usage: `minnumber:1900`

Description: Checks that the value is greater than or equal to the provided number.

#### `numbers`
Usage: `numbers`

Description: Checks that the value only contains numbers.

#### `numeric`
Usage: `numeric`

Description: Checks that the value is numeric.

#### `regex`
Usage: `regex:/^([A-Za-z0-9_\-\.]*)$/`

Description: Checks that the value matches the given regular expression.

#### `required`
Usage: `required`

Description: Checks that the value is not empty.

#### `trim`
Usage: `trim`

Description: This is a special rule and simply trims whitespace from the left and right of the value.

#### `url`
Usage: `url`

Description: Checks that the value is a valid URL.

## Available Hooks

#### `nomad/validate/{$key}`

```
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
```

#### `nomad/validate/{$key}/{$rule_key}/error_message`

```
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
```

#### `nomad/validate/error_messages`

```
/**
 * Filter all error messages generated during validation, listed by data key.
 *
 * @since 1.0.0
 *
 * @param array Error messages generated during validation, listed by data key.
 */
$error_messages = apply_filters( 'nomad/validate/error_messages', $error_messages );
```

## Changelog

### v1.0.0
* Initial Release

## License

The MIT License (MIT). Please see [License File](https://github.com/jakesutherland/nomad-validate/blob/master/LICENSE) for more information.

## Copyright

Copyright (c) 2021 Jake Sutherland
