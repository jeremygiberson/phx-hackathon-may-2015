<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Application\Service\CollectionDays\Delegator\CollectionDaysEventDelegator;
use Application\Service\CollectionDays\Listeners\GetCollectionDaysPostListener;
use Application\Service\CollectionDays\Listeners\GetCollectionDaysPreListener;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

        $locator = $e->getApplication()->getServiceManager();
        $em = $locator->get('ApiEventManager');
        $pre_listener = $locator->get(GetCollectionDaysPreListener::class);
        $post_listener = $locator->get(GetcollectionDaysPostListener::class);

        $em->attach(CollectionDaysEventDelegator::EVENT_PRE, $pre_listener);
        $em->attach(CollectionDaysEventDelegator::EVENT_POST, $post_listener);
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
}
