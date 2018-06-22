<?php
/**
 * Created by PhpStorm.
 * User: tboileau-desktop
 * Date: 22/06/18
 * Time: 01:48
 */

namespace App\Model;


class Foo
{
    /**
     * @var string
     */
    public $name;

    /**
     * Foo constructor.
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }


}