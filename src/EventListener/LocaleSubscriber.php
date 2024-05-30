<?php
namespace App\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class LocaleSubscriber implements EventSubscriberInterface
{
    private $defaultLocale;
    private $requestStack;

    public function __construct(string $defaultLocale, RequestStack $requestStack)
    {
        $this->defaultLocale = $defaultLocale;
        $this->requestStack = $requestStack;
    }

    public function onKernelRequest(RequestEvent $event)
    {
        $request = $event->getRequest();
        //if ($request->hasPreviousSession() && $request->getSession()) {
            
        

            $locale = $request->query->get('_locale', $request->getSession()->get('_locale', $this->defaultLocale));
            $request->setLocale($locale);
            $request->getSession()->set('_locale', $locale);
    
        //}        
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST => [['onKernelRequest', 20]],
        ];
    }
}
