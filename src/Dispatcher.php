<?php

namespace TBoileau\LifecycleBundle;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Response;
use TBoileau\LifecycleBundle\Event\LifecycleEvent;

/**
 * Class Dispatcher
 * @package TBoileau\LifecycleBundle
 */
class Dispatcher
{
    /**
     * @var EventDispatcherInterface
     */
    private $dispatcher;

    /**
     * Dispatcher constructor.
     * @param EventDispatcherInterface $dispatcher
     */
    public function __construct(EventDispatcherInterface $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    /**
     * @param string $state
     * @param mixed $object
     * @return Response
     */
    public function setState(string $state, $object): Response
    {
        $event = new LifecycleEvent($state, $object);
        return $this->dispatcher->dispatch(LifecycleEvent::CHANGE_STATE,$event)->getResponse();
    }


}