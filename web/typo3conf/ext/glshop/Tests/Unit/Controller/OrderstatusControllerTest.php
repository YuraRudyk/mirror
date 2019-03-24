<?php
namespace Glacryl\Glshop\Tests\Unit\Controller;

/**
 * Test case.
 *
 * @author Petro Dikij <petro.dikij@glacryl.de>
 */
class OrderstatusControllerTest extends \TYPO3\TestingFramework\Core\Unit\UnitTestCase
{
    /**
     * @var \Glacryl\Glshop\Controller\OrderstatusController
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder(\Glacryl\Glshop\Controller\OrderstatusController::class)
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
    public function listActionFetchesAllOrderstatusesFromRepositoryAndAssignsThemToView()
    {

        $allOrderstatuses = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $orderstatusRepository = $this->getMockBuilder(\Glacryl\Glshop\Domain\Repository\OrderstatusRepository::class)
            ->setMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $orderstatusRepository->expects(self::once())->method('findAll')->will(self::returnValue($allOrderstatuses));
        $this->inject($this->subject, 'orderstatusRepository', $orderstatusRepository);

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $view->expects(self::once())->method('assign')->with('orderstatuses', $allOrderstatuses);
        $this->inject($this->subject, 'view', $view);

        $this->subject->listAction();
    }

    /**
     * @test
     */
    public function showActionAssignsTheGivenOrderstatusToView()
    {
        $orderstatus = new \Glacryl\Glshop\Domain\Model\Orderstatus();

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $this->inject($this->subject, 'view', $view);
        $view->expects(self::once())->method('assign')->with('orderstatus', $orderstatus);

        $this->subject->showAction($orderstatus);
    }

    /**
     * @test
     */
    public function createActionAddsTheGivenOrderstatusToOrderstatusRepository()
    {
        $orderstatus = new \Glacryl\Glshop\Domain\Model\Orderstatus();

        $orderstatusRepository = $this->getMockBuilder(\Glacryl\Glshop\Domain\Repository\OrderstatusRepository::class)
            ->setMethods(['add'])
            ->disableOriginalConstructor()
            ->getMock();

        $orderstatusRepository->expects(self::once())->method('add')->with($orderstatus);
        $this->inject($this->subject, 'orderstatusRepository', $orderstatusRepository);

        $this->subject->createAction($orderstatus);
    }

    /**
     * @test
     */
    public function editActionAssignsTheGivenOrderstatusToView()
    {
        $orderstatus = new \Glacryl\Glshop\Domain\Model\Orderstatus();

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $this->inject($this->subject, 'view', $view);
        $view->expects(self::once())->method('assign')->with('orderstatus', $orderstatus);

        $this->subject->editAction($orderstatus);
    }

    /**
     * @test
     */
    public function updateActionUpdatesTheGivenOrderstatusInOrderstatusRepository()
    {
        $orderstatus = new \Glacryl\Glshop\Domain\Model\Orderstatus();

        $orderstatusRepository = $this->getMockBuilder(\Glacryl\Glshop\Domain\Repository\OrderstatusRepository::class)
            ->setMethods(['update'])
            ->disableOriginalConstructor()
            ->getMock();

        $orderstatusRepository->expects(self::once())->method('update')->with($orderstatus);
        $this->inject($this->subject, 'orderstatusRepository', $orderstatusRepository);

        $this->subject->updateAction($orderstatus);
    }

    /**
     * @test
     */
    public function deleteActionRemovesTheGivenOrderstatusFromOrderstatusRepository()
    {
        $orderstatus = new \Glacryl\Glshop\Domain\Model\Orderstatus();

        $orderstatusRepository = $this->getMockBuilder(\Glacryl\Glshop\Domain\Repository\OrderstatusRepository::class)
            ->setMethods(['remove'])
            ->disableOriginalConstructor()
            ->getMock();

        $orderstatusRepository->expects(self::once())->method('remove')->with($orderstatus);
        $this->inject($this->subject, 'orderstatusRepository', $orderstatusRepository);

        $this->subject->deleteAction($orderstatus);
    }
}
