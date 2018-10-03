<?php
namespace SkyEngTest;

/**
 * Class BigInt Класс для работы с большими числами
 * @package BigInt
 */
class BigInt
{
    const DIGIT = 10;
    protected $value;

    public function __construct(string $value)
    {
        $this->value = $this->stringToArray($value);
    }

    public function __toString(): string
    {
        return $this->toString();
    }

    public function toString(): string
    {
        return implode($this->toArray());
    }

    public function toArray(): array
    {
        return array_reverse($this->value);
    }

    /**
     * Прибавить число к текущему
     * @param string|BigInt $value
     * @throws \Exception
     */
    public function add($value)
    {
        if (is_string($value)) {
            $value = new self($value);
        }

        if (!$value instanceof self) {
            throw new \Exception("The parameter must be of type String or BigInt");
        }

        if (count($this->value) > count($value->value)) {
            $this->value = $this->addBigInt($this, $value);
        } else {
            $this->value = $this->addBigInt($value, $this);
        }
    }

    protected function addBigInt(self $a, self $b): array
    {
        $carry = 0;
        $sum = [];
        for ($i = 0; $i < count($a->value); $i++) {
            $temp = $a->value[$i] + $b->value[$i] + $carry;
            if ($temp >= self::DIGIT) {
                $sum[] = $temp - self::DIGIT;
                $carry = 1;
            } else {
                $sum[] = $temp;
                $carry = 0;
            }
        }
        if ($carry) {
            $sum[] = $carry;
        }
        return $sum;
    }

    protected function stringToArray(string $string): array
    {
        $pattern = '/^\d*$/';
        if (preg_match($pattern, $string) !== 1) {
            throw new \Exception("The string must consist of numbers");
        }

        $result = [];
        foreach (str_split($string) as $value) {
            $result[] = (int)$value;
        }
        return array_reverse($result);
    }
}
