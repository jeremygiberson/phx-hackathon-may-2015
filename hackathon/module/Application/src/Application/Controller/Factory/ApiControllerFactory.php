<?php


namespace Application\Controller\Factory;


use Application\Controller\ApiController;
use Application\Service\CollectionDays\CollectionDaysInterface;
use Application\Service\RemindMe\RemindMeInterface;
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

        /** @var RemindMeInterface $remindMeService */
        $remindMeService = $serviceLocator->get(RemindMeInterface::class);

        $controller = new ApiController();
        $controller->setCollectionDaysService($collectionDaysService);
        $controller->setRemindMeService($remindMeService);

        return $controller;
    }
}