<?php
namespace Glacryl\Glshop\Tests\Unit\Controller;

/**
 * Test case.
 *
 * @author Petro Dikij <petro.dikij@glacryl.de>
 */
class NoticelistControllerTest extends \TYPO3\TestingFramework\Core\Unit\UnitTestCase
{
    /**
     * @var \Glacryl\Glshop\Controller\NoticelistController
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder(\Glacryl\Glshop\Controller\NoticelistController::class)
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
    public function listActionFetchesAllNoticelistsFromRepositoryAndAssignsThemToView()
    {

        $allNoticelists = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $noticelistRepository = $this->getMockBuilder(\Glacryl\Glshop\Domain\Repository\NoticelistRepository::class)
            ->setMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $noticelistRepository->expects(self::once())->method('findAll')->will(self::returnValue($allNoticelists));
        $this->inject($this->subject, 'noticelistRepository', $noticelistRepository);

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $view->expects(self::once())->method('assign')->with('noticelists', $allNoticelists);
        $this->inject($this->subject, 'view', $view);

        $this->subject->listAction();
    }

    /**
     * @test
     */
    public function showActionAssignsTheGivenNoticelistToView()
    {
        $noticelist = new \Glacryl\Glshop\Domain\Model\Noticelist();

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $this->inject($this->subject, 'view', $view);
        $view->expects(self::once())->method('assign')->with('noticelist', $noticelist);

        $this->subject->showAction($noticelist);
    }

    /**
     * @test
     */
    public function createActionAddsTheGivenNoticelistToNoticelistRepository()
    {
        $noticelist = new \Glacryl\Glshop\Domain\Model\Noticelist();

        $noticelistRepository = $this->getMockBuilder(\Glacryl\Glshop\Domain\Repository\NoticelistRepository::class)
            ->setMethods(['add'])
            ->disableOriginalConstructor()
            ->getMock();

        $noticelistRepository->expects(self::once())->method('add')->with($noticelist);
        $this->inject($this->subject, 'noticelistRepository', $noticelistRepository);

        $this->subject->createAction($noticelist);
    }

    /**
     * @test
     */
    public function deleteActionRemovesTheGivenNoticelistFromNoticelistRepository()
    {
        $noticelist = new \Glacryl\Glshop\Domain\Model\Noticelist();

        $noticelistRepository = $this->getMockBuilder(\Glacryl\Glshop\Domain\Repository\NoticelistRepository::class)
            ->setMethods(['remove'])
            ->disableOriginalConstructor()
            ->getMock();

        $noticelistRepository->expects(self::once())->method('remove')->with($noticelist);
        $this->inject($this->subject, 'noticelistRepository', $noticelistRepository);

        $this->subject->deleteAction($noticelist);
    }
}
