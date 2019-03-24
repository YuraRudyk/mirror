<?php
namespace Glacryl\Glshop\Tests\Unit\Controller;

/**
 * Test case.
 *
 * @author Petro Dikij <petro.dikij@glacryl.de>
 */
class ConditionsControllerTest extends \TYPO3\TestingFramework\Core\Unit\UnitTestCase
{
    /**
     * @var \Glacryl\Glshop\Controller\ConditionsController
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder(\Glacryl\Glshop\Controller\ConditionsController::class)
            ->setMethods(['redirect', 'forward', 'addFlashMessage'])
            ->disableOriginalConstructor()
            ->getMock();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function listActionFetchesAllConditionssFromRepositoryAndAssignsThemToView()
    {

        $allConditionss = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $conditionsRepository = $this->getMockBuilder(\Glacryl\Glshop\Domain\Repository\ConditionsRepository::class)
            ->setMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $conditionsRepository->expects(self::once())->method('findAll')->will(self::returnValue($allConditionss));
        $this->inject($this->subject, 'conditionsRepository', $conditionsRepository);

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $view->expects(self::once())->method('assign')->with('conditionss', $allConditionss);
        $this->inject($this->subject, 'view', $view);

        $this->subject->listAction();
    }

    /**
     * @test
     */
    public function showActionAssignsTheGivenConditionsToView()
    {
        $conditions = new \Glacryl\Glshop\Domain\Model\Conditions();

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $this->inject($this->subject, 'view', $view);
        $view->expects(self::once())->method('assign')->with('conditions', $conditions);

        $this->subject->showAction($conditions);
    }

    /**
     * @test
     */
    public function createActionAddsTheGivenConditionsToConditionsRepository()
    {
        $conditions = new \Glacryl\Glshop\Domain\Model\Conditions();

        $conditionsRepository = $this->getMockBuilder(\Glacryl\Glshop\Domain\Repository\ConditionsRepository::class)
            ->setMethods(['add'])
            ->disableOriginalConstructor()
            ->getMock();

        $conditionsRepository->expects(self::once())->method('add')->with($conditions);
        $this->inject($this->subject, 'conditionsRepository', $conditionsRepository);

        $this->subject->createAction($conditions);
    }

    /**
     * @test
     */
    public function editActionAssignsTheGivenConditionsToView()
    {
        $conditions = new \Glacryl\Glshop\Domain\Model\Conditions();

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $this->inject($this->subject, 'view', $view);
        $view->expects(self::once())->method('assign')->with('conditions', $conditions);

        $this->subject->editAction($conditions);
    }

    /**
     * @test
     */
    public function updateActionUpdatesTheGivenConditionsInConditionsRepository()
    {
        $conditions = new \Glacryl\Glshop\Domain\Model\Conditions();

        $conditionsRepository = $this->getMockBuilder(\Glacryl\Glshop\Domain\Repository\ConditionsRepository::class)
            ->setMethods(['update'])
            ->disableOriginalConstructor()
            ->getMock();

        $conditionsRepository->expects(self::once())->method('update')->with($conditions);
        $this->inject($this->subject, 'conditionsRepository', $conditionsRepository);

        $this->subject->updateAction($conditions);
    }

    /**
     * @test
     */
    public function deleteActionRemovesTheGivenConditionsFromConditionsRepository()
    {
        $conditions = new \Glacryl\Glshop\Domain\Model\Conditions();

        $conditionsRepository = $this->getMockBuilder(\Glacryl\Glshop\Domain\Repository\ConditionsRepository::class)
            ->setMethods(['remove'])
            ->disableOriginalConstructor()
            ->getMock();

        $conditionsRepository->expects(self::once())->method('remove')->with($conditions);
        $this->inject($this->subject, 'conditionsRepository', $conditionsRepository);

        $this->subject->deleteAction($conditions);
    }
}
