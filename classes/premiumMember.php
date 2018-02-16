<?php
/**
 * Created by PhpStorm.
 * User: Mingjie Deng
 * Date: 2018/2/13
 * Time: 22:05
 */

/**
 * Class PremiumMember
 *
 * This class represents a premium member in the dating website.
 */
class PremiumMember extends Member
{
    private $_inDoorInterests;
    private $_outDoorInterests;
    private $_photoPath;

    /**
     * PremiumMember constructor.
     */
    public function __construct($fname, $lname, $age, $gender, $phone)
    {
        parent::__construct($fname, $lname, $age, $gender, $phone);
    }

    /**
     * @return array
     */
    public function getInDoorInterests()
    {
        return $this->_inDoorInterests;
    }

    /**
     * @param array  $inDoorInterests
     */
    public function setInDoorInterests($inDoorInterests)
    {
        $this->_inDoorInterests = $inDoorInterests;
    }

    /**
     * @return array
     */
    public function getOutDoorInterests()
    {
        return $this->_outDoorInterests;
    }

    /**
     * @param array  $outDoorInterests
     */
    public function setOutDoorInterests($outDoorInterests)
    {
        $this->_outDoorInterests = $outDoorInterests;
    }

    /**
     * @return String
     */
    public function getPhotoPath()
    {
        return $this->_photoPath;
    }

    /**
     * @param String $photoPath
     */
    public function setPhotoPath($photoPath)
    {
        $this->_photoPath = $photoPath;
    }
}