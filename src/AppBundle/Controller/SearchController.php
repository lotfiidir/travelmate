<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Trip;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\HttpFoundation\Request;

class SearchController
{
    /**
     * @Route("/trips", name="trips_list")
     */
    /*
    public function searchAction(Request $request)
    {
        /*$search = $this->
            $form = $this->createFormBuilder()
                ->add('searchInput', SearchType::class, array('attr'))
                ->getForm();
        $trips = $this->getDoctrine()
            ->getRepository('AppBundle:Trip')
            ->findAll();
        return $this->render('trip/index.html.twig', array(
            'trips' => $trips
        ));
    }*/
}