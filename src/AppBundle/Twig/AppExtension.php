<?php

namespace AppBundle\Twig;

use Symfony\Component\Intl\Intl;

class AppExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('countryName', array($this, 'countryNameFilter')),
        );
    }

    public function countryNameFilter($countryCode)
    {
        return Intl::getRegionBundle()->getCountryName($countryCode);
    }

    public function getName()
    {
        return 'country_extension';
    }
}