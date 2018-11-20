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
        return $input = preg_replace(' ','/-/', $input);
    }

}