<?php
namespace Glacryl\Glshop\Tests\Unit\Controller;

/**
 * Test case.
 *
 * @author Petro Dikij <petro.dikij@glacryl.de>
 */
class MaterialControllerTest extends \TYPO3\TestingFramework\Core\Unit\UnitTestCase
{
    /**
     * @var \Glacryl\Glshop\Controller\MaterialController
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder(\Glacryl\Glshop\Controller\MaterialController::class)
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
    public function listActionFetchesAllMaterialsFromRepositoryAndAssignsThemToView()
    {

        $allMaterials = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $materialRepository = $this->getMockBuilder(\Glacryl\Glshop\Domain\Repository\MaterialRepository::class)
            ->setMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $materialRepository->expects(self::once())->method('findAll')->will(self::returnValue($allMaterials));
        $this->inject($this->subject, 'materialRepository', $materialRepository);

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $view->expects(self::once())->method('assign')->with('materials', $allMaterials);
        $this->inject($this->subject, 'view', $view);

        $this->subject->listAction();
    }

    /**
     * @test
     */
    public function showActionAssignsTheGivenMaterialToView()
    {
        $material = new \Glacryl\Glshop\Domain\Model\Material();

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $this->inject($this->subject, 'view', $view);
        $view->expects(self::once())->method('assign')->with('material', $material);

        $this->subject->showAction($material);
    }

    /**
     * @test
     */
    public function createActionAddsTheGivenMaterialToMaterialRepository()
    {
        $material = new \Glacryl\Glshop\Domain\Model\Material();

        $materialRepository = $this->getMockBuilder(\Glacryl\Glshop\Domain\Repository\MaterialRepository::class)
            ->setMethods(['add'])
            ->disableOriginalConstructor()
            ->getMock();

        $materialRepository->expects(self::once())->method('add')->with($material);
        $this->inject($this->subject, 'materialRepository', $materialRepository);

        $this->subject->createAction($material);
    }

    /**
     * @test
     */
    public function editActionAssignsTheGivenMaterialToView()
    {
        $material = new \Glacryl\Glshop\Domain\Model\Material();

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $this->inject($this->subject, 'view', $view);
        $view->expects(self::once())->method('assign')->with('material', $material);

        $this->subject->editAction($material);
    }

    /**
     * @test
     */
    public function updateActionUpdatesTheGivenMaterialInMaterialRepository()
    {
        $material = new \Glacryl\Glshop\Domain\Model\Material();

        $materialRepository = $this->getMockBuilder(\Glacryl\Glshop\Domain\Repository\MaterialRepository::class)
            ->setMethods(['update'])
            ->disableOriginalConstructor()
            ->getMock();

        $materialRepository->expects(self::once())->method('update')->with($material);
        $this->inject($this->subject, 'materialRepository', $materialRepository);

        $this->subject->updateAction($material);
    }

    /**
     * @test
     */
    public function deleteActionRemovesTheGivenMaterialFromMaterialRepository()
    {
        $material = new \Glacryl\Glshop\Domain\Model\Material();

        $materialRepository = $this->getMockBuilder(\Glacryl\Glshop\Domain\Repository\MaterialRepository::class)
            ->setMethods(['remove'])
            ->disableOriginalConstructor()
            ->getMock();

        $materialRepository->expects(self::once())->method('remove')->with($material);
        $this->inject($this->subject, 'materialRepository', $materialRepository);

        $this->subject->deleteAction($material);
    }
}
