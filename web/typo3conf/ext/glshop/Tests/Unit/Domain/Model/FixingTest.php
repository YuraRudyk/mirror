<?php
namespace Glacryl\Glshop\Tests\Unit\Domain\Model;

/**
 * Test case.
 *
 * @author Petro Dikij <petro.dikij@glacryl.de>
 */
class FixingTest extends \TYPO3\TestingFramework\Core\Unit\UnitTestCase
{
    /**
     * @var \Glacryl\Glshop\Domain\Model\Fixing
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new \Glacryl\Glshop\Domain\Model\Fixing();
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
    public function getFixingoptionReturnsInitialValueForFixingoption()
    {
        $newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        self::assertEquals(
            $newObjectStorage,
            $this->subject->getFixingoption()
        );
    }

    /**
     * @test
     */
    public function setFixingoptionForObjectStorageContainingFixingoptionSetsFixingoption()
    {
        $fixingoption = new \Glacryl\Glshop\Domain\Model\Fixingoption();
        $objectStorageHoldingExactlyOneFixingoption = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $objectStorageHoldingExactlyOneFixingoption->attach($fixingoption);
        $this->subject->setFixingoption($objectStorageHoldingExactlyOneFixingoption);

        self::assertAttributeEquals(
            $objectStorageHoldingExactlyOneFixingoption,
            'fixingoption',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function addFixingoptionToObjectStorageHoldingFixingoption()
    {
        $fixingoption = new \Glacryl\Glshop\Domain\Model\Fixingoption();
        $fixingoptionObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->setMethods(['attach'])
            ->disableOriginalConstructor()
            ->getMock();

        $fixingoptionObjectStorageMock->expects(self::once())->method('attach')->with(self::equalTo($fixingoption));
        $this->inject($this->subject, 'fixingoption', $fixingoptionObjectStorageMock);

        $this->subject->addFixingoption($fixingoption);
    }

    /**
     * @test
     */
    public function removeFixingoptionFromObjectStorageHoldingFixingoption()
    {
        $fixingoption = new \Glacryl\Glshop\Domain\Model\Fixingoption();
        $fixingoptionObjectStorageMock = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->setMethods(['detach'])
            ->disableOriginalConstructor()
            ->getMock();

        $fixingoptionObjectStorageMock->expects(self::once())->method('detach')->with(self::equalTo($fixingoption));
        $this->inject($this->subject, 'fixingoption', $fixingoptionObjectStorageMock);

        $this->subject->removeFixingoption($fixingoption);
    }
}
