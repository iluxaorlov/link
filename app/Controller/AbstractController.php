<?php

namespace App\Controller;

use Interop\Container\ContainerInterface;

abstract class AbstractController
{
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }
}