<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use FOS\UserBundle\Controller\ProfileController as BaseController;


class ProfileController extends BaseController
{
    /**
     * Edit the user
     */
    public function editAction(Request $request)
    {
        var_dump($request); die();
    }
}