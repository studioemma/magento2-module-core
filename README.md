# StudioEmma_Core

## General

The purpose of this module is to offer general functionality that is usefull for different Magento 2 projects.

## Functions

### getCurrentCategory

You can get the current category by using this code in the view template:

<?php
$_helper = $this->helper('StudioEmma\Core\Helper\Product');
$currentCategory = $_helper->getCurrentCategory();

echo $currentCategory->getName();
?>