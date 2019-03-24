<?php
namespace Glacryl\Glshop\Tests\Unit\Controller;

/**
 * Test case.
 *
 * @author Petro Dikij <petro.dikij@glacryl.de>
 */
class BordereditingoptionControllerTest extends \TYPO3\TestingFramework\Core\Unit\UnitTestCase
{
    /**
     * @var \Glacryl\Glshop\Controller\BordereditingoptionController
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder(\Glacryl\Glshop\Controller\BordereditingoptionController::class)
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
    public function listActionFetchesAllBordereditingoptionsFromRepositoryAndAssignsThemToView()
    {

        $allBordereditingoptions = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $bordereditingoptionRepository = $this->getMockBuilder(\::class)
            ->setMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $bordereditingoptionRepository->expects(self::once())->method('findAll')->will(self::returnValue($allBordereditingoptions));
        $this->inject($this->subject, 'bordereditingoptionRepository', $bordereditingoptionRepository);

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $view->expects(self::once())->method('assign')->with('bordereditingoptions', $allBordereditingoptions);
        $this->inject($this->subject, 'view', $view);

        $this->subject->listAction();
    }

    /**
     * @test
     */
    public function showActionAssignsTheGivenBordereditingoptionToView()
    {
        $bordereditingoption = new \Glacryl\Glshop\Domain\Model\Bordereditingoption();

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $this->inject($this->subject, 'view', $view);
        $view->expects(self::once())->method('assign')->with('bordereditingoption', $bordereditingoption);

        $this->subject->showAction($bordereditingoption);
    }

    /**
     * @test
     */
    public function createActionAddsTheGivenBordereditingoptionToBordereditingoptionRepository()
    {
        $bordereditingoption = new \Glacryl\Glshop\Domain\Model\Bordereditingoption();

        $bordereditingoptionRepository = $this->getMockBuilder(\::class)
            ->setMethods(['add'])
            ->disableOriginalConstructor()
            ->getMock();

        $bordereditingoptionRepository->expects(self::once())->method('add')->with($bordereditingoption);
        $this->inject($this->subject, 'bordereditingoptionRepository', $bordereditingoptionRepository);

        $this->subject->createAction($bordereditingoption);
    }

    /**
     * @test
     */
    public function editActionAssignsTheGivenBordereditingoptionToView()
    {
        $bordereditingoption = new \Glacryl\Glshop\Domain\Model\Bordereditingoption();

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $this->inject($this->subject, 'view', $view);
        $view->expects(self::once())->method('assign')->with('bordereditingoption', $bordereditingoption);

        $this->subject->editAction($bordereditingoption);
    }

    /**
     * @test
     */
    public function updateActionUpdatesTheGivenBordereditingoptionInBordereditingoptionRepository()
    {
        $bordereditingoption = new \Glacryl\Glshop\Domain\Model\Bordereditingoption();

        $bordereditingoptionRepository = $this->getMockBuilder(\::class)
            ->setMethods(['update'])
            ->disableOriginalConstructor()
            ->getMock();

        $bordereditingoptionRepository->expects(self::once())->method('update')->with($bordereditingoption);
        $this->inject($this->subject, 'bordereditingoptionRepository', $bordereditingoptionRepository);

        $this->subject->updateAction($bordereditingoption);
    }

    /**
     * @test
     */
    public function deleteActionRemovesTheGivenBordereditingoptionFromBordereditingoptionRepository()
    {
        $bordereditingoption = new \Glacryl\Glshop\Domain\Model\Bordereditingoption();

        $bordereditingoptionRepository = $this->getMockBuilder(\::class)
            ->setMethods(['remove'])
            ->disableOriginalConstructor()
            ->getMock();

        $bordereditingoptionRepository->expects(self::once())->method('remove')->with($bordereditingoption);
        $this->inject($this->subject, 'bordereditingoptionRepository', $bordereditingoptionRepository);

        $this->subject->deleteAction($bordereditingoption);
    }
}
