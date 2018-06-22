<?php

namespace TBoileau\LifecycleBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class LifecycleEvent
 * @package TBoileau\LifecycleBundle\Event
 */
class LifecycleEvent extends Event
{
    const CHANGE_STATE = "CHANGE_STATE";

    /**
     * @var string
     */
    private $state;

    /**
     * @var Response
     */
    private $response;

    /**
     * @var mixed
     */
    private $object;

    /**
     * LifecycleEvent constructor.
     * @param string $state
     * @param $object
     */
    public function __construct(string $state, $object)
    {
        $this->state = $state;
        $this->object = $object;
    }

    /**
     * @return string
     */
    public function getState(): string
    {
        return $this->state;
    }

    /**
     * @return mixed
     */
    public function getObject()
    {
        return $this->object;
    }

    /**
     * @return Response
     */
    public function getResponse(): Response
    {
        return $this->response;
    }

    /**
     * @param Response $response
     *
     * @return self
     */
    public function setResponse(Response $response): self
    {
        $this->response = $response;

        return $this;
    }



}