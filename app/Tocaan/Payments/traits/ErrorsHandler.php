<?php
namespace App\Tocaan\Payments\traits;

trait ErrorsHandler
{
    public function throw($e)
    {
        throw new \Exception($e);
    }
}
