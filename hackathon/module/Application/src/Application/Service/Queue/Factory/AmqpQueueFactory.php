<?php


namespace Application\Service\Queue\Factory;


use Application\Service\Queue\AmqpQueue;
use PhpAmqpLib\Connection\AMQPConnection;
use Zend\ServiceManager\AbstractPluginManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class AmqpQueueFactory implements FactoryInterface
{
    /** @var  string */
    protected $queueName;

    /**
     * AmqpQueueFactory constructor.
     * @param string $queueName
     */
    public function __construct($queueName)
    {
        $this->queueName = $queueName;
    }


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

        $config = $serviceLocator->get('Config');

        $connection = new AMQPConnection($config['amqp']['host'],
            $config['amqp']['port'],
            $config['amqp']['user'],
            $config['amqp']['password']);


        $instance = new AmqpQueue($this->queueName, $connection);
        return $instance;
    }
}