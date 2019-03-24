<?php
namespace Glacryl\Glshop\Tests\Unit\Controller;

/**
 * Test case.
 *
 * @author Petro Dikij <petro.dikij@glacryl.de>
 */
class MaterialoptiontypeControllerTest extends \TYPO3\TestingFramework\Core\Unit\UnitTestCase
{
    /**
     * @var \Glacryl\Glshop\Controller\MaterialoptiontypeController
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder(\Glacryl\Glshop\Controller\MaterialoptiontypeController::class)
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
    public function listActionFetchesAllMaterialoptiontypesFromRepositoryAndAssignsThemToView()
    {

        $allMaterialoptiontypes = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $materialoptiontypeRepository = $this->getMockBuilder(\::class)
            ->setMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $materialoptiontypeRepository->expects(self::once())->method('findAll')->will(self::returnValue($allMaterialoptiontypes));
        $this->inject($this->subject, 'materialoptiontypeRepository', $materialoptiontypeRepository);

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $view->expects(self::once())->method('assign')->with('materialoptiontypes', $allMaterialoptiontypes);
        $this->inject($this->subject, 'view', $view);

        $this->subject->listAction();
    }

    /**
     * @test
     */
    public function showActionAssignsTheGivenMaterialoptiontypeToView()
    {
        $materialoptiontype = new \Glacryl\Glshop\Domain\Model\Materialoptiontype();

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $this->inject($this->subject, 'view', $view);
        $view->expects(self::once())->method('assign')->with('materialoptiontype', $materialoptiontype);

        $this->subject->showAction($materialoptiontype);
    }

    /**
     * @test
     */
    public function createActionAddsTheGivenMaterialoptiontypeToMaterialoptiontypeRepository()
    {
        $materialoptiontype = new \Glacryl\Glshop\Domain\Model\Materialoptiontype();

        $materialoptiontypeRepository = $this->getMockBuilder(\::class)
            ->setMethods(['add'])
            ->disableOriginalConstructor()
            ->getMock();

        $materialoptiontypeRepository->expects(self::once())->method('add')->with($materialoptiontype);
        $this->inject($this->subject, 'materialoptiontypeRepository', $materialoptiontypeRepository);

        $this->subject->createAction($materialoptiontype);
    }

    /**
     * @test
     */
    public function editActionAssignsTheGivenMaterialoptiontypeToView()
    {
        $materialoptiontype = new \Glacryl\Glshop\Domain\Model\Materialoptiontype();

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $this->inject($this->subject, 'view', $view);
        $view->expects(self::once())->method('assign')->with('materialoptiontype', $materialoptiontype);

        $this->subject->editAction($materialoptiontype);
    }

    /**
     * @test
     */
    public function updateActionUpdatesTheGivenMaterialoptiontypeInMaterialoptiontypeRepository()
    {
        $materialoptiontype = new \Glacryl\Glshop\Domain\Model\Materialoptiontype();

        $materialoptiontypeRepository = $this->getMockBuilder(\::class)
            ->setMethods(['update'])
            ->disableOriginalConstructor()
            ->getMock();

        $materialoptiontypeRepository->expects(self::once())->method('update')->with($materialoptiontype);
        $this->inject($this->subject, 'materialoptiontypeRepository', $materialoptiontypeRepository);

        $this->subject->updateAction($materialoptiontype);
    }

    /**
     * @test
     */
    public function deleteActionRemovesTheGivenMaterialoptiontypeFromMaterialoptiontypeRepository()
    {
        $materialoptiontype = new \Glacryl\Glshop\Domain\Model\Materialoptiontype();

        $materialoptiontypeRepository = $this->getMockBuilder(\::class)
            ->setMethods(['remove'])
            ->disableOriginalConstructor()
            ->getMock();

        $materialoptiontypeRepository->expects(self::once())->method('remove')->with($materialoptiontype);
        $this->inject($this->subject, 'materialoptiontypeRepository', $materialoptiontypeRepository);

        $this->subject->deleteAction($materialoptiontype);
    }
}
