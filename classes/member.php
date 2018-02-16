<?php
/**
 * Created by PhpStorm.
 * User: Mingjie Deng
 * Date: 2018/2/13
 * Time: 21:48
 */

/**
 * Class Member
 *
 * This class represents a member in the dating website
 */
class Member
{
    protected $fname;
    protected $lname;
    protected $age;
    protected $gender;
    protected $phone;
    protected $email;
    protected $state;
    protected $seeking;
    protected $bio;

    /**
     * Member constructor.
     *
     * @param $fname first name
     * @param $lname last name
     * @param $age   age by integer
     * @param $gender gender
     * @param $phone phone
     */
    function __construct($fname, $lname, $age, $gender, $phone)
    {
        $this->fname = $fname;
        $this->lname = $lname;
        $this->age = $age;
        $this->gender = $gender;
        $this->phone = $phone;
    }

    /**
     * @return String first name
     */
    public function getFname()
    {
        return $this->fname;
    }

    /**
     * @param String $fname
     */
    public function setFname($fname)
    {
        $this->fname = $fname;
    }

    /**
     * @return String
     */
    public function getLname()
    {
        return $this->lname;
    }

    /**
     * @param String $lname
     */
    public function setLname($lname)
    {
        $this->lname = $lname;
    }

    /**
     * @return int
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * @param int $age
     */
    public function setAge($age)
    {
        $this->age = $age;
    }

    /**
     * @return String
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * @param String $gender
     */
    public function setGender($gender)
    {
        $this->gender = $gender;
    }

    /**
     * @return String
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param String $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * @return String
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param String $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return String
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param String $state
     */
    public function setState($state)
    {
        $this->state = $state;
    }

    /**
     * @return String
     */
    public function getSeeking()
    {
        return $this->seeking;
    }

    /**
     * @param String $seeking
     */
    public function setSeeking($seeking)
    {
        $this->seeking = $seeking;
    }

    /**
     * @return String
     */
    public function getBio()
    {
        return $this->bio;
    }

    /**
     * @param String $bio
     */
    public function setBio($bio)
    {
        $this->bio = $bio;
    }
    
}