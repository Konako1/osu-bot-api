<?php

namespace App\Helpers;

class OsuHelper
{
    public static function responseToArray(string $response): array
    {
        $result = [];

        foreach (preg_split("/((\r?\n)|(\r\n?))/", $response) as $line) {
            if (!preg_match('/:/', $line))
                continue;
            $lineData = explode(':', $line, 2);
            $key = trim($lineData[0]);
            $value = trim($lineData[1]);
            if ($key == 'accuracy' && !in_array('acc', array_keys($result)))
                $key = 'acc';
            $result[$key] = $value;
        }

        return $result;
    }

    public static function getOptionsString(array $options) {
        $result = '';
        foreach (array_keys($options) as $key) {
            if (is_array($options[$key])) {
                foreach ($options[$key] as $value)
                    $result .= "--$key=$value ";
                continue;
            }
            $result .= "--$key=$options[$key] ";
        }
        return $result;
    }
}
