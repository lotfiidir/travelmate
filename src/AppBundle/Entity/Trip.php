<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Entity\User;

/**
 * Trip
 *
 * @ORM\Table(name="trip")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TripRepository")
 */
class Trip
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_departure", type="datetimetz")
     */
    private $dateDeparture;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_return", type="datetimetz")
     */
    private $dateReturn;

    /**
     * @var string
     *
     * @ORM\Column(name="destination", type="text", length=255)
     */
    private $destination;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="difficulty", type="string", length=255)
     */
    private $difficulty;

    /**
     * @var string
     *
     * @ORM\Column(name="price", type="string", length=255)
     */
    private $price;

    /**
     * @var UploadedFile
     *
     * @ORM\Column(type="string")
     *
     * @Assert\NotBlank(message="Veuillez ajoutez une image.")
     * @Assert\File(mimeTypes={ "image/jpeg", "image/png" })
     * @Assert\Image(minWidth = 200, maxWidth = 1200, minHeight = 200, maxHeight = 800)
     *
     */
    private $imageTrip;
    /**
     * @ORM\Column(type="string")
     **/
    private $imagePath;

    /**
     * @var string
     *
     * @ORM\Column(name="traces", type="text")
     */

    private $traces;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="create_date", type="datetimetz")
     */
    private $createDate;

    /**
     *
     * @ORM\ManyToOne(targetEntity="User", fetch="EAGER")
     *
     */
    private $user;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Trip
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Trip
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get dateDeparture
     *
     * @return \DateTime
     */
    public function getDateDeparture()
    {
        return $this->dateDeparture;
    }

    /**
     * Set dateDeparture
     *
     * @param \DateTime $dateDeparture
     *
     * @return Trip
     */
    public function setDateDeparture($dateDeparture)
    {
        $this->dateDeparture = $dateDeparture;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDateReturn()
    {
        return $this->dateReturn;
    }

    /**
     * @param \DateTime $dateReturn
     */
    public function setDateReturn($dateReturn)
    {
        $this->dateReturn = $dateReturn;
    }

    /**
     * Get destination
     *
     * @return string
     */
    public function getDestination()
    {

        return $this->destination;
    }

    /**
     * Set destination
     *
     * @param string $destination
     *
     * @return Trip
     */
    public function setDestination($destination)
    {
        $this->destination = $destination;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return Trip
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get difficulty
     *
     * @return string
     */
    public function getDifficulty()
    {
        return $this->difficulty;
    }

    /**
     * Set difficulty
     *
     * @param string $difficulty
     *
     * @return Trip
     */
    public function setDifficulty($difficulty)
    {
        $this->difficulty = $difficulty;

        return $this;
    }

    /**
     * Get price
     *
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set price
     *
     * @param string $price
     *
     * @return Trip
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return UploadedFile
     */
    public function getImageTrip()
    {
        return $this->imageTrip;
    }

    /**
     * @param UploadedFile $file - Uploaded File
     */
    public function setImageTrip($imageTrip)
    {
        $this->imageTrip = $imageTrip;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTraces()
    {
        return $this->traces;
    }

    /**
     * @param mixed $traces
     *
     * @return Trip
     */
    public function setTraces($traces)
    {
        $this->traces = $traces;
    }

    /**
     * Get createDate
     *
     * @return \DateTime
     */
    public function getCreateDate()
    {
        return $this->createDate;
    }

    /**
     * Set createDate
     *
     * @param \DateTime $createDate
     *
     * @return Trip
     */
    public function setCreateDate($createDate)
    {
        $this->createDate = $createDate;

        return $this;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user)
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getImagePath()
    {
        return $this->imagePath;
    }

    /**
     * @param mixed $imagePath
     */
    public function setImagePath($imagePath)
    {
        $this->imagePath = $imagePath;
    }

}

