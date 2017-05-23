<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Trip;
use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class UserController extends Controller
{
    /**
     * @Route("/user", name="user_all")
     */
    public function showAction(Request $request)
    {
        $user = new User();
        $usr = $this->getDoctrine()
            ->getRepository('AppBundle:User')
            ->findAll();
        var_dump($usr);
        //dump($request->get('id'));
        //$test = $request->get('id');

        return $this->render('user/show.html.twig', array(
            'trip' => $usr
        ));
    }
}