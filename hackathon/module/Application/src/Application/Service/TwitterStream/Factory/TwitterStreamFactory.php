<?php


namespace Application\Service\TwitterStream\Factory;


use Application\Service\Queue\QueueInterface;
use Application\Service\TwitterStream\TwitterStream;
use Zend\ServiceManager\AbstractPluginManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class TwitterStreamFactory implements FactoryInterface
{

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return TwitterStream
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        if($serviceLocator instanceof AbstractPluginManager)
        {
            $serviceLocator = $serviceLocator->getServiceLocator();
        }

        $config = $serviceLocator->get('Config');

        define('TWITTER_CONSUMER_KEY', $config['twitter']['consumer_key']);
        define('TWITTER_CONSUMER_SECRET', $config['twitter']['consumer_secret']);

        $instance = new TwitterStream(
            $config['twitter']['oauth_token'],
            $config['twitter']['oauth_secret']);

        /** @var QueueInterface $queue */
        $queue = $serviceLocator->get('twitter_queue');

        $instance->setQueue($queue);

        return $instance;
    }
}