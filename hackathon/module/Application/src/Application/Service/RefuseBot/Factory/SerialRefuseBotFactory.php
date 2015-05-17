<?php


namespace Application\Service\RefuseBot\Factory;


use Application\Service\RefuseBot\Classifier\ClassifierInterface;
use Application\Service\RefuseBot\QuestionParser\QuestionParserInterface;
use Application\Service\RefuseBot\SerialRefuseBot;
use Zend\ServiceManager\AbstractPluginManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class SerialRefuseBotFactory implements FactoryInterface
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
        /** @var QuestionParserInterface $parser */
        $parser  = $serviceLocator->get(QuestionParserInterface::class);
        /** @var ClassifierInterface $classifier */
        $classifier = $serviceLocator->get(ClassifierInterface::class);

        $instance = new SerialRefuseBot($parser, $classifier);
        return $instance;
    }
}