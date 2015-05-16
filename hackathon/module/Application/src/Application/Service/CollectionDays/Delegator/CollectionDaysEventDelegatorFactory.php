<?php


namespace Application\Service\CollectionDays\Delegator;


use Zend\EventManager\EventManager;
use Zend\ServiceManager\DelegatorFactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class CollectionDaysEventDelegatorFactory implements DelegatorFactoryInterface
{

    /**
     * A factory that creates delegates of a given service
     *
     * @param ServiceLocatorInterface $serviceLocator the service locator which requested the service
     * @param string $name the normalized service name
     * @param string $requestedName the requested service name
     * @param callable $callback the callback that is responsible for creating the service
     *
     * @return mixed
     */
    public function createDelegatorWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName, $callback)
    {
        $realCollectionDaysService = call_user_func($callback);
        /** @var EventManager $eventManager */
        $eventManager = $serviceLocator->get('ApiEventManager');

        $delegator = new CollectionDaysEventDelegator($realCollectionDaysService);
        $delegator->setEventManager($eventManager);
        return $delegator;
    }
}