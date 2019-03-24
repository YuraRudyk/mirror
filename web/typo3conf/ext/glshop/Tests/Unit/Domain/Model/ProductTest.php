<?php
namespace Glacryl\Glshop\Tests\Unit\Domain\Model;

/**
 * Test case.
 *
 * @author Petro Dikij <petro.dikij@glacryl.de>
 */
class ProductTest extends \TYPO3\TestingFramework\Core\Unit\UnitTestCase
{
    /**
     * @var \Glacryl\Glshop\Domain\Model\Product
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new \Glacryl\Glshop\Domain\Model\Product();
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
    public function getProductoptionReturnsInitialValueForProductoption()
    {
        $newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        self::assertEquals(
            $newObjectStorage,
            $this->subject->getProductoption()
        );
    }

    /**
     * @test
     */
    public function setProductoptionForObjectStorageContainingProductoptionSetsProductoption()
    {
        $productoption = new \Glacryl\Glshop\Domain\Model\Productoption();
        $objectStorageHoldingExactlyOneProductoption = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $objectStorageHoldingExactlyOneProductoption->attach($productoption);
        $this->subject->setProductoption($objectStorageHoldingExactlyOneProductoption);

        self::assertAttributeEquals(
            $objectStorageHoldingExactlyOneProductoption,
            'productoption',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function addProductoptionToObjectStorageHoldingProductoption()
    {
        $productoption = new \Glacryl\Glshop\Domain\Model\Productoption();
        $productoptionObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->setMethods(['attach'])
            ->disableOriginalConstructor()
            ->getMock();

        $productoptionObjectStorageMock->expects(self::once())->method('attach')->with(self::equalTo($productoption));
        $this->inject($this->subject, 'productoption', $productoptionObjectStorageMock);

        $this->subject->addProductoption($productoption);
    }

    /**
     * @test
     */
    public function removeProductoptionFromObjectStorageHoldingProductoption()
    {
        $productoption = new \Glacryl\Glshop\Domain\Model\Productoption();
        $productoptionObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->setMethods(['detach'])
            ->disableOriginalConstructor()
            ->getMock();

        $productoptionObjectStorageMock->expects(self::once())->method('detach')->with(self::equalTo($productoption));
        $this->inject($this->subject, 'productoption', $productoptionObjectStorageMock);

        $this->subject->removeProductoption($productoption);
    }
}
