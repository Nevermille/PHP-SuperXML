<?php

namespace Lianhua\SuperXML;

use DOMDocument;
use DOMNode;
use DOMNodeList;
use DOMXPath;

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
     * @brief If the XML file need to be saved after each operation
     * @var bool
     */
    private $autosave;

    /**
     * @brief The xpath component
     * @var DOMXPath
     */
    private $xpath;

    /**
     * @brief Executes a query on the document or a node
     * @param string $expression The XPath expression
     * @param DOMNode|null $root The root node. If null, the root of the XML document is taken
     * @return DOMNodeList|false A list of nodes
     */
    public function xpathQuery(string $expression, DOMNode $root = null)
    {
        return $this->xpath->query($expression, $root);
    }

    /**
     * @brief Evaluates a path expression on the document or a node
     * @param string $expression The XPath expression
     * @param DOMNode|null $root The root node. If null, the root of the XML document is taken
     * @return mixed A list of nodes or the result value
     */
    public function xpathEval(string $expression, DOMNode $root = null)
    {
        return $this->xpath->evaluate($expression, $root);
    }

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

        $this->filepath = $file;
        $this->autosave = $autosave;
        $this->xpath = new DOMXPath($this->document);
    }
}
