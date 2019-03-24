<?php
namespace Glacryl\Glshop\Tests\Unit\Domain\Model;

/**
 * Test case.
 *
 * @author Petro Dikij <petro.dikij@glacryl.de>
 */
class MaterialTest extends \TYPO3\TestingFramework\Core\Unit\UnitTestCase
{
    /**
     * @var \Glacryl\Glshop\Domain\Model\Material
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new \Glacryl\Glshop\Domain\Model\Material();
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
    public function getMaterialoptionReturnsInitialValueForMaterialoption()
    {
        $newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        self::assertEquals(
            $newObjectStorage,
            $this->subject->getMaterialoption()
        );
    }

    /**
     * @test
     */
    public function setMaterialoptionForObjectStorageContainingMaterialoptionSetsMaterialoption()
    {
        $materialoption = new \Glacryl\Glshop\Domain\Model\Materialoption();
        $objectStorageHoldingExactlyOneMaterialoption = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $objectStorageHoldingExactlyOneMaterialoption->attach($materialoption);
        $this->subject->setMaterialoption($objectStorageHoldingExactlyOneMaterialoption);

        self::assertAttributeEquals(
            $objectStorageHoldingExactlyOneMaterialoption,
            'materialoption',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function addMaterialoptionToObjectStorageHoldingMaterialoption()
    {
        $materialoption = new \Glacryl\Glshop\Domain\Model\Materialoption();
        $materialoptionObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->setMethods(['attach'])
            ->disableOriginalConstructor()
            ->getMock();

        $materialoptionObjectStorageMock->expects(self::once())->method('attach')->with(self::equalTo($materialoption));
        $this->inject($this->subject, 'materialoption', $materialoptionObjectStorageMock);

        $this->subject->addMaterialoption($materialoption);
    }

    /**
     * @test
     */
    public function removeMaterialoptionFromObjectStorageHoldingMaterialoption()
    {
        $materialoption = new \Glacryl\Glshop\Domain\Model\Materialoption();
        $materialoptionObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->setMethods(['detach'])
            ->disableOriginalConstructor()
            ->getMock();

        $materialoptionObjectStorageMock->expects(self::once())->method('detach')->with(self::equalTo($materialoption));
        $this->inject($this->subject, 'materialoption', $materialoptionObjectStorageMock);

        $this->subject->removeMaterialoption($materialoption);
    }
}
