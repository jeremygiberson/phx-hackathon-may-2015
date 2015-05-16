<?php


namespace Application\Controller\Factory;


use Application\Controller\ApiController;
use Application\Service\CollectionDays\CollectionDaysInterface;
use Zend\ServiceManager\AbstractPluginManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ApiControllerFactory implements FactoryInterface
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
        /** @var CollectionDaysInterface $collectionDaysService */
        $collectionDaysService = $serviceLocator->get(CollectionDaysInterface::class);

        $controller = new ApiController();
        $controller->setCollectionDaysService($collectionDaysService);

        return $controller;
    }
}