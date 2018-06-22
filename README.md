# TBoileau/LifecycleBundle

[![Build Status](https://travis-ci.org/TBoileau/LifecycleBundle.svg?branch=master)](https://travis-ci.org/TBoileau/LifecycleBundle) 
[![Maintainability](https://api.codeclimate.com/v1/badges/cd7eb6cb24eafa9295d4/maintainability)](https://codeclimate.com/github/TBoileau/LifecycleBundle/maintainability)
[![Test Coverage](https://api.codeclimate.com/v1/badges/cd7eb6cb24eafa9295d4/test_coverage)](https://codeclimate.com/github/TBoileau/LifecycleBundle/test_coverage)


## Installation

### Step 1: Download the Bundle

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

```console
$ composer require tboileau/form-handler-bundle
```

This command requires you to have Composer installed globally, as explained
in the [installation chapter](https://getcomposer.org/doc/00-intro.md)
of the Composer documentation.

### Step 2: Enable the Bundle

Then, enable the bundle by adding it to the list of registered bundles
in the `config/bundles.php` file of your project:

```php
<?php
// config/bundles.php

return [
    //...
    TBoileau\LifecycleBundle\TBoileauLifecycleBundle::class => ['all' => true],
    //...
];

```