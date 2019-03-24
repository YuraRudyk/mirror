<?php
namespace Glacryl\Glshop\Tests\Unit\Controller;

/**
 * Test case.
 *
 * @author Petro Dikij <petro.dikij@glacryl.de>
 */
class RequestControllerTest extends \TYPO3\TestingFramework\Core\Unit\UnitTestCase
{
    /**
     * @var \Glacryl\Glshop\Controller\RequestController
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder(\Glacryl\Glshop\Controller\RequestController::class)
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
    public function listActionFetchesAllRequestsFromRepositoryAndAssignsThemToView()
    {

        $allRequests = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $requestRepository = $this->getMockBuilder(\Glacryl\Glshop\Domain\Repository\RequestRepository::class)
            ->setMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $requestRepository->expects(self::once())->method('findAll')->will(self::returnValue($allRequests));
        $this->inject($this->subject, 'requestRepository', $requestRepository);

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $view->expects(self::once())->method('assign')->with('requests', $allRequests);
        $this->inject($this->subject, 'view', $view);

        $this->subject->listAction();
    }

    /**
     * @test
     */
    public function showActionAssignsTheGivenRequestToView()
    {
        $request = new \Glacryl\Glshop\Domain\Model\Request();

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $this->inject($this->subject, 'view', $view);
        $view->expects(self::once())->method('assign')->with('request', $request);

        $this->subject->showAction($request);
    }

    /**
     * @test
     */
    public function createActionAddsTheGivenRequestToRequestRepository()
    {
        $request = new \Glacryl\Glshop\Domain\Model\Request();

        $requestRepository = $this->getMockBuilder(\Glacryl\Glshop\Domain\Repository\RequestRepository::class)
            ->setMethods(['add'])
            ->disableOriginalConstructor()
            ->getMock();

        $requestRepository->expects(self::once())->method('add')->with($request);
        $this->inject($this->subject, 'requestRepository', $requestRepository);

        $this->subject->createAction($request);
    }

    /**
     * @test
     */
    public function editActionAssignsTheGivenRequestToView()
    {
        $request = new \Glacryl\Glshop\Domain\Model\Request();

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $this->inject($this->subject, 'view', $view);
        $view->expects(self::once())->method('assign')->with('request', $request);

        $this->subject->editAction($request);
    }

    /**
     * @test
     */
    public function updateActionUpdatesTheGivenRequestInRequestRepository()
    {
        $request = new \Glacryl\Glshop\Domain\Model\Request();

        $requestRepository = $this->getMockBuilder(\Glacryl\Glshop\Domain\Repository\RequestRepository::class)
            ->setMethods(['update'])
            ->disableOriginalConstructor()
            ->getMock();

        $requestRepository->expects(self::once())->method('update')->with($request);
        $this->inject($this->subject, 'requestRepository', $requestRepository);

        $this->subject->updateAction($request);
    }

    /**
     * @test
     */
    public function deleteActionRemovesTheGivenRequestFromRequestRepository()
    {
        $request = new \Glacryl\Glshop\Domain\Model\Request();

        $requestRepository = $this->getMockBuilder(\Glacryl\Glshop\Domain\Repository\RequestRepository::class)
            ->setMethods(['remove'])
            ->disableOriginalConstructor()
            ->getMock();

        $requestRepository->expects(self::once())->method('remove')->with($request);
        $this->inject($this->subject, 'requestRepository', $requestRepository);

        $this->subject->deleteAction($request);
    }
}
