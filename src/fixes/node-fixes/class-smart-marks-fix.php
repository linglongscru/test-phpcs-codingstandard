<?php
/**
 *  This file is part of PHP-Typography.
 *
 *  Copyright 2017 Peter Putzer.
 *
 *  This program is free software; you can redistribute it and/or
 *  modify it under the terms of the GNU General Public License
 *  as published by the Free Software Foundation; either version 2
 *  of the License, or (at your option) any later version.
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
 *  ***
 *
 *  @package mundschenk-at/php-typography
 *  @license http://www.gnu.org/licenses/gpl-2.0.html
 */

namespace PHP_Typography\Fixes\Node_Fixes;

use \PHP_Typography\DOM;
use \PHP_Typography\RE;
use \PHP_Typography\Settings;
use \PHP_Typography\U;

/**
 * Applies smart marks (if enabled).
 *
 * @author Peter Putzer <github@mundschenk.at>
 *
 * @since 5.0.0
 */
class Smart_Marks_Fix extends Abstract_Node_Fix {

	const ESCAPE_501C = '/\b(501\()(c)(\)\((?:[1-9]|[1-2][0-9])\))/u';

	/**
	 * Apply the fix to a given textnode.
	 *
	 * @param \DOMText $textnode Required.
	 * @param Settings $settings Required.
	 * @param bool     $is_title Optional. Default false.
	 */
	public function apply( \DOMText $textnode, Settings $settings, $is_title = false ) {
		if ( empty( $settings['smartMarks'] ) ) {
			return;
		}

		// Escape usage of "501(c)(1...29)" (US non-profit).
		$textnode->data = preg_replace( self::ESCAPE_501C, '$1' . RE::ESCAPE_MARKER . '$2' . RE::ESCAPE_MARKER . '$3', $textnode->data );

		// Replace marks.
		$textnode->data = str_replace( [ '(c)', '(C)' ],   U::COPYRIGHT,      $textnode->data );
		$textnode->data = str_replace( [ '(r)', '(R)' ],   U::REGISTERED_MARK, $textnode->data );
		$textnode->data = str_replace( [ '(p)', '(P)' ],   U::SOUND_COPY_MARK,  $textnode->data );
		$textnode->data = str_replace( [ '(sm)', '(SM)' ], U::SERVICE_MARK,    $textnode->data );
		$textnode->data = str_replace( [ '(tm)', '(TM)' ], U::TRADE_MARK,      $textnode->data );

		// Un-escape escaped sequences.
		$textnode->data = str_replace( RE::ESCAPE_MARKER, '', $textnode->data );
	}
}
