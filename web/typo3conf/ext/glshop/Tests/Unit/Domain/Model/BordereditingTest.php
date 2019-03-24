<?php
namespace Glacryl\Glshop\Tests\Unit\Domain\Model;

/**
 * Test case.
 *
 * @author Petro Dikij <petro.dikij@glacryl.de>
 */
class BordereditingTest extends \TYPO3\TestingFramework\Core\Unit\UnitTestCase
{
    /**
     * @var \Glacryl\Glshop\Domain\Model\Borderediting
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new \Glacryl\Glshop\Domain\Model\Borderediting();
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
    public function getBordereditingoptionReturnsInitialValueForBordereditingoption()
    {
        $newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        self::assertEquals(
            $newObjectStorage,
            $this->subject->getBordereditingoption()
        );
    }

    /**
     * @test
     */
    public function setBordereditingoptionForObjectStorageContainingBordereditingoptionSetsBordereditingoption()
    {
        $bordereditingoption = new \Glacryl\Glshop\Domain\Model\Bordereditingoption();
        $objectStorageHoldingExactlyOneBordereditingoption = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $objectStorageHoldingExactlyOneBordereditingoption->attach($bordereditingoption);
        $this->subject->setBordereditingoption($objectStorageHoldingExactlyOneBordereditingoption);

        self::assertAttributeEquals(
            $objectStorageHoldingExactlyOneBordereditingoption,
            'bordereditingoption',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function addBordereditingoptionToObjectStorageHoldingBordereditingoption()
    {
        $bordereditingoption = new \Glacryl\Glshop\Domain\Model\Bordereditingoption();
        $bordereditingoptionObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->setMethods(['attach'])
            ->disableOriginalConstructor()
            ->getMock();

        $bordereditingoptionObjectStorageMock->expects(self::once())->method('attach')->with(self::equalTo($bordereditingoption));
        $this->inject($this->subject, 'bordereditingoption', $bordereditingoptionObjectStorageMock);

        $this->subject->addBordereditingoption($bordereditingoption);
    }

    /**
     * @test
     */
    public function removeBordereditingoptionFromObjectStorageHoldingBordereditingoption()
    {
        $bordereditingoption = new \Glacryl\Glshop\Domain\Model\Bordereditingoption();
        $bordereditingoptionObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->setMethods(['detach'])
            ->disableOriginalConstructor()
            ->getMock();

        $bordereditingoptionObjectStorageMock->expects(self::once())->method('detach')->with(self::equalTo($bordereditingoption));
        $this->inject($this->subject, 'bordereditingoption', $bordereditingoptionObjectStorageMock);

        $this->subject->removeBordereditingoption($bordereditingoption);
    }
}
