<?php
namespace Glacryl\Glshop\Tests\Unit\Domain\Model;

/**
 * Test case.
 *
 * @author Petro Dikij <petro.dikij@glacryl.de>
 */
class MaterialoptionTest extends \TYPO3\TestingFramework\Core\Unit\UnitTestCase
{
    /**
     * @var \Glacryl\Glshop\Domain\Model\Materialoption
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new \Glacryl\Glshop\Domain\Model\Materialoption();
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
    public function getMaterialoptiontypeReturnsInitialValueForMaterialoptiontype()
    {
        $newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        self::assertEquals(
            $newObjectStorage,
            $this->subject->getMaterialoptiontype()
        );
    }

    /**
     * @test
     */
    public function setMaterialoptiontypeForObjectStorageContainingMaterialoptiontypeSetsMaterialoptiontype()
    {
        $materialoptiontype = new \Glacryl\Glshop\Domain\Model\Materialoptiontype();
        $objectStorageHoldingExactlyOneMaterialoptiontype = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $objectStorageHoldingExactlyOneMaterialoptiontype->attach($materialoptiontype);
        $this->subject->setMaterialoptiontype($objectStorageHoldingExactlyOneMaterialoptiontype);

        self::assertAttributeEquals(
            $objectStorageHoldingExactlyOneMaterialoptiontype,
            'materialoptiontype',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function addMaterialoptiontypeToObjectStorageHoldingMaterialoptiontype()
    {
        $materialoptiontype = new \Glacryl\Glshop\Domain\Model\Materialoptiontype();
        $materialoptiontypeObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->setMethods(['attach'])
            ->disableOriginalConstructor()
            ->getMock();

        $materialoptiontypeObjectStorageMock->expects(self::once())->method('attach')->with(self::equalTo($materialoptiontype));
        $this->inject($this->subject, 'materialoptiontype', $materialoptiontypeObjectStorageMock);

        $this->subject->addMaterialoptiontype($materialoptiontype);
    }

    /**
     * @test
     */
    public function removeMaterialoptiontypeFromObjectStorageHoldingMaterialoptiontype()
    {
        $materialoptiontype = new \Glacryl\Glshop\Domain\Model\Materialoptiontype();
        $materialoptiontypeObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->setMethods(['detach'])
            ->disableOriginalConstructor()
            ->getMock();

        $materialoptiontypeObjectStorageMock->expects(self::once())->method('detach')->with(self::equalTo($materialoptiontype));
        $this->inject($this->subject, 'materialoptiontype', $materialoptiontypeObjectStorageMock);

        $this->subject->removeMaterialoptiontype($materialoptiontype);
    }
}
