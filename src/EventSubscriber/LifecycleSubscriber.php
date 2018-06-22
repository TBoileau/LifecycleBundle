<?php

namespace TBoileau\LifecycleBundle\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use TBoileau\LifecycleBundle\Event\LifecycleEvent;
use TBoileau\LifecycleBundle\Exception\LifecycleStateNotFound;
use Twig\Environment;

/**
 * Class LifecycleSubscriber
 * @package TBoileau\LifecycleBundle\EventSubscriber
 */
abstract class LifecycleSubscriber implements EventSubscriberInterface
{
    /**
     * @var AuthorizationCheckerInterface
     */
    private $authorizationChecker;

    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * @var Environment
     */
    private $twig;

    /**
     * @param RouterInterface $router
     *
     * @return self
     */
    public function setRouter(RouterInterface $router): self
    {
        $this->router = $router;

        return $this;
    }

    /**
     * @param Environment $twig
     *
     * @return self
     */
    public function setTwig(Environment $twig): self
    {
        $this->twig = $twig;

        return $this;
    }

    /**
     * @param AuthorizationCheckerInterface $authorizationChecker
     *
     * @return self
     */
    public function setAuthorizationChecker(AuthorizationCheckerInterface $authorizationChecker): self
    {
        $this->authorizationChecker = $authorizationChecker;

        return $this;
    }

    /**
     * @param string $route
     * @param array  $params
     *
     * @return RedirectResponse
     */
    protected function redirectToRoute(string $route, array $params = []): RedirectResponse
    {
        return new RedirectResponse($this->router->generate($route, $params));
    }

    /**
     * @param string $view
     * @param array  $data
     *
     * @return Response
     *
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    protected function render(string $view, array $data = []): Response
    {
        return new Response($this->twig->render($view, $data));
    }

    /**
     * @param $attributes
     * @param null   $subject
     * @param string $message
     */
    protected function denyAccessUnlessGranted($attributes, $subject = null, string $message = 'Access Denied.')
    {
        if (!$this->authorizationChecker->isGranted($attributes, $subject)) {
            $exception = new AccessDeniedException($message);
            $exception->setAttributes($attributes);
            $exception->setSubject($subject);

            throw $exception;
        }
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            LifecycleEvent::CHANGE_STATE => "onChangeState"
        ];
    }

    /**
     * @param LifecycleEvent $event
     * @throws LifecycleStateNotFound
     */
    public function onChangeState(LifecycleEvent $event)
    {
        if(!isset(static::getSubscribedStates()[$event->getState()]) || !method_exists($this, static::getSubscribedStates()[$event->getState()])) {
            throw new LifecycleStateNotFound('This state was not found !');
        }
        $event->setResponse($this->{static::getSubscribedStates()[$event->getState()]}($event->getObject()));
    }

    /**
     * @return array
     */
    public abstract static function getSubscribedStates(): array;


}