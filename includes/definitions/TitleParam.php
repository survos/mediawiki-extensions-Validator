<?php

/**
 * Defines the title parameter type.
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
class TitleParam extends ParamDefinition {

	/**
	 * @var boolean
	 */
	protected $hasToExist = true;

	/**
	 * @var array of Title|null
	 */
	protected $title = array();

	/**
	 * Returns an identifier for the parameter type.
	 * @since 0.5
	 * @return string
	 */
	public function getType() {
		return 'title';
	}

	/**
	 * @since 0.5
	 * @param boolean $hasToExist
	 */
	public function setHasToExist( $hasToExist ) {
		$this->hasToExist = $hasToExist;
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
		$title = Title::newFromText( $value );

		if( is_null( $title ) ) {
			return false;
		}

		$this->titles[$value] = $title;

		return $this->hasToExist ? $title->isKnown() : true;
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
	 * @return mixed
	 */
	protected function formatValue( $value, Param $param, array $definitions, array $params ) {
		return $this->title[$value];
	}

}