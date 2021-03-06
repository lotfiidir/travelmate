<?php

namespace AppBundle\Repository;

/**
 * TripRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TripRepository extends \Doctrine\ORM\EntityRepository
{
    public function getUserFor($id)
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT u
                 FROM AppBundle:User u
                 WHERE :id'
            )
            ->setParameter('id', '%' . $id . '%')
            ->getResult();
    }

    public function findTripByString($str)
    {
        /*$words = explode(" ", $str);
        var_dump($words);
        $query = "SELECT t
                 FROM AppBundle:Trip t
                 WHERE 1";
        foreach ($words as $word) {
            $query .= "t.title LIKE :word
     OR t.description LIKE :word
     OR t.destination LIKE :word";
        }*/
//ancieennnnn works********************
        /*return $this->getEntityManager()
            ->createQuery(
                'SELECT t
                 FROM AppBundle:Trip t
                 WHERE array_values(t.destination) LIKE :str'
            )
            ->setParameter('str', '%' . $str . '%')
            ->getResult();*/
//***************************************
        /*$string = str_replace(' ', '-', $str);

        $stringClean = preg_replace('/[^A-Za-z0-9\-]/', ' ', $string);
        //        $string = str_replace(' ', ',', $stringClean);
        $words = explode(" ", trim($stringClean));
        $clauses = array();
        $i = 0;
        foreach ($words as $word) {
            // for every word make new search query and parameter
            $parameters[":param" . $i] = "%" . $word . "%";
            if ($i == 0) {
                $clauses = "t.title LIKE :param" . $i . " OR t.description LIKE :param" . $i . " OR t.destination LIKE :param" . $i;
            } else {
                $clauses .= " OR t.title LIKE :param" . $i . " OR t.description LIKE :param" . $i . " OR t.destination LIKE :param" . $i;
            }
            $i++;
        }

        $query = $this->createQueryBuilder('t')
            ->where($clauses)
            ->setParameters($parameters)
            ->getQuery();
        $trips = $query->getResult();
        return $trips;*/

        /*return $this->createQueryBuilder('t')
            ->select('t')
            ->from('AppBundle\Entity\Trip', 't')
            ->where($clauses)
            ->setParameters($parameters)
            ->getResult();
*/


// createQueryBuilder() automatically selects FROM AppBundle:Product
// and aliases it to "p"
       /* $query = $repository->createQueryBuilder('p')
            ->where('p.price > :price')
            ->setParameter('price', '19.99')
            ->orderBy('p.price', 'ASC')
            ->getQuery();

        $products = $query->getResult();*/
       /*$em = $this->getEntityManager();
        $query = $em->createQuery('SELECT t FROM AppBundle:Trip t WHERE t.destination IN (:str)');
        $query->setParameter('str', array(1, 9));
        $trips = $query->getResult();*/
        /*$qb = $this->getEntityManager()->createQueryBuilder('t');
        $qb->add('select','t.destination');
        $qb->add('from', 'AppBundle\Entity\Trip');
        $qb->add('where', $qb->expr()->in('t.destination', array('?1')));
        $query = $qb->getQuery();*/
         /*$qb = $this->createQueryBuilder('t');
         $qb->add('from', 'AppBundle:Trip');
        $qb->add('where', $qb->expr()->in('t.destination', '?1'))
            ->setParameter('str', $str);
        return $qb;*/

        //return $trips;

        return $this->getEntityManager()
            ->createQuery(
                'SELECT t
                 FROM AppBundle:Trip t
                 WHERE t.destination LIKE :str'
            )
            ->setParameter('str', '%' . $str . '%')
            ->getResult();
    }
}
