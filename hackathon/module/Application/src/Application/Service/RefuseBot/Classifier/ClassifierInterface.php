<?php


namespace Application\Service\RefuseBot\Classifier;


interface ClassifierInterface
{
    /**
     * @param string $noun
     * @return Classification
     */
    public function classify($noun);
}