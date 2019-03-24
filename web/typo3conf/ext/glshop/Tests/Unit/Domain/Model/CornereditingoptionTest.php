<?php
namespace Glacryl\Glshop\Tests\Unit\Domain\Model;

/**
 * Test case.
 *
 * @author Petro Dikij <petro.dikij@glacryl.de>
 */
class CornereditingoptionTest extends \TYPO3\TestingFramework\Core\Unit\UnitTestCase
{
    /**
     * @var \Glacryl\Glshop\Domain\Model\Cornereditingoption
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new \Glacryl\Glshop\Domain\Model\Cornereditingoption();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function getFromSizeReturnsInitialValueForFloat()
    {
        self::assertSame(
            0.0,
            $this->subject->getFromSize()
        );
    }

    /**
     * @test
     */
    public function setFromSizeForFloatSetsFromSize()
    {
        $this->subject->setFromSize(3.14159265);

        self::assertAttributeEquals(
            3.14159265,
            'fromSize',
            $this->subject,
            '',
            0.000000001
        );
    }

    /**
     * @test
     */
    public function getToSizeReturnsInitialValueForFloat()
    {
        self::assertSame(
            0.0,
            $this->subject->getToSize()
        );
    }

    /**
     * @test
     */
    public function setToSizeForFloatSetsToSize()
    {
        $this->subject->setToSize(3.14159265);

        self::assertAttributeEquals(
            3.14159265,
            'toSize',
            $this->subject,
            '',
            0.000000001
        );
    }

    /**
     * @test
     */
    public function getPriceReturnsInitialValueForFloat()
    {
        self::assertSame(
            0.0,
            $this->subject->getPrice()
        );
    }

    /**
     * @test
     */
    public function setPriceForFloatSetsPrice()
    {
        $this->subject->setPrice(3.14159265);

        self::assertAttributeEquals(
            3.14159265,
            'price',
            $this->subject,
            '',
            0.000000001
        );
    }
}
