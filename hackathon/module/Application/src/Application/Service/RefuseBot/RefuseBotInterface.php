<?php


namespace Application\Service\RefuseBot;


interface RefuseBotInterface
{
    /**
     * @param string $question
     * @return Recommendation[]
     */
    public function recommend($question);
}