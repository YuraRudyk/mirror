<?php
namespace Glacryl\Glshop\Tests\Unit\Domain\Model;

/**
 * Test case.
 *
 * @author Petro Dikij <petro.dikij@glacryl.de>
 */
class NoticelistTest extends \TYPO3\TestingFramework\Core\Unit\UnitTestCase
{
    /**
     * @var \Glacryl\Glshop\Domain\Model\Noticelist
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new \Glacryl\Glshop\Domain\Model\Noticelist();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function getNoticeNrReturnsInitialValueForInt()
    {
        self::assertSame(
            0,
            $this->subject->getNoticeNr()
        );
    }

    /**
     * @test
     */
    public function setNoticeNrForIntSetsNoticeNr()
    {
        $this->subject->setNoticeNr(12);

        self::assertAttributeEquals(
            12,
            'noticeNr',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getDateReturnsInitialValueForDateTime()
    {
        self::assertEquals(
            null,
            $this->subject->getDate()
        );
    }

    /**
     * @test
     */
    public function setDateForDateTimeSetsDate()
    {
        $dateTimeFixture = new \DateTime();
        $this->subject->setDate($dateTimeFixture);

        self::assertAttributeEquals(
            $dateTimeFixture,
            'date',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getArticleReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getArticle()
        );
    }

    /**
     * @test
     */
    public function setArticleForStringSetsArticle()
    {
        $this->subject->setArticle('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'article',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getExpireReturnsInitialValueForDateTime()
    {
        self::assertEquals(
            null,
            $this->subject->getExpire()
        );
    }

    /**
     * @test
     */
    public function setExpireForDateTimeSetsExpire()
    {
        $dateTimeFixture = new \DateTime();
        $this->subject->setExpire($dateTimeFixture);

        self::assertAttributeEquals(
            $dateTimeFixture,
            'expire',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getUserReturnsInitialValueFor()
    {
    }

    /**
     * @test
     */
    public function setUserForSetsUser()
    {
    }
}
