<?php
namespace Glacryl\Glshop\Tests\Unit\Controller;

/**
 * Test case.
 *
 * @author Petro Dikij <petro.dikij@glacryl.de>
 */
class FixingoptionControllerTest extends \TYPO3\TestingFramework\Core\Unit\UnitTestCase
{
    /**
     * @var \Glacryl\Glshop\Controller\FixingoptionController
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder(\Glacryl\Glshop\Controller\FixingoptionController::class)
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
    public function listActionFetchesAllFixingoptionsFromRepositoryAndAssignsThemToView()
    {

        $allFixingoptions = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $fixingoptionRepository = $this->getMockBuilder(\::class)
            ->setMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $fixingoptionRepository->expects(self::once())->method('findAll')->will(self::returnValue($allFixingoptions));
        $this->inject($this->subject, 'fixingoptionRepository', $fixingoptionRepository);

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $view->expects(self::once())->method('assign')->with('fixingoptions', $allFixingoptions);
        $this->inject($this->subject, 'view', $view);

        $this->subject->listAction();
    }

    /**
     * @test
     */
    public function showActionAssignsTheGivenFixingoptionToView()
    {
        $fixingoption = new \Glacryl\Glshop\Domain\Model\Fixingoption();

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $this->inject($this->subject, 'view', $view);
        $view->expects(self::once())->method('assign')->with('fixingoption', $fixingoption);

        $this->subject->showAction($fixingoption);
    }

    /**
     * @test
     */
    public function createActionAddsTheGivenFixingoptionToFixingoptionRepository()
    {
        $fixingoption = new \Glacryl\Glshop\Domain\Model\Fixingoption();

        $fixingoptionRepository = $this->getMockBuilder(\::class)
            ->setMethods(['add'])
            ->disableOriginalConstructor()
            ->getMock();

        $fixingoptionRepository->expects(self::once())->method('add')->with($fixingoption);
        $this->inject($this->subject, 'fixingoptionRepository', $fixingoptionRepository);

        $this->subject->createAction($fixingoption);
    }

    /**
     * @test
     */
    public function editActionAssignsTheGivenFixingoptionToView()
    {
        $fixingoption = new \Glacryl\Glshop\Domain\Model\Fixingoption();

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $this->inject($this->subject, 'view', $view);
        $view->expects(self::once())->method('assign')->with('fixingoption', $fixingoption);

        $this->subject->editAction($fixingoption);
    }

    /**
     * @test
     */
    public function updateActionUpdatesTheGivenFixingoptionInFixingoptionRepository()
    {
        $fixingoption = new \Glacryl\Glshop\Domain\Model\Fixingoption();

        $fixingoptionRepository = $this->getMockBuilder(\::class)
            ->setMethods(['update'])
            ->disableOriginalConstructor()
            ->getMock();

        $fixingoptionRepository->expects(self::once())->method('update')->with($fixingoption);
        $this->inject($this->subject, 'fixingoptionRepository', $fixingoptionRepository);

        $this->subject->updateAction($fixingoption);
    }

    /**
     * @test
     */
    public function deleteActionRemovesTheGivenFixingoptionFromFixingoptionRepository()
    {
        $fixingoption = new \Glacryl\Glshop\Domain\Model\Fixingoption();

        $fixingoptionRepository = $this->getMockBuilder(\::class)
            ->setMethods(['remove'])
            ->disableOriginalConstructor()
            ->getMock();

        $fixingoptionRepository->expects(self::once())->method('remove')->with($fixingoption);
        $this->inject($this->subject, 'fixingoptionRepository', $fixingoptionRepository);

        $this->subject->deleteAction($fixingoption);
    }
}
