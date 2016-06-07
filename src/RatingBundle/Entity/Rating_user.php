<?php

namespace RatingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Rating_user
 *
 * @ORM\Table(name="rating_user")
 * @ORM\Entity(repositoryClass="RatingBundle\Repository\Rating_userRepository")
 */
class Rating_user
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
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User")
     * @ORM\JoinColumn(name="target_user_id", referencedColumnName="id")
     */
    private $targetUserId;

    /**
     * @var float
     *
     * @ORM\Column(name="score1", type="float")
     */
    private $score1;


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
     * @return Rating_user
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
     * Set targetUserId
     *
     * @param integer $targetUserId
     *
     * @return Rating_user
     */
    public function setTargetUserId($targetUserId)
    {
        $this->targetUserId = $targetUserId;

        return $this;
    }

    /**
     * Get targetUserId
     *
     * @return int
     */
    public function getTargetUserId()
    {
        return $this->targetUserId;
    }

    /**
     * Set score1
     *
     * @param float $score1
     *
     * @return Rating_user
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
}

