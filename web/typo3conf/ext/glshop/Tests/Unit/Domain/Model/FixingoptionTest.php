<?php
namespace Glacryl\Glshop\Tests\Unit\Domain\Model;

/**
 * Test case.
 *
 * @author Petro Dikij <petro.dikij@glacryl.de>
 */
class FixingoptionTest extends \TYPO3\TestingFramework\Core\Unit\UnitTestCase
{
    /**
     * @var \Glacryl\Glshop\Domain\Model\Fixingoption
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new \Glacryl\Glshop\Domain\Model\Fixingoption();
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
    public function getNameReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getName()
        );
    }

    /**
     * @test
     */
    public function setNameForStringSetsName()
    {
        $this->subject->setName('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'name',
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
    public function getProjectionReturnsInitialValueForFloat()
    {
        self::assertSame(
            0.0,
            $this->subject->getProjection()
        );
    }

    /**
     * @test
     */
    public function setProjectionForFloatSetsProjection()
    {
        $this->subject->setProjection(3.14159265);

        self::assertAttributeEquals(
            3.14159265,
            'projection',
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
    public function getDrillDownsideReturnsInitialValueForFloat()
    {
        self::assertSame(
            0.0,
            $this->subject->getDrillDownside()
        );
    }

    /**
     * @test
     */
    public function setDrillDownsideForFloatSetsDrillDownside()
    {
        $this->subject->setDrillDownside(3.14159265);

        self::assertAttributeEquals(
            3.14159265,
            'drillDownside',
            $this->subject,
            '',
            0.000000001
        );
    }

    /**
     * @test
     */
    public function getBorderLengthReturnsInitialValueForFloat()
    {
        self::assertSame(
            0.0,
            $this->subject->getBorderLength()
        );
    }

    /**
     * @test
     */
    public function setBorderLengthForFloatSetsBorderLength()
    {
        $this->subject->setBorderLength(3.14159265);

        self::assertAttributeEquals(
            3.14159265,
            'borderLength',
            $this->subject,
            '',
            0.000000001
        );
    }

    /**
     * @test
     */
    public function getPositionReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getPosition()
        );
    }

    /**
     * @test
     */
    public function setPositionForStringSetsPosition()
    {
        $this->subject->setPosition('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'position',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getDiameterReturnsInitialValueForFloat()
    {
        self::assertSame(
            0.0,
            $this->subject->getDiameter()
        );
    }

    /**
     * @test
     */
    public function setDiameterForFloatSetsDiameter()
    {
        $this->subject->setDiameter(3.14159265);

        self::assertAttributeEquals(
            3.14159265,
            'diameter',
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
}
