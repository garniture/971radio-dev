<?php

namespace Garniture\RadioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Images
 * @ORM\Table(name="uploaded_image")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Image{
    
  /**
    * @ORM\Column(name="id", type="integer")
    * @ORM\Id
    * @ORM\GeneratedValue(strategy="AUTO")
    */
      private $id;

  /**
    * @ORM\Column(name="url", type="string", length=255)
    */
      private $url;

  /**
    * @ORM\Column(name="alt", type="string", length=255)
    */
      private $alt;


  /**
    * @Assert\File(maxSize="500k")
    */
  private $file;

  private $tempFilename;

  /**
   *
   * @var type 
   * @ORM\Column(name="date_ajout", type="datetime", nullable=true)
   */
  private $dateAjout;
  
  
  function __construct() {
      
      $this->dateAjout= new \DateTime();
      
  }

  /**
    * @ORM\PrePersist()
    * @ORM\PreUpdate()
    */
      public function preUpload(){

        if (null === $this->file) {
          return;
        }
        $this->url = $this->file->guessExtension();

       $this->alt = $this->file->getClientOriginalName();
      }

  /**
    * @ORM\PostPersist()
    * @ORM\PostUpdate()
    */
    public function upload()
    {
      if (null === $this->file) {
        return;
      }

       if (null !== $this->tempFilename) {
        $oldFile = $this->getUploadRootDir().'/'.$this->id.'.'.$this->tempFilename;
        if (file_exists($oldFile)) {
          unlink($oldFile);
        }
      }

      $this->file->move(
        $this->getUploadRootDir(), // Le répertoire de destination
        $this->id.'.'.$this->url 
      );
    }

  /**
    * @ORM\PreRemove()
    */
      public function preRemoveUpload() {
        $this->tempFilename = $this->getUploadRootDir().'/'.$this->id.'.'.$this->url;
      }

  /**
    * @ORM\PostRemove()
    */
      public function removeUpload()
      {
        if (file_exists($this->tempFilename)) {
          unlink($this->tempFilename);
        }
      }

  public function getUploadDir(){
    return 'uploads/images';
  }

  protected function getUploadRootDir()
  {
    return __DIR__.'/../../../../web/'.$this->getUploadDir();
  }

  public function getWebPath()
  {
    return $this->getUploadDir().'/'.$this->getId().'.'.$this->getUrl();
  }


  /**
* @return integer
*/
  public function getId()
  {
    return $this->id;
  }

  /**
* @param string $url
* @return Image
*/
  public function setUrl($url)
  {
    $this->url = $url;
    return $this;
  }

  /**
* @return string
*/
  public function getUrl()
  {
    return $this->url;
  }

  /**
* @param string $alt
* @return Image
*/
  public function setAlt($alt)
  {
    $this->alt = $alt;
    return $this;
  }

  /**
* @return string
*/
  public function getAlt()
  {
    return $this->alt;
  }

  public function setFile($file)
  {
    $this->file = $file;
    if (null !== $this->url) {
      $this->tempFilename = $this->url;
      $this->url = null;
      $this->alt = null;
    }
  }

  public function getFile()
  {
    return $this->file;
  }

    /**
     * Set dateAjout
     *
     * @param \DateTime $dateAjout
     * @return Images
     */
    public function setDateAjout($dateAjout)
    {
        $this->dateAjout = $dateAjout;
    
        return $this;
    }

    /**
     * Get dateAjout
     *
     * @return \DateTime 
     */
    public function getDateAjout()
    {
        return $this->dateAjout;
    }

    public function __toString() {
        return 'image :'.$this->id;
    }

}