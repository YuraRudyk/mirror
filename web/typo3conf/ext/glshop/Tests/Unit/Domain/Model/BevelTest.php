<?php
namespace Glacryl\Glshop\Tests\Unit\Domain\Model;

/**
 * Test case.
 *
 * @author Petro Dikij <petro.dikij@glacryl.de>
 */
class BevelTest extends \TYPO3\TestingFramework\Core\Unit\UnitTestCase
{
    /**
     * @var \Glacryl\Glshop\Domain\Model\Bevel
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new \Glacryl\Glshop\Domain\Model\Bevel();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function getThreadReturnsInitialValueForFloat()
    {
        self::assertSame(
            0.0,
            $this->subject->getThread()
        );
    }

    /**
     * @test
     */
    public function setThreadForFloatSetsThread()
    {
        $this->subject->setThread(3.14159265);

        self::assertAttributeEquals(
            3.14159265,
            'thread',
            $this->subject,
            '',
            0.000000001
        );
    }

    /**
     * @test
     */
    public function getDrillReturnsInitialValueForFloat()
    {
        self::assertSame(
            0.0,
            $this->subject->getDrill()
        );
    }

    /**
     * @test
     */
    public function setDrillForFloatSetsDrill()
    {
        $this->subject->setDrill(3.14159265);

        self::assertAttributeEquals(
            3.14159265,
            'drill',
            $this->subject,
            '',
            0.000000001
        );
    }

    /**
     * @test
     */
    public function getBevelReturnsInitialValueForFloat()
    {
        self::assertSame(
            0.0,
            $this->subject->getBevel()
        );
    }

    /**
     * @test
     */
    public function setBevelForFloatSetsBevel()
    {
        $this->subject->setBevel(3.14159265);

        self::assertAttributeEquals(
            3.14159265,
            'bevel',
            $this->subject,
            '',
            0.000000001
        );
    }

    /**
     * @test
     */
    public function getDepthReturnsInitialValueForFloat()
    {
        self::assertSame(
            0.0,
            $this->subject->getDepth()
        );
    }

    /**
     * @test
     */
    public function setDepthForFloatSetsDepth()
    {
        $this->subject->setDepth(3.14159265);

        self::assertAttributeEquals(
            3.14159265,
            'depth',
            $this->subject,
            '',
            0.000000001
        );
    }
}
