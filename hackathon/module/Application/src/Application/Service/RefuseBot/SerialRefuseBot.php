<?php


namespace Application\Service\RefuseBot;


use Application\Service\RefuseBot\Classifier\ClassifierInterface;
use Application\Service\RefuseBot\QuestionParser\QuestionParserInterface;

class SerialRefuseBot implements RefuseBotInterface
{
    /** @var  QuestionParserInterface */
    protected $questionParser;
    /** @var  ClassifierInterface */
    protected $classifier;

    /**
     * SerialRefuseBot constructor.
     * @param QuestionParserInterface $questionParser
     * @param ClassifierInterface $classifier
     */
    public function __construct(QuestionParserInterface $questionParser, ClassifierInterface $classifier)
    {
        $this->questionParser = $questionParser;
        $this->classifier = $classifier;
    }

    /**
     * @return QuestionParserInterface
     */
    public function getQuestionParser()
    {
        return $this->questionParser;
    }

    /**
     * @param QuestionParserInterface $questionParser
     * @return self
     */
    public function setQuestionParser($questionParser)
    {
        $this->questionParser = $questionParser;
        return $this;
    }

    /**
     * @return ClassifierInterface
     */
    public function getClassifier()
    {
        return $this->classifier;
    }

    /**
     * @param ClassifierInterface $classifier
     * @return self
     */
    public function setClassifier($classifier)
    {
        $this->classifier = $classifier;
        return $this;
    }

    /**
     * @param string $question
     * @return Recommendation[]
     */
    public function recommend($question)
    {
        $nouns = $this->getQuestionParser()->parseNouns($question);
        if(empty($nouns)){
            throw new \RuntimeException("Sorry, I could not understand your question.");
        }

        $recommendations = [];
        foreach($nouns as $noun)
        {
            $classification = $this->getClassifier()->classify($noun);
            $recommendations[] = new Recommendation($noun, $classification->getInstruction());
        }

        return $recommendations;
    }
}