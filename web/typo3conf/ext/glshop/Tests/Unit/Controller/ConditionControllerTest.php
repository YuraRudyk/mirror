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
 * Test case for class Glacryl\Glshop\Controller\ConditionController.
 *
 * @author Petro Dikij <petro.dikij@glacryl.de>
 */
class ConditionControllerTest extends \TYPO3\CMS\Core\Tests\UnitTestCase {

	/**
	 * @var \Glacryl\Glshop\Controller\ConditionController
	 */
	protected $subject = NULL;

	protected function setUp() {
		$this->subject = $this->getMock('Glacryl\\Glshop\\Controller\\ConditionController', array('redirect', 'forward', 'addFlashMessage'), array(), '', FALSE);
	}

	protected function tearDown() {
		unset($this->subject);
	}

	/**
	 * @test
	 */
	public function listActionFetchesAllConditionsFromRepositoryAndAssignsThemToView() {

		$allConditions = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array(), array(), '', FALSE);

		$conditionRepository = $this->getMock('Glacryl\\Glshop\\Domain\\Repository\\ConditionRepository', array('findAll'), array(), '', FALSE);
		$conditionRepository->expects($this->once())->method('findAll')->will($this->returnValue($allConditions));
		$this->inject($this->subject, 'conditionRepository', $conditionRepository);

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$view->expects($this->once())->method('assign')->with('conditions', $allConditions);
		$this->inject($this->subject, 'view', $view);

		$this->subject->listAction();
	}

	/**
	 * @test
	 */
	public function showActionAssignsTheGivenConditionToView() {
		$condition = new \Glacryl\Glshop\Domain\Model\Condition();

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$this->inject($this->subject, 'view', $view);
		$view->expects($this->once())->method('assign')->with('condition', $condition);

		$this->subject->showAction($condition);
	}

	/**
	 * @test
	 */
	public function newActionAssignsTheGivenConditionToView() {
		$condition = new \Glacryl\Glshop\Domain\Model\Condition();

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$view->expects($this->once())->method('assign')->with('newCondition', $condition);
		$this->inject($this->subject, 'view', $view);

		$this->subject->newAction($condition);
	}

	/**
	 * @test
	 */
	public function createActionAddsTheGivenConditionToConditionRepository() {
		$condition = new \Glacryl\Glshop\Domain\Model\Condition();

		$conditionRepository = $this->getMock('Glacryl\\Glshop\\Domain\\Repository\\ConditionRepository', array('add'), array(), '', FALSE);
		$conditionRepository->expects($this->once())->method('add')->with($condition);
		$this->inject($this->subject, 'conditionRepository', $conditionRepository);

		$this->subject->createAction($condition);
	}

	/**
	 * @test
	 */
	public function editActionAssignsTheGivenConditionToView() {
		$condition = new \Glacryl\Glshop\Domain\Model\Condition();

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$this->inject($this->subject, 'view', $view);
		$view->expects($this->once())->method('assign')->with('condition', $condition);

		$this->subject->editAction($condition);
	}

	/**
	 * @test
	 */
	public function updateActionUpdatesTheGivenConditionInConditionRepository() {
		$condition = new \Glacryl\Glshop\Domain\Model\Condition();

		$conditionRepository = $this->getMock('Glacryl\\Glshop\\Domain\\Repository\\ConditionRepository', array('update'), array(), '', FALSE);
		$conditionRepository->expects($this->once())->method('update')->with($condition);
		$this->inject($this->subject, 'conditionRepository', $conditionRepository);

		$this->subject->updateAction($condition);
	}

	/**
	 * @test
	 */
	public function deleteActionRemovesTheGivenConditionFromConditionRepository() {
		$condition = new \Glacryl\Glshop\Domain\Model\Condition();

		$conditionRepository = $this->getMock('Glacryl\\Glshop\\Domain\\Repository\\ConditionRepository', array('remove'), array(), '', FALSE);
		$conditionRepository->expects($this->once())->method('remove')->with($condition);
		$this->inject($this->subject, 'conditionRepository', $conditionRepository);

		$this->subject->deleteAction($condition);
	}
}
