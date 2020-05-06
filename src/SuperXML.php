<?php

namespace Lianhua\SuperXML;

use DOMDocument;

/*
SuperXML Library
Copyright (C) 2020  Lianhua Studio

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

/**
 * @file SuperXML.php
 * @author Camille Nevermind
 */

/**
 * @brief The main class
 * @class SuperXML
 * @package Lianhua\SuperXML
 */
class SuperXML
{
    /**
     * @brief The DOM Document
     * @var DOMDocument
     */
    private $document;

    /**
     * @brief The path to file
     * @var string
     */
    private $filepath;

    /**
     * @brief The constructor
     * @param string $file The file path to the XML file
     * @param bool $autosave If the file needs to be updated at each operation
     * @return void
     *
     * If the file doesn't exist, a new one will be created
     */
    public function __construct(string $file, bool $autosave = true)
    {
        if (!file_exists($file)) {
            $this->document = new DOMDocument("1.0", "UTF-8");
        } else {
            $this->document = new DOMDocument();
            $this->document->load($file);
        }
    }
}
