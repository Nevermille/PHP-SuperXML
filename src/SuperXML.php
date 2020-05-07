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
    protected $document;

    /**
     * @brief The path to file
     * @var string
     */
    protected $filepath;

    /**
     * @brief If the XML file need to be saved after each operation
     * @var bool
     */
    protected $autosave;

    /**
     * @brief The xpath component
     * @var DOMXPath
     */
    protected $xpath;

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
     * @brief Replaces values inside the XML
     * @param string $expression The XPath expression
     * @param string $value The value to put
     * @param DOMNode|null $root The root node. If null, the root of the XML document is taken
     * @return void
     */
    public function replaceValue(string $expression, string $value, DOMNode $root = null): void
    {
        $nodes = $this->xpathQuery($expression, $root);

        foreach ($nodes as $node) {
            $node->nodeValue = $value;
        }

        $this->autosave();
    }

    /**
     * @brief Adds a child to a node
     * @param string $expression The XPath expression of the parent node
     * @param string $name The name of the child
     * @param string|null $value The value of the child
     * @param DOMNode|null $root The root node. If null, the root of the XML document is taken
     * @return void
     */
    public function addChild(string $expression, string $name, string $value = null, DOMNode $root = null): void
    {
        $nodes = $this->xpathQuery($expression, $root);

        foreach ($nodes as $node) {
            $newNode = $this->document->createElement($name, $value);
            $node->appendChild($newNode);
        }

        $this->autosave();
    }

    /**
     * @brief Removes nodes from the document
     * @param string $expression The XPath expression
     * @param DOMNode|null $root The root node. If null, the root of the XML document is taken
     * @return void
     */
    public function remove(string $expression, DOMNode $root = null): void
    {
        $nodes = $this->xpathQuery($expression, $root);

        foreach ($nodes as $node) {
            $node->parentNode->removeChild($node);
        }

        $this->autosave();
    }

    /**
     * @brief Sets an attribute for nodes
     * @param string $expression The XPath expression
     * @param string $name The name of the attribute
     * @param string $value The value of the attribute
     * @param DOMNode|null $root The root node. If null, the root of the XML document is taken
     * @return void
     */
    public function setAttribute(string $expression, string $name, string $value, DOMNode $root = null): void
    {
        $nodes = $this->xpathQuery($expression, $root);

        foreach ($nodes as $node) {
            $node->setAttribute($name, $value);
        }

        $this->autosave();
    }

    /**
     * @brief Removes an attribute on nodes
     * @param string $expression The XPath expression
     * @param string $name The name of the attribute
     * @param DOMNode|null $root The root node. If null, the root of the XML document is taken
     * @return void
     */
    public function removeAttribute(string $expression, string $name, DOMNode $root = null): void
    {
        $nodes = $this->xpathQuery($expression, $root);

        foreach ($nodes as $node) {
            $node->removeAttribute($name);
        }

        $this->autosave();
    }

    /**
     * @brief Returns the XML string
     * @param DOMNode|null $root The root node. If null, the root of the XML document is taken
     * @return string The XML string
     */
    public function getXML(DOMNode $root = null): string
    {
        return $this->document->saveXML($root);
    }

    /**
     * @brief Saves the file if autosave is set to true
     * @return void
     */
    protected function autosave(): void
    {
        if ($this->autosave) {
            $this->save();
        }
    }

    /**
     * @brief Saves the file into the original file
     * @return void
     */
    public function save(): void
    {
        $this->saveAs($this->filepath);
    }

    /**
     * @brief Saves the XML into a file
     * @param mixed $filepath The path to the file
     * @return void
     */
    public function saveAs($filepath): void
    {
        file_put_contents($filepath, $this->document->saveXML());
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
