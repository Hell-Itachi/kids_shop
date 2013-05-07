<?php

namespace Itc\KidsBundle\Entity\User;

use Doctrine\ORM\Mapping as ORM;

/**
 * Adress
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Adress
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="userid", type="integer")
     */
    private $userid;

    /**
     * @var string
     *
     * @ORM\Column(name="fio", type="string", length=255,  nullable=true)
     */
    private $fio;

    /**
     * @var string
     *
     * @ORM\Column(name="h_num", type="string", length=20, nullable=true)
     */
    private $h_num;

    /**
     * @var string
     *
     * @ORM\Column(name="street", type="string", length=50,  nullable=true)
     */
    private $street;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=50, nullable=true)
     */
    private $city;

    /**
     * @var integer
     *
     * @ORM\Column(name="postcode", type="integer",  nullable=true)
     */
    private $postcode;

    /**
     * @var string
     *
     * @ORM\Column(name="state", type="string", length=100, nullable=true)
     */
    private $state;

    /**
     * @var integer
     *
     * @ORM\Column(name="pd_id", type="integer", nullable=true)
     */
    private $pd_id;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set userid
     *
     * @param integer $userid
     * @return Adress
     */
    public function setUserid($userid)
    {
        $this->userid = $userid;
    
        return $this;
    }

    /**
     * Get userid
     *
     * @return integer 
     */
    public function getUserid()
    {
        return $this->userid;
    }

    /**
     * Set fio
     *
     * @param string $fio
     * @return Adress
     */
    public function setFio($fio)
    {
        $this->fio = $fio;
    
        return $this;
    }

    /**
     * Get fio
     *
     * @return string 
     */
    public function getFio()
    {
        return $this->fio;
    }

    /**
     * Set h_num
     *
     * @param string $hNum
     * @return Adress
     */
    public function setHNum($hNum)
    {
        $this->h_num = $hNum;
    
        return $this;
    }

    /**
     * Get h_num
     *
     * @return string 
     */
    public function getHNum()
    {
        return $this->h_num;
    }

    /**
     * Set street
     *
     * @param string $street
     * @return Adress
     */
    public function setStreet($street)
    {
        $this->street = $street;
    
        return $this;
    }

    /**
     * Get street
     *
     * @return string 
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * Set city
     *
     * @param string $city
     * @return Adress
     */
    public function setCity($city)
    {
        $this->city = $city;
    
        return $this;
    }

    /**
     * Get city
     *
     * @return string 
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set postcode
     *
     * @param integer $postcode
     * @return Adress
     */
    public function setPostcode($postcode)
    {
        $this->postcode = $postcode;
    
        return $this;
    }

    /**
     * Get postcode
     *
     * @return integer 
     */
    public function getPostcode()
    {
        return $this->postcode;
    }

    /**
     * Set state
     *
     * @param string $state
     * @return Adress
     */
    public function setState($state)
    {
        $this->state = $state;
    
        return $this;
    }

    /**
     * Get state
     *
     * @return string 
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set pd_id
     *
     * @param integer $pdId
     * @return Adress
     */
    public function setPdId($pdId)
    {
        $this->pd_id = $pdId;
    
        return $this;
    }

    /**
     * Get pd_id
     *
     * @return integer 
     */
    public function getPdId()
    {
        return $this->pd_id;
    }
    function __toString(){
        return is_null( $this->fio ) ? "" : $this->fio ;
    }
}
