<?php
namespace Glacryl\Glshop\Tests\Unit\Domain\Model;

/**
 * Test case.
 *
 * @author Petro Dikij <petro.dikij@glacryl.de>
 */
class BordereditingoptionTest extends \TYPO3\TestingFramework\Core\Unit\UnitTestCase
{
    /**
     * @var \Glacryl\Glshop\Domain\Model\Bordereditingoption
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new \Glacryl\Glshop\Domain\Model\Bordereditingoption();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function getFormSizeReturnsInitialValueForFloat()
    {
        self::assertSame(
            0.0,
            $this->subject->getFormSize()
        );
    }

    /**
     * @test
     */
    public function setFormSizeForFloatSetsFormSize()
    {
        $this->subject->setFormSize(3.14159265);

        self::assertAttributeEquals(
            3.14159265,
            'formSize',
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
