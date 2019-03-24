<?php
namespace Glacryl\Glshop\Tests\Unit\Controller;

/**
 * Test case.
 *
 * @author Petro Dikij <petro.dikij@glacryl.de>
 */
class ProductoptionControllerTest extends \TYPO3\TestingFramework\Core\Unit\UnitTestCase
{
    /**
     * @var \Glacryl\Glshop\Controller\ProductoptionController
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder(\Glacryl\Glshop\Controller\ProductoptionController::class)
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
    public function listActionFetchesAllProductoptionsFromRepositoryAndAssignsThemToView()
    {

        $allProductoptions = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $productoptionRepository = $this->getMockBuilder(\Glacryl\Glshop\Domain\Repository\ProductoptionRepository::class)
            ->setMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $productoptionRepository->expects(self::once())->method('findAll')->will(self::returnValue($allProductoptions));
        $this->inject($this->subject, 'productoptionRepository', $productoptionRepository);

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $view->expects(self::once())->method('assign')->with('productoptions', $allProductoptions);
        $this->inject($this->subject, 'view', $view);

        $this->subject->listAction();
    }

    /**
     * @test
     */
    public function showActionAssignsTheGivenProductoptionToView()
    {
        $productoption = new \Glacryl\Glshop\Domain\Model\Productoption();

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $this->inject($this->subject, 'view', $view);
        $view->expects(self::once())->method('assign')->with('productoption', $productoption);

        $this->subject->showAction($productoption);
    }

    /**
     * @test
     */
    public function createActionAddsTheGivenProductoptionToProductoptionRepository()
    {
        $productoption = new \Glacryl\Glshop\Domain\Model\Productoption();

        $productoptionRepository = $this->getMockBuilder(\Glacryl\Glshop\Domain\Repository\ProductoptionRepository::class)
            ->setMethods(['add'])
            ->disableOriginalConstructor()
            ->getMock();

        $productoptionRepository->expects(self::once())->method('add')->with($productoption);
        $this->inject($this->subject, 'productoptionRepository', $productoptionRepository);

        $this->subject->createAction($productoption);
    }

    /**
     * @test
     */
    public function editActionAssignsTheGivenProductoptionToView()
    {
        $productoption = new \Glacryl\Glshop\Domain\Model\Productoption();

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $this->inject($this->subject, 'view', $view);
        $view->expects(self::once())->method('assign')->with('productoption', $productoption);

        $this->subject->editAction($productoption);
    }

    /**
     * @test
     */
    public function updateActionUpdatesTheGivenProductoptionInProductoptionRepository()
    {
        $productoption = new \Glacryl\Glshop\Domain\Model\Productoption();

        $productoptionRepository = $this->getMockBuilder(\Glacryl\Glshop\Domain\Repository\ProductoptionRepository::class)
            ->setMethods(['update'])
            ->disableOriginalConstructor()
            ->getMock();

        $productoptionRepository->expects(self::once())->method('update')->with($productoption);
        $this->inject($this->subject, 'productoptionRepository', $productoptionRepository);

        $this->subject->updateAction($productoption);
    }

    /**
     * @test
     */
    public function deleteActionRemovesTheGivenProductoptionFromProductoptionRepository()
    {
        $productoption = new \Glacryl\Glshop\Domain\Model\Productoption();

        $productoptionRepository = $this->getMockBuilder(\Glacryl\Glshop\Domain\Repository\ProductoptionRepository::class)
            ->setMethods(['remove'])
            ->disableOriginalConstructor()
            ->getMock();

        $productoptionRepository->expects(self::once())->method('remove')->with($productoption);
        $this->inject($this->subject, 'productoptionRepository', $productoptionRepository);

        $this->subject->deleteAction($productoption);
    }
}
