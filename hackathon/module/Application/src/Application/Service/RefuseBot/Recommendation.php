<?php


namespace Application\Service\RefuseBot;


class Recommendation
{
    /** @var  string */
    protected $noun;
    /** @var  string */
    protected $instructions;

    /**
     * Recommendation constructor.
     * @param string $noun
     * @param string $instructions
     */
    public function __construct($noun, $instructions)
    {
        $this->setNoun($noun);
        $this->setInstructions($instructions);
    }

    /**
     * @return string
     */
    public function getNoun()
    {
        return $this->noun;
    }

    /**
     * @param string $noun
     * @return self
     */
    public function setNoun($noun)
    {
        $this->noun = $noun;
        return $this;
    }

    /**
     * @return string
     */
    public function getInstructions()
    {
        return $this->instructions;
    }

    /**
     * @param string $instructions
     * @return self
     */
    public function setInstructions($instructions)
    {
        $this->instructions = $instructions;
        return $this;
    }


}