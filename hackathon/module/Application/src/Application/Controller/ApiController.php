<?php


namespace Application\Controller;


use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;

class ApiController extends AbstractActionController
{
    public function collectionDaysAction()
    {
        return new JsonModel([
            'GARBAGE' => 'THURSDAY',
            'RECYCLE' => 'WEDNESDAY',
            'COMPOST' => 'TUESDAY'
        ]);
    }

    public function remindMeAction()
    {
        return new JsonModel([
            'message' => 'You have signed up for reminders.',
            'email' => 'john.doe@null.com',
            'address' => '123 Pudding Ln',
            'reminders' => [
                ['day' => 'Monday', 'container' => 'Compost'],
                ['day' => 'Tuesday', 'container' => 'Recycling'],
                ['day' => 'Wednesday', 'container' => 'Garbage']
            ]
        ]);
    }
}