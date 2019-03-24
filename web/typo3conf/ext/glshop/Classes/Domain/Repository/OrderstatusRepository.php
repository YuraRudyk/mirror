<?php
namespace Glacryl\Glshop\Domain\Repository;


/***************************************************************
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
 ***************************************************************/
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
 * The repository for Orderstatuses
 */
class OrderstatusRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{

    /**
     * PersistenceManager
     * 
     * @var \TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager
     * @inject
     */
    protected $persistenceManager = null;

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
     * Funciton SaveStatus
     * 
     * @param \Glacryl\Glshop\Domain\Model\Orderstatus $status
     * @return \Glacryl\Glshop\Domain\Model\Orderstatus $status
     */
    public function save($status)
    {
        $this->add($status);
        $this->persistenceManager->persistAll();
        return $status;
    }

    //ToDo Bei gelegenheit mal machen
    /**
     * getAllCurrentStatus
     * 
     * @return
     */
    public function getAllCurrentStatus()
    {
        $query = $this->createQuery();
        $res = $query->setOrderings(['uid' => 'DESC'])->execute();
        $res = $res->getFirst();
        if (isset($res)) {
            $res = intval($res->getUid()) + 1;
        } else {
            $res = 1;
        }
        return $res;
    }

    /**
     * getAllStatusse
     * 
     * @return
     */
    public function getAllStatusse()
    {
        $query = $this->createQuery();
        $query->getQuerySettings()->setReturnRawQueryResult(TRUE);
        $query->statement("SELECT * FROM tx_glshop_domain_model_orderstatus");
        return $query->execute();
    }

    /**
     * debug
     * 
     * @param $data
     * @param $functions
     * @param $vars
     * @param $fluid
     * @return
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
