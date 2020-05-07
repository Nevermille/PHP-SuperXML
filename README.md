# PHP SuperXML
A little library for XML manipulation in PHP

[![Build Status](https://travis-ci.com/Nevermille/PHP-SuperXML.svg?branch=master)](https://travis-ci.com/Nevermille/PHP-SuperXML) [![BCH compliance](https://bettercodehub.com/edge/badge/Nevermille/PHP-SuperXML?branch=master)](https://bettercodehub.com/) [![License: GPL v3](https://img.shields.io/badge/License-GPLv3-blue.svg)](https://www.gnu.org/licenses/gpl-3.0)

## Overview

A simple library to manipulate XML files in PHP

## Compatibility

This library has been tested for PHP 7.3 and higher

## Installation

Just use composer in your project:

```
composer require lianhua/superxml
```

If you don't use composer, clone or download this repository, all you need is inside the src directory.

## Usage
### Open a XML file

Let's say we have the following XML file:

```xml
<inventory>
    <fruits>
        <fruit>Apple</fruit>
        <fruit>Banana</fruit>
    </fruits>
    <vegetables>
        <vegetable>Carrot</vegetable>
    </vegetables>
</inventory>
```

You can open this document with a new SuperXML:

```php
$xml = new SuperXML("/path/to/xml/file");
```

### Search nodes

You can search all nodes from a XPath expression:

```php
$nodes = $xml->xpathQuery("/inventory/fruits/fruit"); // DOMNodeList with 'Apple' and 'Banana' nodes
```

### Evaluate expression

You can evaluate an XPath expression:

```php
$count = $xml->xpathEval("count(/inventory/fruits/fruit)"); // 2
```

### Create a node

You can create a node with the XPath expression of the parent:

```php
$xml->addChild("/inventory/fruits", "fruit", "Kiwi");
```

The document becomes:

```xml
<inventory>
    <fruits>
        <fruit>Apple</fruit>
        <fruit>Banana</fruit>
        <fruit>Kiwi</fruit>
    </fruits>
    <vegetables>
        <vegetable>Carrot</vegetable>
    </vegetables>
</inventory>
```

### Delete a node

You can delete a node:

```php
$xml->remove("/inventory/vegetables/vegetable");
```

The document becomes:

```xml
<inventory>
    <fruits>
        <fruit>Apple</fruit>
        <fruit>Banana</fruit>
    </fruits>
    <vegetables>

    </vegetables>
</inventory>
```

### Replace a value

You can replace a node value:

```php
$xml->replaceValue("/inventory/vegetables/vegetable", "Potato");
```

The document becomes:

```xml
<inventory>
    <fruits>
        <fruit>Apple</fruit>
        <fruit>Banana</fruit>
    </fruits>
    <vegetables>
        <vegetable>Potato</vegetable>
    </vegetables>
</inventory>
```

### Set an attribute

You can set an attribute to nodes:

```php
$xml->setAttribute("/document/vegetables/vegetable[.='Carrot']", "growIn", "soil");
```

The document becomes:

```xml
<inventory>
    <fruits>
        <fruit>Apple</fruit>
        <fruit>Banana</fruit>
    </fruits>
    <vegetables>
        <vegetable growIn="soil">Carrot</vegetable>
    </vegetables>
</inventory>
```

### Remove an attribute

You can remove an attribute, let's say you have the last example to start with:

```php
$xml->removeAttribute("/document/vegetables/vegetable[.='Carrot']", "growIn", "soil");
```

The document becomes:

```xml
<inventory>
    <fruits>
        <fruit>Apple</fruit>
        <fruit>Banana</fruit>
    </fruits>
    <vegetables>
        <vegetable>Carrot</vegetable>
    </vegetables>
</inventory>
```

### Autosaving

By default, the document is saved each time you edit it. To avoid this, set the second constructor parameter to false :

```php
$xml = new SuperXML("/path/to/xml/file", false);
```
