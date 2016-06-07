<?php

namespace RatingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Rating_property
 *
 * @ORM\Table(name="rating_property")
 * @ORM\Entity(repositoryClass="RatingBundle\Repository\Rating_propertyRepository")
 */
class Rating_property
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $userId;

    /**
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="PropertyBundle\Entity\Properties")
     * @ORM\JoinColumn(name="property_id", referencedColumnName="id")
     */
    private $propertyId;

    /**
     * @var float
     *
     * @ORM\Column(name="score1", type="float")
     */
    private $score1;

    /**
     * @var float
     *
     * @ORM\Column(name="score2", type="float")
     */
    private $score2;

    /**
     * @var float
     *
     * @ORM\Column(name="score3", type="float")
     */
    private $score3;


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
     * Set userId
     *
     * @param integer $userId
     *
     * @return Rating_property
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set propertyId
     *
     * @param integer $propertyId
     *
     * @return Rating_property
     */
    public function setPropertyId($propertyId)
    {
        $this->propertyId = $propertyId;

        return $this;
    }

    /**
     * Get propertyId
     *
     * @return int
     */
    public function getPropertyId()
    {
        return $this->propertyId;
    }

    /**
     * Set score1
     *
     * @param float $score1
     *
     * @return Rating_property
     */
    public function setScore1($score1)
    {
        $this->score1 = $score1;

        return $this;
    }

    /**
     * Get score1
     *
     * @return float
     */
    public function getScore1()
    {
        return $this->score1;
    }

    /**
     * Set score2
     *
     * @param float $score2
     *
     * @return Rating_property
     */
    public function setScore2($score2)
    {
        $this->score2 = $score2;

        return $this;
    }

    /**
     * Get score2
     *
     * @return float
     */
    public function getScore2()
    {
        return $this->score2;
    }

    /**
     * Set score3
     *
     * @param float $score3
     *
     * @return Rating_property
     */
    public function setScore3($score3)
    {
        $this->score3 = $score3;

        return $this;
    }

    /**
     * Get score3
     *
     * @return float
     */
    public function getScore3()
    {
        return $this->score3;
    }
}

