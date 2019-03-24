<?php
namespace Glacryl\Glshop\Tests\Unit\Controller;

/**
 * Test case.
 *
 * @author Petro Dikij <petro.dikij@glacryl.de>
 */
class ProductionControllerTest extends \TYPO3\TestingFramework\Core\Unit\UnitTestCase
{
    /**
     * @var \Glacryl\Glshop\Controller\ProductionController
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder(\Glacryl\Glshop\Controller\ProductionController::class)
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
    public function listActionFetchesAllProductionsFromRepositoryAndAssignsThemToView()
    {

        $allProductions = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $productionRepository = $this->getMockBuilder(\Glacryl\Glshop\Domain\Repository\ProductionRepository::class)
            ->setMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $productionRepository->expects(self::once())->method('findAll')->will(self::returnValue($allProductions));
        $this->inject($this->subject, 'productionRepository', $productionRepository);

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $view->expects(self::once())->method('assign')->with('productions', $allProductions);
        $this->inject($this->subject, 'view', $view);

        $this->subject->listAction();
    }

    /**
     * @test
     */
    public function createActionAddsTheGivenProductionToProductionRepository()
    {
        $production = new \Glacryl\Glshop\Domain\Model\Production();

        $productionRepository = $this->getMockBuilder(\Glacryl\Glshop\Domain\Repository\ProductionRepository::class)
            ->setMethods(['add'])
            ->disableOriginalConstructor()
            ->getMock();

        $productionRepository->expects(self::once())->method('add')->with($production);
        $this->inject($this->subject, 'productionRepository', $productionRepository);

        $this->subject->createAction($production);
    }

    /**
     * @test
     */
    public function editActionAssignsTheGivenProductionToView()
    {
        $production = new \Glacryl\Glshop\Domain\Model\Production();

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $this->inject($this->subject, 'view', $view);
        $view->expects(self::once())->method('assign')->with('production', $production);

        $this->subject->editAction($production);
    }

    /**
     * @test
     */
    public function updateActionUpdatesTheGivenProductionInProductionRepository()
    {
        $production = new \Glacryl\Glshop\Domain\Model\Production();

        $productionRepository = $this->getMockBuilder(\Glacryl\Glshop\Domain\Repository\ProductionRepository::class)
            ->setMethods(['update'])
            ->disableOriginalConstructor()
            ->getMock();

        $productionRepository->expects(self::once())->method('update')->with($production);
        $this->inject($this->subject, 'productionRepository', $productionRepository);

        $this->subject->updateAction($production);
    }

    /**
     * @test
     */
    public function deleteActionRemovesTheGivenProductionFromProductionRepository()
    {
        $production = new \Glacryl\Glshop\Domain\Model\Production();

        $productionRepository = $this->getMockBuilder(\Glacryl\Glshop\Domain\Repository\ProductionRepository::class)
            ->setMethods(['remove'])
            ->disableOriginalConstructor()
            ->getMock();

        $productionRepository->expects(self::once())->method('remove')->with($production);
        $this->inject($this->subject, 'productionRepository', $productionRepository);

        $this->subject->deleteAction($production);
    }
}
