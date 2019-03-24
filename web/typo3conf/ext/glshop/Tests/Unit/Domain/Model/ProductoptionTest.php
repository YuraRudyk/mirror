<?php
namespace Glacryl\Glshop\Tests\Unit\Domain\Model;

/**
 * Test case.
 *
 * @author Petro Dikij <petro.dikij@glacryl.de>
 */
class ProductoptionTest extends \TYPO3\TestingFramework\Core\Unit\UnitTestCase
{
    /**
     * @var \Glacryl\Glshop\Domain\Model\Productoption
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new \Glacryl\Glshop\Domain\Model\Productoption();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function getArticleNrReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getArticleNr()
        );
    }

    /**
     * @test
     */
    public function setArticleNrForStringSetsArticleNr()
    {
        $this->subject->setArticleNr('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'articleNr',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getDescriptionReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getDescription()
        );
    }

    /**
     * @test
     */
    public function setDescriptionForStringSetsDescription()
    {
        $this->subject->setDescription('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'description',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getPicReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getPic()
        );
    }

    /**
     * @test
     */
    public function setPicForStringSetsPic()
    {
        $this->subject->setPic('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'pic',
            $this->subject
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
    public function getWidthReturnsInitialValueForFloat()
    {
        self::assertSame(
            0.0,
            $this->subject->getWidth()
        );
    }

    /**
     * @test
     */
    public function setWidthForFloatSetsWidth()
    {
        $this->subject->setWidth(3.14159265);

        self::assertAttributeEquals(
            3.14159265,
            'width',
            $this->subject,
            '',
            0.000000001
        );
    }

    /**
     * @test
     */
    public function getLengthReturnsInitialValueForFloat()
    {
        self::assertSame(
            0.0,
            $this->subject->getLength()
        );
    }

    /**
     * @test
     */
    public function setLengthForFloatSetsLength()
    {
        $this->subject->setLength(3.14159265);

        self::assertAttributeEquals(
            3.14159265,
            'length',
            $this->subject,
            '',
            0.000000001
        );
    }

    /**
     * @test
     */
    public function getHeightReturnsInitialValueForFloat()
    {
        self::assertSame(
            0.0,
            $this->subject->getHeight()
        );
    }

    /**
     * @test
     */
    public function setHeightForFloatSetsHeight()
    {
        $this->subject->setHeight(3.14159265);

        self::assertAttributeEquals(
            3.14159265,
            'height',
            $this->subject,
            '',
            0.000000001
        );
    }

    /**
     * @test
     */
    public function getSizeReturnsInitialValueForFloat()
    {
        self::assertSame(
            0.0,
            $this->subject->getSize()
        );
    }

    /**
     * @test
     */
    public function setSizeForFloatSetsSize()
    {
        $this->subject->setSize(3.14159265);

        self::assertAttributeEquals(
            3.14159265,
            'size',
            $this->subject,
            '',
            0.000000001
        );
    }
}
