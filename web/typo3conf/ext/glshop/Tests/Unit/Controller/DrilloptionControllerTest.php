<?php
namespace Glacryl\Glshop\Tests\Unit\Controller;

/**
 * Test case.
 *
 * @author Petro Dikij <petro.dikij@glacryl.de>
 */
class DrilloptionControllerTest extends \TYPO3\TestingFramework\Core\Unit\UnitTestCase
{
    /**
     * @var \Glacryl\Glshop\Controller\DrilloptionController
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder(\Glacryl\Glshop\Controller\DrilloptionController::class)
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
    public function listActionFetchesAllDrilloptionsFromRepositoryAndAssignsThemToView()
    {

        $allDrilloptions = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $drilloptionRepository = $this->getMockBuilder(\::class)
            ->setMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $drilloptionRepository->expects(self::once())->method('findAll')->will(self::returnValue($allDrilloptions));
        $this->inject($this->subject, 'drilloptionRepository', $drilloptionRepository);

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $view->expects(self::once())->method('assign')->with('drilloptions', $allDrilloptions);
        $this->inject($this->subject, 'view', $view);

        $this->subject->listAction();
    }

    /**
     * @test
     */
    public function showActionAssignsTheGivenDrilloptionToView()
    {
        $drilloption = new \Glacryl\Glshop\Domain\Model\Drilloption();

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $this->inject($this->subject, 'view', $view);
        $view->expects(self::once())->method('assign')->with('drilloption', $drilloption);

        $this->subject->showAction($drilloption);
    }

    /**
     * @test
     */
    public function createActionAddsTheGivenDrilloptionToDrilloptionRepository()
    {
        $drilloption = new \Glacryl\Glshop\Domain\Model\Drilloption();

        $drilloptionRepository = $this->getMockBuilder(\::class)
            ->setMethods(['add'])
            ->disableOriginalConstructor()
            ->getMock();

        $drilloptionRepository->expects(self::once())->method('add')->with($drilloption);
        $this->inject($this->subject, 'drilloptionRepository', $drilloptionRepository);

        $this->subject->createAction($drilloption);
    }

    /**
     * @test
     */
    public function editActionAssignsTheGivenDrilloptionToView()
    {
        $drilloption = new \Glacryl\Glshop\Domain\Model\Drilloption();

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $this->inject($this->subject, 'view', $view);
        $view->expects(self::once())->method('assign')->with('drilloption', $drilloption);

        $this->subject->editAction($drilloption);
    }

    /**
     * @test
     */
    public function updateActionUpdatesTheGivenDrilloptionInDrilloptionRepository()
    {
        $drilloption = new \Glacryl\Glshop\Domain\Model\Drilloption();

        $drilloptionRepository = $this->getMockBuilder(\::class)
            ->setMethods(['update'])
            ->disableOriginalConstructor()
            ->getMock();

        $drilloptionRepository->expects(self::once())->method('update')->with($drilloption);
        $this->inject($this->subject, 'drilloptionRepository', $drilloptionRepository);

        $this->subject->updateAction($drilloption);
    }

    /**
     * @test
     */
    public function deleteActionRemovesTheGivenDrilloptionFromDrilloptionRepository()
    {
        $drilloption = new \Glacryl\Glshop\Domain\Model\Drilloption();

        $drilloptionRepository = $this->getMockBuilder(\::class)
            ->setMethods(['remove'])
            ->disableOriginalConstructor()
            ->getMock();

        $drilloptionRepository->expects(self::once())->method('remove')->with($drilloption);
        $this->inject($this->subject, 'drilloptionRepository', $drilloptionRepository);

        $this->subject->deleteAction($drilloption);
    }
}
