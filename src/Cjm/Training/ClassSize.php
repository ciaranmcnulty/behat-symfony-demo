<?php

namespace Cjm\Training;

class ClassSize
{
    private $min;
    private $max;

    private function __construct(int $min, int $max)
    {
        $this->min = $min;
        $this->max = $max;
    }

    public static function between(int $min, int $max)
    {
        return new ClassSize($min, $max);
    }

    public function allows(int $number)
    {
        return $number >= $this->min;
    }
}
