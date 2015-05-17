<?php


namespace Application\Service\RemindMe;


class Notification
{
    /** @var  string */
    protected $email;
    /** @var  string */
    protected $address;
    /** @var  string */
    protected $service;
    /** @var  string */
    protected $day;

    /**
     * Notification constructor.
     * @param string $email
     * @param string $address
     * @param string $service
     * @param string $day
     */
    public function __construct($email, $address, $service, $day)
    {
        $this->setService($service);
        $this->setEmail($email);
        $this->setDay($day);
        $this->setAddress($address);
    }

    /**
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param string $address
     * @return self
     */
    public function setAddress($address)
    {
        $this->address = $address;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return self
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     * @param string $service
     * @return self
     */
    public function setService($service)
    {
        $this->service = $service;
        return $this;
    }

    /**
     * @return string
     */
    public function getDay()
    {
        return $this->day;
    }

    /**
     * @param string $day
     * @return self
     */
    public function setDay($day)
    {
        $this->day = $day;
        return $this;
    }


}