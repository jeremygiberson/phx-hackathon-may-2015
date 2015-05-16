<?php
/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */

use Application\Controller\ApiController;
use Zend\View\Model\JsonModel;

return array(
    'zf-rpc' => [
        'CollectionDays' => [
            'http_methods' => ['GET'],
            'route-name' => 'collection-days',
            //'callable' => ApiController::class . '::collectionDaysAction'
        ],
        'RemindMe' => [
            'http_methods' => ['GET'],
            'route-name' => 'remind-me',
            'callable' => ApiController::class . '::remindMeAction'
        ],
        'RefuseBot' => [
            'http_methods' => ['GET'],
            'route-name' => 'refuse-bot',
            'callable' => ApiController::class . '::refuseBotAction'
        ]
    ]
);