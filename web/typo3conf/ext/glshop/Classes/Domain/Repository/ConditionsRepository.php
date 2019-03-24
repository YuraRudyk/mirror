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
 * The repository for Conditions
 */
class ConditionsRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
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
     * findOrderByUid
     * 
     * @param $uid
     * @return
     */
    public function findConditions()
    {
        $cond = $this->findAll();
        $arr = [];
        for ($i = 0; $i < count($cond); $i++) {
            array_push(
            $arr, 
            [
    'uid' => $cond[$i]->getUid(),
'days' => $cond[$i]->getDays(),
'reduction' => $cond[$i]->getReduction(),
'netto' => $cond[$i]->getNetto()
]
            );
        }

        //$this->debugTypo($cond);
        return $arr;
    }

    /**
     * @param $data
     */
    public function debugTypo($data)
    {
        \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($data);
    }
}
