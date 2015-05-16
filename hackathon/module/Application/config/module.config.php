<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

use Application\Controller\ApiController;
use Application\Controller\Factory\ApiControllerFactory;
use Application\Controller\IndexController;
use Application\Service\CollectionDays\CollectionDaysInterface;
use Application\Service\CollectionDays\Delegator\CollectionDaysEventDelegatorFactory;
use Application\Service\CollectionDays\Listeners\Factory\GetCollectionDaysPostListenerFactory;
use Application\Service\CollectionDays\Listeners\Factory\GetCollectionDaysPreListenerFactory;
use Application\Service\CollectionDays\Listeners\GetCollectionDaysPostListener;
use Application\Service\CollectionDays\Listeners\GetCollectionDaysPreListener;
use Application\Service\CollectionDays\PhxGovCollectionDays;
use Application\Service\RemindMe\Factory\DbAdapterRemindMeFactory;
use Application\Service\RemindMe\RemindMeInterface;
use Zend\Cache\Service\StorageCacheAbstractServiceFactory;
use Zend\Mvc\Service\EventManagerFactory;

return array(
    'router' => array(
        'routes' => array(
            'home' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        'controller' => IndexController::class,
                        'action'     => 'index',
                    ),
                ),
            ),
            'collection-days' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/collection-days',
                    'defaults' => array(
                        'controller' => 'CollectionDays',
                        'action' => 'collectionDays'
                    ),
                ),
            ),
            'remind-me' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/remind-me',
                    'defaults' => array(
                        'controller' => 'RemindMe',
                        'action' => 'remindMe'
                    ),
                ),
            ),
            'unsubscribe-remind-me' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/unsubscribe-remind-me',
                    'defaults' => array(
                        'controller' => 'UnsubscribeRemindMe',
                        'action' => 'unsubscribeRemindMe'
                    ),
                ),
            ),
            'refuse-bot' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/refuse-bot',
                    'defaults' => array(
                        'controller' => 'RefuseBot'
                    ),
                ),
            ),
        ),
    ),
    'service_manager' => array(
        'invokables' => [
            CollectionDaysInterface::class => PhxGovCollectionDays::class,
            CollectionDaysEventDelegatorFactory::class => CollectionDaysEventDelegatorFactory::class,
        ],
        'factories' => [
            RemindMeInterface::class => DbAdapterRemindMeFactory::class,
            GetCollectionDaysPreListener::class => GetCollectionDaysPreListenerFactory::class,
            GetCollectionDaysPostListener::class => GetCollectionDaysPostListenerFactory::class,
            'ApiEventManager' => EventManagerFactory::class,
        ],
        'abstract_factories' => array(
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
            StorageCacheAbstractServiceFactory::class,
        ),
        'aliases' => array(
            'translator' => 'MvcTranslator',
        ),
        'delegators' => [
            CollectionDaysInterface::class => [
                CollectionDaysEventDelegatorFactory::class
            ]
        ]
    ),
    'translator' => array(
        'locale' => 'en_US',
        'translation_file_patterns' => array(
            array(
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            IndexController::class => IndexController::class,
            ApiController::class => ApiController::class
        ),
        'factories' => array(
            ApiController::class => ApiControllerFactory::class,
            'CollectionDays' => ApiControllerFactory::class,
            'RemindMe' => ApiControllerFactory::class,
            'UnsubscribeRemindMe' => ApiControllerFactory::class,
        ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    // Placeholder for console routes
    'console' => array(
        'router' => array(
            'routes' => array(
                'send-reminders' => [
                    'options' => [
                        'route' => 'notify <day>',
                        'defaults' => [
                            'controller' => ApiController::class,
                            'action' => 'sendNotifications'
                        ]
                    ]
                ]
            ),
        ),
    ),

    'caches' => [
        'cache' => [
            'adapter' => [
                'name'    => 'apc',
                'options' => ['ttl' => 3600],
            ],
            'plugins' => [
                'exception_handler' => ['throw_exceptions' => false],
            ],
        ]
    ]
);
