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
 * Test case for class \Glacryl\Glshop\Domain\Model\Abatement.
 *
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @author Petro Dikij <petro.dikij@glacryl.de>
 */
class AbatementTest extends \TYPO3\CMS\Core\Tests\UnitTestCase {
	/**
	 * @var \Glacryl\Glshop\Domain\Model\Abatement
	 */
	protected $subject = NULL;

	protected function setUp() {
		$this->subject = new \Glacryl\Glshop\Domain\Model\Abatement();
	}

	protected function tearDown() {
		unset($this->subject);
	}

	/**
	 * @test
	 */
	public function getThreadReturnsInitialValueForFloat() {
		$this->assertSame(
			0.0,
			$this->subject->getThread()
		);
	}

	/**
	 * @test
	 */
	public function setThreadForFloatSetsThread() {
		$this->subject->setThread(3.14159265);

		$this->assertAttributeEquals(
			3.14159265,
			'thread',
			$this->subject,
			'',
			0.000000001
		);
	}

	/**
	 * @test
	 */
	public function getDrillReturnsInitialValueForFloat() {
		$this->assertSame(
			0.0,
			$this->subject->getDrill()
		);
	}

	/**
	 * @test
	 */
	public function setDrillForFloatSetsDrill() {
		$this->subject->setDrill(3.14159265);

		$this->assertAttributeEquals(
			3.14159265,
			'drill',
			$this->subject,
			'',
			0.000000001
		);
	}

	/**
	 * @test
	 */
	public function getAbatementReturnsInitialValueForFloat() {
		$this->assertSame(
			0.0,
			$this->subject->getAbatement()
		);
	}

	/**
	 * @test
	 */
	public function setAbatementForFloatSetsAbatement() {
		$this->subject->setAbatement(3.14159265);

		$this->assertAttributeEquals(
			3.14159265,
			'abatement',
			$this->subject,
			'',
			0.000000001
		);
	}

	/**
	 * @test
	 */
	public function getDepthReturnsInitialValueForFloat() {
		$this->assertSame(
			0.0,
			$this->subject->getDepth()
		);
	}

	/**
	 * @test
	 */
	public function setDepthForFloatSetsDepth() {
		$this->subject->setDepth(3.14159265);

		$this->assertAttributeEquals(
			3.14159265,
			'depth',
			$this->subject,
			'',
			0.000000001
		);
	}
}
