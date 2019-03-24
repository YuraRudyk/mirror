<?php
namespace Glacryl\Glshop\Tests\Unit\Controller;

/**
 * Test case.
 *
 * @author Petro Dikij <petro.dikij@glacryl.de>
 */
class BevelControllerTest extends \TYPO3\TestingFramework\Core\Unit\UnitTestCase
{
    /**
     * @var \Glacryl\Glshop\Controller\BevelController
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder(\Glacryl\Glshop\Controller\BevelController::class)
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
    public function listActionFetchesAllBevelsFromRepositoryAndAssignsThemToView()
    {

        $allBevels = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $bevelRepository = $this->getMockBuilder(\Glacryl\Glshop\Domain\Repository\BevelRepository::class)
            ->setMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $bevelRepository->expects(self::once())->method('findAll')->will(self::returnValue($allBevels));
        $this->inject($this->subject, 'bevelRepository', $bevelRepository);

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $view->expects(self::once())->method('assign')->with('bevels', $allBevels);
        $this->inject($this->subject, 'view', $view);

        $this->subject->listAction();
    }

    /**
     * @test
     */
    public function showActionAssignsTheGivenBevelToView()
    {
        $bevel = new \Glacryl\Glshop\Domain\Model\Bevel();

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $this->inject($this->subject, 'view', $view);
        $view->expects(self::once())->method('assign')->with('bevel', $bevel);

        $this->subject->showAction($bevel);
    }

    /**
     * @test
     */
    public function createActionAddsTheGivenBevelToBevelRepository()
    {
        $bevel = new \Glacryl\Glshop\Domain\Model\Bevel();

        $bevelRepository = $this->getMockBuilder(\Glacryl\Glshop\Domain\Repository\BevelRepository::class)
            ->setMethods(['add'])
            ->disableOriginalConstructor()
            ->getMock();

        $bevelRepository->expects(self::once())->method('add')->with($bevel);
        $this->inject($this->subject, 'bevelRepository', $bevelRepository);

        $this->subject->createAction($bevel);
    }

    /**
     * @test
     */
    public function editActionAssignsTheGivenBevelToView()
    {
        $bevel = new \Glacryl\Glshop\Domain\Model\Bevel();

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $this->inject($this->subject, 'view', $view);
        $view->expects(self::once())->method('assign')->with('bevel', $bevel);

        $this->subject->editAction($bevel);
    }

    /**
     * @test
     */
    public function updateActionUpdatesTheGivenBevelInBevelRepository()
    {
        $bevel = new \Glacryl\Glshop\Domain\Model\Bevel();

        $bevelRepository = $this->getMockBuilder(\Glacryl\Glshop\Domain\Repository\BevelRepository::class)
            ->setMethods(['update'])
            ->disableOriginalConstructor()
            ->getMock();

        $bevelRepository->expects(self::once())->method('update')->with($bevel);
        $this->inject($this->subject, 'bevelRepository', $bevelRepository);

        $this->subject->updateAction($bevel);
    }

    /**
     * @test
     */
    public function deleteActionRemovesTheGivenBevelFromBevelRepository()
    {
        $bevel = new \Glacryl\Glshop\Domain\Model\Bevel();

        $bevelRepository = $this->getMockBuilder(\Glacryl\Glshop\Domain\Repository\BevelRepository::class)
            ->setMethods(['remove'])
            ->disableOriginalConstructor()
            ->getMock();

        $bevelRepository->expects(self::once())->method('remove')->with($bevel);
        $this->inject($this->subject, 'bevelRepository', $bevelRepository);

        $this->subject->deleteAction($bevel);
    }
}
