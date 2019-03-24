<?php
namespace Glacryl\Glshop\Tests\Unit\Controller;

/**
 * Test case.
 *
 * @author Petro Dikij <petro.dikij@glacryl.de>
 */
class ConfirmationControllerTest extends \TYPO3\TestingFramework\Core\Unit\UnitTestCase
{
    /**
     * @var \Glacryl\Glshop\Controller\ConfirmationController
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder(\Glacryl\Glshop\Controller\ConfirmationController::class)
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
    public function listActionFetchesAllConfirmationsFromRepositoryAndAssignsThemToView()
    {

        $allConfirmations = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $confirmationRepository = $this->getMockBuilder(\Glacryl\Glshop\Domain\Repository\ConfirmationRepository::class)
            ->setMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $confirmationRepository->expects(self::once())->method('findAll')->will(self::returnValue($allConfirmations));
        $this->inject($this->subject, 'confirmationRepository', $confirmationRepository);

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $view->expects(self::once())->method('assign')->with('confirmations', $allConfirmations);
        $this->inject($this->subject, 'view', $view);

        $this->subject->listAction();
    }

    /**
     * @test
     */
    public function createActionAddsTheGivenConfirmationToConfirmationRepository()
    {
        $confirmation = new \Glacryl\Glshop\Domain\Model\Confirmation();

        $confirmationRepository = $this->getMockBuilder(\Glacryl\Glshop\Domain\Repository\ConfirmationRepository::class)
            ->setMethods(['add'])
            ->disableOriginalConstructor()
            ->getMock();

        $confirmationRepository->expects(self::once())->method('add')->with($confirmation);
        $this->inject($this->subject, 'confirmationRepository', $confirmationRepository);

        $this->subject->createAction($confirmation);
    }

    /**
     * @test
     */
    public function editActionAssignsTheGivenConfirmationToView()
    {
        $confirmation = new \Glacryl\Glshop\Domain\Model\Confirmation();

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $this->inject($this->subject, 'view', $view);
        $view->expects(self::once())->method('assign')->with('confirmation', $confirmation);

        $this->subject->editAction($confirmation);
    }

    /**
     * @test
     */
    public function updateActionUpdatesTheGivenConfirmationInConfirmationRepository()
    {
        $confirmation = new \Glacryl\Glshop\Domain\Model\Confirmation();

        $confirmationRepository = $this->getMockBuilder(\Glacryl\Glshop\Domain\Repository\ConfirmationRepository::class)
            ->setMethods(['update'])
            ->disableOriginalConstructor()
            ->getMock();

        $confirmationRepository->expects(self::once())->method('update')->with($confirmation);
        $this->inject($this->subject, 'confirmationRepository', $confirmationRepository);

        $this->subject->updateAction($confirmation);
    }

    /**
     * @test
     */
    public function deleteActionRemovesTheGivenConfirmationFromConfirmationRepository()
    {
        $confirmation = new \Glacryl\Glshop\Domain\Model\Confirmation();

        $confirmationRepository = $this->getMockBuilder(\Glacryl\Glshop\Domain\Repository\ConfirmationRepository::class)
            ->setMethods(['remove'])
            ->disableOriginalConstructor()
            ->getMock();

        $confirmationRepository->expects(self::once())->method('remove')->with($confirmation);
        $this->inject($this->subject, 'confirmationRepository', $confirmationRepository);

        $this->subject->deleteAction($confirmation);
    }
}
