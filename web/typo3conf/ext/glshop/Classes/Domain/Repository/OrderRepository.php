<?php
namespace Glacryl\Glshop\Domain\Repository;


/* * *************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2014 Petro Dikij <petro.dikij@glacryl.de>, Glacryl Hedel GmbH
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 * ************************************************************* */
/***
 *
 * This file is part of the "Glacryl Shop System" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2019 Petro Dikij <petro.dikij@glacryl.de>, Glacryl Hedel GmbH
 *
 ***/
/**
 * The repository for Orders
 */
class OrderRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{

    /**
     * PersistenceManager
     * 
     * @var \TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager
     * @inject
     */
    protected $persistenceManager = null;

    /**
     * CustomerRepository
     * 
     * @var \Glacryl\Glshop\Domain\Repository\CustomerRepository
     * @inject
     */
    protected $customerRepository = NULL;

    /**
     * Initialize the repository
     * 
     * @return void
     */
    public function initializeObject()
    {
        $querySettings = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\Typo3QuerySettings');
        $querySettings->setRespectStoragePage(FALSE);
        $this->setDefaultQuerySettings($querySettings);
    }

    /**
     * Funciton SaveOrder
     * 
     * @param \Glacryl\Glshop\Domain\Model\Order $order
     * @return \Glacryl\Glshop\Domain\Model\Order $order
     */
    public function save($order)
    {
        $this->add($order);
        $this->persistenceManager->persistAll();
        return $order;
    }

    /**
     * @param $order
     * @param $state
     */
    public function testChangeStatus($order, $state)
    {
        $change = true;
        $statusse = $order->getOrderstatus();

        //$this->debugTypo($statusse);
        if (isset($statusse)) {
            foreach ($statusse as $status) {
                if ($status->getOrderstate() == $state) {
                    $change = false;
                }
            }
        }
        return $change;
    }

    /**
     * findByCustomer
     * 
     * @param $user
     * @return
     */
    public function findByCustomer($user)
    {
        $query = $this->createQuery();
        $query->getQuerySettings()->setReturnRawQueryResult(TRUE);
        $query->statement("SELECT * FROM tx_glshop_domain_model_order WHERE user='" . $user . "' ORDER BY uid DESC");
        return $query->execute();
    }

    /**
     * findOrderByUid
     * 
     * @param $uid
     * @return
     */
    public function findOrderByUid($uid)
    {
        $order = $this->findByUid($uid);
        $shipping = null;
        if ($order->getShippingaddress()) {
            $shipping = [
    'firma' => $order->getShippingaddress()->getCompany(),
'name' => $order->getShippingaddress()->getPerson(),
'strasse' => $order->getShippingaddress()->getStreet(),
'plz' => $order->getShippingaddress()->getZip(),
'ort' => $order->getShippingaddress()->getCity(),
'uid' => $order->getShippingaddress()->getUid()
];
        }
        $arr = [
    'uid' => $order->getUid(),
'date' => $order->getDate()->format('Y/m/d H:i'),
'article' => unserialize($order->getArticle()),
'comment' => unserialize($order->getComment()),
'formular' => unserialize($order->getFormular()),
'user' => $order->getUser(),
'shippingadress' => $shipping,
'conditions' => $order->getConditions() != null ? $order->getConditions()->getUid() : null
];

        //$this->debugTypo($order);
        return $arr;
    }

    /**
     * getAbschlussOrders
     * 
     * @param String $von
     * @param String $bis
     * @return array
     */
    public function getAbschlussOrders($von, $bis)
    {
        $data = [];
        $orders = $this->findOrdersForPeriod($von);
        foreach ($orders as $order) {
            $invoice = $order->getInvoice()->current();
            if (isset($invoice)) {
                $v = strtotime($von);
                $b = strtotime($bis);
                $d = $invoice->getDate()->getTimestamp();
                if ($v <= $d && $d <= $b) {
                    array_push($data, $this->getOrderDataForAbschluss($order));
                }
            }
        }
        $sorted = $this->array_orderby($data, 'rgNr', SORT_ASC, 'rgDatum', SORT_ASC);
        return $sorted;
    }

    /**
     * @param $von
     */
    public function findOrdersForPeriod($von)
    {
        $v = new \DateTime($von);
        $v->modify('-3 month');
        $vF = $v->format('d.m.Y H:i');
        $query = $this->createQuery();
        $query->matching(
        $query->logicalAnd($query->greaterThanOrEqual('date', strtotime($vF)), $query->greaterThan('invoice', 0))
        );
        $result = $query->execute();
        return $result;
    }
    public function array_orderby()
    {
        $args = func_get_args();
        $data = array_shift($args);
        foreach ($args as $n => $field) {
            if (is_string($field)) {
                $tmp = [];
                foreach ($data as $key => $row) {
                    $tmp[$key] = $row[$field];
                }
                $args[$n] = $tmp;
            }
        }
        $args[] =& $data;
        call_user_func_array('array_multisort', $args);
        return array_pop($args);
    }

    /**
     * @param $order
     */
    public function getOrderDataForAbschluss($order)
    {

        /*if($order->getConfirmation()->current()->getUid() == 576){
        		$this->debugTypo($order, 'Auftrag I' . $order->getUid() . ':');
        		}*/
        $zwSumme = 0;
        $items = unserialize($order->getArticle());
        $formular = unserialize($order->getFormular());
        $bemerkungen = unserialize($order->getComment());
        $versand = floatval($formular['versandkosten']);
        $rabatt = floatval($bemerkungen['rabatt']);
        $ewPalette = floatval($bemerkungen['ewPalette']);
        $nachlass = floatval($formular['nachlass']);
        $nachlassEinheit = $formular['nachlassEinheit'];
        $werbeland = $bemerkungen['werbelandRabatt'];

        /*if($order->getConfirmation()->current()->getUid() == 576){		
        		$this->debugTypo($items, 'Artikel:');	
        		$this->debugTypo($formular, 'formular:');	
        		$this->debugTypo($bemerkungen, 'Bemerkung:');	
        		}*/
        $mwSt = $formular['ausland'] == 'true' ? 0 : 19;
        $preisNetto = 0;
        foreach ($items as $item) {
            $preisNetto += $item['preis'] * $item['anzahl'];
        }
        $zwSumme += $zwSumme + $preisNetto;
        if (isset($rabatt) && $rabatt != 0) {
            $zwSumme = $zwSumme - $rabatt;
        }
        if (isset($nachlass) && $nachlass != '' && $nachlass != 0) {
            if ($nachlassEinheit == 'EUR') {
                $zwSumme = $zwSumme - floatval($nachlass);
            } else {
                $berechnet = $zwSumme * floatval($nachlass) / 100;
                $zwSumme = $zwSumme - $berechnet;
            }
        }
        if (isset($werbeland) && $werbeland != 0) {
            $summeWerbeland = $zwSumme * $werbeland / 100;
            $zwSumme = $zwSumme - $summeWerbeland;
        }
        if (isset($ewPalette) && $ewPalette != 0) {
            $zwSumme = $zwSumme + $ewPalette;
        }
        $netto = $zwSumme + $versand;
        $invoice = $order->getInvoice()->current();
        $user = $this->customerRepository->findByUid($order->getUser());

        //$this->debugTypo($user, 'user:');
        $confirmation = $order->getConfirmation()->current();
        $zahlungsbed = '';
        $bed = $user->getPayCondition();
        if ($bed->getDays() == 0) {
            $zahlungsbed .= 'Netto innerhalb v. ' . $bed->getNetto() . ' Tagen';
        } else {
            $zahlungsbed .= $bed->getDays() . ' Tage ' . $bed->getReduction() . '%, ' . $bed->getNetto() . ' Tage netto';
        }
        $data = [
    'brutto' => round($netto * ($mwSt == 0 ? 1 : 1 + $mwSt / 100), 2),
'mwstSatz' => $mwSt,
'steuer' => '' . round($netto * ($mwSt / 100), 2),
'netto' => round($netto, 2),
'kennzeichen' => 'S',
'rgNr' => 'I' . $invoice->getUid(),
'rgDatum' => $invoice->getDate()->format('d.m.Y'),
'auNr' => 'I' . $confirmation->getUid(),
'kdNr' => $user->getUid(),
'gegenkonto' => '8401',
'kdName' => $user->getCompany(),
'art1' => 'Zahlungsbedingung',
'inhalt1' => $zahlungsbed
];

        //$this->debugTypo($data, 'Exceldata:');
        return $data;
    }

    /**
     * @param $data
     * @param $name
     */
    public function debugTypo($data, $name = '')
    {
        \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($data, $name);
    }

    /**
     * @param $data
     * @param $functions
     * @param $vars
     * @param $fluid
     */
    public function debug($data, $functions = false, $vars = false, $fluid = false)
    {
        if ($fluid) {
            $this->view->assign('debug', $data);
        } else {
            echo "<pre>";
            if ($functions) {
                $class_methods = get_class_methods($data);
                foreach ($class_methods as $method_name) {
                    echo "{$method_name}\n";
                }
            } else {
                if ($vars) {
                    var_dump(get_object_vars($data));
                } else {
                    var_dump($data);
                }
            }
            echo "</pre>";
        }
    }
}
