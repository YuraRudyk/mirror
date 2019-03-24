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
 * The repository for Cornereditings
 */
class CornereditingRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{

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
    public function getEckbearbeitungen()
    {
        $array = [];
        $query = $this->createQuery();
        $eckbearbeitungen = $query->execute();
        for ($i = 0; $i < count($eckbearbeitungen); $i++) {
            $arr1 = [
    "uid" => $eckbearbeitungen[$i]->getUid(),
"pid" => $eckbearbeitungen[$i]->getPid(),
"name" => $eckbearbeitungen[$i]->getName(),
"bild" => $eckbearbeitungen[$i]->getPic(),
"preis" => $eckbearbeitungen[$i]->getPrice(),
"varianten" => []
];
            $varianten = $eckbearbeitungen[$i]->getCornereditingoption();
            foreach ($varianten as $variante) {
                $arr2 = [
    "uid" => $variante->getUid(),
"pid" => $variante->getPid(),
"ab" => $variante->getFromSize(),
"bis" => $variante->getToSize(),
"preis" => $variante->getPrice()
];
                array_push($arr1['varianten'], $arr2);
            }
            array_push($array, $arr1);
        }
        return $array;
    }
}
