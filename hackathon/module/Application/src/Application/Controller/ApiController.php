<?php


namespace Application\Controller;


use Application\Service\CollectionDays\CollectionDaysInterface;
use Application\Service\Notify\NotifyInterface;
use Application\Service\RemindMe\RemindMeInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use ZF\ApiProblem\ApiProblem;
use ZF\ApiProblem\ApiProblemResponse;

class ApiController extends AbstractActionController
{
    /** @var  CollectionDaysInterface */
    protected $collectionDaysService;

    /** @var  RemindMeInterface */
    protected $remindMeService;

    /** @var  NotifyInterface */
    protected $notifyService;

    /**
     * @return NotifyInterface
     */
    public function getNotifyService()
    {
        return $this->notifyService;
    }

    /**
     * @param NotifyInterface $notifyService
     * @return self
     */
    public function setNotifyService($notifyService)
    {
        $this->notifyService = $notifyService;
        return $this;
    }



    /**
     * @return RemindMeInterface
     */
    public function getRemindMeService()
    {
        return $this->remindMeService;
    }

    /**
     * @param RemindMeInterface $remindMeService
     * @return self
     */
    public function setRemindMeService($remindMeService)
    {
        $this->remindMeService = $remindMeService;
        return $this;
    }

    /**
     * @return CollectionDaysInterface
     */
    public function getCollectionDaysService()
    {
        return $this->collectionDaysService;
    }

    /**
     * @param CollectionDaysInterface $collectionDaysService
     * @return self
     */
    public function setCollectionDaysService($collectionDaysService)
    {
        $this->collectionDaysService = $collectionDaysService;
        return $this;
    }


    public function collectionDaysAction()
    {
        $address = $this->getRequest()->getQuery('address',null);
        if(!$address) {
            // todo handle with content validation
            return new ApiProblemResponse(new ApiProblem(400, 'Address must be provided'));
        }

        $days = $this->getCollectionDaysService()->getCollectionDays($address);
        if($days instanceof ApiProblem)
        {
            return new ApiProblemResponse($days);
        }

        $response = [];
        foreach($days as $collectionDay)
        {
            $response[$collectionDay->getService()] = $collectionDay->getDay();
        }

        return new JsonModel($response);
    }

    public function remindMeAction()
    {
        $address = $this->getRequest()->getQuery('address',null);
        if(!$address) {
            // todo handle with content validation
            return new ApiProblemResponse(new ApiProblem(400, 'Address must be provided'));
        }

        $email = $this->getRequest()->getQuery('email',null);
        if(!$email) {
            // todo handle with content validation
            return new ApiProblemResponse(new ApiProblem(400, 'Email must be provided'));
        }

        try {
            $collectionDays = $this->getCollectionDaysService()->getCollectionDays($address);
        } catch (\Exception $e) {
            return new ApiProblemResponse(new ApiProblem(400, $e->getMessage()));
        }

        try {
            $this->getRemindMeService()->subscribe($email, $address, $collectionDays);
        } catch (\Exception $e) {
            return new ApiProblemResponse(new ApiProblem(400, $e->getMessage()));
        }

        $response =[
            'message' => 'You have signed up for reminders.',
            'email' => $email,
            'address' => $address,
            'reminders' => []
        ];

        foreach($collectionDays as $collectionDay)
        {
            $response['reminders'][] = [
                'day' => $collectionDay->getDay(),
                'container' => $collectionDay->getService()
            ];
        }

        return new JsonModel($response);
    }

    public function unsubscribeRemindMeAction()
    {
        $address = $this->getRequest()->getQuery('address',null);
        if(!$address) {
            // todo handle with content validation
            return new ApiProblemResponse(new ApiProblem(400, 'Address must be provided'));
        }

        $email = $this->getRequest()->getQuery('email',null);
        if(!$email) {
            // todo handle with content validation
            return new ApiProblemResponse(new ApiProblem(400, 'Email must be provided'));
        }

        try {
            $this->getRemindMeService()->unsubscribe($email, $address);
        } catch (\Exception $e) {
            return new ApiProblemResponse(new ApiProblem(400, $e->getMessage()));
        }

        $response =[
            'message' => 'You have unsubscribed from reminders.',
            'email' => $email,
            'address' => $address
        ];

        return new JsonModel($response);
    }

    public function sendNotificationsAction()
    {
        $day = $this->getRequest()->getParam('day', 'MONDAY');

        $notifications = $this->getRemindMeService()->notifications($day);
        $count = 0;
        foreach($notifications as $notification)
        {
            $count++;
            $subject = sprintf("%s reminder", $notification->getService());
            $message = sprintf("You need to take out your %s container so it can be emptied %s.

To unsubscribe please visit this link: <a href='http://hackathon.local/unsubscribe-remind-me?address=%s&email=%s'>http://hackathon.local/unsubscribe-remind-me?address=%s&email=%s</a>\n",
                $notification->getService(), $notification->getDay(),
                urlencode($notification->getAddress()), $notification->getEmail(),
                urlencode($notification->getAddress()), $notification->getEmail());

            $this->getNotifyService()->notify($notification->getAddress(),
                $subject, $message);
        }

        echo sprintf("Sent %s notifications", $count);
    }

    public function refuseBotAction()
    {
        return new JsonModel([
            'responses' => [
                ['noun' => 'milk carton', 'instructions' => 'clean and recycle'],
                ['noun' => 'soup can', 'instructions' => 'clean and recycle'],
                ['noun' => 'banana peel', 'instructions' => 'compost or throw in garbage']
            ]
        ]);
    }


}