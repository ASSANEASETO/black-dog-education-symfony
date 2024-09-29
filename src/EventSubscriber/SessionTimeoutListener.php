<?php
namespace App\EventSubscriber;

use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class SessionTimeoutListener implements EventSubscriberInterface
{
    private RouterInterface $router;
    private AuthorizationCheckerInterface $authChecker;

    public function __construct(RouterInterface $router, AuthorizationCheckerInterface $authChecker)
    {
        $this->router = $router;
        $this->authChecker = $authChecker;
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        if (!$event->isMainRequest()) {
            return;
        }

        $request = $event->getRequest();
        $session = $request->getSession();

        if ($this->authChecker->isGranted('IS_AUTHENTICATED_FULLY') && $session->has('last_activity')) {
            $lastActivity = $session->get('last_activity');
            $currentTime = time();

            if (($currentTime - $lastActivity) > 600) { // 10 minutes
                $session->invalidate();
                $event->setResponse(new RedirectResponse($this->router->generate('app_logout')));
            }
        }

        $session->set('last_activity', time());
    }

    public static function getSubscribedEvents()
    {
        return [
            'kernel.request' => 'onKernelRequest',
        ];
    }
}