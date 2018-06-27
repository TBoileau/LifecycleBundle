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
     * @return mixed|null
     */
    public function setState(string $state, $object)
    {
        $event = new LifecycleEvent($state, $object);
        return $this->dispatcher->dispatch(LifecycleEvent::CHANGE_STATE,$event)->getResponse();
    }


}