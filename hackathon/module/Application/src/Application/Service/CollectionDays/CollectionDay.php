<?php


namespace Application\Service\CollectionDays;


class CollectionDay
{
    const SERVICE_COMPOST = 'COMPOST';
    const SERVICE_RECYCLE = 'RECYCLE';
    const SERVICE_GARBAGE = 'GARBAGE';

    const MONDAY = 'MONDAY';
    const TUESDAY = 'TUESDAY';
    const WEDNESDAY = 'WEDNESDAY';
    const THURSDAY = 'THURSDAY';
    const FRIDAY = 'FRIDAY';
    const SATURDAY = 'SATURDAY';
    const SUNDAY = 'SUNDAY';

    /** @var  string */
    protected $day;
    /** @var  string */
    protected $service;

    /**
     * CollectionDay constructor.
     * @param string $day
     * @param string $service
     */
    public function __construct($day, $service)
    {
        $this->setDay($day);
        $this->setService($service);
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
        if(!in_array($day, [
            self::MONDAY,
            self::TUESDAY,
            self::WEDNESDAY,
            self::THURSDAY,
            self::FRIDAY,
            self::SATURDAY,
            self::SUNDAY
        ])) {
            throw new \RuntimeException("Not a valid day of the week");
        }
        $this->day = $day;
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
        if(!in_array($service, [
            self::SERVICE_COMPOST,
            self::SERVICE_GARBAGE,
            self::SERVICE_RECYCLE
        ])){
            throw new \RuntimeException("Not a valid service type");
        }
        $this->service = $service;
        return $this;
    }


}