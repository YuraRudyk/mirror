<?php
namespace Glacryl\Glshop\Tests\Unit\Controller;
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
 * Test case for class Glacryl\Glshop\Controller\AbatementController.
 *
 * @author Petro Dikij <petro.dikij@glacryl.de>
 */
class AbatementControllerTest extends \TYPO3\CMS\Core\Tests\UnitTestCase {

	/**
	 * @var \Glacryl\Glshop\Controller\AbatementController
	 */
	protected $subject = NULL;

	protected function setUp() {
		$this->subject = $this->getMock('Glacryl\\Glshop\\Controller\\AbatementController', array('redirect', 'forward', 'addFlashMessage'), array(), '', FALSE);
	}

	protected function tearDown() {
		unset($this->subject);
	}

	/**
	 * @test
	 */
	public function listActionFetchesAllAbatementsFromRepositoryAndAssignsThemToView() {

		$allAbatements = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array(), array(), '', FALSE);

		$abatementRepository = $this->getMock('Glacryl\\Glshop\\Domain\\Repository\\AbatementRepository', array('findAll'), array(), '', FALSE);
		$abatementRepository->expects($this->once())->method('findAll')->will($this->returnValue($allAbatements));
		$this->inject($this->subject, 'abatementRepository', $abatementRepository);

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$view->expects($this->once())->method('assign')->with('abatements', $allAbatements);
		$this->inject($this->subject, 'view', $view);

		$this->subject->listAction();
	}

	/**
	 * @test
	 */
	public function showActionAssignsTheGivenAbatementToView() {
		$abatement = new \Glacryl\Glshop\Domain\Model\Abatement();

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$this->inject($this->subject, 'view', $view);
		$view->expects($this->once())->method('assign')->with('abatement', $abatement);

		$this->subject->showAction($abatement);
	}

	/**
	 * @test
	 */
	public function newActionAssignsTheGivenAbatementToView() {
		$abatement = new \Glacryl\Glshop\Domain\Model\Abatement();

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$view->expects($this->once())->method('assign')->with('newAbatement', $abatement);
		$this->inject($this->subject, 'view', $view);

		$this->subject->newAction($abatement);
	}

	/**
	 * @test
	 */
	public function createActionAddsTheGivenAbatementToAbatementRepository() {
		$abatement = new \Glacryl\Glshop\Domain\Model\Abatement();

		$abatementRepository = $this->getMock('Glacryl\\Glshop\\Domain\\Repository\\AbatementRepository', array('add'), array(), '', FALSE);
		$abatementRepository->expects($this->once())->method('add')->with($abatement);
		$this->inject($this->subject, 'abatementRepository', $abatementRepository);

		$this->subject->createAction($abatement);
	}

	/**
	 * @test
	 */
	public function editActionAssignsTheGivenAbatementToView() {
		$abatement = new \Glacryl\Glshop\Domain\Model\Abatement();

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$this->inject($this->subject, 'view', $view);
		$view->expects($this->once())->method('assign')->with('abatement', $abatement);

		$this->subject->editAction($abatement);
	}

	/**
	 * @test
	 */
	public function updateActionUpdatesTheGivenAbatementInAbatementRepository() {
		$abatement = new \Glacryl\Glshop\Domain\Model\Abatement();

		$abatementRepository = $this->getMock('Glacryl\\Glshop\\Domain\\Repository\\AbatementRepository', array('update'), array(), '', FALSE);
		$abatementRepository->expects($this->once())->method('update')->with($abatement);
		$this->inject($this->subject, 'abatementRepository', $abatementRepository);

		$this->subject->updateAction($abatement);
	}

	/**
	 * @test
	 */
	public function deleteActionRemovesTheGivenAbatementFromAbatementRepository() {
		$abatement = new \Glacryl\Glshop\Domain\Model\Abatement();

		$abatementRepository = $this->getMock('Glacryl\\Glshop\\Domain\\Repository\\AbatementRepository', array('remove'), array(), '', FALSE);
		$abatementRepository->expects($this->once())->method('remove')->with($abatement);
		$this->inject($this->subject, 'abatementRepository', $abatementRepository);

		$this->subject->deleteAction($abatement);
	}
}
