<?php


namespace Application\Controller;


use Application\Service\CollectionDays\CollectionDaysInterface;
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
            return new ApiProblemResponse(ApiProblem(400, 'Address must be provided'));
        }

        $email = $this->getRequest()->getQuery('email',null);
        if(!$email) {
            // todo handle with content validation
            return new ApiProblemResponse(ApiProblem(400, 'Email must be provided'));
        }

        $collectionDays = $this->getCollectionDaysService()->getCollectionDays($address);
        if($collectionDays instanceof ApiProblem){
            return new ApiProblemResponse($collectionDays);
        }



        return new JsonModel([
            'message' => 'You have signed up for reminders.',
            'email' => $email,
            'address' => $address,
            'reminders' => [
                ['day' => 'Monday', 'container' => 'Compost'],
                ['day' => 'Tuesday', 'container' => 'Recycling'],
                ['day' => 'Wednesday', 'container' => 'Garbage']
            ]
        ]);
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