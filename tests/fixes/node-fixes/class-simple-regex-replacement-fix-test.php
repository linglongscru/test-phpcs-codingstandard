<?php
/**
 *  This file is part of PHP-Typography.
 *
 *  Copyright 2015-2017 Peter Putzer.
 *
 *  This program is free software; you can redistribute it and/or
 *  modify it under the terms of the GNU General Public License
 *  as published by the Free Software Foundation; either version 2
 *  of the License, or ( at your option ) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program; if not, write to the Free Software
 *  Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 *
 *  @package mundschenk-at/php-typography/tests
 *  @license http://www.gnu.org/licenses/gpl-2.0.html
 */

namespace PHP_Typography\Tests\Fixes\Node_Fixes;

use \PHP_Typography\Fixes\Node_Fixes;
use \PHP_Typography\Settings;

/**
 * Simple_Regex_Replacement_Fix unit test.
 *
 * @coversDefaultClass \PHP_Typography\Fixes\Node_Fixes\Simple_Regex_Replacement_Fix
 * @usesDefaultClass \PHP_Typography\Fixes\Node_Fixes\Simple_Regex_Replacement_Fix
 *
 * @uses ::__construct
 * @uses PHP_Typography\Fixes\Node_Fixes\Abstract_Node_Fix::__construct
 * @uses PHP_Typography\Fixes\Node_Fixes\Classes_Dependent_Fix::__construct
 * @uses PHP_Typography\Fixes\Node_Fixes\Simple_Regex_Replacement_Fix::__construct
 * @uses PHP_Typography\Arrays
 * @uses PHP_Typography\DOM
 * @uses PHP_Typography\Settings
 * @uses PHP_Typography\Settings\Dash_Style
 * @uses PHP_Typography\Settings\Quote_Style
 * @uses PHP_Typography\Settings\Simple_Dashes
 * @uses PHP_Typography\Settings\Simple_Quotes
 * @uses PHP_Typography\Strings
 */
class Simple_Regex_Replacement_Fix_Test extends Node_Fix_Testcase {

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	protected function setUp() { // @codingStandardsIgnoreLine
		parent::setUp();
	}

	/**
	 * Tests the constructor.
	 *
	 * @covers ::__construct
	 */
	public function test_constructor() {
		$this->fix = $this->getMockForAbstractClass( Node_Fixes\Simple_Regex_Replacement_Fix::class, [ '/(.*)/', '*$1*', 'fooBar' ] );

		$this->assertAttributeEquals( '/(.*)/', 'regex',           $this->fix );
		$this->assertAttributeEquals( 'fooBar', 'settings_switch', $this->fix );
		$this->assertAttributeEquals( '*$1*',   'replacement',     $this->fix );
	}

	/**
	 * Provide data for testing apply_internal.
	 *
	 * @return array
	 */
	public function provide_apply_data() {
		return [
			[ 'foo & bar', '*foo & bar*' ],
		];
	}

	/**
	 * Test apply.
	 *
	 * @covers ::apply
	 *
	 * @uses PHP_Typography\Text_Parser
	 * @uses PHP_Typography\Text_Parser\Token
	 *
	 * @dataProvider provide_apply_data
	 *
	 * @param string $input  HTML input.
	 * @param string $result Expected result.
	 */
	public function test_apply( $input, $result ) {
		$this->fix = $this->getMockForAbstractClass( Node_Fixes\Simple_Regex_Replacement_Fix::class, [ '/(.+)/u', '*$1*', 'styleAmpersands' ] );
		$this->s->set_style_ampersands( true );

		$this->assertFixResultSame( $input, $result );
	}

	/**
	 * Test apply.
	 *
	 * @covers ::apply
	 *
	 * @uses PHP_Typography\Text_Parser
	 * @uses PHP_Typography\Text_Parser\Token
	 *
	 * @dataProvider provide_apply_data
	 *
	 * @param string $input  HTML input.
	 * @param string $result Expected result.
	 */
	public function test_apply_off( $input, $result ) {
		$this->fix = $this->getMockForAbstractClass( Node_Fixes\Simple_Regex_Replacement_Fix::class, [ '/(.+)/u', '*$1*', 'styleAmpersands' ] );
		$this->s->set_style_ampersands( false );

		$this->assertFixResultSame( $input, $input );
	}
}
