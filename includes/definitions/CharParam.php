<?php

/**
 * Defines the char parameter type.
 * Specifies the type specific validation and formatting logic.
 *
 * @since 0.5
 *
 * @file
 * @ingroup Validator
 * @ingroup ParamDefinition
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class CharParam extends StringParam {

	/**
	 * Returns an identifier for the parameter type.
	 * @since 0.5
	 * @return string
	 */
	public function getType() {
		return 'char';
	}

	/**
	 * Formats the parameter value to it's final result.
	 *
	 * @since 0.5
	 *
	 * @param $value mixed
	 * @param $param Param
	 * @param $definitions array of ParamDefinition
	 * @param $params array of Param
	 *
	 * @return boolean
	 */
	protected function validateValue( $value, Param $param, array $definitions, array $params ) {
		return strlen( $param->getValue() ) === 1;
	}

}