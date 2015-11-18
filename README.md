StudioEmma_Core
===============

# General

The purpose of this module is to offer general functionality that is usefull for different Magento 2 projects.

# Functions

## Product

### getCurrentCategory

You can get the current category by using this code in the view template:

```php
<?php
$_helper = $this->helper('StudioEmma\Core\Helper\Product');
$currentCategory = $_helper->getCurrentCategory();

echo $currentCategory->getName();
?>
```

## Store

### getCurrentStore

Return the current store

```php
<?php
$_helper = $this->helper('StudioEmma\Core\Helper\Store');
$currentStore = $_helper->getCurrentStore();
?>
```

### getLocale

Return the current locale associated with the current store.

```php
<?php
$_helper = $this->helper('StudioEmma\Core\Helper\Store');
echo $_helper->getLocale();
?>
```