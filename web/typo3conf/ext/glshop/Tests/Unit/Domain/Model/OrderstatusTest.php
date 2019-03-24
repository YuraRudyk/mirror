<?php
namespace Glacryl\Glshop\Tests\Unit\Domain\Model;

/**
 * Test case.
 *
 * @author Petro Dikij <petro.dikij@glacryl.de>
 */
class OrderstatusTest extends \TYPO3\TestingFramework\Core\Unit\UnitTestCase
{
    /**
     * @var \Glacryl\Glshop\Domain\Model\Orderstatus
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new \Glacryl\Glshop\Domain\Model\Orderstatus();
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
    public function getOrderstateReturnsInitialValueForOrderstate()
    {
        self::assertEquals(
            null,
            $this->subject->getOrderstate()
        );
    }

    /**
     * @test
     */
    public function setOrderstateForOrderstateSetsOrderstate()
    {
        $orderstateFixture = new \Glacryl\Glshop\Domain\Model\Orderstate();
        $this->subject->setOrderstate($orderstateFixture);

        self::assertAttributeEquals(
            $orderstateFixture,
            'orderstate',
            $this->subject
        );
    }
}
