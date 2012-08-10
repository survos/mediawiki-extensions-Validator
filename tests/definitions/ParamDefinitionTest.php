<?php

/**
 * Unit test base for ParamDefinition deriving classes.
 *
 * @file
 * @since 0.5
 *
 * @ingroup Validator
 * @ingroup Test
 *
 * @group Validator
 * @group ParamDefinition
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
abstract class ParamDefinitionTest extends MediaWikiTestCase {

	public abstract function valueProvider();

	public abstract function getType();

	public function getDefinitions() {
		$params = array();

		$params['empty'] = array();

		$params['values'] = array(
			'values' => array( 'foo', '1', '0.1', 'yes', 1, 0.1 )
		);

		return $params;
	}

	public function definitionProvider() {
		$definitions = $this->getDefinitions();

		foreach ( $definitions as &$definition ) {
			$definition['type'] = $this->getType();
		}

		return $definitions;
	}

	public function instanceProvider() {
		$definitions = array();

		foreach ( $this->definitionProvider() as $name => $definition ) {
			if ( !array_key_exists( 'message', $definition ) ) {
				$definition['message'] = 'test-' . $name;
			}

			$definition['name'] = $name;
			$definitions[] = array( ParamDefinition::newFromArray( $definition ) );
		}

		return $definitions;
	}

	/**
	 * @dataProvider instanceProvider
	 */
	public function testGetType( IParamDefinition $definition )  {
		$this->assertEquals( $this->getType(), $definition->getType() );
	}

	/**
	 * @dataProvider instanceProvider
	 */
	public function testValidate( IParamDefinition $definition ) {
		$values = $this->valueProvider();

		foreach ( $values[$definition->getName()] as $data ) {
			list( $input, $valid, ) = $data;

			$param = new Param( $definition );
			$param->setUserValue( $definition->getName(), $input );

			$this->assertEquals(
				$valid,
				$definition->validate( $param, array(), array() ) === true
			);
		}
	}

	/**
	 * @dataProvider instanceProvider
	 */
	public function testFormat( IParamDefinition $sourceDefinition ) {
		$values = $this->valueProvider();

		foreach ( $values[$sourceDefinition->getName()] as $data ) {
			$definition = clone $sourceDefinition;

			list( $input, $valid, ) = $data;

			$param = new Param( $definition );
			$param->setUserValue( $definition->getName(), $input );

			if ( $valid && array_key_exists( 2, $data ) ) {
				$defs = array();
				$definition->format( $param, $defs, array() );

				$this->assertEquals(
					$data[2],
					$param->getValue()
				);
			}
		}
	}

}