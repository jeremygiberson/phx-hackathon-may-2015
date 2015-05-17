<?php


namespace Application\Service\RefuseBot\QuestionParser;


interface QuestionParserInterface
{
    /**
     * @param string $question
     * @return string[]
     */
    public function parseNouns($question);
}