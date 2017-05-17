<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Trip;
use Ivory\GoogleMap\Base\Coordinate;
use Ivory\GoogleMap\Event\Event;
use Ivory\GoogleMap\Map;
use Ivory\GoogleMap\Overlay\Animation;
use Ivory\GoogleMap\Overlay\Circle;
use Ivory\GoogleMap\Overlay\Icon;
use Ivory\GoogleMap\Overlay\Marker;
use Ivory\GoogleMap\Overlay\MarkerShape;
use Ivory\GoogleMap\Overlay\MarkerShapeType;
use Ivory\GoogleMap\Overlay\Symbol;
use Ivory\GoogleMap\Overlay\SymbolPath;
use Ivory\GoogleMapBundle\Form\Type;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;


class TripController extends Controller
{
    /**
     * @Route("/trips", name="trips_list")
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
     */
    public function createAction(Request $request)
    {
        $trip = new Trip();
        $form = $this->createFormBuilder($trip)
            ->add('title', TextType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px', 'placeholder' => 'Ajouter un titre...')))
            ->add('description', TextareaType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px', 'placeholder' => 'Ajouter une description...')))
            ->add('date_departure', DateTimeType::class, array('attr' => array('class' => 'formcontrol', 'style' => 'margin-bottom:15px')))
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
            ->add('save', SubmitType::class, array('label' => 'Créer le voyage', 'attr' => array('class' => 'btn btn-primary', 'style' => 'margin-bottom:15px')))
            ->getForm();
        $map = new Map();
        $marker1 = new Marker(new Coordinate(42.1799151,-0.3684824));
        $marker2 = new Marker(new Coordinate(50,-0.3684824));
        $marker3 = new Marker(new Coordinate(41.8333925,-88.0123449));
        //$map->getOverlayManager()->addMarkers([$marker1, $marker2]);
        $map->setAutoZoom(true);
        $map->getOverlayManager()->addMarker($marker1);
        $map->getOverlayManager()->addMarker($marker2);
        $map->getOverlayManager()->addMarker($marker3);
//        $map->setCenter(new Coordinate(49.1799151,-0.3684824));
        $map->setMapOption('zoom', 13);
//        var_dump($map);

        //$event = new Event($marker->getVariable(),'click','function(){alert("Marker clicked"}', true);

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

            $now = new \DateTime('now');

            $trip->setTitle($title);
            $trip->setDescription($description);
            $trip->setDateDeparture($dateDeparture);
            $trip->setDestination($destination);
            $trip->setType($type);
            $trip->setDifficulty($difficulty);
            $trip->setPrice($price);
            $trip->setImageTrip($fileName);
            $trip->setCreateDate($now);

            $em = $this->getDoctrine()->getManager();

            $em->persist($trip);
            $em->flush();

            $this->addFlash(
                'notice', 'Voyage Ajoutée avec succes !'
            );
            return $this->redirectToRoute('trips_list');
        }

        return $this->render('trip/create.html.twig', array(
            'form' => $form->createView(),
            'map' => $map));
    }

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
            }else {
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

        return $this->render('trip/details.html.twig', array(
            'trip' => $trip
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