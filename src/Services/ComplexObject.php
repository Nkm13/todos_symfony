<?php
// src/Services/ComplexObject.php
namespace App\Services;

class ComplexObject
{
    private $foo;
    private $bar;
    private $baz;
    private $other;

    public function __construct(
        $foo,
        $bar,
        $baz,
        $other
    ) {
        $this->foo = $foo;
        $this->bar = $bar;
        $this->baz = $baz;
        $this->other = $other;
    }

    public function doSomething()
    {
    }
}
