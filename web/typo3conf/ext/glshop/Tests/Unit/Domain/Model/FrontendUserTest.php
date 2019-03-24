<?php

namespace Glacryl\Glshop\Tests\Unit\Domain\Model;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2014 Petro Dikij <petro.dikij@glacryl.de>, Glacryl Hedel GmbH
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * Test case for class \Glacryl\Glshop\Domain\Model\FrontendUser.
 *
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @author Petro Dikij <petro.dikij@glacryl.de>
 */
class FrontendUserTest extends \TYPO3\CMS\Core\Tests\UnitTestCase {
	/**
	 * @var \Glacryl\Glshop\Domain\Model\FrontendUser
	 */
	protected $subject = NULL;

	protected function setUp() {
		$this->subject = new \Glacryl\Glshop\Domain\Model\FrontendUser();
	}

	protected function tearDown() {
		unset($this->subject);
	}

	/**
	 * @test
	 */
	public function getUstIdReturnsInitialValueForString() {
		$this->assertSame(
			'',
			$this->subject->getUstId()
		);
	}

	/**
	 * @test
	 */
	public function setUstIdForStringSetsUstId() {
		$this->subject->setUstId('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'ustId',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getKdNrReturnsInitialValueForInteger() {
		$this->assertSame(
			0,
			$this->subject->getKdNr()
		);
	}

	/**
	 * @test
	 */
	public function setKdNrForIntegerSetsKdNr() {
		$this->subject->setKdNr(12);

		$this->assertAttributeEquals(
			12,
			'kdNr',
			$this->subject
		);
	}
}
