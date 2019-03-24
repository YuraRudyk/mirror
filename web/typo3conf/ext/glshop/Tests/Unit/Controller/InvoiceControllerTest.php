<?php
namespace Glacryl\Glshop\Tests\Unit\Controller;

/**
 * Test case.
 *
 * @author Petro Dikij <petro.dikij@glacryl.de>
 */
class InvoiceControllerTest extends \TYPO3\TestingFramework\Core\Unit\UnitTestCase
{
    /**
     * @var \Glacryl\Glshop\Controller\InvoiceController
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder(\Glacryl\Glshop\Controller\InvoiceController::class)
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
    public function listActionFetchesAllInvoicesFromRepositoryAndAssignsThemToView()
    {

        $allInvoices = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $invoiceRepository = $this->getMockBuilder(\Glacryl\Glshop\Domain\Repository\InvoiceRepository::class)
            ->setMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $invoiceRepository->expects(self::once())->method('findAll')->will(self::returnValue($allInvoices));
        $this->inject($this->subject, 'invoiceRepository', $invoiceRepository);

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $view->expects(self::once())->method('assign')->with('invoices', $allInvoices);
        $this->inject($this->subject, 'view', $view);

        $this->subject->listAction();
    }

    /**
     * @test
     */
    public function createActionAddsTheGivenInvoiceToInvoiceRepository()
    {
        $invoice = new \Glacryl\Glshop\Domain\Model\Invoice();

        $invoiceRepository = $this->getMockBuilder(\Glacryl\Glshop\Domain\Repository\InvoiceRepository::class)
            ->setMethods(['add'])
            ->disableOriginalConstructor()
            ->getMock();

        $invoiceRepository->expects(self::once())->method('add')->with($invoice);
        $this->inject($this->subject, 'invoiceRepository', $invoiceRepository);

        $this->subject->createAction($invoice);
    }

    /**
     * @test
     */
    public function editActionAssignsTheGivenInvoiceToView()
    {
        $invoice = new \Glacryl\Glshop\Domain\Model\Invoice();

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $this->inject($this->subject, 'view', $view);
        $view->expects(self::once())->method('assign')->with('invoice', $invoice);

        $this->subject->editAction($invoice);
    }

    /**
     * @test
     */
    public function updateActionUpdatesTheGivenInvoiceInInvoiceRepository()
    {
        $invoice = new \Glacryl\Glshop\Domain\Model\Invoice();

        $invoiceRepository = $this->getMockBuilder(\Glacryl\Glshop\Domain\Repository\InvoiceRepository::class)
            ->setMethods(['update'])
            ->disableOriginalConstructor()
            ->getMock();

        $invoiceRepository->expects(self::once())->method('update')->with($invoice);
        $this->inject($this->subject, 'invoiceRepository', $invoiceRepository);

        $this->subject->updateAction($invoice);
    }

    /**
     * @test
     */
    public function deleteActionRemovesTheGivenInvoiceFromInvoiceRepository()
    {
        $invoice = new \Glacryl\Glshop\Domain\Model\Invoice();

        $invoiceRepository = $this->getMockBuilder(\Glacryl\Glshop\Domain\Repository\InvoiceRepository::class)
            ->setMethods(['remove'])
            ->disableOriginalConstructor()
            ->getMock();

        $invoiceRepository->expects(self::once())->method('remove')->with($invoice);
        $this->inject($this->subject, 'invoiceRepository', $invoiceRepository);

        $this->subject->deleteAction($invoice);
    }
}
