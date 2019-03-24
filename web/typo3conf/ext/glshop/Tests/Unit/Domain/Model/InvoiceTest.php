<?php
namespace Glacryl\Glshop\Tests\Unit\Domain\Model;

/**
 * Test case.
 *
 * @author Petro Dikij <petro.dikij@glacryl.de>
 */
class InvoiceTest extends \TYPO3\TestingFramework\Core\Unit\UnitTestCase
{
    /**
     * @var \Glacryl\Glshop\Domain\Model\Invoice
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new \Glacryl\Glshop\Domain\Model\Invoice();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function getFileReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getFile()
        );
    }

    /**
     * @test
     */
    public function setFileForStringSetsFile()
    {
        $this->subject->setFile('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'file',
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
    public function getSendReturnsInitialValueForInt()
    {
        self::assertSame(
            0,
            $this->subject->getSend()
        );
    }

    /**
     * @test
     */
    public function setSendForIntSetsSend()
    {
        $this->subject->setSend(12);

        self::assertAttributeEquals(
            12,
            'send',
            $this->subject
        );
    }
}
