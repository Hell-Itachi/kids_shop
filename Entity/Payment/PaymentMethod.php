<?php

namespace Itc\KidsBundle\Entity\Payment;

use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use \Itc\AdminBundle\Entity\Content;
/**
 * PaymentMethod
 *
 * @ORM\Table()
 * @ORM\Entity
 * @Vich\Uploadable
 */
class PaymentMethod extends Content
{
    protected $metaTitle;
    protected $metaDescription;
    protected $metaKeyword;
    protected $description;
    protected $title;
    protected $translit;
    protected $content;
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="company", type="string", length=255)
     */
    protected $company;

    /**
     * @var integer
     *
     * @ORM\Column(name="acc_num", type="integer")
     */
    protected $acc_num;


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
     * Set company
     *
     * @param string $company
     * @return PaymentMethod
     */
    public function setCompany($company)
    {
        $this->company = $company;
    
        return $this;
    }

    /**
     * Get company
     *
     * @return string 
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * Set acc_num
     *
     * @param integer $accNum
     * @return PaymentMethod
     */
    public function setAccNum($accNum)
    {
        $this->acc_num = $accNum;
    
        return $this;
    }

    /**
     * Get acc_num
     *
     * @return integer 
     */
    public function getAccNum()
    {
        return $this->acc_num;
    }
    
    public function setIconImage($image)
    {
        $this->iconImage = $image;
    }
    
    public function getIconImage()
    {
        return $this->iconImage;
    }
}
