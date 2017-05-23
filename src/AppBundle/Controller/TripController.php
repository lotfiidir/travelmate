<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Trip;
use AppBundle\Entity\User;
use Ivory\GoogleMap\Base\Coordinate;
use Ivory\GoogleMap\Event\Event;
use Ivory\GoogleMap\Map;
use Ivory\GoogleMap\Overlay\Animation;
use Ivory\GoogleMap\Overlay\Circle;
use Ivory\GoogleMap\Overlay\Icon;
use Ivory\GoogleMap\Overlay\IconSequence;
use Ivory\GoogleMap\Overlay\Marker;
use Ivory\GoogleMap\Overlay\MarkerShape;
use Ivory\GoogleMap\Overlay\MarkerShapeType;
use Ivory\GoogleMap\Overlay\Polyline;
use Ivory\GoogleMap\Overlay\Symbol;
use Ivory\GoogleMap\Overlay\SymbolPath;
use Ivory\GoogleMapBundle\Form\Type;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Serializer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;


class TripController extends Controller
{
    /**
     * @Route("/", name="trips_list")
     */
    public function listAction(Request $request)
    {
        $trips = $this->getDoctrine()
            ->getRepository('AppBundle:Trip')
            ->findAll();

        return $this->render('trip/index.html.twig', array(
            'trips' => $trips
        ));
    }

    /**
     * @Route("/trip/creer", name="trip_create")
     *
     * @Method({"GET", "POST"})
     */
    public function createAction(Request $request)
    {
        $trip = new Trip();
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $trip->setUser($user->getId());
        dump($trip->getUser());
        $form = $this->createFormBuilder($trip)
            ->add('title', TextType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px', 'placeholder' => 'Ajouter un titre...')))
            ->add('description', TextareaType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px', 'placeholder' => 'Ajouter une description...')))
            ->add('date_departure', DateTimeType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
            ->add('destination', CountryType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
            ->add('type', ChoiceType::class, array('choices' => array("Auto-stop" => "Auto-stop",
                "Aventure" => "Aventure",
                "Camping sauvage" => "Camping sauvage",
                "Circuit touristique" => "Circuit touristique",
                "Evasion" => "Evasion",
                "Excursion" => "Excursion",
                "Exploration" => "Exploration",
                "Expedition" => "Expédition",
                "Navigation" => "Navigation",
                "Promenade" => "Promenade",
                "Randonnee pedestre" => "Randonnée pédestre",
                "Road trip" => "Road trip",
                "Tour du monde" => "Tour du monde",
                "Voyage experimental" => "Voyage expérimental",
            ), 'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
            ->add('difficulty', ChoiceType::class, array('choices' => array('Facile' => 'Facile', 'Moyen' => 'Moyen', 'Dur' => 'Dur'), 'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
            ->add('price', ChoiceType::class, array('choices' => array('Bas' => 'Bas', 'Moyennement bas' => 'Moyennement bas', 'Moyen' => 'Moyen', 'Moyennement eleve' => 'Moyennement élevé', 'Elevé' => 'Élevé'), 'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
            ->add('imageTrip', FileType::class, array('data_class' => null, 'label' => 'Image du voyage', 'attr' => array('class' => 'file', 'style' => 'margin-bottom:15px')))
            ->add('traces', HiddenType::class, array('label' => 'map', 'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px'), 'required' => false))
            ->add('save', SubmitType::class, array('label' => 'Créer le voyage', 'attr' => array('class' => 'btn btn-primary', 'style' => 'margin-bottom:15px')))
            ->getForm();
//////////->
        //$map = new Map();
///////////<-
        /*$marker2 = new Marker(new Coordinate(50,-0.3684824));
        $marker3 = new Marker(new Coordinate(41.8333925,-88.0123449));*/
        //$map->getOverlayManager()->addMarkers([$marker1, $marker2]);
/////////////->
        /*$marker = new Marker(new Coordinate(49.1799151, -0.3684824));
        $map->getOverlayManager()->addMarker($marker);
        $map->setCenter(new Coordinate(49.1799151, -0.3684824));
        $map->setMapOption('zoom', 13);
        $map->setStylesheetOption('width', '100%');
        dump($map);*/
/////////////////<-
        //$map->setAutoZoom(true);
        /*
        $map->getOverlayManager()->addMarker($marker);
        $map->getOverlayManager()->addMarker($marker2);
        $map->getOverlayManager()->addMarker($marker3);*/
//        $map->setCenter(new Coordinate(49.1799151,-0.3684824));
        //$map->setMapOption('zoom', 13);
//        var_dump($map);
//////////////->
        /*$event = new Event(
            $map->getVariable(),
            'click',
            'function(event){
                    getTrace(event, '.$map->getVariable().');
                   }',true);
        $map->getEventManager()->addDomEvent($event);*/
////////////////<-

        /*$encoders = array(new JsonEncoder());
        $normalizers = array(new GetSetMethodNormalizer());

        $serializer = new Serializer($normalizers, $encoders);

        $jsonContent = $serializer->serialize($map, 'json');
        var_dump($jsonContent);*/

        //var_dump($event->getHandle());

        if ($request->getMethod() == 'POST') {
            $json = new Response($request);
            $trip->setTraces($request->getContent(false));
            $jsonArray[] = $request->getContent(false);
            foreach ($jsonArray as $item) {
                $trip->setTraces($item);
            }
        }
        //var_dump($trip->getTraces());

        //$map->getEventManager()->addEvent($event);
        //var_dump($map);


        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // get data
            $title = $form['title']->getData();
            $description = $form['description']->getData();
            $dateDeparture = $form['date_departure']->getData();
            $destination = $form['destination']->getData();
            $type = $form['type']->getData();
            $difficulty = $form['difficulty']->getData();
            $price = $form['price']->getData();
            $file = $trip->getImageTrip();
            $fileName = md5(uniqid()) . '.' . $file->guessExtension();
            $file->move(
                $this->getParameter('imagesTrip_directory'),
                $fileName
            );
            $traces = $form['traces']->getData();

            $now = new \DateTime('now');

            $trip->setTitle($title);
            $trip->setDescription($description);
            $trip->setDateDeparture($dateDeparture);
            $trip->setDestination($destination);
            $trip->setType($type);
            $trip->setDifficulty($difficulty);
            $trip->setPrice($price);
            $trip->setImageTrip($fileName);
            $trip->setTraces($traces);
            $trip->setCreateDate($now);
            $user = $this->get('security.token_storage')->getToken()->getUser();
            $trip->setUser($user->getId());

            $em = $this->getDoctrine()->getManager();

            $em->persist($trip);
            $em->flush();

            $this->addFlash(
                'notice', 'Voyage Ajoutée avec succes !'
            );
            return $this->redirectToRoute('trips_list');
        }

        return $this->render('trip/create.html.twig', array(
            'form' => $form->createView()/*,
            'map' => $map*/));
    }

    /*    /**
         *
         *

        public function getTraceAction(Request $request)
        {
            $map = new Map();
            $marker = new Marker(new Coordinate(50, -0.3684824));
            $map->getOverlayManager()->addMarker($marker);
            $map->setCenter(new Coordinate(50, -0.3684824));
            $map->setMapOption('zoom', 13);
            $map->setStylesheetOption('width', '100%');
            var_dump($map);
            $json = $request->getContent(false);

            return new JsonResponse($json);
        }*/


    /**
     * @Route("/trip/edit/{id}", name="trip_edit")
     */
    public function editAction($id, Request $request)
    {

        $trip = $this->getDoctrine()
            ->getRepository('AppBundle:Trip')
            ->find($id);
        $now = new \DateTime('now');

        $trip->setTitle($trip->getTitle());
        $trip->setDescription($trip->getDescription());
        $trip->setDateDeparture($trip->getDateDeparture());
        $trip->setDestination($trip->getDestination());
        $trip->setType($trip->getType());
        $trip->setDifficulty($trip->getDifficulty());
        $trip->setPrice($trip->getPrice());
        $trip->setImageTrip($trip->getImageTrip());
        $trip->setCreateDate($now);
        $oldfile = $trip->getImageTrip();
        $trip->setTraces($trip->getTraces());

        $form = $this->createFormBuilder($trip)
            ->add('title', TextType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
            ->add('description', TextareaType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
            ->add('date_departure', DateTimeType::class, array('attr' => array('class' => 'formcontrol', 'style' => 'margin-bottom:15px')))
            ->add('destination', CountryType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
            ->add('type', ChoiceType::class, array('choices' => array("Auto-stop" => "Auto-stop",
                "Aventure" => "Aventure",
                "Camping sauvage" => "Camping sauvage",
                "Circuit touristique" => "Circuit touristique",
                "Evasion" => "Evasion",
                "Excursion" => "Excursion",
                "Exploration" => "Exploration",
                "Expédition" => "Expédition",
                "Navigation" => "Navigation",
                "Promenade" => "Promenade",
                "Randonnée pédestre" => "Randonnée pédestre",
                "Road trip" => "Road trip",
                "Tour du monde" => "Tour du monde",
                "Voyage expérimental" => "Voyage expérimental",
            ), 'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
            ->add('difficulty', ChoiceType::class, array('choices' => array('Facile' => 'Facile', 'Moyen' => 'Moyen', 'Dur' => 'Dur'), 'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
            ->add('price', ChoiceType::class, array('choices' => array('Bas' => 'Bas', 'Moyennement bas' => 'Moyennement bas', 'Moyen' => 'Moyen', 'Moyennement eleve' => 'Moyennement élevé', 'Elevé' => 'Élevé'), 'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
            ->add('imageTrip', FileType::class, array('data_class' => null, 'label' => 'Image du voyage', 'attr' => array('class' => 'btn btn-file', 'style' => 'margin-bottom:15px')))
            ->add('traces', HiddenType::class, array('label' => 'map', 'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px'), 'required' => false))
            ->add('save', SubmitType::class, array('label' => 'Modifier le voyage', 'attr' => array('class' => 'btn btn-primary', 'style' => 'margin-bottom:15px')))
            ->getForm();


        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // get data
            $title = $form['title']->getData();
            $description = $form['description']->getData();
            $dateDeparture = $form['date_departure']->getData();
            $destination = $form['destination']->getData();
            $type = $form['type']->getData();
            $difficulty = $form['difficulty']->getData();
            $price = $form['price']->getData();
            $file = $trip->getImageTrip();
            $traces = $form['traces']->getData();

            if ($oldfile !== $file) {
                $oldFile = $this->getParameter('imagesTrip_directory') . "/$oldfile";
                if ($oldFile !== null) {
                    unlink($oldFile);
                }
                $fileName = md5(uniqid()) . '.' . $file->guessExtension();
                $file->move(
                    $this->getParameter('imagesTrip_directory'),
                    $fileName
                );
            } else {
                $fileName = $oldfile;
            }

            $em = $this->getDoctrine()->getManager();
            $trip = $em->getRepository('AppBundle:Trip')->find($id);

            $trip->setTitle($title);
            $trip->setDescription($description);
            $trip->setDateDeparture($dateDeparture);
            $trip->setDestination($destination);
            $trip->setType($type);
            $trip->setDifficulty($difficulty);
            $trip->setPrice($price);
            $trip->setImageTrip($fileName);
            $trip->setCreateDate($now);
            $trip->setTraces($traces);
            $user = $this->get('security.token_storage')->getToken()->getUser();
            $trip->setUser($user->getId());

            $em->flush();

            $this->addFlash(
                'notice',
                'Voyage modifier'
            );
            return $this->redirectToRoute('trips_list');
        }

        return $this->render('trip/edit.html.twig', array(
            'trip' => $trip,
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/trip/details/{id}", name="trip_details")
     */
    public function detailsAction($id)
    {

        $trip = $this->getDoctrine()
            ->getRepository('AppBundle:Trip')
            ->find($id);
        dump($trip->getUser());

        $userId = $trip->getUser();
        dump($userId);
        $user = $this->getDoctrine()
        ->getRepository('AppBundle:User')
        ->find($userId);
        dump($user);

        $map = new Map();
        $map->setAutoZoom(true);
        if ($trip->getTraces() != '') {
            $poly = [];
            $polyline = new Polyline();

            foreach (json_decode($trip->getTraces()) as $item) {
                $marker = new Marker(new Coordinate($item));
                $map->getOverlayManager()->addMarker($marker);
                list($lat, $lng) = explode(",", $item);
                $poly[] = new Coordinate($lat, $lng);
                dump($polyline);
            }
            $polyline->setCoordinates(
                $poly
            );
            $polyline->setIconSequences([]);
            $polyline->setOption('fillOpacity', 0.5);
            $map->setStylesheetOption('width', '100%');
            $map->getOverlayManager()->addPolyline($polyline);
        }
        return $this->render('trip/details.html.twig', array(
            'trip' => $trip,
            'map' => $map,
            'user' => $user
        ));
    }

    /**
     * @Route("/trip/delete/{id}", name="trip_delete")
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $trip = $em->getRepository('AppBundle:Trip')->find($id);

        $em->remove($trip);
        $em->flush();

        $this->addFlash(
            'notice',
            'Trip Removed'
        );
        return $this->redirectToRoute('trips_list');
    }
}