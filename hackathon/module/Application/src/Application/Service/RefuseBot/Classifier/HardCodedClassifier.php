<?php


namespace Application\Service\RefuseBot\Classifier;


class HardCodedClassifier implements ClassifierInterface
{
    protected $classifications = [
        'milk carton' => 'recycle',
        'soup can' => 'recycle',
        'banana peel' => 'compost'
    ];

    protected $instructions = [
        'recycle' => 'clean and recycle',
        'compost' => 'compost or throw in the garbage',
        'garbage' => 'throw in the garbage',
        'unknown' => 'please ask me again later'
    ];

    /**
     * @param string $noun
     * @return Classification
     */
    public function classify($noun)
    {
        $noun = strtolower($noun);
        if(in_array($noun, array_keys($this->classifications)))
        {
            $category = $this->classifications[$noun];
        } else {
            $category = 'unknown';
        }

        return new Classification($category, $this->instructions[$category]);
    }
}