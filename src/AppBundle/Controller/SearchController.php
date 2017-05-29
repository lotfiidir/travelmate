<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Trip;
use AppBundle\Repository\TripRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SearchController extends Controller
{
    /**
     * @Route("search", name="ajax_search")
     * @Method("GET")
     */
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
        ));*/

        $search = $this->getDoctrine()->getManager();
        $reqString = $request->get('q');
        $trips = $search->getRepository('AppBundle:Trip')->findTripByString($reqString);


        if (!$trips) {
            $notFound = $this->forward('AppBundle:search:not-found.html.twig')->getContent();
            $result['trips'] = $notFound;

        } else {
            //$result['trips'] = $this->getRealTrips($trips);

                $result = $this->found($trips)->getContent();


        }
        /*
        return $this->render('template.html.twig', array(
            'trips' => new Response(json_encode($result))
        ));*/
        return new Response(json_encode($result));
    }

    public function found($trips)
    {
        foreach ($trips as $trip) {
            $trips = $trip;
        }

        //var_dump($user);
        return $this->render('search/found.html.twig', array(
            'trip' => $trips));
    }

    public function notFound()
    {
        return $this->render('search/not-found.html.twig');
    }

    /**
     * @Route("trips/search", name="search")
     * @Method("GET")
     */
    public function showAction(Request $request)
    {
        return $this->render('template.html.twig');
    }

    public function getRealTrips($trips)
    {
        foreach ($trips as $trip) {
            $realTrips[$trip->getId()] = $trip->getTitle();
        }
        return $realTrips;
    }
}