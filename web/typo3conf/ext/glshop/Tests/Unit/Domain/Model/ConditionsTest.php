<?php
namespace Glacryl\Glshop\Tests\Unit\Domain\Model;

/**
 * Test case.
 *
 * @author Petro Dikij <petro.dikij@glacryl.de>
 */
class ConditionsTest extends \TYPO3\TestingFramework\Core\Unit\UnitTestCase
{
    /**
     * @var \Glacryl\Glshop\Domain\Model\Conditions
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new \Glacryl\Glshop\Domain\Model\Conditions();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function getDaysReturnsInitialValueForInt()
    {
        self::assertSame(
            0,
            $this->subject->getDays()
        );
    }

    /**
     * @test
     */
    public function setDaysForIntSetsDays()
    {
        $this->subject->setDays(12);

        self::assertAttributeEquals(
            12,
            'days',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getReductionReturnsInitialValueForInt()
    {
        self::assertSame(
            0,
            $this->subject->getReduction()
        );
    }

    /**
     * @test
     */
    public function setReductionForIntSetsReduction()
    {
        $this->subject->setReduction(12);

        self::assertAttributeEquals(
            12,
            'reduction',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getNettoReturnsInitialValueForInt()
    {
        self::assertSame(
            0,
            $this->subject->getNetto()
        );
    }

    /**
     * @test
     */
    public function setNettoForIntSetsNetto()
    {
        $this->subject->setNetto(12);

        self::assertAttributeEquals(
            12,
            'netto',
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
