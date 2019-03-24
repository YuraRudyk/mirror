<?php
namespace Glacryl\Glshop\Tests\Unit\Domain\Model;

/**
 * Test case.
 *
 * @author Petro Dikij <petro.dikij@glacryl.de>
 */
class OrderstateTest extends \TYPO3\TestingFramework\Core\Unit\UnitTestCase
{
    /**
     * @var \Glacryl\Glshop\Domain\Model\Orderstate
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new \Glacryl\Glshop\Domain\Model\Orderstate();
    }

    protected function tearDown()
    {
        parent::tearDown();
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
    public function getValueReturnsInitialValueForInt()
    {
        self::assertSame(
            0,
            $this->subject->getValue()
        );
    }

    /**
     * @test
     */
    public function setValueForIntSetsValue()
    {
        $this->subject->setValue(12);

        self::assertAttributeEquals(
            12,
            'value',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getAcrReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getAcr()
        );
    }

    /**
     * @test
     */
    public function setAcrForStringSetsAcr()
    {
        $this->subject->setAcr('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'acr',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getPrefixReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getPrefix()
        );
    }

    /**
     * @test
     */
    public function setPrefixForStringSetsPrefix()
    {
        $this->subject->setPrefix('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'prefix',
            $this->subject
        );
    }
}
