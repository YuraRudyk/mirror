<?php
namespace Glacryl\Glshop\Tests\Unit\Controller;

/**
 * Test case.
 *
 * @author Petro Dikij <petro.dikij@glacryl.de>
 */
class DrillControllerTest extends \TYPO3\TestingFramework\Core\Unit\UnitTestCase
{
    /**
     * @var \Glacryl\Glshop\Controller\DrillController
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder(\Glacryl\Glshop\Controller\DrillController::class)
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
    public function listActionFetchesAllDrillsFromRepositoryAndAssignsThemToView()
    {

        $allDrills = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $drillRepository = $this->getMockBuilder(\Glacryl\Glshop\Domain\Repository\DrillRepository::class)
            ->setMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $drillRepository->expects(self::once())->method('findAll')->will(self::returnValue($allDrills));
        $this->inject($this->subject, 'drillRepository', $drillRepository);

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $view->expects(self::once())->method('assign')->with('drills', $allDrills);
        $this->inject($this->subject, 'view', $view);

        $this->subject->listAction();
    }

    /**
     * @test
     */
    public function showActionAssignsTheGivenDrillToView()
    {
        $drill = new \Glacryl\Glshop\Domain\Model\Drill();

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $this->inject($this->subject, 'view', $view);
        $view->expects(self::once())->method('assign')->with('drill', $drill);

        $this->subject->showAction($drill);
    }

    /**
     * @test
     */
    public function createActionAddsTheGivenDrillToDrillRepository()
    {
        $drill = new \Glacryl\Glshop\Domain\Model\Drill();

        $drillRepository = $this->getMockBuilder(\Glacryl\Glshop\Domain\Repository\DrillRepository::class)
            ->setMethods(['add'])
            ->disableOriginalConstructor()
            ->getMock();

        $drillRepository->expects(self::once())->method('add')->with($drill);
        $this->inject($this->subject, 'drillRepository', $drillRepository);

        $this->subject->createAction($drill);
    }

    /**
     * @test
     */
    public function editActionAssignsTheGivenDrillToView()
    {
        $drill = new \Glacryl\Glshop\Domain\Model\Drill();

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $this->inject($this->subject, 'view', $view);
        $view->expects(self::once())->method('assign')->with('drill', $drill);

        $this->subject->editAction($drill);
    }

    /**
     * @test
     */
    public function updateActionUpdatesTheGivenDrillInDrillRepository()
    {
        $drill = new \Glacryl\Glshop\Domain\Model\Drill();

        $drillRepository = $this->getMockBuilder(\Glacryl\Glshop\Domain\Repository\DrillRepository::class)
            ->setMethods(['update'])
            ->disableOriginalConstructor()
            ->getMock();

        $drillRepository->expects(self::once())->method('update')->with($drill);
        $this->inject($this->subject, 'drillRepository', $drillRepository);

        $this->subject->updateAction($drill);
    }

    /**
     * @test
     */
    public function deleteActionRemovesTheGivenDrillFromDrillRepository()
    {
        $drill = new \Glacryl\Glshop\Domain\Model\Drill();

        $drillRepository = $this->getMockBuilder(\Glacryl\Glshop\Domain\Repository\DrillRepository::class)
            ->setMethods(['remove'])
            ->disableOriginalConstructor()
            ->getMock();

        $drillRepository->expects(self::once())->method('remove')->with($drill);
        $this->inject($this->subject, 'drillRepository', $drillRepository);

        $this->subject->deleteAction($drill);
    }
}
