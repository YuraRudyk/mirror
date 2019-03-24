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
 * The repository for Fixings
 */
class FixingRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
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
    public function getHalter()
    {
        $array = [];
        $query = $this->createQuery();
        $halter = $query->execute();
        for ($i = 0; $i < count($halter); $i++) {
            $arr1 = [
    "uid" => $halter[$i]->getUid(),
"pid" => $halter[$i]->getPid(),
"name" => $halter[$i]->getName(),
"beschreibung" => $halter[$i]->getDescription(),
"verwendung" => $halter[$i]->getUsefixing(),
"montage" => $halter[$i]->getMounting(),
"bild" => $halter[$i]->getPic(),
"varianten" => []
];
            $varianten = $halter[$i]->getFixingoption();
            foreach ($varianten as $variante) {
                $arr2 = [
    "uid" => $variante->getUid(),
"pid" => $variante->getPid(),
"artnr" => $variante->getArticleNr(),
"name" => $variante->getName(),
"beschreibung" => $variante->getDescription(),
"material" => $variante->getMaterial(),
"befestigung" => $variante->getFix(),
"kopfform" => $variante->getHead(),
"laenge" => $variante->getLeange(),
"kopfstaerke" => $variante->getHeadsize(),
"sandwitch" => $variante->getSandwitch(),
"wandabstand" => $variante->getProjection(),
"materialVon" => $variante->getFromSize(),
"materialBis" => $variante->getToSize(),
"plattenbohrungUnterseite" => $variante->getDrillDownside(),
"halterkantenlaenge" => $variante->getBorderLength(),
"position" => $variante->getPosition(),
"durchmesser" => $variante->getDiameter(),
"preis" => $variante->getPrice(),
"gewicht" => $variante->getWeight(),
"bild" => $variante->getPic()
];
                array_push($arr1['varianten'], $arr2);
            }
            array_push($array, $arr1);
        }
        return $array;
    }
}
