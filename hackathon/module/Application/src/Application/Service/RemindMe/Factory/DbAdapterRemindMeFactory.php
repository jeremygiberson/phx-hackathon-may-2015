<?php


namespace Application\Service\RemindMe\Factory;


use Application\Service\RemindMe\DbAdapterRemindMe;
use Zend\Db\Adapter\Adapter;
use Zend\ServiceManager\AbstractPluginManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class DbAdapterRemindMeFactory implements FactoryInterface
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
        /** @var Adapter $adapter */
        $adapter = $serviceLocator->get(Adapter::class);

        $instance = new DbAdapterRemindMe();
        $instance->setDbAdapter($adapter);
        return $instance;
    }
}