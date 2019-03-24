<?php
namespace Glacryl\Glshop\Tests\Unit\Controller;

/**
 * Test case.
 *
 * @author Petro Dikij <petro.dikij@glacryl.de>
 */
class CornereditingoptionControllerTest extends \TYPO3\TestingFramework\Core\Unit\UnitTestCase
{
    /**
     * @var \Glacryl\Glshop\Controller\CornereditingoptionController
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder(\Glacryl\Glshop\Controller\CornereditingoptionController::class)
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
    public function listActionFetchesAllCornereditingoptionsFromRepositoryAndAssignsThemToView()
    {

        $allCornereditingoptions = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $cornereditingoptionRepository = $this->getMockBuilder(\::class)
            ->setMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $cornereditingoptionRepository->expects(self::once())->method('findAll')->will(self::returnValue($allCornereditingoptions));
        $this->inject($this->subject, 'cornereditingoptionRepository', $cornereditingoptionRepository);

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $view->expects(self::once())->method('assign')->with('cornereditingoptions', $allCornereditingoptions);
        $this->inject($this->subject, 'view', $view);

        $this->subject->listAction();
    }

    /**
     * @test
     */
    public function showActionAssignsTheGivenCornereditingoptionToView()
    {
        $cornereditingoption = new \Glacryl\Glshop\Domain\Model\Cornereditingoption();

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $this->inject($this->subject, 'view', $view);
        $view->expects(self::once())->method('assign')->with('cornereditingoption', $cornereditingoption);

        $this->subject->showAction($cornereditingoption);
    }

    /**
     * @test
     */
    public function createActionAddsTheGivenCornereditingoptionToCornereditingoptionRepository()
    {
        $cornereditingoption = new \Glacryl\Glshop\Domain\Model\Cornereditingoption();

        $cornereditingoptionRepository = $this->getMockBuilder(\::class)
            ->setMethods(['add'])
            ->disableOriginalConstructor()
            ->getMock();

        $cornereditingoptionRepository->expects(self::once())->method('add')->with($cornereditingoption);
        $this->inject($this->subject, 'cornereditingoptionRepository', $cornereditingoptionRepository);

        $this->subject->createAction($cornereditingoption);
    }

    /**
     * @test
     */
    public function editActionAssignsTheGivenCornereditingoptionToView()
    {
        $cornereditingoption = new \Glacryl\Glshop\Domain\Model\Cornereditingoption();

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $this->inject($this->subject, 'view', $view);
        $view->expects(self::once())->method('assign')->with('cornereditingoption', $cornereditingoption);

        $this->subject->editAction($cornereditingoption);
    }

    /**
     * @test
     */
    public function updateActionUpdatesTheGivenCornereditingoptionInCornereditingoptionRepository()
    {
        $cornereditingoption = new \Glacryl\Glshop\Domain\Model\Cornereditingoption();

        $cornereditingoptionRepository = $this->getMockBuilder(\::class)
            ->setMethods(['update'])
            ->disableOriginalConstructor()
            ->getMock();

        $cornereditingoptionRepository->expects(self::once())->method('update')->with($cornereditingoption);
        $this->inject($this->subject, 'cornereditingoptionRepository', $cornereditingoptionRepository);

        $this->subject->updateAction($cornereditingoption);
    }

    /**
     * @test
     */
    public function deleteActionRemovesTheGivenCornereditingoptionFromCornereditingoptionRepository()
    {
        $cornereditingoption = new \Glacryl\Glshop\Domain\Model\Cornereditingoption();

        $cornereditingoptionRepository = $this->getMockBuilder(\::class)
            ->setMethods(['remove'])
            ->disableOriginalConstructor()
            ->getMock();

        $cornereditingoptionRepository->expects(self::once())->method('remove')->with($cornereditingoption);
        $this->inject($this->subject, 'cornereditingoptionRepository', $cornereditingoptionRepository);

        $this->subject->deleteAction($cornereditingoption);
    }
}
