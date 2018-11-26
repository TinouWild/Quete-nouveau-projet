<?php
/**
 * Created by PhpStorm.
 * User: etienne
 * Date: 19/11/18
 * Time: 16:28
 */

namespace App\Service;


class Slugify
{

    public function generate(string $input) : string
    {
        $unwantedChars = array(',', '!', '?'); // create array with unwanted chars
        $input = str_replace($unwantedChars, '', $input); // remove them
        $input = strtolower($input);
        $input = trim($input);
        $input = str_replace(" ", "-", $input);
        return $input;
    }

}