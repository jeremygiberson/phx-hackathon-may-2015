<?php


namespace Application\Service\RefuseBot\Classifier;


class Classification {
    /** @var  string */
    protected $category;
    /** @var  string */
    protected $instruction;

    /**
     * Classification constructor.
     * @param string $category
     * @param string $instruction
     */
    public function __construct($category, $instruction)
    {
        $this->category = $category;
        $this->instruction = $instruction;
    }

    /**
     * @return string
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param string $category
     * @return self
     */
    public function setCategory($category)
    {
        $this->category = $category;
        return $this;
    }

    /**
     * @return string
     */
    public function getInstruction()
    {
        return $this->instruction;
    }

    /**
     * @param string $instruction
     * @return self
     */
    public function setInstruction($instruction)
    {
        $this->instruction = $instruction;
        return $this;
    }



}