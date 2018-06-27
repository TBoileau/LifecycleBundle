<?php

namespace App\Lifecycle;

use App\Model\Foo;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use TBoileau\LifecycleBundle\EventSubscriber\LifecycleSubscriber;

class FooLifecycle extends LifecycleSubscriber
{
    /**
     * @return array
     */
    public static function getSubscribedStates(): array
    {
        return [
            "SHOW" => "onShow",
            "REDIRECT" => "onRedirect",
            "GRANTED" => "onGranted"
        ];
    }

    /**
     * @param Foo $foo
     * @return Response
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function onGranted(Foo $foo): Response
    {
        $this->denyAccessUnlessGranted("test", $foo);
        return $this->render("index.html.twig", ["foo" => $foo]);
    }

    /**
     * @param Foo $foo
     * @return Response
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function onShow(Foo $foo): Response
    {
        return $this->render("index.html.twig", ["foo" => $foo]);
    }

    /**
     * @param Foo $foo
     * @return RedirectResponse
     */
    public function onRedirect(Foo $foo): RedirectResponse
    {
        return $this->redirectToRoute("show");
    }
}