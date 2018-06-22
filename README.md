# TBoileau/LifecycleBundle

[![Build Status](https://travis-ci.org/TBoileau/LifecycleBundle.svg?branch=master)](https://travis-ci.org/TBoileau/LifecycleBundle) 
[![Maintainability](https://api.codeclimate.com/v1/badges/cd7eb6cb24eafa9295d4/maintainability)](https://codeclimate.com/github/TBoileau/LifecycleBundle/maintainability)
[![Test Coverage](https://api.codeclimate.com/v1/badges/cd7eb6cb24eafa9295d4/test_coverage)](https://codeclimate.com/github/TBoileau/LifecycleBundle/test_coverage)
[![Latest Stable Version](https://poser.pugx.org/tboileau/lifecycle-bundle/v/stable)](https://packagist.org/packages/tboileau/lifecycle-bundle)
[![Total Downloads](https://poser.pugx.org/tboileau/lifecycle-bundle/downloads)](https://packagist.org/packages/tboileau/lifecycle-bundle)
[![License](https://poser.pugx.org/tboileau/lifecycle-bundle/license)](https://packagist.org/packages/tboileau/lifecycle-bundle)


As you know, the **"S"** of SOLID principles correspond to **Single responsability**. It means the each class should have only a single responsability. So, you can't have logical code of persisting entity in a controller. It must be in a service dedicated to that.

And for manage the lifecycle of your object (like states : add, update and delete), this bundle make that process simplier.


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

## Create a new lifecycle manager

## Step 1: Use the maker to generate your lifecycle class


Open a command console, enter your project directory and execute the following command to generate a new lifecycle manager :

```console
$ php bin/console make:lifecycle FooLifecycle
  
  Please enter a new state :
  > name_of_your_state
  
  Please enter a new state :
  >
  
  created: src/Lifecycle/FooLifecycle.php

  Success !
```

### Step 2 : Configure your new lifecycle manager

Don't forget to configure your new handler in `config/services.yaml` :

```yaml
services:
    # ...        
    App\Lifecycle\FooLifecycle:
        tags:
            - { name: t_boileau.lifecycle }
```


### Step 3 : Edit your new lifecycle manager

Most important thing is to add states in `getSubscribedStates` and declare methods

```php
<?php
// App\Lifecycle\FooLifecycle.php

namespace App\Lifecycle;

use App\Entity\Foo;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use TBoileau\LifecycleBundle\EventSubscriber\LifecycleSubscriber;

class FooLifecycle extends LifecycleSubscriber
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * FooSubscriber constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    /**
     * @return array
     */
    public static function getSubscribedStates(): array
    {
        return [
            "ADD" => "onAdd",
        ];
    }

    /**
     * @param $object
     * @return Response
     */
    public function onAdd(Foo $foo): Response
    {
        $this->entityManager->persist($foo);
        $this->entityManager->flush();
        return $this->redirectToRoute("homepage");
    }
}
```

### Step 4 : Use the dispatcher 

You must simply call the method `setState` of the dispatcher to change state of your object :

```php
<?php
namespace App\Controller;

use App\Form\FooType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use TBoileau\LifecycleBundle\Dispatcher;

class FooController extends Controller
{
    /**
     * @Route("/add", name="add")
     * @param Dispatcher $dispatcher
     * @param Request $request
     * @return Response
     */
    public function show(Dispatcher $dispatcher, Request $request)
    {
        $form = $this->createForm(FooType::class)->handleRequest($request);
        
        if($form->isSubmitted() and $form->isValid()) {
            return $dispatcher->setState("ADD", $form->getData());
        }
        
        return $this->render("foo/add.html.twig", ["form" => $form->createView()]);
    }
}
```

