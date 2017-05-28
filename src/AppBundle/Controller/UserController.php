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
     * @Route("/user/details/{id}", name="user_details")
     */
    public function detailsAction($id)
    {

        $user = $this->getDoctrine()
            ->getRepository('AppBundle:User')
            ->find($id);
        $userId = $user->getId();
        $trips = $this->getDoctrine()
            ->getRepository('AppBundle:Trip')
            ->findBy(array('user' => $userId));
        return $this->render('user/show.html.twig', array(
            'user' => $user,
            'trips' => $trips
        ));
    }
}