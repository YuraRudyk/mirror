<?php
namespace Glacryl\Glshop\Tests\Unit\Controller;

/**
 * Test case.
 *
 * @author Petro Dikij <petro.dikij@glacryl.de>
 */
class OrderstateControllerTest extends \TYPO3\TestingFramework\Core\Unit\UnitTestCase
{
    /**
     * @var \Glacryl\Glshop\Controller\OrderstateController
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder(\Glacryl\Glshop\Controller\OrderstateController::class)
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
    public function listActionFetchesAllOrderstatesFromRepositoryAndAssignsThemToView()
    {

        $allOrderstates = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $orderstateRepository = $this->getMockBuilder(\Glacryl\Glshop\Domain\Repository\OrderstateRepository::class)
            ->setMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $orderstateRepository->expects(self::once())->method('findAll')->will(self::returnValue($allOrderstates));
        $this->inject($this->subject, 'orderstateRepository', $orderstateRepository);

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $view->expects(self::once())->method('assign')->with('orderstates', $allOrderstates);
        $this->inject($this->subject, 'view', $view);

        $this->subject->listAction();
    }

    /**
     * @test
     */
    public function showActionAssignsTheGivenOrderstateToView()
    {
        $orderstate = new \Glacryl\Glshop\Domain\Model\Orderstate();

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $this->inject($this->subject, 'view', $view);
        $view->expects(self::once())->method('assign')->with('orderstate', $orderstate);

        $this->subject->showAction($orderstate);
    }

    /**
     * @test
     */
    public function createActionAddsTheGivenOrderstateToOrderstateRepository()
    {
        $orderstate = new \Glacryl\Glshop\Domain\Model\Orderstate();

        $orderstateRepository = $this->getMockBuilder(\Glacryl\Glshop\Domain\Repository\OrderstateRepository::class)
            ->setMethods(['add'])
            ->disableOriginalConstructor()
            ->getMock();

        $orderstateRepository->expects(self::once())->method('add')->with($orderstate);
        $this->inject($this->subject, 'orderstateRepository', $orderstateRepository);

        $this->subject->createAction($orderstate);
    }

    /**
     * @test
     */
    public function editActionAssignsTheGivenOrderstateToView()
    {
        $orderstate = new \Glacryl\Glshop\Domain\Model\Orderstate();

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $this->inject($this->subject, 'view', $view);
        $view->expects(self::once())->method('assign')->with('orderstate', $orderstate);

        $this->subject->editAction($orderstate);
    }

    /**
     * @test
     */
    public function updateActionUpdatesTheGivenOrderstateInOrderstateRepository()
    {
        $orderstate = new \Glacryl\Glshop\Domain\Model\Orderstate();

        $orderstateRepository = $this->getMockBuilder(\Glacryl\Glshop\Domain\Repository\OrderstateRepository::class)
            ->setMethods(['update'])
            ->disableOriginalConstructor()
            ->getMock();

        $orderstateRepository->expects(self::once())->method('update')->with($orderstate);
        $this->inject($this->subject, 'orderstateRepository', $orderstateRepository);

        $this->subject->updateAction($orderstate);
    }

    /**
     * @test
     */
    public function deleteActionRemovesTheGivenOrderstateFromOrderstateRepository()
    {
        $orderstate = new \Glacryl\Glshop\Domain\Model\Orderstate();

        $orderstateRepository = $this->getMockBuilder(\Glacryl\Glshop\Domain\Repository\OrderstateRepository::class)
            ->setMethods(['remove'])
            ->disableOriginalConstructor()
            ->getMock();

        $orderstateRepository->expects(self::once())->method('remove')->with($orderstate);
        $this->inject($this->subject, 'orderstateRepository', $orderstateRepository);

        $this->subject->deleteAction($orderstate);
    }
}
