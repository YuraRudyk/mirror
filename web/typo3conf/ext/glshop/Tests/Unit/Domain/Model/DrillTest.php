<?php
namespace Glacryl\Glshop\Tests\Unit\Domain\Model;

/**
 * Test case.
 *
 * @author Petro Dikij <petro.dikij@glacryl.de>
 */
class DrillTest extends \TYPO3\TestingFramework\Core\Unit\UnitTestCase
{
    /**
     * @var \Glacryl\Glshop\Domain\Model\Drill
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new \Glacryl\Glshop\Domain\Model\Drill();
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
    public function getDrilloptionReturnsInitialValueForDrilloption()
    {
        $newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        self::assertEquals(
            $newObjectStorage,
            $this->subject->getDrilloption()
        );
    }

    /**
     * @test
     */
    public function setDrilloptionForObjectStorageContainingDrilloptionSetsDrilloption()
    {
        $drilloption = new \Glacryl\Glshop\Domain\Model\Drilloption();
        $objectStorageHoldingExactlyOneDrilloption = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $objectStorageHoldingExactlyOneDrilloption->attach($drilloption);
        $this->subject->setDrilloption($objectStorageHoldingExactlyOneDrilloption);

        self::assertAttributeEquals(
            $objectStorageHoldingExactlyOneDrilloption,
            'drilloption',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function addDrilloptionToObjectStorageHoldingDrilloption()
    {
        $drilloption = new \Glacryl\Glshop\Domain\Model\Drilloption();
        $drilloptionObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->setMethods(['attach'])
            ->disableOriginalConstructor()
            ->getMock();

        $drilloptionObjectStorageMock->expects(self::once())->method('attach')->with(self::equalTo($drilloption));
        $this->inject($this->subject, 'drilloption', $drilloptionObjectStorageMock);

        $this->subject->addDrilloption($drilloption);
    }

    /**
     * @test
     */
    public function removeDrilloptionFromObjectStorageHoldingDrilloption()
    {
        $drilloption = new \Glacryl\Glshop\Domain\Model\Drilloption();
        $drilloptionObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->setMethods(['detach'])
            ->disableOriginalConstructor()
            ->getMock();

        $drilloptionObjectStorageMock->expects(self::once())->method('detach')->with(self::equalTo($drilloption));
        $this->inject($this->subject, 'drilloption', $drilloptionObjectStorageMock);

        $this->subject->removeDrilloption($drilloption);
    }
}
