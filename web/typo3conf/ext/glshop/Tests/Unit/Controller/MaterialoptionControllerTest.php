<?php
namespace Glacryl\Glshop\Tests\Unit\Controller;

/**
 * Test case.
 *
 * @author Petro Dikij <petro.dikij@glacryl.de>
 */
class MaterialoptionControllerTest extends \TYPO3\TestingFramework\Core\Unit\UnitTestCase
{
    /**
     * @var \Glacryl\Glshop\Controller\MaterialoptionController
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder(\Glacryl\Glshop\Controller\MaterialoptionController::class)
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
    public function listActionFetchesAllMaterialoptionsFromRepositoryAndAssignsThemToView()
    {

        $allMaterialoptions = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $materialoptionRepository = $this->getMockBuilder(\Glacryl\Glshop\Domain\Repository\MaterialoptionRepository::class)
            ->setMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $materialoptionRepository->expects(self::once())->method('findAll')->will(self::returnValue($allMaterialoptions));
        $this->inject($this->subject, 'materialoptionRepository', $materialoptionRepository);

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $view->expects(self::once())->method('assign')->with('materialoptions', $allMaterialoptions);
        $this->inject($this->subject, 'view', $view);

        $this->subject->listAction();
    }

    /**
     * @test
     */
    public function showActionAssignsTheGivenMaterialoptionToView()
    {
        $materialoption = new \Glacryl\Glshop\Domain\Model\Materialoption();

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $this->inject($this->subject, 'view', $view);
        $view->expects(self::once())->method('assign')->with('materialoption', $materialoption);

        $this->subject->showAction($materialoption);
    }

    /**
     * @test
     */
    public function createActionAddsTheGivenMaterialoptionToMaterialoptionRepository()
    {
        $materialoption = new \Glacryl\Glshop\Domain\Model\Materialoption();

        $materialoptionRepository = $this->getMockBuilder(\Glacryl\Glshop\Domain\Repository\MaterialoptionRepository::class)
            ->setMethods(['add'])
            ->disableOriginalConstructor()
            ->getMock();

        $materialoptionRepository->expects(self::once())->method('add')->with($materialoption);
        $this->inject($this->subject, 'materialoptionRepository', $materialoptionRepository);

        $this->subject->createAction($materialoption);
    }

    /**
     * @test
     */
    public function editActionAssignsTheGivenMaterialoptionToView()
    {
        $materialoption = new \Glacryl\Glshop\Domain\Model\Materialoption();

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $this->inject($this->subject, 'view', $view);
        $view->expects(self::once())->method('assign')->with('materialoption', $materialoption);

        $this->subject->editAction($materialoption);
    }

    /**
     * @test
     */
    public function updateActionUpdatesTheGivenMaterialoptionInMaterialoptionRepository()
    {
        $materialoption = new \Glacryl\Glshop\Domain\Model\Materialoption();

        $materialoptionRepository = $this->getMockBuilder(\Glacryl\Glshop\Domain\Repository\MaterialoptionRepository::class)
            ->setMethods(['update'])
            ->disableOriginalConstructor()
            ->getMock();

        $materialoptionRepository->expects(self::once())->method('update')->with($materialoption);
        $this->inject($this->subject, 'materialoptionRepository', $materialoptionRepository);

        $this->subject->updateAction($materialoption);
    }

    /**
     * @test
     */
    public function deleteActionRemovesTheGivenMaterialoptionFromMaterialoptionRepository()
    {
        $materialoption = new \Glacryl\Glshop\Domain\Model\Materialoption();

        $materialoptionRepository = $this->getMockBuilder(\Glacryl\Glshop\Domain\Repository\MaterialoptionRepository::class)
            ->setMethods(['remove'])
            ->disableOriginalConstructor()
            ->getMock();

        $materialoptionRepository->expects(self::once())->method('remove')->with($materialoption);
        $this->inject($this->subject, 'materialoptionRepository', $materialoptionRepository);

        $this->subject->deleteAction($materialoption);
    }
}
