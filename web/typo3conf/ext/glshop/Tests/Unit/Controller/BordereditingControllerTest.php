<?php
namespace Glacryl\Glshop\Tests\Unit\Controller;

/**
 * Test case.
 *
 * @author Petro Dikij <petro.dikij@glacryl.de>
 */
class BordereditingControllerTest extends \TYPO3\TestingFramework\Core\Unit\UnitTestCase
{
    /**
     * @var \Glacryl\Glshop\Controller\BordereditingController
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder(\Glacryl\Glshop\Controller\BordereditingController::class)
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
    public function listActionFetchesAllBordereditingsFromRepositoryAndAssignsThemToView()
    {

        $allBordereditings = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $bordereditingRepository = $this->getMockBuilder(\Glacryl\Glshop\Domain\Repository\BordereditingRepository::class)
            ->setMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $bordereditingRepository->expects(self::once())->method('findAll')->will(self::returnValue($allBordereditings));
        $this->inject($this->subject, 'bordereditingRepository', $bordereditingRepository);

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $view->expects(self::once())->method('assign')->with('bordereditings', $allBordereditings);
        $this->inject($this->subject, 'view', $view);

        $this->subject->listAction();
    }

    /**
     * @test
     */
    public function showActionAssignsTheGivenBordereditingToView()
    {
        $borderediting = new \Glacryl\Glshop\Domain\Model\Borderediting();

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $this->inject($this->subject, 'view', $view);
        $view->expects(self::once())->method('assign')->with('borderediting', $borderediting);

        $this->subject->showAction($borderediting);
    }

    /**
     * @test
     */
    public function createActionAddsTheGivenBordereditingToBordereditingRepository()
    {
        $borderediting = new \Glacryl\Glshop\Domain\Model\Borderediting();

        $bordereditingRepository = $this->getMockBuilder(\Glacryl\Glshop\Domain\Repository\BordereditingRepository::class)
            ->setMethods(['add'])
            ->disableOriginalConstructor()
            ->getMock();

        $bordereditingRepository->expects(self::once())->method('add')->with($borderediting);
        $this->inject($this->subject, 'bordereditingRepository', $bordereditingRepository);

        $this->subject->createAction($borderediting);
    }

    /**
     * @test
     */
    public function editActionAssignsTheGivenBordereditingToView()
    {
        $borderediting = new \Glacryl\Glshop\Domain\Model\Borderediting();

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $this->inject($this->subject, 'view', $view);
        $view->expects(self::once())->method('assign')->with('borderediting', $borderediting);

        $this->subject->editAction($borderediting);
    }

    /**
     * @test
     */
    public function updateActionUpdatesTheGivenBordereditingInBordereditingRepository()
    {
        $borderediting = new \Glacryl\Glshop\Domain\Model\Borderediting();

        $bordereditingRepository = $this->getMockBuilder(\Glacryl\Glshop\Domain\Repository\BordereditingRepository::class)
            ->setMethods(['update'])
            ->disableOriginalConstructor()
            ->getMock();

        $bordereditingRepository->expects(self::once())->method('update')->with($borderediting);
        $this->inject($this->subject, 'bordereditingRepository', $bordereditingRepository);

        $this->subject->updateAction($borderediting);
    }

    /**
     * @test
     */
    public function deleteActionRemovesTheGivenBordereditingFromBordereditingRepository()
    {
        $borderediting = new \Glacryl\Glshop\Domain\Model\Borderediting();

        $bordereditingRepository = $this->getMockBuilder(\Glacryl\Glshop\Domain\Repository\BordereditingRepository::class)
            ->setMethods(['remove'])
            ->disableOriginalConstructor()
            ->getMock();

        $bordereditingRepository->expects(self::once())->method('remove')->with($borderediting);
        $this->inject($this->subject, 'bordereditingRepository', $bordereditingRepository);

        $this->subject->deleteAction($borderediting);
    }
}
