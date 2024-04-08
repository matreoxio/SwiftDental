<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ConvertRomanNumerals extends Command
{
    protected $signature = 'convert:roman {value}';
    protected $description = 'Converts between integer and Roman numeral values';

    // Check which function should be used
    public function handle()
    {
        $value = $this->argument('value');

        // Check if the past value is an integer
        if (is_numeric($value)) {
            // If yes go to integerToRoman function
            $result = $this->integerToRoman($value);
            $this->info("Roman numeral: $result");
        } else {
            // If no, go to romanToInteger function
            $result = $this->romanToInteger($value);
            $this->info("Integer value: $result");
        }
    }

    private function integerToRoman($integer)
    {
        $integer = intval($integer);
        $result = '';

        // Create a lookup array for Roman numerals an their corresponding value
        $lookup = [
            'M' => 1000, 'CM' => 900, 'D' => 500, 'CD' => 400,
            'C' => 100, 'XC' => 90, 'L' => 50, 'XL' => 40,
            'X' => 10, 'IX' => 9, 'V' => 5, 'IV' => 4, 'I' => 1
        ];

        foreach ($lookup as $roman => $value) {
            $matches = intval($integer / $value);
            $result .= str_repeat($roman, $matches);
            $integer %= $value;
        }

        return $result;
    }

    private function romanToInteger($roman)
    {
        
        // Create a lookup array for Roman numerals an their corresponding value
        $lookup = [
            'M' => 1000, 'CM' => 900, 'D' => 500, 'CD' => 400,
            'C' => 100, 'XC' => 90, 'L' => 50, 'XL' => 40,
            'X' => 10, 'IX' => 9, 'V' => 5, 'IV' => 4, 'I' => 1
        ];

        $integer = 0;

        foreach ($lookup as $romanValue => $value) {
            while (strpos($roman, $romanValue) === 0) {
                $integer += $value;
                $roman = substr($roman, strlen($romanValue));
            }
        }

        return $integer;
    }
}
