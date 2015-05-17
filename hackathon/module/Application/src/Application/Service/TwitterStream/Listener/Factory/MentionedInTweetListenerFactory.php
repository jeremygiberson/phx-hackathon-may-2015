<?php


namespace Application\Service\TwitterStream\Listener\Factory;


use Application\Service\RefuseBot\RefuseBotInterface;
use Application\Service\TwitterStream\Listener\MentionedInTweetListener;
use Zend\ServiceManager\AbstractPluginManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class MentionedInTweetListenerFactory implements FactoryInterface
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

        /** @var RefuseBotInterface $refuseBotService */
        $refuseBotService = $serviceLocator->get(RefuseBotInterface::class);

        $instance = new MentionedInTweetListener($refuseBotService);

        return $instance;
    }
}