<?php
namespace Glacryl\Glshop\Tests\Unit\Controller;

/**
 * Test case.
 *
 * @author Petro Dikij <petro.dikij@glacryl.de>
 */
class CornereditingControllerTest extends \TYPO3\TestingFramework\Core\Unit\UnitTestCase
{
    /**
     * @var \Glacryl\Glshop\Controller\CornereditingController
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder(\Glacryl\Glshop\Controller\CornereditingController::class)
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
    public function listActionFetchesAllCornereditingsFromRepositoryAndAssignsThemToView()
    {

        $allCornereditings = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $cornereditingRepository = $this->getMockBuilder(\Glacryl\Glshop\Domain\Repository\CornereditingRepository::class)
            ->setMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $cornereditingRepository->expects(self::once())->method('findAll')->will(self::returnValue($allCornereditings));
        $this->inject($this->subject, 'cornereditingRepository', $cornereditingRepository);

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $view->expects(self::once())->method('assign')->with('cornereditings', $allCornereditings);
        $this->inject($this->subject, 'view', $view);

        $this->subject->listAction();
    }

    /**
     * @test
     */
    public function showActionAssignsTheGivenCornereditingToView()
    {
        $cornerediting = new \Glacryl\Glshop\Domain\Model\Cornerediting();

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $this->inject($this->subject, 'view', $view);
        $view->expects(self::once())->method('assign')->with('cornerediting', $cornerediting);

        $this->subject->showAction($cornerediting);
    }

    /**
     * @test
     */
    public function createActionAddsTheGivenCornereditingToCornereditingRepository()
    {
        $cornerediting = new \Glacryl\Glshop\Domain\Model\Cornerediting();

        $cornereditingRepository = $this->getMockBuilder(\Glacryl\Glshop\Domain\Repository\CornereditingRepository::class)
            ->setMethods(['add'])
            ->disableOriginalConstructor()
            ->getMock();

        $cornereditingRepository->expects(self::once())->method('add')->with($cornerediting);
        $this->inject($this->subject, 'cornereditingRepository', $cornereditingRepository);

        $this->subject->createAction($cornerediting);
    }

    /**
     * @test
     */
    public function editActionAssignsTheGivenCornereditingToView()
    {
        $cornerediting = new \Glacryl\Glshop\Domain\Model\Cornerediting();

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $this->inject($this->subject, 'view', $view);
        $view->expects(self::once())->method('assign')->with('cornerediting', $cornerediting);

        $this->subject->editAction($cornerediting);
    }

    /**
     * @test
     */
    public function updateActionUpdatesTheGivenCornereditingInCornereditingRepository()
    {
        $cornerediting = new \Glacryl\Glshop\Domain\Model\Cornerediting();

        $cornereditingRepository = $this->getMockBuilder(\Glacryl\Glshop\Domain\Repository\CornereditingRepository::class)
            ->setMethods(['update'])
            ->disableOriginalConstructor()
            ->getMock();

        $cornereditingRepository->expects(self::once())->method('update')->with($cornerediting);
        $this->inject($this->subject, 'cornereditingRepository', $cornereditingRepository);

        $this->subject->updateAction($cornerediting);
    }

    /**
     * @test
     */
    public function deleteActionRemovesTheGivenCornereditingFromCornereditingRepository()
    {
        $cornerediting = new \Glacryl\Glshop\Domain\Model\Cornerediting();

        $cornereditingRepository = $this->getMockBuilder(\Glacryl\Glshop\Domain\Repository\CornereditingRepository::class)
            ->setMethods(['remove'])
            ->disableOriginalConstructor()
            ->getMock();

        $cornereditingRepository->expects(self::once())->method('remove')->with($cornerediting);
        $this->inject($this->subject, 'cornereditingRepository', $cornereditingRepository);

        $this->subject->deleteAction($cornerediting);
    }
}
