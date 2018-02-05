<?php

namespace Application\System;

use Application\System\Exception\InvalidRequestException;
use Application\System\Exception\NotFoundException;

class Config
{

    /**
     * Fetch the configuration key value
     * @param string $getValue
     * @return mixed|string
     * @throws InvalidRequestException
     * @throws NotFoundException
     */
    public static function get(string $getValue)
    {
        if (empty($getValue)) return '';

        $getValues = explode('.', $getValue);


        if (count($getValues) < 1) throw new InvalidRequestException('Must pass config keys');

        $file = array_shift($getValues);
        $file .= '.php';

        if (file_exists(rootPath('Config/' . $file))) {

            $configurations = require rootPath('Config/' . $file);

            foreach ($getValues as $value) {
                if (isset($configurations[$value])) {
                    $configurations = $configurations[$value];
                }

                if (!is_array($configurations)) {
                    return $configurations;
                }
            }
            return $configurations;
        }
        throw new  NotFoundException('Configuration File not found ' . $file);
    }
}