<?php
namespace Glacryl\Glshop\Domain\Model;


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
 * Anfragen
 */
class Request extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * date
     * 
     * @var \DateTime
     */
    protected $date = NULL;

    /**
     * title
     * 
     * @var string
     */
    protected $title = '';

    /**
     * text
     * 
     * @var string
     */
    protected $text = '';

    /**
     * files
     * 
     * @var string
     */
    protected $files = '';

    /**
     * done
     * 
     * @var int
     */
    protected $done = 0;

    /**
     * user
     * 
     * @var
     */
    protected $user = NULL;

    /**
     * Returns the date
     * 
     * @return \DateTime $date
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Sets the date
     * 
     * @param \DateTime $date
     * @return void
     */
    public function setDate(\DateTime $date)
    {
        $this->date = $date;
    }

    /**
     * Returns the title
     * 
     * @return string $title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Sets the title
     * 
     * @param string $title
     * @return void
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Returns the text
     * 
     * @return string $text
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Sets the text
     * 
     * @param string $text
     * @return void
     */
    public function setText($text)
    {
        $this->text = $text;
    }

    /**
     * Returns the files
     * 
     * @return string $files
     */
    public function getFiles()
    {
        return $this->files;
    }

    /**
     * Sets the files
     * 
     * @param string $files
     * @return void
     */
    public function setFiles($files)
    {
        $this->files = $files;
    }

    /**
     * Returns the done
     * 
     * @return integer $done
     */
    public function getDone()
    {
        return $this->done;
    }

    /**
     * Sets the done
     * 
     * @param integer $done
     * @return void
     */
    public function setDone($done)
    {
        $this->done = $done;
    }

    /**
     * Returns the user
     * 
     * @return user
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Sets the user
     * 
     * @param string $user
     * @return user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }
}
