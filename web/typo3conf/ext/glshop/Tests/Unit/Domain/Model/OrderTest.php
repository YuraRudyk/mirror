<?php
namespace Glacryl\Glshop\Tests\Unit\Domain\Model;

/**
 * Test case.
 *
 * @author Petro Dikij <petro.dikij@glacryl.de>
 */
class OrderTest extends \TYPO3\TestingFramework\Core\Unit\UnitTestCase
{
    /**
     * @var \Glacryl\Glshop\Domain\Model\Order
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new \Glacryl\Glshop\Domain\Model\Order();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function getDateReturnsInitialValueForDateTime()
    {
        self::assertEquals(
            null,
            $this->subject->getDate()
        );
    }

    /**
     * @test
     */
    public function setDateForDateTimeSetsDate()
    {
        $dateTimeFixture = new \DateTime();
        $this->subject->setDate($dateTimeFixture);

        self::assertAttributeEquals(
            $dateTimeFixture,
            'date',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getArticleReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getArticle()
        );
    }

    /**
     * @test
     */
    public function setArticleForStringSetsArticle()
    {
        $this->subject->setArticle('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'article',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getCommentReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getComment()
        );
    }

    /**
     * @test
     */
    public function setCommentForStringSetsComment()
    {
        $this->subject->setComment('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'comment',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getFormularReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getFormular()
        );
    }

    /**
     * @test
     */
    public function setFormularForStringSetsFormular()
    {
        $this->subject->setFormular('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'formular',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getUserReturnsInitialValueFor()
    {
    }

    /**
     * @test
     */
    public function setUserForSetsUser()
    {
    }

    /**
     * @test
     */
    public function getConfirmationReturnsInitialValueForConfirmation()
    {
        $newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        self::assertEquals(
            $newObjectStorage,
            $this->subject->getConfirmation()
        );
    }

    /**
     * @test
     */
    public function setConfirmationForObjectStorageContainingConfirmationSetsConfirmation()
    {
        $confirmation = new \Glacryl\Glshop\Domain\Model\Confirmation();
        $objectStorageHoldingExactlyOneConfirmation = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $objectStorageHoldingExactlyOneConfirmation->attach($confirmation);
        $this->subject->setConfirmation($objectStorageHoldingExactlyOneConfirmation);

        self::assertAttributeEquals(
            $objectStorageHoldingExactlyOneConfirmation,
            'confirmation',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function addConfirmationToObjectStorageHoldingConfirmation()
    {
        $confirmation = new \Glacryl\Glshop\Domain\Model\Confirmation();
        $confirmationObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->setMethods(['attach'])
            ->disableOriginalConstructor()
            ->getMock();

        $confirmationObjectStorageMock->expects(self::once())->method('attach')->with(self::equalTo($confirmation));
        $this->inject($this->subject, 'confirmation', $confirmationObjectStorageMock);

        $this->subject->addConfirmation($confirmation);
    }

    /**
     * @test
     */
    public function removeConfirmationFromObjectStorageHoldingConfirmation()
    {
        $confirmation = new \Glacryl\Glshop\Domain\Model\Confirmation();
        $confirmationObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->setMethods(['detach'])
            ->disableOriginalConstructor()
            ->getMock();

        $confirmationObjectStorageMock->expects(self::once())->method('detach')->with(self::equalTo($confirmation));
        $this->inject($this->subject, 'confirmation', $confirmationObjectStorageMock);

        $this->subject->removeConfirmation($confirmation);
    }

    /**
     * @test
     */
    public function getProductionReturnsInitialValueForProduction()
    {
        $newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        self::assertEquals(
            $newObjectStorage,
            $this->subject->getProduction()
        );
    }

    /**
     * @test
     */
    public function setProductionForObjectStorageContainingProductionSetsProduction()
    {
        $production = new \Glacryl\Glshop\Domain\Model\Production();
        $objectStorageHoldingExactlyOneProduction = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $objectStorageHoldingExactlyOneProduction->attach($production);
        $this->subject->setProduction($objectStorageHoldingExactlyOneProduction);

        self::assertAttributeEquals(
            $objectStorageHoldingExactlyOneProduction,
            'production',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function addProductionToObjectStorageHoldingProduction()
    {
        $production = new \Glacryl\Glshop\Domain\Model\Production();
        $productionObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->setMethods(['attach'])
            ->disableOriginalConstructor()
            ->getMock();

        $productionObjectStorageMock->expects(self::once())->method('attach')->with(self::equalTo($production));
        $this->inject($this->subject, 'production', $productionObjectStorageMock);

        $this->subject->addProduction($production);
    }

    /**
     * @test
     */
    public function removeProductionFromObjectStorageHoldingProduction()
    {
        $production = new \Glacryl\Glshop\Domain\Model\Production();
        $productionObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->setMethods(['detach'])
            ->disableOriginalConstructor()
            ->getMock();

        $productionObjectStorageMock->expects(self::once())->method('detach')->with(self::equalTo($production));
        $this->inject($this->subject, 'production', $productionObjectStorageMock);

        $this->subject->removeProduction($production);
    }

    /**
     * @test
     */
    public function getDeliveryReturnsInitialValueForDelivery()
    {
        $newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        self::assertEquals(
            $newObjectStorage,
            $this->subject->getDelivery()
        );
    }

    /**
     * @test
     */
    public function setDeliveryForObjectStorageContainingDeliverySetsDelivery()
    {
        $delivery = new \Glacryl\Glshop\Domain\Model\Delivery();
        $objectStorageHoldingExactlyOneDelivery = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $objectStorageHoldingExactlyOneDelivery->attach($delivery);
        $this->subject->setDelivery($objectStorageHoldingExactlyOneDelivery);

        self::assertAttributeEquals(
            $objectStorageHoldingExactlyOneDelivery,
            'delivery',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function addDeliveryToObjectStorageHoldingDelivery()
    {
        $delivery = new \Glacryl\Glshop\Domain\Model\Delivery();
        $deliveryObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->setMethods(['attach'])
            ->disableOriginalConstructor()
            ->getMock();

        $deliveryObjectStorageMock->expects(self::once())->method('attach')->with(self::equalTo($delivery));
        $this->inject($this->subject, 'delivery', $deliveryObjectStorageMock);

        $this->subject->addDelivery($delivery);
    }

    /**
     * @test
     */
    public function removeDeliveryFromObjectStorageHoldingDelivery()
    {
        $delivery = new \Glacryl\Glshop\Domain\Model\Delivery();
        $deliveryObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->setMethods(['detach'])
            ->disableOriginalConstructor()
            ->getMock();

        $deliveryObjectStorageMock->expects(self::once())->method('detach')->with(self::equalTo($delivery));
        $this->inject($this->subject, 'delivery', $deliveryObjectStorageMock);

        $this->subject->removeDelivery($delivery);
    }

    /**
     * @test
     */
    public function getInvoiceReturnsInitialValueForInvoice()
    {
        $newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        self::assertEquals(
            $newObjectStorage,
            $this->subject->getInvoice()
        );
    }

    /**
     * @test
     */
    public function setInvoiceForObjectStorageContainingInvoiceSetsInvoice()
    {
        $invoice = new \Glacryl\Glshop\Domain\Model\Invoice();
        $objectStorageHoldingExactlyOneInvoice = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $objectStorageHoldingExactlyOneInvoice->attach($invoice);
        $this->subject->setInvoice($objectStorageHoldingExactlyOneInvoice);

        self::assertAttributeEquals(
            $objectStorageHoldingExactlyOneInvoice,
            'invoice',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function addInvoiceToObjectStorageHoldingInvoice()
    {
        $invoice = new \Glacryl\Glshop\Domain\Model\Invoice();
        $invoiceObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->setMethods(['attach'])
            ->disableOriginalConstructor()
            ->getMock();

        $invoiceObjectStorageMock->expects(self::once())->method('attach')->with(self::equalTo($invoice));
        $this->inject($this->subject, 'invoice', $invoiceObjectStorageMock);

        $this->subject->addInvoice($invoice);
    }

    /**
     * @test
     */
    public function removeInvoiceFromObjectStorageHoldingInvoice()
    {
        $invoice = new \Glacryl\Glshop\Domain\Model\Invoice();
        $invoiceObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->setMethods(['detach'])
            ->disableOriginalConstructor()
            ->getMock();

        $invoiceObjectStorageMock->expects(self::once())->method('detach')->with(self::equalTo($invoice));
        $this->inject($this->subject, 'invoice', $invoiceObjectStorageMock);

        $this->subject->removeInvoice($invoice);
    }

    /**
     * @test
     */
    public function getShippingaddressReturnsInitialValueForShippingaddress()
    {
        self::assertEquals(
            null,
            $this->subject->getShippingaddress()
        );
    }

    /**
     * @test
     */
    public function setShippingaddressForShippingaddressSetsShippingaddress()
    {
        $shippingaddressFixture = new \Glacryl\Glshop\Domain\Model\Shippingaddress();
        $this->subject->setShippingaddress($shippingaddressFixture);

        self::assertAttributeEquals(
            $shippingaddressFixture,
            'shippingaddress',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getOrderstatusReturnsInitialValueForOrderstatus()
    {
        $newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        self::assertEquals(
            $newObjectStorage,
            $this->subject->getOrderstatus()
        );
    }

    /**
     * @test
     */
    public function setOrderstatusForObjectStorageContainingOrderstatusSetsOrderstatus()
    {
        $orderstatu = new \Glacryl\Glshop\Domain\Model\Orderstatus();
        $objectStorageHoldingExactlyOneOrderstatus = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $objectStorageHoldingExactlyOneOrderstatus->attach($orderstatu);
        $this->subject->setOrderstatus($objectStorageHoldingExactlyOneOrderstatus);

        self::assertAttributeEquals(
            $objectStorageHoldingExactlyOneOrderstatus,
            'orderstatus',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function addOrderstatuToObjectStorageHoldingOrderstatus()
    {
        $orderstatu = new \Glacryl\Glshop\Domain\Model\Orderstatus();
        $orderstatusObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->setMethods(['attach'])
            ->disableOriginalConstructor()
            ->getMock();

        $orderstatusObjectStorageMock->expects(self::once())->method('attach')->with(self::equalTo($orderstatu));
        $this->inject($this->subject, 'orderstatus', $orderstatusObjectStorageMock);

        $this->subject->addOrderstatu($orderstatu);
    }

    /**
     * @test
     */
    public function removeOrderstatuFromObjectStorageHoldingOrderstatus()
    {
        $orderstatu = new \Glacryl\Glshop\Domain\Model\Orderstatus();
        $orderstatusObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->setMethods(['detach'])
            ->disableOriginalConstructor()
            ->getMock();

        $orderstatusObjectStorageMock->expects(self::once())->method('detach')->with(self::equalTo($orderstatu));
        $this->inject($this->subject, 'orderstatus', $orderstatusObjectStorageMock);

        $this->subject->removeOrderstatu($orderstatu);
    }

    /**
     * @test
     */
    public function getConditionsReturnsInitialValueForConditions()
    {
        self::assertEquals(
            null,
            $this->subject->getConditions()
        );
    }

    /**
     * @test
     */
    public function setConditionsForConditionsSetsConditions()
    {
        $conditionsFixture = new \Glacryl\Glshop\Domain\Model\Conditions();
        $this->subject->setConditions($conditionsFixture);

        self::assertAttributeEquals(
            $conditionsFixture,
            'conditions',
            $this->subject
        );
    }
}
