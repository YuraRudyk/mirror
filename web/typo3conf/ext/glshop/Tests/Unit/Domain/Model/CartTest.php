<?php
namespace Glacryl\Glshop\Tests\Unit\Domain\Model;

/**
 * Test case.
 *
 * @author Petro Dikij <petro.dikij@glacryl.de>
 */
class CartTest extends \TYPO3\TestingFramework\Core\Unit\UnitTestCase
{
    /**
     * @var \Glacryl\Glshop\Domain\Model\Cart
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new \Glacryl\Glshop\Domain\Model\Cart();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function getSessionIdReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getSessionId()
        );
    }

    /**
     * @test
     */
    public function setSessionIdForStringSetsSessionId()
    {
        $this->subject->setSessionId('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'sessionId',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getPositionReturnsInitialValueForInt()
    {
        self::assertSame(
            0,
            $this->subject->getPosition()
        );
    }

    /**
     * @test
     */
    public function setPositionForIntSetsPosition()
    {
        $this->subject->setPosition(12);

        self::assertAttributeEquals(
            12,
            'position',
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
    public function getQtyReturnsInitialValueForInt()
    {
        self::assertSame(
            0,
            $this->subject->getQty()
        );
    }

    /**
     * @test
     */
    public function setQtyForIntSetsQty()
    {
        $this->subject->setQty(12);

        self::assertAttributeEquals(
            12,
            'qty',
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
