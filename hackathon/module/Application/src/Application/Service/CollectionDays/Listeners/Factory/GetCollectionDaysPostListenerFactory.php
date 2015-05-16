<?php


namespace Application\Service\CollectionDays\Listeners\Factory;


use Application\Service\CollectionDays\Listeners\GetCollectionDaysPostListener;
use Zend\Cache\Storage\StorageInterface;
use Zend\ServiceManager\AbstractPluginManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class GetCollectionDaysPostListenerFactory implements FactoryInterface
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

        /** @var StorageInterface $cache */
        $cache = $serviceLocator->get('cache');

        $instance = new GetCollectionDaysPostListener($cache);
        return $instance;
    }
}