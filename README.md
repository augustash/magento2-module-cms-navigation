# Magento 2 Module - CMS Navigation

![https://www.augustash.com](http://augustash.s3.amazonaws.com/logos/ash-inline-color-500.png)

**This is a private module and is not currently aimed at public consumption.**

## Overview

The `Augustash_CmsNavigation` module is a simple extension to allow displaying CMS pages alongside the default category-based navigation.

## Installation

### Via Local Module

Install the extension files directly into the project source:

```bash
mkdir -p app/code/Augustash/CmsNavigation/
curl -Ss https://github.com/augustash/magento2-module-cms-navigation/archive/0.9.0.tar.gz | tar xf - --strip 1 -C app/code/Augustash/CmsNavigation/
bin/magento module:enable --clear-static-content Augustash_CmsNavigation
bin/magento setup:upgrade
bin/magento cache:flush
```

### Via Composer

Install the extension using Composer using our development package repository:

```bash
composer config repositories.augustash composer https://packages.augustash.com/repo/private
composer require augustash/magento2-module-cms-navigation:~0.9.0
bin/magento module:enable --clear-static-content Augustash_CmsNavigation
bin/magento setup:upgrade
bin/magento cache:flush
```

## Uninstall

After all dependent modules have also been disabled or uninstalled, you can finally remove this module:

```bash
bin/magento module:disable --clear-static-content Augustash_CmsNavigation
rm -rf app/code/Augustash/CmsNavigation/
composer remove augustash/magento2-module-cms-navigation
bin/magento setup:upgrade
bin/magento cache:flush
```

## Structure

[Typical file structure for a Magento 2 module](http://devdocs.magento.com/guides/v2.3/extension-dev-guide/build/module-file-structure.html).
