<?php
namespace Glacryl\Glshop\Tests\Unit\Controller;

/**
 * Test case.
 *
 * @author Petro Dikij <petro.dikij@glacryl.de>
 */
class DeliveryControllerTest extends \TYPO3\TestingFramework\Core\Unit\UnitTestCase
{
    /**
     * @var \Glacryl\Glshop\Controller\DeliveryController
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder(\Glacryl\Glshop\Controller\DeliveryController::class)
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
    public function listActionFetchesAllDeliveriesFromRepositoryAndAssignsThemToView()
    {

        $allDeliveries = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $deliveryRepository = $this->getMockBuilder(\Glacryl\Glshop\Domain\Repository\DeliveryRepository::class)
            ->setMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $deliveryRepository->expects(self::once())->method('findAll')->will(self::returnValue($allDeliveries));
        $this->inject($this->subject, 'deliveryRepository', $deliveryRepository);

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $view->expects(self::once())->method('assign')->with('deliveries', $allDeliveries);
        $this->inject($this->subject, 'view', $view);

        $this->subject->listAction();
    }

    /**
     * @test
     */
    public function createActionAddsTheGivenDeliveryToDeliveryRepository()
    {
        $delivery = new \Glacryl\Glshop\Domain\Model\Delivery();

        $deliveryRepository = $this->getMockBuilder(\Glacryl\Glshop\Domain\Repository\DeliveryRepository::class)
            ->setMethods(['add'])
            ->disableOriginalConstructor()
            ->getMock();

        $deliveryRepository->expects(self::once())->method('add')->with($delivery);
        $this->inject($this->subject, 'deliveryRepository', $deliveryRepository);

        $this->subject->createAction($delivery);
    }

    /**
     * @test
     */
    public function editActionAssignsTheGivenDeliveryToView()
    {
        $delivery = new \Glacryl\Glshop\Domain\Model\Delivery();

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $this->inject($this->subject, 'view', $view);
        $view->expects(self::once())->method('assign')->with('delivery', $delivery);

        $this->subject->editAction($delivery);
    }

    /**
     * @test
     */
    public function updateActionUpdatesTheGivenDeliveryInDeliveryRepository()
    {
        $delivery = new \Glacryl\Glshop\Domain\Model\Delivery();

        $deliveryRepository = $this->getMockBuilder(\Glacryl\Glshop\Domain\Repository\DeliveryRepository::class)
            ->setMethods(['update'])
            ->disableOriginalConstructor()
            ->getMock();

        $deliveryRepository->expects(self::once())->method('update')->with($delivery);
        $this->inject($this->subject, 'deliveryRepository', $deliveryRepository);

        $this->subject->updateAction($delivery);
    }

    /**
     * @test
     */
    public function deleteActionRemovesTheGivenDeliveryFromDeliveryRepository()
    {
        $delivery = new \Glacryl\Glshop\Domain\Model\Delivery();

        $deliveryRepository = $this->getMockBuilder(\Glacryl\Glshop\Domain\Repository\DeliveryRepository::class)
            ->setMethods(['remove'])
            ->disableOriginalConstructor()
            ->getMock();

        $deliveryRepository->expects(self::once())->method('remove')->with($delivery);
        $this->inject($this->subject, 'deliveryRepository', $deliveryRepository);

        $this->subject->deleteAction($delivery);
    }
}
