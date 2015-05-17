<?php


namespace Application\Service\TwitterRest\Factory;


use Abraham\TwitterOAuth\TwitterOAuth;
use Application\Service\TwitterRest\TwitterOauthTwitterRest;
use Zend\ServiceManager\AbstractPluginManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class TwitterOAuthTwitterRestFactory implements FactoryInterface
{

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return TwitterOauthTwitterRest
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        if($serviceLocator instanceof AbstractPluginManager)
        {
            $serviceLocator = $serviceLocator->getServiceLocator();
        }

        $config = $serviceLocator->get('Config');

        $connection = new TwitterOAuth($config['twitter']['consumer_key'],
            $config['twitter']['consumer_secret'],
            $config['twitter']['oauth_token'],
            $config['twitter']['oauth_secret']);

        $instance = new TwitterOauthTwitterRest($connection);
        return $instance;
    }
}