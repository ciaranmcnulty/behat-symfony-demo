<?php

namespace Cjm\Training\Enrolment\Model;

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

    public function isViable(int $size)
    {
        return $size >= $this->min;
    }

    public function hasMoreCapacity(int $size)
    {
        return $size < $this->max;
    }
}
