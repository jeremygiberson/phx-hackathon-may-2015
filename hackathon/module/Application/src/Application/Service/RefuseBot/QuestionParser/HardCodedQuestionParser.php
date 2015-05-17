<?php


namespace Application\Service\RefuseBot\QuestionParser;


class HardCodedQuestionParser implements QuestionParserInterface
{
    protected $nouns = [
        'milk carton',
        'soup can',
        'banana peel',
        'cereal box'
    ];

    /**
     * @param string $question
     * @return string[]
     */
    public function parseNouns($question)
    {
        $found_nouns = [];
        foreach($this->nouns as $noun)
        {
            $pattern = sprintf("/(\\s|^)(%s)(\\s|$)/", $noun);
            if(preg_match($pattern, $question)){
                $found_nouns[] = $noun;
            }
        }
        return $found_nouns;
    }
}