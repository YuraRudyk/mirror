<?php
namespace Glacryl\Glshop\Tests\Unit\Domain\Model;

/**
 * Test case.
 *
 * @author Petro Dikij <petro.dikij@glacryl.de>
 */
class RequestTest extends \TYPO3\TestingFramework\Core\Unit\UnitTestCase
{
    /**
     * @var \Glacryl\Glshop\Domain\Model\Request
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new \Glacryl\Glshop\Domain\Model\Request();
    }

    protected function tearDown()
    {
        parent::tearDown();
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
    public function getTitleReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getTitle()
        );
    }

    /**
     * @test
     */
    public function setTitleForStringSetsTitle()
    {
        $this->subject->setTitle('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'title',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getTextReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getText()
        );
    }

    /**
     * @test
     */
    public function setTextForStringSetsText()
    {
        $this->subject->setText('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'text',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getFilesReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getFiles()
        );
    }

    /**
     * @test
     */
    public function setFilesForStringSetsFiles()
    {
        $this->subject->setFiles('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'files',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getDoneReturnsInitialValueForInt()
    {
        self::assertSame(
            0,
            $this->subject->getDone()
        );
    }

    /**
     * @test
     */
    public function setDoneForIntSetsDone()
    {
        $this->subject->setDone(12);

        self::assertAttributeEquals(
            12,
            'done',
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
