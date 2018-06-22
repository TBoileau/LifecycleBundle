<?php
/**
 * Created by PhpStorm.
 * User: tboileau-desktop
 * Date: 08/05/18
 * Time: 02:38
 */

namespace App\Controller;

use App\Model\Foo;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use TBoileau\LifecycleBundle\Dispatcher;

class FooController extends Controller
{
    /**
     * @Route("/show", name="show")
     * @param Dispatcher $dispatcher
     * @return Response
     */
    public function show(Dispatcher $dispatcher)
    {
        return $dispatcher->setState("SHOW", new Foo("bar"));
    }

    /**
     * @Route("/redirect", name="redirect")
     * @param Dispatcher $dispatcher
     * @return Response
     */
    public function redirection(Dispatcher $dispatcher)
    {
        return $dispatcher->setState("REDIRECT", new Foo("bar"));
    }

    /**
     * @Route("/granted", name="granted")
     * @param Dispatcher $dispatcher
     * @return Response
     */
    public function granted(Dispatcher $dispatcher)
    {
        return $dispatcher->setState("GRANTED", new Foo("bar"));
    }

    /**
     * @Route("/fail", name="fail")
     * @param Dispatcher $dispatcher
     * @return Response
     */
    public function fail(Dispatcher $dispatcher)
    {
        return $dispatcher->setState("FAIL", new Foo("bar"));
    }
}