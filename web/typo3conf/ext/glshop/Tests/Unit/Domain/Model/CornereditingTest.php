<?php
namespace Glacryl\Glshop\Tests\Unit\Domain\Model;

/**
 * Test case.
 *
 * @author Petro Dikij <petro.dikij@glacryl.de>
 */
class CornereditingTest extends \TYPO3\TestingFramework\Core\Unit\UnitTestCase
{
    /**
     * @var \Glacryl\Glshop\Domain\Model\Cornerediting
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new \Glacryl\Glshop\Domain\Model\Cornerediting();
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
    public function getFormReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getForm()
        );
    }

    /**
     * @test
     */
    public function setFormForStringSetsForm()
    {
        $this->subject->setForm('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'form',
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
    public function getCornereditingoptionReturnsInitialValueForCornereditingoption()
    {
        $newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        self::assertEquals(
            $newObjectStorage,
            $this->subject->getCornereditingoption()
        );
    }

    /**
     * @test
     */
    public function setCornereditingoptionForObjectStorageContainingCornereditingoptionSetsCornereditingoption()
    {
        $cornereditingoption = new \Glacryl\Glshop\Domain\Model\Cornereditingoption();
        $objectStorageHoldingExactlyOneCornereditingoption = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $objectStorageHoldingExactlyOneCornereditingoption->attach($cornereditingoption);
        $this->subject->setCornereditingoption($objectStorageHoldingExactlyOneCornereditingoption);

        self::assertAttributeEquals(
            $objectStorageHoldingExactlyOneCornereditingoption,
            'cornereditingoption',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function addCornereditingoptionToObjectStorageHoldingCornereditingoption()
    {
        $cornereditingoption = new \Glacryl\Glshop\Domain\Model\Cornereditingoption();
        $cornereditingoptionObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->setMethods(['attach'])
            ->disableOriginalConstructor()
            ->getMock();

        $cornereditingoptionObjectStorageMock->expects(self::once())->method('attach')->with(self::equalTo($cornereditingoption));
        $this->inject($this->subject, 'cornereditingoption', $cornereditingoptionObjectStorageMock);

        $this->subject->addCornereditingoption($cornereditingoption);
    }

    /**
     * @test
     */
    public function removeCornereditingoptionFromObjectStorageHoldingCornereditingoption()
    {
        $cornereditingoption = new \Glacryl\Glshop\Domain\Model\Cornereditingoption();
        $cornereditingoptionObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->setMethods(['detach'])
            ->disableOriginalConstructor()
            ->getMock();

        $cornereditingoptionObjectStorageMock->expects(self::once())->method('detach')->with(self::equalTo($cornereditingoption));
        $this->inject($this->subject, 'cornereditingoption', $cornereditingoptionObjectStorageMock);

        $this->subject->removeCornereditingoption($cornereditingoption);
    }
}
