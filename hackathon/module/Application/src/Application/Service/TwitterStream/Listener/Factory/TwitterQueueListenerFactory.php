<?php


namespace Application\Service\TwitterStream\Listener\Factory;


use Application\Service\TwitterStream\Listener\TwitterQueueListener;
use Zend\EventManager\EventManager;
use Zend\ServiceManager\AbstractPluginManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class TwitterQueueListenerFactory implements FactoryInterface
{

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        if($serviceLocator instanceof AbstractPluginManager)
        {
            $serviceLocator = $serviceLocator->getServiceLocator();
        }

        /** @var EventManager $eventManager */
        $eventManager = $serviceLocator->get('TwitterEventManager');

        return new TwitterQueueListener($eventManager);
    }
}