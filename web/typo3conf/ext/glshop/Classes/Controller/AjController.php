<?php

namespace Glacryl\Glshop\Controller;

class AjController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

	/**
	 * ShippingaddressRepository
	 *
	 * @var \Glacryl\Glshop\Domain\Repository\ShippingaddressRepository
	 * @inject
	 */
	protected $shippingadressRepository;

	/**
	 * GutscheinRepository
	 *
	 * @var \Glacryl\Glshop\Domain\Repository\GutscheinRepository
	 * @inject
	 */
	protected $gutscheinRepository;

	/**
	 * GutscheinUsageRepository
	 *
	 * @var \Glacryl\Glshop\Domain\Repository\GutscheinUsageRepository
	 * @inject
	 */
	protected $gutscheinUsageRepository;

	/**
	 * CustomerController
	 *
	 * @var \Glacryl\Glshop\Controller\CustomerController
	 * @inject
	 */
	protected $customerController;

	/**
	 * CartController
	 *
	 * @var \Glacryl\Glshop\Controller\CartController
	 * @inject
	 */
	protected $cartController;

	/**
	 * OrderController
	 *
	 * @var \Glacryl\Glshop\Controller\OrderController
	 * @inject
	 */
	protected $orderController;

	/**
	 * PriceController
	 *
	 * @var \Glacryl\Glshop\Controller\PriceController
	 * @inject
	 */
	protected $priceController;

	/**
	 * ProduktartController
	 *
	 * @var \Glacryl\Glshop\Controller\ProduktartController
	 * @inject
	 */
	protected $produktartController;

	/**
	 * NoticelistController
	 *
	 * @var \Glacryl\Glshop\Controller\NoticelistController
	 * @inject
	 */
	protected $noticelistController;

	/**
	 * PriceRepository
	 *
	 * @var \Glacryl\Glshop\Domain\Repository\PriceRepository
	 * @inject
	 */
	protected $priceRepository;

	/**
	 * ShopRepository
	 *
	 * @var \Glacryl\Glshop\Domain\Repository\ShopRepository
	 * @inject
	 */
	protected $shopRepository;

	/**
	 * CartRepository
	 *
	 * @var \Glacryl\Glshop\Domain\Repository\CartRepository
	 * @inject
	 */
	protected $cartRepository;

	/**
	 * NoticelistRepository
	 *
	 * @var \Glacryl\Glshop\Domain\Repository\NoticelistRepository
	 * @inject
	 */
	protected $noticelistRepository;

	/**
	 * ProductionRepository
	 *
	 * @var \Glacryl\Glshop\Domain\Repository\ProductionRepository
	 * @inject
	 */
	protected $productionRepository;

	/**
	 * DeliveryRepository
	 *
	 * @var \Glacryl\Glshop\Domain\Repository\DeliveryRepository
	 * @inject
	 */
	protected $deliveryRepository;

	/**
	 * InvoiceRepository
	 *
	 * @var \Glacryl\Glshop\Domain\Repository\InvoiceRepository
	 * @inject
	 */
	protected $invoiceRepository;

	/**
	 * ConfirmationRepository
	 *
	 * @var \Glacryl\Glshop\Domain\Repository\ConfirmationRepository
	 * @inject
	 */
	protected $confirmationRepository;

	/**
	 * CustomerRepository 
	 * 
	 *
	 * @var \Glacryl\Glshop\Domain\Repository\CustomerRepository
	 * @inject
	 */
	protected $customerRepository;

	/**
	 * ConditionsRepository
	 * 
	 *
	 * @var \Glacryl\Glshop\Domain\Repository\ConditionsRepository
	 * @inject
	 */
	protected $conditionsRepository;

	/**
	 * MaillUtility utility class
	 *
	 * @var \TYPO3\CMS\Core\Utility\MailUtility
	 * @inject
	 */
	protected $mailUtility;

	/**
	 * OrderRepository
	 *
	 * @var \Glacryl\Glshop\Domain\Repository\OrderRepository
	 * @inject
	 */
	protected $orderRepository;

	/**
	 * OrderstatusRepository
	 *
	 * @var \Glacryl\Glshop\Domain\Repository\OrderstatusRepository
	 * @inject
	 */
	protected $orderstatusRepository;

	/**
	 * BevelRepository
	 *
	 * @var \Glacryl\Glshop\Domain\Repository\BevelRepository
	 * @inject
	 */
	protected $bevelRepository;

	/**
	 * MaterialRepository
	 *
	 * @var \Glacryl\Glshop\Domain\Repository\MaterialRepository
	 * @inject
	 */
	protected $materialRepository;

	/**
	 * BordereditingRepository
	 *
	 * @var \Glacryl\Glshop\Domain\Repository\BordereditingRepository
	 * @inject
	 */
	protected $bordereditingRepository;

	/**
	 * CornereditingRepository
	 *
	 * @var \Glacryl\Glshop\Domain\Repository\CornereditingRepository
	 * @inject
	 */
	protected $cornereditingRepository;

	/**
	 * FixingRepository
	 *
	 * @var \Glacryl\Glshop\Domain\Repository\FixingRepository
	 * @inject
	 */
	protected $fixingRepository;

	/**
	 * DrillRepository
	 *
	 * @var \Glacryl\Glshop\Domain\Repository\DrillRepository
	 * @inject
	 */
	protected $drillRepository;

	/**
	 * OrderstateRepository
	 *
	 * @var \Glacryl\Glshop\Domain\Repository\OrderstateRepository
	 * @inject
	 */
	protected $orderstateRepository;

	/**
	 * RechnungsbuchRepository
	 *
	 * @var \Glacryl\Glshop\Domain\Repository\RechnungsbuchRepository
	 * @inject
	 */
	protected $rechnungsbuchRepository;

	/**
	 * StatusRepository
	 *
	 * @var \Glacryl\Glshop\Domain\Repository\StatusRepository
	 * @inject
	 */
	protected $statusRepository;

	/**
	 * BereichRepository
	 *
	 * @var \Glacryl\Glshop\Domain\Repository\BereichRepository
	 * @inject
	 */
	protected $bereichRepository;
	protected $ajax = false;

	/**
	 * KonfiguratorData
	 * 
	 * @var \array
	 */
	protected $konfiguratorData = array(
		'material' => array(),
		'ecken' => array(),
		'kanten' => array(),
		'halter' => array(),
		'bohrungen' => array(),
		'senkungen' => array(),
		'mFactor' => array(),
		'mFactorInflation' => 1,
		'pFactorInflation' => 1,
		'eFactorInflation' => 1,
		'edit' => array(),
		'tempern' => 0,
		'produktart' => array()
	);
	protected $filePrefix = array(
		'ab' => 'BI_',
		'fe' => 'FE_I',
		'ls' => 'LS_I',
		'lsK' => 'LSK_I',
		're' => 'RE_I',
		'reK' => 'REK_I',
	);
	protected $orderStatus = array(
		'st' => 0,
		'eg' => 1,
		'ab' => 2,
		'fe' => 3,
		'ls' => 4,
		'lsK' => 4,
		're' => 5,
		'reK' => 5,
	);

	/**
	 * MÃƒÂ¶gliche Bestellstatusse Bezeichnungen
	 * 
	 * @var array orderStatusName
	 */
	protected $orderStatusName = array(
		0 => 'Storniert',
		1 => 'Eingegangen',
		2 => 'Gepr&uuml;ft',
		3 => 'In Fertigung',
		4 => 'Versendet',
		5 => 'Abgerechnet',
	);

	/**
	 * Ajax action returns konfigData in json encoding
	 *
	 * @return string JSON encoded konfigData
	 */
	public function ajaxAction() {
        \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump('test');exit;

//		$args = $this->request->getArguments();

		if (isset($args['positionNr']) && $args['positionNr'] != '') {
			$userId = $GLOBALS['TSFE']->fe_user->user['uid'];
			$sessId = $GLOBALS['TSFE']->fe_user->user['ses_id'];

			$posNr = $args['positionNr'];
			$cartItems = $this->cartRepository->getCurrentCartItems($userId, $sessId);

			foreach ($cartItems as $cartItem) {
				if (intval($cartItem->getPosition()) == intval($posNr)) {
					//$this->debugTypo($cartItem); 		
					$this->konfiguratorData['edit'] = array(
						'article' => unserialize($cartItem->getArticle()),
						'qty' => $cartItem->getQty(),
						'uid' => $cartItem->getUid(),
						'posNr' => $cartItem->getPosition()
					);
				}
			}
		}

		// ermittle KonfiguratorDaten
		$this->setKonfiguratorData();

		//$this->debugTypo($this->konfiguratorData);
		return json_encode($this->konfiguratorData);
	}

	public function rahmenKonfigAction() {
		if (!isset($GLOBALS['TCA'])) {
			$GLOBALS['TSFE']->includeTCA();
		}
		$args = $this->request->getArguments();

		if (isset($args['positionNr']) && $args['positionNr'] != '') {
			$userId = $GLOBALS['TSFE']->fe_user->user['uid'];
			$sessId = $GLOBALS['TSFE']->fe_user->user['ses_id'];

			$posNr = $args['positionNr'];
			$cartItems = $this->cartRepository->getCurrentCartItems($userId, $sessId);

			foreach ($cartItems as $cartItem) {
				if (intval($cartItem->getPosition()) == intval($posNr)) {
					$this->konfiguratorData['edit'] = array(
						'article' => unserialize($cartItem->getArticle()),
						'qty' => $cartItem->getQty(),
						'uid' => $cartItem->getUid(),
						'posNr' => $cartItem->getPosition()
					);
				}
			}
		}

		$rahmenData = $this->produktartController->getDataForRahmenKonfigurator();

		return json_encode($rahmenData);
	}

	/**
	 * ProductsAction - return Products
	 *
	 * @return string JSON encoded products
	 */
	public function getProductsAction() {
		if (!isset($GLOBALS['TCA'])) {
			$GLOBALS['TSFE']->includeTCA();
		}
		$group = intval($GLOBALS['TSFE']->fe_user->user['usergroup']);
		$pFactorInflation = ($group == 4 ? $this->shopRepository->findByAKey('demoFactor') : ($group == 3 ? $this->shopRepository->findByAKey('productPrivatFactor') : $this->shopRepository->findByAKey('productFactor')));

		$products = $this->fixingRepository->getHalter();
		return json_encode(array('products' => $products, 'config' => $pFactorInflation->getFirst()->getAValue()));
	}

	public function setKonfiguratorData() {
		if (!isset($GLOBALS['TCA'])) {
			$GLOBALS['TSFE']->includeTCA();
		}

		//$this->debugTypo($this->konfiguratorData, '1', true);

		$group = intval($GLOBALS['TSFE']->fe_user->user['usergroup']);

		$mFactorInflation = ($group == 4 ? $this->shopRepository->findByAKey('demoFactor') : ($group == 3 ? $this->shopRepository->findByAKey('materialPrivatFactor') : $this->shopRepository->findByAKey('materialFactor')));
		$pFactorInflation = ($group == 4 ? $this->shopRepository->findByAKey('demoFactor') : ($group == 3 ? $this->shopRepository->findByAKey('productPrivatFactor') : $this->shopRepository->findByAKey('productFactor')));
		$eFactorInflation = ($group == 4 ? $this->shopRepository->findByAKey('demoFactor') : ($group == 3 ? $this->shopRepository->findByAKey('editPrivatFactor') : $this->shopRepository->findByAKey('editFactor')));
		$cutoff = $this->shopRepository->findByAKey('cutoff');
		$tempern = $this->shopRepository->findByAKey('tempern');

		//$this->debugTypo($this->konfiguratorData, '2', true);

		$this->konfiguratorData['material'] = $this->materialRepository->getMaterial();
		$this->konfiguratorData['ecken'] = $this->cornereditingRepository->getEckbearbeitungen();
		$this->konfiguratorData['kanten'] = $this->bordereditingRepository->getKantenbearbeitungen();
		$this->konfiguratorData['bohrungen'] = $this->drillRepository->getBohrungen();
		$this->konfiguratorData['halter'] = $this->fixingRepository->getHalter();
		$this->konfiguratorData['senkungen'] = $this->bevelRepository->getSenkungen();

		//$this->debugTypo($this->konfiguratorData, '3', true);

		$this->konfiguratorData['mFactor'] = $this->priceRepository->getPriceFactorByGroup($group);

		$this->konfiguratorData['mFactorInflation'] = $mFactorInflation->getFirst()->getAValue();
		$this->konfiguratorData['pFactorInflation'] = $pFactorInflation->getFirst()->getAValue();
		$this->konfiguratorData['eFactorInflation'] = $eFactorInflation->getFirst()->getAValue();

		//$this->debugTypo($this->konfiguratorData, '4', true);

		$this->konfiguratorData['cutoff'] = $cutoff->getFirst()->getAValue();
		$this->konfiguratorData['tempern'] = $tempern->getFirst()->getAValue();

		//$this->debugTypo($this->konfiguratorData, '5', true);

		$this->iniControllerForBackendAjaxRequest();
		//$this->debugTypo($this->konfiguratorData, '6', true);

		$this->konfiguratorData['produktart'] = $this->produktartController->getDataForRahmenKonfigurator();

		//	$this->debugTypo($this->konfiguratorData, '7', true);
	}

	/**
	 * Holt einen User zur Bestellung
	 * @param \Integer $uid
	 * @return \Glacryl\Glshop\Domain\Repository\CustomerRepository
	 */
	public function getUser($uid) {
		if (!isset($GLOBALS['TCA'])) {
			$GLOBALS['TSFE']->includeTCA();
		}
		$user = $this->customerRepository->findByUid($uid);
		return $user;
	}

	/**
	 * User Bearbeiten
	 * 
	 * @return string
	 */
	/* public function editUserAction() {
	  $userId = $GLOBALS['TSFE']->fe_user->user['uid'];
	  $user = $this->getUser($userId);
	  $args = $this->request->getArguments();

	  $res = $this->customerController->editUserFunction($user, $args);
	  return json_encode(array('error' => 'false', 'user' => $res));
	  } */

	/**
	 * action userAdress
	 *
	 * @return string
	 */
	public function userAdressAction() {
		if (!isset($GLOBALS['TCA'])) {
			$GLOBALS['TSFE']->includeTCA();
		}
		$userId = $GLOBALS['TSFE']->fe_user->user['uid'];
		$lieferadressen = $this->shippingadressRepository->findByUser($userId);

		$array = array();
		foreach ($lieferadressen as $adress) {
			array_push($array, array(
				'uid' => $adress->getUid(),
				'pid' => $adress->getPid(),
				'company' => $adress->getCompany(),
				'person' => $adress->getPerson(),
				'street' => $adress->getStreet(),
				'zip' => $adress->getZip(),
				'city' => $adress->getCity(),
			));
		}

		return json_encode($array);
	}

	/**
	 * action saveLieferAdresse
	 *
	 * @return string
	 */
	public function saveLieferAdresseAction() {
		$userId = $GLOBALS['TSFE']->fe_user->user['uid'];
		$args = $this->request->getArguments();

		$abwAdresse = new \Glacryl\Glshop\Domain\Model\Shippingaddress();

		$abwAdresse->setCompany($args['abwFirma']);
		$abwAdresse->setPerson($args['abwPerson']);
		$abwAdresse->setStreet($args['abwStrasse']);
		$abwAdresse->setZip($args['abwPlz']);
		$abwAdresse->setCity($args['abwOrt']);
		$abwAdresse->setPid(intval('4'));
		$abwAdresse->setUser($userId);
		$savedObject = $this->shippingadressRepository->saveAdress($abwAdresse);
		if (isset($savedObject)) {
			$savedProperties = array(
				'uid' => $savedObject->getUid(),
				'pid' => $savedObject->getPid(),
				'company' => $savedObject->getCompany(),
				'person' => $savedObject->getPerson(),
				'street' => $savedObject->getStreet(),
				'zip' => $savedObject->getZip(),
				'city' => $savedObject->getCity(),
			);
		}
		return json_encode($savedProperties);
	}

	public function iniBackendAjaxRequest() {

		$this->ajax = true;
		$this->objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\CMS\Extbase\Object\ObjectManager');
		$this->persistenceManager = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager');

		$this->request = $this->objectManager->get('TYPO3\CMS\Extbase\Mvc\Request');
		$this->request->setArguments($GLOBALS['_REQUEST']['arguments']);
		$this->response = $this->objectManager->create('TYPO3\CMS\Extbase\Mvc\ResponseInterface');

		$this->materialRepository = $this->objectManager->get('Glacryl\\Glshop\\Domain\\Repository\\MaterialRepository');
		$this->fixingRepository = $this->objectManager->get('Glacryl\\Glshop\\Domain\\Repository\\FixingRepository');
		$this->cornereditingRepository = $this->objectManager->get('Glacryl\\Glshop\\Domain\\Repository\\CornereditingRepository');
		$this->bordereditingRepository = $this->objectManager->get('Glacryl\\Glshop\\Domain\\Repository\\BordereditingRepository');
		$this->drillRepository = $this->objectManager->get('Glacryl\\Glshop\\Domain\\Repository\\DrillRepository');
		$this->bevelRepository = $this->objectManager->get('Glacryl\\Glshop\\Domain\\Repository\\BevelRepository');

		$this->orderRepository = $this->objectManager->get('Glacryl\\Glshop\\Domain\\Repository\\OrderRepository');
		$this->orderstatusRepository = $this->objectManager->get('Glacryl\\Glshop\\Domain\\Repository\\OrderstatusRepository');
		$this->orderstateRepository = $this->objectManager->get('Glacryl\\Glshop\\Domain\\Repository\\OrderstateRepository');
		$this->customerRepository = $this->objectManager->get('Glacryl\\Glshop\\Domain\\Repository\\CustomerRepository');
		$this->shippingadressRepository = $this->objectManager->get('Glacryl\\Glshop\\Domain\\Repository\\ShippingaddressRepository');

		$this->conditionsRepository = $this->objectManager->get('Glacryl\\Glshop\\Domain\\Repository\\ConditionsRepository');
		$this->shopRepository = $this->objectManager->get('Glacryl\\Glshop\\Domain\\Repository\\ShopRepository');
		$this->priceRepository = $this->objectManager->get('Glacryl\\Glshop\\Domain\\Repository\\PriceRepository');
		$this->noticelistRepository = $this->objectManager->get('Glacryl\\Glshop\\Domain\\Repository\\NoticelistRepository');

		$this->confirmationRepository = $this->objectManager->get('Glacryl\\Glshop\\Domain\\Repository\\ConfirmationRepository');
		$this->productionRepository = $this->objectManager->get('Glacryl\\Glshop\\Domain\\Repository\\ProductionRepository');
		$this->deliveryRepository = $this->objectManager->get('Glacryl\\Glshop\\Domain\\Repository\\DeliveryRepository');
		$this->invoiceRepository = $this->objectManager->get('Glacryl\\Glshop\\Domain\\Repository\\InvoiceRepository');

		$this->statusRepository = $this->objectManager->get('Glacryl\\Glshop\\Domain\\Repository\\StatusRepository');
		$this->bereichRepository = $this->objectManager->get('Glacryl\\Glshop\\Domain\\Repository\\BereichRepository');
		$this->rechnungsbuchRepository = $this->objectManager->get('Glacryl\\Glshop\\Domain\\Repository\\RechnungsbuchRepository');

		$this->gutscheinRepository = $this->objectManager->get('Glacryl\\Glshop\\Domain\\Repository\\GutscheinRepository');
		$this->gutscheinUsageRepository = $this->objectManager->get('Glacryl\\Glshop\\Domain\\Repository\\GutscheinUsageRepository');
	}

	public function iniControllerForBackendAjaxRequest() {
		$this->orderController = $this->objectManager->get('Glacryl\\Glshop\\Controller\\OrderController');
		$this->produktartController = $this->objectManager->get('Glacryl\\Glshop\\Controller\\ProduktartController');
	}

	/**
	 * editOrderAction
	 * 
	 * @param array $params Array of parameters from the AJAX interface, currently unused
	 * @param \TYPO3\CMS\Core\Http\AjaxRequestHandler $ajaxObj Object of type AjaxRequestHandler
	 * 
	 * @return void
	 */
	public function editOrderAction($params = array(), \TYPO3\CMS\Core\Http\AjaxRequestHandler &$ajaxObj = NULL) {

		$this->iniBackendAjaxRequest();

		$orderUid = $this->request->getArgument('uid');
		$post = $this->request->getArguments();

		$res = false;

		$order = $this->orderRepository->findByUid($orderUid);


		if ($post['opt'] != 're') {
			$formular = array(
				'lieferzeit' => $post['lieferzeit'],
				'lieferart' => $post['lieferart'],
				'lieferadresse' => $post['lieferadresse'],
				'versandkosten' => $post['versandkosten'],
				'zahlung' => $post['zahlung'],
				'hinweis' => $post['hinweis'],
			);
			if ($post['opt'] == 'ab') {
				$formular['ausland'] = null;
				$formular['ausland'] = $post['ausland'];
				//$this->debugTypo($formular, 'FOrmularAB', true);
			}

			//$this->debugTypo($formular, 'FOrmular', true);
		} else {
			$formular = unserialize($order->getFormular());
			$formular['lieferdatum'] = $post['lieferdatum'];
			$formular['lieferart'] = $post['lieferart'];
			$formular['versandNach'] = $post['versandNach'];
			$formular['nachlass'] = (isset($post['nachlass']) ? $post['nachlass'] : null);
			$formular['nachlassEinheit'] = (isset($post['nachlassEinheit']) ? $post['nachlassEinheit'] : null);
			$formular['ausland'] = $post['ausland'];
		}

		$order->setFormular(serialize($formular));

		$this->objectManager->get('Glacryl\\Glshop\\Domain\\Repository\\OrderRepository')->update($order);

		if ($this->ajax) {
			$this->persistenceManager->persistAll();

			$test = $this->orderRepository->findByUid($orderUid);

			if ($test->getFormular() == serialize($formular)) {
				$res = true;
			}
		}

		$ajaxObj->addContent('glshop', json_encode(array('res' => $res)));
	}

	/**
	 * checkABAction
	 *
	 * @param array $params Array of parameters from the AJAX interface, currently unused
	 * @param \TYPO3\CMS\Core\Http\AjaxRequestHandler $ajaxObj Object of type AjaxRequestHandler
	 * 
	 * @return void
	 */
	public function checkABAction($params = array(), \TYPO3\CMS\Core\Http\AjaxRequestHandler &$ajaxObj = NULL) {
		$this->iniBackendAjaxRequest();
		$orderUid = $this->request->getArgument('uid');

		$res = array('abSet' => false);

		$order = $this->orderRepository->findByUid($orderUid);

		foreach ($order->getOrderstatus() as $status) {
			if ($status->getOrderstate()->getValue() == 2) {
				$res['abSet'] = true;
			}
		}

		$ajaxObj->addContent('glshop', json_encode($res));
	}

	/**
	 * getDxfAction
	 *
	 * @param array $params Array of parameters from the AJAX interface, currently unused
	 * @param \TYPO3\CMS\Core\Http\AjaxRequestHandler $ajaxObj Object of type AjaxRequestHandler
	 * 
	 * @return void
	 */
	public function getDxfAction($params = array(), \TYPO3\CMS\Core\Http\AjaxRequestHandler &$ajaxObj = NULL) {
		$this->iniBackendAjaxRequest();
		$orderUid = $this->request->getArgument('uid');
		$files = array();
		$order = $this->orderRepository->findByUid($orderUid);

		$dxf = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('DXF');

		$extPath = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('glshop');

		$abId = 0;
		foreach ($order->getConfirmation() as $ab) {
			$abId = $ab->getUid();
		}

		//$files = new $dxf($data, $extPath);
		$files = new $dxf($order->getArticle(), $extPath, $abId);

		$ajaxObj->addContent('glshop', json_encode($files->getFileList(true)));
	}

	/**
	 * getOrderAction
	 *
	 * @param array $params Array of parameters from the AJAX interface, currently unused
	 * @param \TYPO3\CMS\Core\Http\AjaxRequestHandler $ajaxObj Object of type AjaxRequestHandler
	 * 
	 * @return void
	 */
	public function getOrderAction($params = array(), \TYPO3\CMS\Core\Http\AjaxRequestHandler &$ajaxObj = NULL) {

		$this->iniBackendAjaxRequest();

		$orderUid = $this->request->getArgument('uid');

		//$this->debugTypo($orderUid);

		$this->setKonfiguratorData();

		$order = $this->orderRepository->findOrderByUid($orderUid);

		$u = $this->getUser($order['user']);

		//$this->debugTypo($u);
		//$adresses = $this->shippingadressRepository->getAdressesByUser($order['user']);
		$adresses = $this->shippingadressRepository->findByUser($order['user']);

		//$this->debugTypo($adresses);

		$adressen = array();

		//$this->debugTypo($adresses);
		//$this->debugTypo(count($adresses));

		for ($i = 0; $i < count($adresses); $i++) {
			array_push($adressen, array(
				'uid' => $adresses[$i]->getUid(),
				'firma' => $adresses[$i]->getCompany(),
				'name' => $adresses[$i]->getPerson(),
				'street' => $adresses[$i]->getStreet(),
				'plz' => $adresses[$i]->getZip(),
				'ort' => $adresses[$i]->getCity(),
				'eigene' => false
			));
		}

		//$this->debugTypo($adressen);

		array_push($adressen, array(
			'firma' => $u->getCompany(),
			'anrede' => ($u->getGender() == '0' ? 'Herr' : 'Frau'),
			'name' => $u->getFirstName() . ' ' . $u->getLastName(),
			'strasse' => $u->getAddress(),
			'plz' => $u->getZip(),
			'ort' => $u->getCity(),
			'country' => $u->getCountry(),
			'eigene' => true
		));

		//$this->debugTypo($adressen);

		$order = array(
			'order' => $order,
			'conditions' => $this->conditionsRepository->findConditions(),
			'data' => $this->konfiguratorData,
			'adressen' => $adressen
		);

		$ajaxObj->addContent('glshop', json_encode($order));
	}

	/**
	 * getAbschlussAction
	 *
	 * @param array $params Array of parameters from the AJAX interface, currently unused
	 * @param \TYPO3\CMS\Core\Http\AjaxRequestHandler $ajaxObj Object of type AjaxRequestHandler
	 * 
	 * @return void
	 */
	public function getAbschlussAction($params = array(), \TYPO3\CMS\Core\Http\AjaxRequestHandler &$ajaxObj = NULL) {
		$this->iniBackendAjaxRequest();
		$this->iniControllerForBackendAjaxRequest();
		$args = $this->request->getArguments();
		$abschlussData = $this->orderController->getAbschlussFunction($args);

		$vDate = strtotime($args['von']);
		$monat = date("n", $vDate);
		$jahr = date("Y");

		$monate = array(
			1 => "Januar",
			2 => "Februar",
			3 => "Maerz",
			4 => "April",
			5 => "Mai",
			6 => "Juni",
			7 => "Juli",
			8 => "August",
			9 => "September",
			10 => "Oktober",
			11 => "November",
			12 => "Dezember"
		);

		if ($args['generate']) {
			$fileName = 'Abschluss_' . $monate[$monat] . '_' . $jahr . '.csv';
			$res = $this->createAbschlussCSV($abschlussData, $fileName);
			$ajaxObj->addContent('glshop', json_encode($res));
		} else {
			$ajaxObj->addContent('glshop', json_encode($abschlussData));
		}
	}

	public function createAbschlussCSV($abschlussData, $fileName) {
		$ext_path = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('glshop');
		$abschlussPath = $ext_path . 'Resources/Private/Downloads/Excel/Abschluss/';

		$filePath = $abschlussPath . $fileName;

		// open the file for writing
		$file = fopen($filePath, 'w');
		fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

		// save the column headers
		fputcsv($file, array(
			'Brutto',
			'Steuersatz',
			'Steuer',
			'Netto',
			'Soll/Haben-Kennzeichen',
			'Belegfeld1',
			'Datum',
			'Auftragsnummer',
			'Konto',
			'Gegenkonto (ohne BU-Schluessel)',
			'Kd. Name',
			'Zusatzinforamtion - Art 1',
			'Zusatzinformation - Inhalt 1'
			)
		);

		// save each row of the data
		foreach ($abschlussData as $row) {
			fputcsv($file, array(
				number_format($row['brutto'], 2, ',', ''),
				number_format($row['mwstSatz'], 2, ',', ''),
				number_format($row['steuer'], 2, ',', ''),
				number_format($row['netto'], 2, ',', ''),
				$row['kennzeichen'],
				$row['rgNr'],
				$row['rgDatum'],
				$row['auNr'],
				$row['kdNr'],
				$row['gegenkonto'],
				$row['kdName'],
				$row['art1'],
				$row['inhalt1'],
				));
		}

		// Close the file
		fclose($file);

		return array('fileName' => $fileName);
	}

	/**
	 * File action 
	 *
	 * @param array $params Array of parameters from the AJAX interface, currently unused
	 * @param \TYPO3\CMS\Core\Http\AjaxRequestHandler $ajaxObj Object of type AjaxRequestHandler
	 * 
	 * @return void
	 */
	public function fileAction($params = array(), \TYPO3\CMS\Core\Http\AjaxRequestHandler &$ajaxObj = NULL) {

		$this->iniBackendAjaxRequest();

		$orderUid = $this->request->getArgument('uid');
		$fileOpt = $this->request->getArgument('opt');

		//$this->debugTypo($orderUid, 'OrderUid', true);

		$file = array('fileName' => $this->checkFile($fileOpt, $orderUid));

		//$this->debugTypo($file, 'FileName', true);

		$ajaxObj->addContent('glshop', json_encode($file));
	}

	public function checkFile($fileOpt, $orderUid) {
		//$this->debugTypo('Checkfile start', 'Checkfile', true);
		$state = $this->orderstateRepository->findByAcr($fileOpt)->getFirst();
		$extPath = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('glshop');
		$file = '';
		$fileId = 0;

		$order = $this->orderRepository->findByUid($orderUid);

		//$this->debugTypo($state, 'state', true);
		//$this->debugTypo($order, 'order', true);

		switch ($state->getAcr()) {
			case 'ab':
				$fileId = $order->getConfirmation();
				break;
			case 'fe':
				$fileId = $order->getProduction();
				break;
			case 're':
			case 'reK':
				$fileId = $order->getInvoice();
				break;
			case 'ls':
			case 'lsK':
				$fileId = $order->getDelivery();
				break;
		}

		$fileNumbers = array();

		//$this->debugTypo($fileId, 'FileId', true);


		if (isset($fileId) && count($fileId) > 0) {
			$counter = 0;
			foreach ($fileId as $fileIdOne) {
				if ($counter == 0) {
					$file = $state->getPrefix() . $fileIdOne->getUid() . '.pdf';

					//$this->debugTypo($file);

					if (!file_exists($extPath . 'Resources/Private/Downloads/' . $file)) {
						$fileNumbers[$state->getAcr()] = $fileIdOne->getUid();
						$file = $this->createFile($state, $order, $fileNumbers, false);
					}
					$counter++;
				}
			}
		} else {
			$ab = $this->confirmationRepository->getNextFreeNumber();
			$fe = $this->productionRepository->getNextFreeNumber();
			$ls = $this->deliveryRepository->getNextFreeNumber();
			$lsK = $ls;
			$re = $this->invoiceRepository->getNextFreeNumber();
			$reK = $re;

			$file = $this->createFile($state, $order, array('ab' => $ab, 'fe' => $fe, 'ls' => $ls, 'lsK' => $lsK, 're' => $re, 'reK' => $reK), true);

			//$this->debugTypo($file);
		}

		//$this->debugTypo('Checkfile end', 'Checkfileend', true);
		return $file;
	}

	public function createFile($orderstate, $order, $fileNumbers, $saveToDb) {
		//$this->debugTypo('Create file Start');
		//$this->debugTypo($order->getUser());

		$user = $this->getUser($order->getUser());

		//$this->debugTypo($user);

		$extPath = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('glshop');

		//$this->debugTypo($extPath);

		$fileName = $orderstate->getPrefix();

		//$this->debugTypo($fileName);

		$pdfLbry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('mPDF');

		$vorlagen = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('Vorlagen');

		//$this->debugTypo($vorlagen);

		switch ($orderstate->getAcr()) {
			case 'ab':
				$fileName .= $fileNumbers['ab'];
				$mpdf = new $pdfLbry('utf8', 'A4', '', '', 25, 5, 110, 35, 9);
				break;
			case 'fe':
				$fileName .= $fileNumbers['fe'];
				$mpdf = new $pdfLbry('utf8', 'A4', '', '', 25, 5, 75, 5, 9);
				break;
			case 're':
				$fileName .= $fileNumbers['re'];
				$mpdf = new $pdfLbry('utf8', 'A4', '', '', 20, 5, 110, 35, 9);
				break;
			case 'reK':
				$fileName .= $fileNumbers['reK'];
				$mpdf = new $pdfLbry('utf8', 'A4', '', '', 20, 5, 110, 35, 9);
				break;
			case 'ls':
				$fileName .= $fileNumbers['ls'];
				$mpdf = new $pdfLbry('utf8', 'A4', '', '', 20, 5, 110, 35, 9);
				break;
			case 'lsK':
				$fileName .= $fileNumbers['lsK'];
				$mpdf = new $pdfLbry('utf8', 'A4', '', '', 20, 5, 110, 35, 9);
				break;
		}
		$fileName .= '.pdf';

		//$this->debugTypo($fileName);

		$this->setKonfiguratorData();

		//$this->debugTypo($this->konfiguratorData);

		$mpdf->shrink_tables_to_fit = 1;


		$abUid = $order->getConfirmation();

		//$this->debugTypo($abUid);
		//$this->debugTypo('AB fehler start');

		if (count($abUid) > 0) {
			$counter = 0;
			foreach ($abUid as $abUidOne) {
				if ($counter == 0) {
					$abId = $abUidOne->getUid();
					$counter++;
				}
			}
		} else {
			$abId = 0;
		}

		$kdAdressen = $this->shippingadressRepository->findByUser($user->getUid());
		$zBed = $this->conditionsRepository->findAll();

		$vorlagenKonfig = array(
			'extPath' => $extPath,
			'user' => $user,
			'order' => $order,
			'abUid' => $abId,
			'konfigData' => $this->konfiguratorData,
			'nextNumber' => $fileNumbers,
			'opt' => $orderstate->getAcr(),
			'kdAdressen' => $kdAdressen,
			'zBed' => $zBed
		);

		//$this->debugTypo($vorlagenKonfig);
		//$this->debugTypo('AB fehler end');
		$vorlagen->initialize($vorlagenKonfig);

		//$mpdf->SetProtection(array('print'));
		//$mpdf->SetProtection(array());
		$mpdf->SetTitle("Glacryl Hedel GmbH");
		$mpdf->SetAuthor("Glacryl Hedel GmbH");
		$mpdf->SetDisplayMode('fullpage');

		$css = file_get_contents($extPath . 'Resources/Php/Mpdf/glvorlagen/style' . $orderstate->getAcr() . '.css');

		//$this->debugTypo($vorlagen->getVorlage($orderstate->getAcr()));

		$mpdf->WriteHTML($css, 1);
		$mpdf->WriteHTML($vorlagen->getVorlage($orderstate->getAcr()), 2);

		$mpdf->Output($extPath . 'Resources/Private/Downloads/' . $fileName, 'F');

		if (file_exists($extPath . 'Resources/Private/Downloads/' . $fileName)) {
			if ($saveToDb) {
				$savedId = $this->saveFileData($orderstate, $fileName, $order);
			}
			$this->changeStatus($orderstate, $order);
		}

		//$this->debugTypo('Create file end');
		return $fileName;
	}

	public function changeStatus($orderState, $order) {

		if (is_string($orderState)) {
			$orderState = $this->orderstateRepository->findByAcr($orderState)->getFirst();
		}
		//$this->debugTypo($orderState);

		if ($orderState->getAcr() != 'eg') {
			$user = $GLOBALS['BE_USER']->user['uid'];
		} else {
			$user = 1;
		}

		$changeStatus = false;
		$changeStatus = $this->orderRepository->testChangeStatus($order, $orderState);

		if ($changeStatus) {

			$status = new \Glacryl\Glshop\Domain\Model\Orderstatus;
			$status->setPid('4');
			$status->setDate(new \DateTime('now'));
			$status->setOrderstate($orderState);
			$status->setCruserId($user);

			$order->addOrderstatu($status);

			$this->objectManager->get('Glacryl\\Glshop\\Domain\\Repository\\OrderRepository')->update($order);

			if ($this->ajax) {
				$this->persistenceManager->persistAll();
			}
		}
		return true;
	}

	public function saveFileData($orderstate, $fileName, $order) {
		$lastUid = 0;

		switch ($orderstate->getAcr()) {
			case 'ab':
				$obj = new \Glacryl\Glshop\Domain\Model\Confirmation;
				break;
			case 'fe':
				$obj = new \Glacryl\Glshop\Domain\Model\Production;
				break;
			case 'ls':
			case 'lsK':
				$obj = new \Glacryl\Glshop\Domain\Model\Delivery;
				break;
			case 're':
			case 'reK':
				$obj = new \Glacryl\Glshop\Domain\Model\Invoice;
				break;
		}

		//$this->debugTypo($obj);



		$obj->setFile($fileName);
		$obj->setSend(1);
		$obj->setDate(new \DateTime('now'));
		$obj->setPid(intval('4'));

		//$this->debugTypo($obj);
		//$obj->setUser($GLOBALS['BE_USER']->user['uid']);

		switch ($orderstate->getAcr()) {
			case 'ab':
				//$savedObject = $this->confirmationRepository->save($obj);
				$order->addConfirmation($obj);
				$this->orderRepository->update($order);
				$this->persistenceManager->persistAll();
				$savedObject = $order->getConfirmation();
				break;
			case 'fe':
				//$savedObject = $this->productionRepository->save($obj);
				$order->addProduction($obj);
				$this->orderRepository->update($order);
				$this->persistenceManager->persistAll();
				$savedObject = $order->getProduction();
				break;
			case 'ls':
			case 'lsK':
				//$savedObject = $this->deliveryRepository->save($obj);
				$order->addDelivery($obj);
				$this->orderRepository->update($order);
				$this->persistenceManager->persistAll();
				$savedObject = $order->getDelivery();
				break;
			case 're':
			case 'reK':
				//$savedObject = $this->invoiceRepository->save($obj);
				$order->addInvoice($obj);
				$this->orderRepository->update($order);
				$this->persistenceManager->persistAll();
				$savedObject = $order->getInvoice();
				break;
		}

		if (isset($savedObject)) {
			foreach ($savedObject as $object) {
				$lastUid = $object->getUid();
				if ($orderstate->getAcr() == 'ab') {
					$this->addEntryToRechnungsbuch($order);
				} else if ($orderstate->getAcr() == 'ls') {
					$this->updateRechnungsbuchEntryStatus($order, 2);
				} else if ($orderstate->getAcr() == 're') {
					$this->updatePaymentDay($order);
					$this->updateRechnungsbuchEntryStatus($order, 3);
				}
			}
		}
		return $lastUid;
	}

	public function addEntryToRechnungsbuch($order) {
		$debug = false;
		$this->debugTypo('Start', 'addEntry RE Buch', $debug);


		$steuer = $this->getSteuerForRechnungsbuch($order);
		$this->debugTypo($steuer, 'Steuer', $debug);
		$netto = $this->getNettoForRechnungsbuch($order);
		$this->debugTypo($netto, 'Netto', $debug);
		$brutto = $netto * (1 + ($steuer / 100));
		$this->debugTypo($steuer, 'Brutto', $debug);

		$this->debugTypo($this->statusRepository->findAll(), 'Statusse alle', $debug);
		$status = $this->statusRepository->findByUid(1);
		$this->debugTypo($status, 'Status', $debug);

		$buch = new \Glacryl\Glshop\Domain\Model\Rechnungsbuch;
		$buch->setPid(intval('4'));
		$buch->setNetto($netto);
		$buch->setSteuer($steuer);
		$buch->setBrutto($brutto);
		$buch->addStatus($status);
		$buch->addBestellung($order);

		$this->debugTypo($buch, 'Buch', $debug);

		$this->rechnungsbuchRepository->add($buch);

		if ($this->ajax) {
			$this->persistenceManager->persistAll();
		}
		$this->debugTypo('END', 'Entry Buch', $debug);
	}

	public function getSteuerForRechnungsbuch($order) {
		$steuer = 19.00;
		//$this->debugTypo($order, 'Order', true);
		$user = $this->getUser($order->getUser());
		$shippingAdress = $order->getShippingaddress();

		if (!isset($shippingAdress)) {
			
		} else {
			$country = $user->getCountry();
			$this->debugTypo($country, 'UserLand', true);
			if ($country != 'DEU') {
				$steuer = 0.00;
			}
		}
		return $steuer;
	}

	public function getNettoForRechnungsbuch($order) {
		$netto = 0;

		$items = unserialize($order->getArticle());
		$formular = unserialize($order->getFormular());
		$comment = unserialize($order->getComment());

		foreach ($items as $pos => $item) {
			$netto += (floatval($item['preis']) * floatval($item['anzahl']));
		}

		$werbelandRabatt = round($netto * $comment['werbelandRabatt'] / 100, 2);

		$netto += floatval($formular['versandkosten']);
		$netto -= floatval($comment['rabatt']);
		$netto += floatval($comment['ewPalette']);
		$netto -= floatval($werbelandRabatt);

		return $netto;
	}

	public function updateRechnungsbuchEntryStatus($order, $statusId) {
		$buch = $this->rechnungsbuchRepository->findOneByBestellung($order);
		$statusObj = $this->statusRepository->findByUid($statusId);

		//$oldstatusId = $buch->getStatus()->current();
		//$oldStatusObj = $this->statusRepository->findByUid($oldstatusId);
		//$status = $this->statusRepository->findByBereich($this->bereichRepository->findByName('Rechnungsbuch')->getFirst())->getFirst();
		//$buch->addStatus($statusObj);

		$buch->updateStatus($statusId);

		$this->rechnungsbuchRepository->update($buch);

		if ($this->ajax) {
			$this->persistenceManager->persistAll();
		}
		$this->persistenceManager->persistAll();
	}

	public function updatePaymentDay($order) {
		$buch = $this->rechnungsbuchRepository->findOneByBestellung($order);
		$termin = null;

		//$this->debugTypo($buch, 'Buch', true);


		$status = $buch->getStatus()->current();

		//$this->debugTypo($status, 'Status', true);

		if (($status->getUid() == 2) && ($buch->getTermin() == null)) {
			$netto = $buch->getBestellung()->current()->getConditions()->getNetto();

			//$termin = mktime(0, 0, 0, date("m"), date("d") + $netto, date("Y"));
		}

		//$this->debugTypo($termin, 'Termin', true);
		//$timestamp = strtotime("+" . $netto . " days");
		//$this->debugTypo(date("Y-m-d", $timestamp), 'Termindatetime Neu', true);

		$buch->setTermin(new \DateTime('now +' . $netto . ' days'));

		$this->rechnungsbuchRepository->update($buch);

		if ($this->ajax) {
			$this->persistenceManager->persistAll();
		}
	}

	/**
	 * File senden
	 *
	 * @param array $params Array of parameters from the AJAX interface, currently unused
	 * @param \TYPO3\CMS\Core\Http\AjaxRequestHandler $ajaxObj Object of type AjaxRequestHandler
	 * 
	 * @return void
	 */
	public function sendFileAction($params = array(), \TYPO3\CMS\Core\Http\AjaxRequestHandler &$ajaxObj = NULL) {
		$this->iniBackendAjaxRequest();

		$fileName = $this->request->getArgument('fileName');

		$type = $this->request->getArgument('type');

		header('Set-Cookie: fileDownload=true; path=/');
		header('Cache-Control: max-age=60, must-revalidate');

		if (($type != null) && ($type == 'abschluss')) {
			header('Content-Type: application/vnd.ms-excel');
		} else {
			if (preg_match('/.pdf/i', $fileName)) {
				header('Content-Type: application/pdf');
			} else {
				header('Content-Type: application/dxf');
			}
		}

		header('Content-Disposition: attachment; filename="' . $fileName . '"');
		if (isset($type) && ($type == 'abschluss')) {
			readfile(\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('glshop') . 'Resources/Private/Downloads/Excel/Abschluss/' . $fileName);
		} else {
			if (preg_match('/.pdf/i', $fileName)) {
				readfile(\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('glshop') . 'Resources/Private/Downloads/' . $fileName);
			} else {
				readfile(\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('glshop') . 'Resources/Private/Downloads/Dxf/' . $fileName);
			}
		}
		exit;
	}

	/**
	 * Order action 
	 *
	 * @return string JSON encoded errors
	 */
	public function orderAction() {
		$error = array();

		$order = array(
			'schildData' => $this->request->getArgument('schildData'),
			'schildImg' => $this->request->getArgument('schildImg'),
			'ihrKunde' => $this->request->getArgument('kundenName'),
			'interneNummer' => $this->request->getArgument('kundenNr'),
			'kundenNummer' => $this->request->getArgument('interneNummer'),
			'bemerkung' => $this->request->getArgument('bemerkung'),
			'abholer' => $this->request->getArgument('abholer'),
			'abwAdresse' => array(
				'abwUid' => $this->request->getArgument('abwAdr'),
			)
		);
		$error = $this->saveOrder($order);

		return json_encode($error);
	}

	public function saveOrder($order) {

		$GLOBALS['TSFE']->includeTCA();
		$error = array('error' => true);
		$userId = $GLOBALS['TSFE']->fe_user->user['uid'];
		$bestellung = new \Glacryl\Glshop\Domain\Model\Bestellungen;
		$bestellung->setBestelldatum(time()); //(date('Y-m-d H:i:s'));
		$bestellung->setBetragNetto(floatval(''));
		$bestellung->setIhrKunde($order['ihrKunde']);
		$bestellung->setInterneNummer($order['interneNummer']);
		$bestellung->setIhreKundenNr($order['kundenNummer']);
		$bestellung->setBemerkung($order['bemerkung']);
		$bestellung->setData($order['schildData']);
		$bestellung->setUser($userId);
		$bestellung->setAbholer($order['abholer']);
		$bestellung->setPid(intval('4'));

		if (isset($order['abwAdresse']['abwUid']) && ($order['abwAdresse']['abwUid'] != 'none')) {
			$abwAdresse = $this->shippingadressRepository->findByUid($order['abwAdresse']['abwUid']);
			$bestellung->setLieferadresse($abwAdresse);
		}

		$savedObject = $this->bestellungenRepository->saveOrder($bestellung);

		if (isset($savedObject)) {
			$lastUid = $savedObject->getUid();

			$this->saveOrderImg($lastUid, $userId, $order['schildImg']);

			#$fileName = $this->createFile('ab', $lastUid);
			$this->changeStatus('eg', $lastUid);
			$error = array();
			#if (!$this->sendBestellMail($lastUid, $fileName))
			if (!$this->sendBestellMail($lastUid))
				$error = array('mail' => true);
		}
		return $error;
	}

	public function saveOrderImg($lastUid, $userId, $img) {

		#//$this->debugTypo($GLOBALS);#['TYPO3_CONF_VARS']['EXTCONF']['extbase']['extensions']['Glshop']);
		$user = $this->customerRepository->findByUid($userId);
		#//$this->debugTypo($user);

		$fileName = $user->getCompany() . '_' . $user->getFirstName() . ' ' . $user->getLastName() . '_Bestellung_' . $lastUid . '.png';
		$output_file = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('pd_schildkonfigurator') . 'Resources/Private/Downloads/Zeichnungen/' . $fileName;
		$ifp = fopen($output_file, "wb");
		$data = explode(',', $img);
		fwrite($ifp, base64_decode($data[1]));
		fclose($ifp);
		return $output_file;
	}

	/**
	 * Funktion sendBestellMail
	 *
	 * @param \int $lastUid Id des letzten gespeicherten Auftrags
	 * @param \string $fileName Name der AB Datei
	 * @return bool Sending indicator
	 */
	public function sendBestellMail($lastUid, $fileName = false, $feUser = NULL) {
		if (isset($feUser)) {
			$to = $feUser->getEmail();
		}

		$subject = 'Ihre Bestellung vom ' . date('d.m.Y H:i', time()) . ' bei Glacryl Hedel GmbH';

		$order = $this->orderRepository->findByUid($lastUid);

		$data = array(
			'user' => $this->getUser($order->getUser()),
			'GlacrylLogo' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('glshop') . 'Resources/Public/Mail/Glacryl_Logo.jpg',
			'100Jahre' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('glshop') . 'Resources/Public/Mail/100Jahre_Glacryl.jpg',
		);

		$vorlagen = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('Vorlagen');

		$vorlage = new $vorlagen();

		$vorlage->initialize($data, true);

		$message = $vorlage->getVorlage($vorlage->ABMAIL);

		$pfad = array();
		#$pfad[] = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('glshop') . 'Resources/Private/Downloads/' . $fileName;
		$pfad[] = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('glshop') . 'Resources/Public/Mail/100Jahre_Glacryl.jpg';
		$pfad[] = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('glshop') . 'Resources/Public/Mail/Glacryl_Logo.jpg';
		return $this->sendMail($to, $subject, $message, $pfad);
	}

	function sendMail($to, $subject, $message, $pfad) {
		$absender = "Glacry Hedel GmbH";
		$absender_mail = "info@glacryl.de";
		$reply = "info@glacryl.de";

		if (is_string($pfad)) {
			if (function_exists("mime_content_type"))
				$type = mime_content_type($pfad);
			else
				$type = "application/octet-stream";
			$anhang = array("name" => basename($pfad), "size" => filesize($pfad), "type" => $type, "data" => implode("", file($pfad)));
		} else {
			$anhang = array();
			foreach ($pfad AS $pf) {
				$name = basename($pf);
				$size = filesize($pf);
				$data = implode("", file($pf));
				if (function_exists("mime_content_type"))
					$type = mime_content_type($pf);
				else
					$type = "application/octet-stream";
				$anhang[] = array("name" => $name, "size" => $size, "type" => $type, "data" => $data);
			}
		}
		$mime_boundary = "-----=" . md5(uniqid(mt_rand(), 1));

		$header = "From:" . $absender . "<" . $absender_mail . ">\n";
		$header .= "Reply-To: " . $reply . "\n";

		$header .= "MIME-Version: 1.0\r\n";
		$header .= "Content-Type: multipart/mixed;\r\n";
		$header .= " boundary=\"" . $mime_boundary . "\"\r\n";

		$content = "This is a multi-part message in MIME format.\r\n\r\n";
		$content .= "--" . $mime_boundary . "\r\n";
		$content .= "Content-Type: text/html charset=\"utf8\"\r\n";
		$content .= "Content-Transfer-Encoding: 8bit\r\n\r\n";
		$content .= $message . "\r\n";

		//$anhang ist ein Mehrdimensionals Array
		//$anhang enthaelt mehrere Dateien
		if (is_array($anhang) AND is_array(current($anhang))) {
			foreach ($anhang AS $dat) {
				$data = chunk_split(base64_encode($dat['data']));
				$content .= "--" . $mime_boundary . "\r\n";
				$content .= "Content-Disposition: attachment;\r\n";
				$content .= "\tfilename=\"" . $dat['name'] . "\";\r\n";
				$content .= "Content-Length: ." . $dat['size'] . ";\r\n";
				$content .= "Content-Type: " . $dat['type'] . "; name=\"" . $dat['name'] . "\"\r\n";
				$content .= "Content-ID: <" . md5($dat['name']) . ">" . "\r\n";
				$content .= "Content-Transfer-Encoding: base64\r\n\r\n";
				$content .= $data . "\r\n";
			}
			$content .= "--" . $mime_boundary . "--";
		} else { //Nur 1 Datei als Anhang
			$data = chunk_split(base64_encode($anhang['data']));
			$content .= "--" . $mime_boundary . "\r\n";
			$content .= "Content-Disposition: attachment;\r\n";
			$content .= "\tfilename=\"" . $anhang['name'] . "\";\r\n";
			$content .= "Content-Length: ." . $dat['size'] . ";\r\n";
			$content .= "Content-Type: " . $anhang['type'] . "; name=\"" . $anhang['name'] . "\"\r\n";
			$content .= "Content-Transfer-Encoding: base64\r\n\r\n";
			$content .= $data . "\r\n";
		}
		if (@mail($to, $subject, $content, $header)) {
			$subject = 'Neue Bestellung vom ' . date('d.m.Y H:i', time()) . ' im Online-Shop';
			@mail('info@glacryl.de', $subject, $content, $header); // Fuer Live Aendern auf glacryl @ToDo
			return true;
		} else {
			return false;
		}
	}

	public function orderOverviewAction() {
		$userId = $GLOBALS['TSFE']->fe_user->user['uid'];
		$bestellungen = $this->orderRepository->findByCustomer($userId);
		$currStatusse = $this->orderstatusRepository->getAllStatusse();
		$abs = $this->confirmationRepository->getAllAbs();

		foreach ($bestellungen as $key => $bestellung) {

			$lastStatus = null;
			$statusHtml = '';
			$statusKey = '';
			foreach ($currStatusse as $status) {
				if (($status['orders'] == $bestellung['uid'])) {
					if (($lastStatus != null)) {
						if ($status['status'] > $lastStatus) {
							$lastStatus = $status['status'];
						}
					} else {
						$lastStatus = $status['status'];
					}
				}
			}
			for ($i = 0; $i < count($this->orderStatusName); $i++) {
				if ($lastStatus == $i) {
					$statusKey = $i;
					if ($i != 0) {
						$statusHtml .= '<span style="color:green;">' . $this->orderStatusName[$i] . '</span>';
					} else {
						$statusHtml .= '<span style="color:red;">' . $this->orderStatusName[$i] . '</span>';
					}
				}
			}

			foreach ($abs as $keyAb => $ab) {
				if ($ab['orders'] == $bestellung['uid']) {
					$orderNr = 'BI' . $ab['uid'];
					$oId = $ab['uid'];
				}
			}

			$bemerkung = '';
			if ($bestellung['interneNummer'] != '') {
				$bemerkung = '<span>Int. VorgangsNr.: ' . $bestellung['interneNummer'] . '</span><br />';
			}
			if ($bestellung['ihrKunde'] != '') {
				$bemerkung = '<span>Kunde: ' . $bestellung['ihrKunde'] . '</span><br />';
			}
			if ($bestellung['ihreKundenNr'] != '') {
				$bemerkung = '<span>Kd.Nr.: ' . $bestellung['ihreKundenNr'] . '</span><br />';
			}
			if ($bestellung['bemerkung'] != '') {
				$bemerkung = '<span>Sonstiges: ' . $bestellung['bemerkung'] . '</span><br />';
			}

			$aktionen = '<button class="ab_download" value="' . $statusKey . '" alt="AB" title="AB"><span class="oId" style="display:none">' . $oId . '</span></button>';
			$aktionen .= '<button class="re_order" value="' . $statusKey . '" alt="Nochmal bestellen" title="Nochmal bestellen"><span class="oId" style="display:none">' . $oId . '</span></button>';
			if ($oId == '') {
				$aktionen .= '<button class="dis_order" value="' . $statusKey . '" alt="Stornieren" title="Stornieren"><span class="bId" style="display:none">' . $bestellung['uid'] . '</span></button>';
			} else {
				$aktionen .= '<button class="dis_order" value="' . $statusKey . '" alt="Stornieren" title="Stornieren"><span class="oId" style="display:none">' . $oId . '</span></button>';
			}
			$array[$key] = array(
				$statusHtml, // Status
				$orderNr, // Auftragsnummer
				date('d.m.Y H:i', $bestellung['bestelldatum']), // Bestelldatum
				$bemerkung, // Bemerkungen
				($bestellung['abholer'] == 1 ? 'Selbstabholung' : 'Lieferung'), // Lieferart
				$bestellung['betragNetto'], // Betrag
				'<span style="display:inline-block;width:92px;">' . $aktionen . '</span>' // Aktionen
			);
		}
		if ($array == null) {
			$array[0] = array(
				'', // Status
				$orderNr, // Auftragsnummer
				'', // Bestelldatum
				'Es sind noch keine Bestellungen vorhanden!', // Bemerkungen
				'', // Lieferart
				'', // Betrag
				'' // Aktionen
			);
		}
		$dat['aaData'] = $array;
		$res = json_encode($dat);
		return $res;
	}

	public function createOrderMessage($lastUid) {
		
	}

	public function savePositionImg($img) {
		$fileName = time() . $GLOBALS['TSFE']->fe_user->user['uid'] . '.png';
		$output_file = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('glshop') . 'Resources/Public/Zeichnungen/' . $fileName;
		$ifp = fopen($output_file, "wb");
		$data = explode(',', $img);
		fwrite($ifp, base64_decode($data[1]));
		fclose($ifp);
		return $fileName;
	}

	public function getCartAction() {
		if (!isset($GLOBALS['TCA'])) {
			$GLOBALS['TSFE']->includeTCA();
		}

		$userId = $GLOBALS['TSFE']->fe_user->user['uid'];
		$sess_id = $GLOBALS['TSFE']->fe_user->user['ses_id'];

		$cartItems = $this->cartRepository->getCurrentCartItems($userId, $sess_id);

		$this->debugTypo($cartItems);
	}

	public function addToCartAction() {
		if (!isset($GLOBALS['TCA'])) {
			$GLOBALS['TSFE']->includeTCA();
		}
		$args = $this->request->getArguments();
		$cart = $this->objectManager->get('\\Glacryl\\Glshop\\Domain\\Model\\Cart');
		$sess_id = $GLOBALS['TSFE']->fe_user->user['ses_id'];

		if (($args['schild'] != null) && ($args['schild'] != false) && ($args['schild'] != 'false')) {
			$fileName = $this->savePositionImg($args['img']);
		} else if (($args['rahmen'] != null) && ($args['rahmen'] != false) && ($args['rahmen'] != 'false')) {
			$fileName = $this->savePositionImg($args['img']);
		}

		$cart->setPid(intval('4'));
		$cart->setUser($GLOBALS['TSFE']->fe_user->user['uid']);
		$cart->setSessionId($sess_id);

		if (isset($args['posNr'])) {
			$cart->setPosition($args['posNr']);
			$cartItems = $this->cartRepository->findBySessionId($sess_id);
			foreach ($cartItems as $key => $cartItem) {
				if (intval($cartItem->getPosition()) == intval($args['posNr'])) {
					$this->cartRepository->deleteCart($cartItem);
				}
			}
		} else {
			$cart->setPosition($this->cartRepository->getNextPositionNr($sess_id));
		}

		//$this->debugTypo($args['artikel']);

		$cart->setArticle(serialize($args['artikel']));
		$cart->setQty($args['anzahl']);
		$cart->setPrice(floatval($args['preis']));
		$cart->setPic($fileName);

		$cartItem = $this->cartRepository->save($cart);

		$res = array(
			'uid' => $cartItem->getUid(),
			'user' => $cartItem->getUser(),
			'positionNr' => $cartItem->getPosition(),
			'artikel' => unserialize($cartItem->getArticle()),
			'anzahl' => $cartItem->getQty(),
			'preis' => $cartItem->getPrice(),
			'bild' => $cartItem->getPic()
		);
		return json_encode($res);
	}

	public function getCurrentCartItemsAction() {
		$ses_id = $GLOBALS['TSFE']->fe_user->user['ses_id'];
		$db = $this->cartRepository->findBySessionId($ses_id);
		$cart = array();
		foreach ($db as $key => $cartItem) {
			$cart[$key] = array(
				'uid' => $cartItem->getUid(),
				'user' => $cartItem->getUser(),
				'sessionId' => $cartItem->getSessionId(),
				'positionNr' => $cartItem->getPositionNr(),
				'artikel' => unserialize($cartItem->getArtikel()),
				'anzahl' => $cartItem->getAnzahl(),
				'preis' => $cartItem->getPreis(),
				'bild' => $cartItem->getBild()
			);
		}
		return json_encode($cart);
	}

	/**
	 * 
	 * @return string
	 */
	public function orderFromNoticeListAction() {
		$ses_id = $GLOBALS['TSFE']->fe_user->user['ses_id'];
		$userId = $GLOBALS['TSFE']->fe_user->user['uid'];

		$noticeName = '';

		$result = true;
		$args = $this->request->getArguments();
		$notice_ids = explode('_', $args['ids']);

		$notices = array();
		for ($i = 0; $i < count($notice_ids); $i++) {
			array_push($notices, $this->noticelistRepository->findByUid($notice_ids[$i]));
		}

		foreach ($notices as $notice) {
			$cart = new \Glacryl\Glshop\Domain\Model\Cart();
			$cart->setArticle($notice->getArticle());
			$cart->setPic($notice->getPic());
			$cart->setPosition($notice->getPosition());
			$cart->setPrice($notice->getPrice());
			$cart->setQty($notice->getQty());
			$cart->setSessionId($ses_id);
			$cart->setUser($userId);
			$cart->setNotice(1);

			if ($noticeName == '') {
				$noticeName = $notice->getNoticeName();
			}

			$res = $this->cartRepository->save($cart);
			if (($res->getUid() == null) || ($res->getUid() == 0)) {
				$result = false;
			}
		}

		$this->cartController->refactorPositionNumber($userId, $ses_id);

		//$this->debugTypo($notices);

		return json_encode(array('noError' => $result, 'listName' => $noticeName));
	}

	/**
	 * 
	 * @return string
	 */
	public function clearFromNoticeListAction() {
		$ses_id = $GLOBALS['TSFE']->fe_user->user['ses_id'];
		$userId = $GLOBALS['TSFE']->fe_user->user['uid'];

		$noticeName = '';

		$result = true;
		$args = $this->request->getArguments();
		$notice_ids = explode('_', $args['ids']);

		$notices = array();
		for ($i = 0; $i < count($notice_ids); $i++) {
			array_push($notices, $this->noticelistRepository->findByUid($notice_ids[$i]));
		}

		foreach ($notices as $notice) {
			$this->noticelistRepository->deleteNoticelist($notice);
		}

		return json_encode(array('noError' => $result, 'listName' => $noticeName));
	}

	/**
	 * 
	 * @return string
	 */
	public function createNoticeListAction() {
		$ses_id = $GLOBALS['TSFE']->fe_user->user['ses_id'];
		$userId = $GLOBALS['TSFE']->fe_user->user['uid'];
		$args = $this->request->getArguments();

		$db = $this->cartRepository->getCurrentCartItems($userId, $ses_id);

		$this->priceController->init($db);

		$details = array(
			'rabatt' => round($this->priceController->getRabatt(), 2),
			'ewPalette' => $this->priceController->getEwPalette(),
			'werbelandRabatt' => $this->priceController->getWerbelandRabatt()
		);
		$result = true;

		$now = new \DateTime('now');
		$expire = $this->addMonths(new \DateTime('now'), +6);

		foreach ($db as $key => $cartItem) {
			$article = unserialize($cartItem->getArticle());
			if ($article['voucher'] == null) {
				$noticelist = new \Glacryl\Glshop\Domain\Model\Noticelist();
				$noticelist->setArticle($cartItem->getArticle());
				$noticelist->setDetails(serialize($details));
				$noticelist->setNoticeName($args['name']);
				$noticelist->setPic($cartItem->getPic());
				$noticelist->setPosition($cartItem->getPosition());
				$noticelist->setQty($cartItem->getQty());
				$noticelist->setPrice($cartItem->getPrice());
				$noticelist->setDate($now);
				$noticelist->setExpire($expire);
				$noticelist->setUser($userId);
				$noticelist->setPid(intval('4'));

				$res = $this->noticelistRepository->saveNoticelist($noticelist);

				if (($res->getUid() == null) || ($res->getUid() == 0)) {
					$result = false;
				}
			}
		}



		return json_encode(array('noError' => $result, 'listName' => $args['name']));
	}

	public function getNoticeDetailAction() {
		$userId = $GLOBALS['TSFE']->fe_user->user['uid'];
		//$this->debugTypo($GLOBALS['TSFE'], 'TSFE', true);

		$noticeName = '';
		$details = array();

		$this->setKonfiguratorData();

		//$this->debugTypo($this->konfiguratorData, 'Konfigdata', true);

		$result = true;
		$args = $this->request->getArguments();
		$notice_ids = explode('_', $args['ids']);

		$notices = array();
		for ($i = 0; $i < count($notice_ids); $i++) {
			array_push($notices, $this->noticelistRepository->findByUid($notice_ids[$i]));
		}

		//$this->debugTypo($notices, '$notices', true);
		//$this->debugTypo($userId, 'User', true);

		foreach ($notices as $notice) {
			if ($notice->getUser() == $userId) {
				array_push($details, $this->noticelistController->getNoticeDetail($notice, $this->konfiguratorData));
			} else {
				$result = false;
				$details = 'Falscher Benutzer';
			}
		}

		//$this->debugTypo($details, 'Details', true);


		return json_encode(array('noError' => $result, 'details' => $details));
	}

	function addMonths($date, $months) {
		$years = floor(abs($months / 12));
		$leap = 29 <= $date->format('d');
		$m = 12 * (0 <= $months ? 1 : -1);
		for ($a = 1; $a < $years; ++$a) {
			$date = addMonths($date, $m);
		}
		$months -= ($a - 1) * $m;

		$init = clone $date;
		if (0 != $months) {
			$modifier = $months . ' months';

			$date->modify($modifier);
			if ($date->format('m') % 12 != (12 + $months + $init->format('m')) % 12) {
				$day = $date->format('d');
				$init->modify("-{$day} days");
			}
			$init->modify($modifier);
		}

		$y = $init->format('Y');
		if ($leap && ($y % 4) == 0 && ($y % 100) != 0 && 28 == $init->format('d')) {
			$init->modify('+1 day');
		}
		return $init;
	}

	function addYears($date, $years) {
		return addMonths($date, 12 * $years);
	}

	public function getNewShippingPriceAction() {
		if (!isset($GLOBALS['TCA'])) {
			$GLOBALS['TSFE']->includeTCA();
		}

		$userId = $GLOBALS['TSFE']->fe_user->user['uid'];
		$user = $this->customerRepository->findByUid($userId);

		$args = $this->request->getArguments();
		$sess_id = $GLOBALS['TSFE']->fe_user->user['ses_id'];

		$plz = $args['zip'];

		$cartItems = $this->cartRepository->getCurrentCartItems($userId, $sess_id);

		$this->priceController->init($cartItems);
		$shipping = $this->priceController->calculateShipping($cartItems, $user, $plz);

		return json_encode($shipping);
	}

	public function placeOrderAction() {
		if (!isset($GLOBALS['TCA'])) {
			$GLOBALS['TSFE']->includeTCA();
		}



		$error = array('error' => true);
		$userId = $GLOBALS['TSFE']->fe_user->user['uid'];
		$args = $this->request->getArguments();
		$sess_id = $GLOBALS['TSFE']->fe_user->user['ses_id'];

		$data = $args['data'];

		$cartItems = $this->cartRepository->getCurrentCartItems($userId, $sess_id);

		$this->priceController->init($cartItems);

		$bemerkungen = array(
			'bemerkung' => array(
				'kommission' => $data['bemerkung']['kommission'],
				'bemerkung' => $data['bemerkung']['bemerkung'],
			),
			'versand' => array(
				'art' => $data['versand']['art'],
				'preis' => $data['versand']['preis']
			),
			'zahlung' => array(
				'art' => $data['zahlung']['art']
			),
			'rabatt' => $this->priceController->getRabatt(),
			'ewPalette' => $this->priceController->getEwPalette(),
			'werbelandRabatt' => $this->priceController->getWerbelandRabatt()
		);

		$artikel = array();
		$imgs = array();

		$ext_path = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('glshop');

		foreach ($cartItems as $cartItem) {
			$article = unserialize($cartItem->getArticle());
			if (!isset($article['material']) || isset($article['profil'])) {
				$picName = $cartItem->getPic();
			} else {
				// Neues Schild Bild erstellen und an DB uebergeben
				$schild = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('Schild');
				$picName = $schild->initialize($article, $ext_path)->draw()->saveImg($userId, $cartItem->getPosition());
			}
			$artikel[$cartItem->getPosition()] = array(
				'artikel' => $article,
				'anzahl' => $cartItem->getQty(),
				'preis' => $cartItem->getPrice(),
				'bild' => $picName
			);
			array_push($imgs, $picName);
		}

		$user = $this->getUser($userId);

		$order = new \Glacryl\Glshop\Domain\Model\Order();
		/** ToDO: Pid auf 117 ändern */
		$order->setPid(intval('4'));
		$order->setDate(new \DateTime('now'));
		$order->setUser($userId);
		$order->setComment(serialize($bemerkungen));
		$order->setArticle(serialize($artikel));
		$order->setFormular('');
		// Fehler Quelle, wenn keine Kondition hinterlegt ist!
		$order->setConditions($user->getPayCondition());



		if (isset($data['adresse']['lieferung']) && ($data['adresse']['lieferung'] != '')) {
			$abwAdresse = $this->shippingadressRepository->findByUid($data['adresse']['lieferung']);
			$order->setShippingaddress($abwAdresse);
		}

		$savedOrder = $this->orderRepository->save($order);

		if (isset($savedOrder)) {
			$lastUid = $savedOrder->getUid();
			for ($i = 0; $i < count($imgs); $i++) {
				if (isset($imgs) && ($imgs != '')) {
					if ($imgs[$i] != null) {
						if (file_exists($ext_path . 'Resources/Public/Zeichnungen/' . $imgs[$i])) {
							//rename($ext_path . 'Resources/Public/Zeichnungen/' . $imgs[$i], $ext_path . 'Resources/Private/Downloads/Zeichnungen/' . $imgs[$i]);
							copy($ext_path . 'Resources/Public/Zeichnungen/' . $imgs[$i], $ext_path . 'Resources/Private/Downloads/Zeichnungen/' . $imgs[$i]);
						}
					}
				}
			}

			$this->changeStatus('eg', $savedOrder);

			if (!$this->sendBestellMail($lastUid, false, $this->getUser($userId))) {
				$error = array('mail' => true);
			}

			foreach ($cartItems as $cartItem) {
				$this->cartRepository->deleteCart($cartItem);
			}
		}

		return json_encode($error);
	}

	public function uploadFileAction() {
		$userId = $GLOBALS['TSFE']->fe_user->user['uid'];
		$args = $this->request->getArguments();

		//$this->debugTypo($_FILES);

		$extPath = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('pd_schildkonfigurator');

		$output_dir = $extPath . 'Resources/Private/Uploads/' . $userId . "/";

		if (!file_exists($output_dir)) {
			mkdir($output_dir, 0777, true);
		}

		if (isset($_FILES["files"])) {
			$ret = array();

			$error = $_FILES["files"]["error"];
			//You need to handle  both cases
			//If Any browser does not support serializing of multiple files using FormData() 
			if (!is_array($_FILES["files"]["name"])) { //single file
				$fileName = $_FILES["files"]["name"];
				move_uploaded_file($_FILES["files"]["tmp_name"], $output_dir . $fileName);
				$ret[] = $fileName;
			} else {  //Multiple files, file[]
				$fileCount = count($_FILES["files"]["name"]);
				for ($i = 0; $i < $fileCount; $i++) {
					$fileName = $_FILES["files"]["name"][$i];
					move_uploaded_file($_FILES["files"]["tmp_name"][$i], $output_dir . $fileName);
					$ret[] = $fileName;
				}
			}
			return json_encode($ret);
		}
	}

	public function debugTypo($data, $name = '', $print = false) {
		if ($print) {
			\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($data, $name);
		}
	}

	public function debug($data, $functions = false, $vars = false, $fluid = false) {
		if ($fluid) {
			$this->view->assign('debug', $data);
		} else {
			echo "<pre>";
			if ($functions) {
				$class_methods = get_class_methods($data);
				foreach ($class_methods as $method_name) {
					echo "$method_name\n";
				}
			} else if ($vars) {
				var_dump(get_object_vars($data));
			} else {
				var_dump($data);
			}
			echo "</pre>";
		}
	}

}

?>