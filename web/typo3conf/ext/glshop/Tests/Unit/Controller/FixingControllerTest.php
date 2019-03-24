<?php
namespace Glacryl\Glshop\Tests\Unit\Controller;

/**
 * Test case.
 *
 * @author Petro Dikij <petro.dikij@glacryl.de>
 */
class FixingControllerTest extends \TYPO3\TestingFramework\Core\Unit\UnitTestCase
{
    /**
     * @var \Glacryl\Glshop\Controller\FixingController
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder(\Glacryl\Glshop\Controller\FixingController::class)
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
    public function listActionFetchesAllFixingsFromRepositoryAndAssignsThemToView()
    {

        $allFixings = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $fixingRepository = $this->getMockBuilder(\Glacryl\Glshop\Domain\Repository\FixingRepository::class)
            ->setMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $fixingRepository->expects(self::once())->method('findAll')->will(self::returnValue($allFixings));
        $this->inject($this->subject, 'fixingRepository', $fixingRepository);

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $view->expects(self::once())->method('assign')->with('fixings', $allFixings);
        $this->inject($this->subject, 'view', $view);

        $this->subject->listAction();
    }

    /**
     * @test
     */
    public function showActionAssignsTheGivenFixingToView()
    {
        $fixing = new \Glacryl\Glshop\Domain\Model\Fixing();

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $this->inject($this->subject, 'view', $view);
        $view->expects(self::once())->method('assign')->with('fixing', $fixing);

        $this->subject->showAction($fixing);
    }

    /**
     * @test
     */
    public function createActionAddsTheGivenFixingToFixingRepository()
    {
        $fixing = new \Glacryl\Glshop\Domain\Model\Fixing();

        $fixingRepository = $this->getMockBuilder(\Glacryl\Glshop\Domain\Repository\FixingRepository::class)
            ->setMethods(['add'])
            ->disableOriginalConstructor()
            ->getMock();

        $fixingRepository->expects(self::once())->method('add')->with($fixing);
        $this->inject($this->subject, 'fixingRepository', $fixingRepository);

        $this->subject->createAction($fixing);
    }

    /**
     * @test
     */
    public function editActionAssignsTheGivenFixingToView()
    {
        $fixing = new \Glacryl\Glshop\Domain\Model\Fixing();

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $this->inject($this->subject, 'view', $view);
        $view->expects(self::once())->method('assign')->with('fixing', $fixing);

        $this->subject->editAction($fixing);
    }

    /**
     * @test
     */
    public function updateActionUpdatesTheGivenFixingInFixingRepository()
    {
        $fixing = new \Glacryl\Glshop\Domain\Model\Fixing();

        $fixingRepository = $this->getMockBuilder(\Glacryl\Glshop\Domain\Repository\FixingRepository::class)
            ->setMethods(['update'])
            ->disableOriginalConstructor()
            ->getMock();

        $fixingRepository->expects(self::once())->method('update')->with($fixing);
        $this->inject($this->subject, 'fixingRepository', $fixingRepository);

        $this->subject->updateAction($fixing);
    }

    /**
     * @test
     */
    public function deleteActionRemovesTheGivenFixingFromFixingRepository()
    {
        $fixing = new \Glacryl\Glshop\Domain\Model\Fixing();

        $fixingRepository = $this->getMockBuilder(\Glacryl\Glshop\Domain\Repository\FixingRepository::class)
            ->setMethods(['remove'])
            ->disableOriginalConstructor()
            ->getMock();

        $fixingRepository->expects(self::once())->method('remove')->with($fixing);
        $this->inject($this->subject, 'fixingRepository', $fixingRepository);

        $this->subject->deleteAction($fixing);
    }
}
