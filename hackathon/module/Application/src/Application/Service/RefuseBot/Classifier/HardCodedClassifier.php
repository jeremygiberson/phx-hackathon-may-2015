<?php


namespace Application\Service\RefuseBot\Classifier;


class HardCodedClassifier implements ClassifierInterface
{
    protected $classifications = [
        'milk carton' => 'recycle',
        'soup can' => 'recycle',
        'banana peel' => 'compost',
        'cereal box' => 'recycle',
        'car battery' => 'automotive',
        'magazine' => 'recycle'
    ];

    protected $instructions = [
        'recycle' => 'clean and recycle',
        'compost' => 'compost or throw in the garbage',
        'garbage' => 'throw in the garbage',
        'unknown' => 'please ask me again later',
        'automotive' => 'Many automotive retailers will take back batteries. Or contact your local municipality for more information.'
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