<?php
// src/Acme/UserBundle/AcmeUserBundle.php

namespace project\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class ChildUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}