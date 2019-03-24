<?php
namespace Glacryl\Glshop\Tests\Unit\Controller;

/**
 * Test case.
 *
 * @author Petro Dikij <petro.dikij@glacryl.de>
 */
class ShippingaddressControllerTest extends \TYPO3\TestingFramework\Core\Unit\UnitTestCase
{
    /**
     * @var \Glacryl\Glshop\Controller\ShippingaddressController
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder(\Glacryl\Glshop\Controller\ShippingaddressController::class)
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
    public function listActionFetchesAllShippingaddressesFromRepositoryAndAssignsThemToView()
    {

        $allShippingaddresses = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $shippingaddressRepository = $this->getMockBuilder(\Glacryl\Glshop\Domain\Repository\ShippingaddressRepository::class)
            ->setMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $shippingaddressRepository->expects(self::once())->method('findAll')->will(self::returnValue($allShippingaddresses));
        $this->inject($this->subject, 'shippingaddressRepository', $shippingaddressRepository);

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $view->expects(self::once())->method('assign')->with('shippingaddresses', $allShippingaddresses);
        $this->inject($this->subject, 'view', $view);

        $this->subject->listAction();
    }

    /**
     * @test
     */
    public function showActionAssignsTheGivenShippingaddressToView()
    {
        $shippingaddress = new \Glacryl\Glshop\Domain\Model\Shippingaddress();

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $this->inject($this->subject, 'view', $view);
        $view->expects(self::once())->method('assign')->with('shippingaddress', $shippingaddress);

        $this->subject->showAction($shippingaddress);
    }

    /**
     * @test
     */
    public function createActionAddsTheGivenShippingaddressToShippingaddressRepository()
    {
        $shippingaddress = new \Glacryl\Glshop\Domain\Model\Shippingaddress();

        $shippingaddressRepository = $this->getMockBuilder(\Glacryl\Glshop\Domain\Repository\ShippingaddressRepository::class)
            ->setMethods(['add'])
            ->disableOriginalConstructor()
            ->getMock();

        $shippingaddressRepository->expects(self::once())->method('add')->with($shippingaddress);
        $this->inject($this->subject, 'shippingaddressRepository', $shippingaddressRepository);

        $this->subject->createAction($shippingaddress);
    }

    /**
     * @test
     */
    public function editActionAssignsTheGivenShippingaddressToView()
    {
        $shippingaddress = new \Glacryl\Glshop\Domain\Model\Shippingaddress();

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $this->inject($this->subject, 'view', $view);
        $view->expects(self::once())->method('assign')->with('shippingaddress', $shippingaddress);

        $this->subject->editAction($shippingaddress);
    }

    /**
     * @test
     */
    public function updateActionUpdatesTheGivenShippingaddressInShippingaddressRepository()
    {
        $shippingaddress = new \Glacryl\Glshop\Domain\Model\Shippingaddress();

        $shippingaddressRepository = $this->getMockBuilder(\Glacryl\Glshop\Domain\Repository\ShippingaddressRepository::class)
            ->setMethods(['update'])
            ->disableOriginalConstructor()
            ->getMock();

        $shippingaddressRepository->expects(self::once())->method('update')->with($shippingaddress);
        $this->inject($this->subject, 'shippingaddressRepository', $shippingaddressRepository);

        $this->subject->updateAction($shippingaddress);
    }

    /**
     * @test
     */
    public function deleteActionRemovesTheGivenShippingaddressFromShippingaddressRepository()
    {
        $shippingaddress = new \Glacryl\Glshop\Domain\Model\Shippingaddress();

        $shippingaddressRepository = $this->getMockBuilder(\Glacryl\Glshop\Domain\Repository\ShippingaddressRepository::class)
            ->setMethods(['remove'])
            ->disableOriginalConstructor()
            ->getMock();

        $shippingaddressRepository->expects(self::once())->method('remove')->with($shippingaddress);
        $this->inject($this->subject, 'shippingaddressRepository', $shippingaddressRepository);

        $this->subject->deleteAction($shippingaddress);
    }
}
