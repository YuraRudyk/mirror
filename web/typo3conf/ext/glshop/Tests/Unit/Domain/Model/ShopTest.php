<?php
namespace Glacryl\Glshop\Tests\Unit\Domain\Model;

/**
 * Test case.
 *
 * @author Petro Dikij <petro.dikij@glacryl.de>
 */
class ShopTest extends \TYPO3\TestingFramework\Core\Unit\UnitTestCase
{
    /**
     * @var \Glacryl\Glshop\Domain\Model\Shop
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new \Glacryl\Glshop\Domain\Model\Shop();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function getUserUploadPathReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getUserUploadPath()
        );
    }

    /**
     * @test
     */
    public function setUserUploadPathForStringSetsUserUploadPath()
    {
        $this->subject->setUserUploadPath('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'userUploadPath',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getConfirmationPathReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getConfirmationPath()
        );
    }

    /**
     * @test
     */
    public function setConfirmationPathForStringSetsConfirmationPath()
    {
        $this->subject->setConfirmationPath('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'confirmationPath',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getProductionPathReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getProductionPath()
        );
    }

    /**
     * @test
     */
    public function setProductionPathForStringSetsProductionPath()
    {
        $this->subject->setProductionPath('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'productionPath',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getDeliveryPathReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getDeliveryPath()
        );
    }

    /**
     * @test
     */
    public function setDeliveryPathForStringSetsDeliveryPath()
    {
        $this->subject->setDeliveryPath('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'deliveryPath',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getInvoicePathReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getInvoicePath()
        );
    }

    /**
     * @test
     */
    public function setInvoicePathForStringSetsInvoicePath()
    {
        $this->subject->setInvoicePath('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'invoicePath',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getMaterialImgPathReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getMaterialImgPath()
        );
    }

    /**
     * @test
     */
    public function setMaterialImgPathForStringSetsMaterialImgPath()
    {
        $this->subject->setMaterialImgPath('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'materialImgPath',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getProductImgPathReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getProductImgPath()
        );
    }

    /**
     * @test
     */
    public function setProductImgPathForStringSetsProductImgPath()
    {
        $this->subject->setProductImgPath('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'productImgPath',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getEditImgPathReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getEditImgPath()
        );
    }

    /**
     * @test
     */
    public function setEditImgPathForStringSetsEditImgPath()
    {
        $this->subject->setEditImgPath('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'editImgPath',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getMaterialFactorReturnsInitialValueForFloat()
    {
        self::assertSame(
            0.0,
            $this->subject->getMaterialFactor()
        );
    }

    /**
     * @test
     */
    public function setMaterialFactorForFloatSetsMaterialFactor()
    {
        $this->subject->setMaterialFactor(3.14159265);

        self::assertAttributeEquals(
            3.14159265,
            'materialFactor',
            $this->subject,
            '',
            0.000000001
        );
    }

    /**
     * @test
     */
    public function getProductFactorReturnsInitialValueForFloat()
    {
        self::assertSame(
            0.0,
            $this->subject->getProductFactor()
        );
    }

    /**
     * @test
     */
    public function setProductFactorForFloatSetsProductFactor()
    {
        $this->subject->setProductFactor(3.14159265);

        self::assertAttributeEquals(
            3.14159265,
            'productFactor',
            $this->subject,
            '',
            0.000000001
        );
    }

    /**
     * @test
     */
    public function getEditFactorReturnsInitialValueForFloat()
    {
        self::assertSame(
            0.0,
            $this->subject->getEditFactor()
        );
    }

    /**
     * @test
     */
    public function setEditFactorForFloatSetsEditFactor()
    {
        $this->subject->setEditFactor(3.14159265);

        self::assertAttributeEquals(
            3.14159265,
            'editFactor',
            $this->subject,
            '',
            0.000000001
        );
    }

    /**
     * @test
     */
    public function getMaterialPrivatFactorReturnsInitialValueForFloat()
    {
        self::assertSame(
            0.0,
            $this->subject->getMaterialPrivatFactor()
        );
    }

    /**
     * @test
     */
    public function setMaterialPrivatFactorForFloatSetsMaterialPrivatFactor()
    {
        $this->subject->setMaterialPrivatFactor(3.14159265);

        self::assertAttributeEquals(
            3.14159265,
            'materialPrivatFactor',
            $this->subject,
            '',
            0.000000001
        );
    }

    /**
     * @test
     */
    public function getProductPrivatFactorReturnsInitialValueForFloat()
    {
        self::assertSame(
            0.0,
            $this->subject->getProductPrivatFactor()
        );
    }

    /**
     * @test
     */
    public function setProductPrivatFactorForFloatSetsProductPrivatFactor()
    {
        $this->subject->setProductPrivatFactor(3.14159265);

        self::assertAttributeEquals(
            3.14159265,
            'productPrivatFactor',
            $this->subject,
            '',
            0.000000001
        );
    }

    /**
     * @test
     */
    public function getEditPrivatFactorReturnsInitialValueForFloat()
    {
        self::assertSame(
            0.0,
            $this->subject->getEditPrivatFactor()
        );
    }

    /**
     * @test
     */
    public function setEditPrivatFactorForFloatSetsEditPrivatFactor()
    {
        $this->subject->setEditPrivatFactor(3.14159265);

        self::assertAttributeEquals(
            3.14159265,
            'editPrivatFactor',
            $this->subject,
            '',
            0.000000001
        );
    }
}
