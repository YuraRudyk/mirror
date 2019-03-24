<?php
namespace Glacryl\Glshop\Tests\Unit\Controller;

/**
 * Test case.
 *
 * @author Petro Dikij <petro.dikij@glacryl.de>
 */
class CartControllerTest extends \TYPO3\TestingFramework\Core\Unit\UnitTestCase
{
    /**
     * @var \Glacryl\Glshop\Controller\CartController
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder(\Glacryl\Glshop\Controller\CartController::class)
            ->setMethods(['redirect', 'forward', 'addFlashMessage'])
            ->disableOriginalConstructor()
            ->getMock();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function listActionFetchesAllCartsFromRepositoryAndAssignsThemToView()
    {

        $allCarts = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $cartRepository = $this->getMockBuilder(\Glacryl\Glshop\Domain\Repository\CartRepository::class)
            ->setMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $cartRepository->expects(self::once())->method('findAll')->will(self::returnValue($allCarts));
        $this->inject($this->subject, 'cartRepository', $cartRepository);

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $view->expects(self::once())->method('assign')->with('carts', $allCarts);
        $this->inject($this->subject, 'view', $view);

        $this->subject->listAction();
    }

    /**
     * @test
     */
    public function showActionAssignsTheGivenCartToView()
    {
        $cart = new \Glacryl\Glshop\Domain\Model\Cart();

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $this->inject($this->subject, 'view', $view);
        $view->expects(self::once())->method('assign')->with('cart', $cart);

        $this->subject->showAction($cart);
    }

    /**
     * @test
     */
    public function createActionAddsTheGivenCartToCartRepository()
    {
        $cart = new \Glacryl\Glshop\Domain\Model\Cart();

        $cartRepository = $this->getMockBuilder(\Glacryl\Glshop\Domain\Repository\CartRepository::class)
            ->setMethods(['add'])
            ->disableOriginalConstructor()
            ->getMock();

        $cartRepository->expects(self::once())->method('add')->with($cart);
        $this->inject($this->subject, 'cartRepository', $cartRepository);

        $this->subject->createAction($cart);
    }

    /**
     * @test
     */
    public function editActionAssignsTheGivenCartToView()
    {
        $cart = new \Glacryl\Glshop\Domain\Model\Cart();

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $this->inject($this->subject, 'view', $view);
        $view->expects(self::once())->method('assign')->with('cart', $cart);

        $this->subject->editAction($cart);
    }

    /**
     * @test
     */
    public function updateActionUpdatesTheGivenCartInCartRepository()
    {
        $cart = new \Glacryl\Glshop\Domain\Model\Cart();

        $cartRepository = $this->getMockBuilder(\Glacryl\Glshop\Domain\Repository\CartRepository::class)
            ->setMethods(['update'])
            ->disableOriginalConstructor()
            ->getMock();

        $cartRepository->expects(self::once())->method('update')->with($cart);
        $this->inject($this->subject, 'cartRepository', $cartRepository);

        $this->subject->updateAction($cart);
    }

    /**
     * @test
     */
    public function deleteActionRemovesTheGivenCartFromCartRepository()
    {
        $cart = new \Glacryl\Glshop\Domain\Model\Cart();

        $cartRepository = $this->getMockBuilder(\Glacryl\Glshop\Domain\Repository\CartRepository::class)
            ->setMethods(['remove'])
            ->disableOriginalConstructor()
            ->getMock();

        $cartRepository->expects(self::once())->method('remove')->with($cart);
        $this->inject($this->subject, 'cartRepository', $cartRepository);

        $this->subject->deleteAction($cart);
    }
}
