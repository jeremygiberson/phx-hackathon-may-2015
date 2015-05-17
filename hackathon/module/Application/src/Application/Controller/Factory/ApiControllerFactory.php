<?php


namespace Application\Controller\Factory;


use Application\Controller\ApiController;
use Application\Service\CollectionDays\CollectionDaysInterface;
use Application\Service\Notify\NotifyInterface;
use Application\Service\Queue\QueueInterface;
use Application\Service\RefuseBot\RefuseBotInterface;
use Application\Service\RemindMe\RemindMeInterface;
use Application\Service\TwitterStream\TwitterStream;
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

        /** @var NotifyInterface $notifyService */
        $notifyService = $serviceLocator->get(NotifyInterface::class);

        /** @var RefuseBotInterface $refuseBot */
        $refuseBot = $serviceLocator->get(RefuseBotInterface::class);

        /** @var TwitterStream $twitterStream */
        $twitterStream = $serviceLocator->get(TwitterStream::class);

        /** @var QueueInterface $queue */
        $queue = $serviceLocator->get('twitter_queue');

        $controller = new ApiController();
        $controller->setCollectionDaysService($collectionDaysService);
        $controller->setRemindMeService($remindMeService);
        $controller->setNotifyService($notifyService);
        $controller->setRefuseBot($refuseBot);
        $controller->setTwitterStream($twitterStream);
        $controller->setQueue($queue);

        return $controller;
    }
}