<?php

        

          


        

          

declare(strict_types=1);

        

          


        

          

final class PhoneNumber

        

          

{

        

          

    private string $number;

        

          


        

          

    public function __construct(string $number)

        

          

    {

        

          

        $this->validateCharacters($number);

        

          


        

          

        $num = preg_replace('#\\D#', '', $number);

        

          

        $result = preg_match('#^(?<prefix>1)?(?<area>\d{3})(?<exchange>\d{3})(?<n>\d{4})$#', $num, $matches, PREG_UNMATCHED_AS_NULL);

        

          


        

          

        $this->validateLength($num);

        

          

        $this->validatePhoneParts($matches);

        

          


        

          

        $this->number = $matches['area'] . $matches['exchange'] . $matches['n'];

        

          

    }

        

          


        

          

    public function number(): string

        

          

    {

        

          

        return $this->number;

        

          

    }

        

          


        

          

    /**

        

          

     * @throws InvalidArgumentException

        

          

     */

        

          

    private function validateCharacters(string $number): void

        

          

    {

        

          

        if (preg_match('#[a-z]#i', $number)) {

        

          

            throw new InvalidArgumentException('letters not permitted');

        

          

        }

        

          

        if (preg_match('#[@!:]#', $number)) {

        

          

            throw new InvalidArgumentException('punctuations not permitted');

        

          

        }

        

          

    }

        

          


        

          

    /**

        

          

     * @throws InvalidArgumentException

        

          

     */

        

          

    private function validateLength(string $number): void

        

          

    {

        

          

        $length = mb_strlen($number);

        

          


        

          

        $length === 9 && throw new InvalidArgumentException('incorrect number of digits');

        

          

        $length > 11 && throw new InvalidArgumentException('more than 11 digits');

        

          

        $length === 11 && !str_starts_with($number, '1') && throw new InvalidArgumentException('11 digits must start with 1');

        

          

    }

        

          


        

          

    /**

        

          

     * @param array{?prefix: string, area: string, exchange: string, n: string} $parts

        

          

     * @throws InvalidArgumentException

        

          

     */

        

          

    private function validatePhoneParts(array $parts): void

        

          

    {

        

          

        match ($parts['area'][0]) {

        

          

            '0' => throw new InvalidArgumentException('area code cannot start with zero'),

        

          

            '1' => throw new InvalidArgumentException('area code cannot start with one'),

        

          

            default => true,

        

          

        };

        

          

        match ($parts['exchange'][0]) {

        

          

            '0' => throw new InvalidArgumentException('exchange code cannot start with zero'),

        

          

            '1' => throw new InvalidArgumentException('exchange code cannot start with one'),

        

          

            default => true,

        

          

        };

        

          

    }

        

          

}
