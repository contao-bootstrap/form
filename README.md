Contao-Bootstrap Form Component
===============================

[![Build Status](http://img.shields.io/travis/contao-bootstrap/form/master.svg?style=flat-square)](https://travis-ci.org/contao-bootstrap/form)
[![Version](http://img.shields.io/packagist/v/contao-bootstrap/form.svg?style=flat-square)](http://packagist.org/packages/contao-bootstrap/form)
[![License](http://img.shields.io/packagist/l/contao-bootstrap/form.svg?style=flat-square)](http://packagist.org/packages/contao-bootstrap/form)
[![Downloads](http://img.shields.io/packagist/dt/contao-bootstrap/form.svg?style=flat-square)](http://packagist.org/packages/contao-bootstrap/form)
[![Contao Community Alliance coding standard](http://img.shields.io/badge/cca-coding_standard-red.svg?style=flat-square)](https://github.com/contao-community-alliance/coding-standard)


This extension provides Bootstrap 4 form support for Contao CMS.

Features
--------

 - Horizontal forms
 - Vertical forms
 - Choose different form layouts for each form
 - Choose form layout in content element or module
 - Uses custom styles by default
 - Support of non custom styles by changing form layout
 
Changelog
---------

See [changelog](CHANGELOG.md)
 
Requirements
------------

 - PHP 7.1
 - Contao ~4.4
 
 
Install
-------

### Managed edition

When using the managed edition it's pretty simple to install the package. Just search for the package in the
Contao Manager and install it. Alternatively you can use the CLI.  

```bash
# Using the contao manager
$ php contao-manager.phar.php composer require contao-bootstrap/form~2.0@beta

# Using composer directly
$ php composer.phar require contao-bootstrap/form~2.0@beta
```

### Standard edition

Without the contao manager you also have to register the bundle

```php

class AppKernel
{
    public function registerBundles()
    {
        $bundles = [
            // ...
            new Contao\CoreBundle\HttpKernel\Bundle\ContaoModuleBundle('metapalettes', $this->getRootDir()),
            new Contao\CoreBundle\HttpKernel\Bundle\ContaoModuleBundle('multicolumnwizard', $this->getRootDir()),
            new Netzmacht\Html\Netzmacht\HtmlBundle(),
            new Netzmacht\Contao\FormDesigner\NetzmachtContaoFormDesignerBundle(),
            new ContaoBootstrap\Core\ContaoBootstrapCoreBundle(),
            new ContaoBootstrap\Form\ContaoBootstrapFormBundle()
        ];
    }
}

```
