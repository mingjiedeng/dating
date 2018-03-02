<?php
/**
 * Created by PhpStorm.
 * User: Mingjie Deng
 * Date: 2018/2/13
 * Time: 21:48
 */
/*
DROP TABLE IF EXISTS  Members;
CREATE TABLE IF NOT EXISTS `Members` (
    `member_id` MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `fname` VARCHAR(30) NULL,
    `lname` VARCHAR(30) NULL,
    `age` SMALLINT NULL,
    `gender` VARCHAR(10) NULL,
    `phone` VARCHAR(20) NULL,
    `email` VARCHAR(50) NULL,
    `state` VARCHAR(50) NULL,
    `seeking` VARCHAR(10) NULL,
    `bio` VARCHAR(5000) NULL,
    `premium` TINYINT NOT NULL DEFAULT '0',
    `image` VARCHAR(100) NULL,
    `interests` VARCHAR(300) NULL,

  PRIMARY KEY (`member_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
*/
/**
 * Class Member
 *
 * This class represents a member in the dating website
 */
class Member extends DataObject
{
    protected $data = array(
        'member_id' => '',
        'fname' => '',
        'lname' => '',
        'age' => '',
        'gender' => '',
        'phone' => '',
        'email' => '',
        'state' => '',
        'seeking' => '',
        'bio' => '',
        'premium' => '0',
        'image' => '',
        'interests' => ''
    );

    public function setPremiumData($indoorInterests, $outdoorInterests)
    {
        //Set the interests into data field
        $this->data['interests'] = implode(', ', $indoorInterests) . ', ' . implode(',', $outdoorInterests);

        //Upload and save the path of image into data field
        $this->uploadImg();

        //Save the member data into database
        $this->saveToDB();
    }

    public function saveToDB()
    {
        $this->validData();

        $dbh = parent::connect();
        $sql = "INSERT INTO Members (`fname`, `lname`, `age`, `gender`, `phone`, 
                  `email`, `state`, `seeking`, `bio`, `premium`, `image`, `interests`) 
                value (:fname, :lname, :age, :gender, :phone, :email, :state, 
                  :seeking, :bio, :premium, :image, :interests)";

        try {
            $statement = $dbh->prepare($sql);

            $statement->bindValue(':fname', $this->data['fname'], PDO::PARAM_STR);
            $statement->bindValue(':lname', $this->data['lname'], PDO::PARAM_STR);
            $statement->bindValue(':age', $this->data['age'], PDO::PARAM_INT);
            $statement->bindValue(':gender', $this->data['gender'], PDO::PARAM_STR);
            $statement->bindValue(':phone', $this->data['phone'], PDO::PARAM_STR);
            $statement->bindValue(':email', $this->data['email'], PDO::PARAM_STR);
            $statement->bindValue(':state', $this->data['state'], PDO::PARAM_STR);
            $statement->bindValue(':seeking', $this->data['seeking'], PDO::PARAM_STR);
            $statement->bindValue(':bio', $this->data['bio'], PDO::PARAM_STR);
            $statement->bindValue(':premium', $this->data['premium'], PDO::PARAM_INT);
            $statement->bindValue(':image', $this->data['image'], PDO::PARAM_STR);
            $statement->bindValue(':interests', $this->data['interests'], PDO::PARAM_STR);

            $statement->execute();
            parent::disconnect( $dbh );
        } catch ( PDOException $e ) {
            parent::disconnect( $dbh );
            die( "Query failed: " . $e->getMessage() );
        }
    }


    public static function getMembers()
    {
        $dbh = parent::connect();
        $sql = "SELECT * FROM Members ORDER BY lname";

        try {
            $statement = $dbh->prepare($sql);
            $statement->execute();
            $members = array();
            foreach ( $statement->fetchAll() as $row ) {
                $members[] = new Member( $row );
            }
            parent::disconnect( $dbh );
            return $members;
        } catch ( PDOException $e ) {
            parent::disconnect( $dbh );
            die( "Query failed: " . $e->getMessage() );
        }
    }

    public static function getMember($id)
    {
        $dbh = parent::connect();
        $sql = "select * from Members where member_id = :id";

        try {
            $statement = $dbh->prepare($sql);
            $statement->bindParam(':id', $id, PDO::PARAM_INT);
            $statement->execute();
            $row = $statement->fetch(PDO::FETCH_ASSOC);
            parent::disconnect( $dbh );
            if ( $row ) return new Member( $row );
        }catch ( PDOException $e ) {
            parent::disconnect( $dbh );
            die( "Query failed: " . $e->getMessage() );
        }
    }

    /**
     * Upload and validate the image,
     * and set up the object field
     */
    function uploadImg()
    {
        //Validate the uploaded image
        if ($_FILES['fileToUpload']['error'] != 4) {
            $target_dir = "images/";
            $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);

            //Assign the path of image to object field if validated
            if ($this->validImg($_FILES['fileToUpload']) && !file_exists($target_file)) {
                move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
                $this->data['image'] = $target_file;
            } else {
                $this->data['image'] = "";
            }
        }
    }

    function validData(){
        if (!$this->validName($this->data['fname']))
            $this->data['fname'] = "";

        if (!$this->validName($this->data['lname']))
            $this->data['lname'] = "";

        if (!$this->validAge($this->data['age']))
            $this->data['age'] = "";

        if (!$this->validPhone($this->data['phone']))
            $this->data['phone'] = "";
    }

    /**
     * @param $name
     * @return bool
     */
    function validName($name)
    {
        return !empty($name) && ctype_alpha($name);
    }

    /**
     * @param $age
     * @return bool
     */
    function validAge($age)
    {
        return ctype_digit($age) && $age >= 18;
    }

    /**
     * @param $phone
     * @return bool
     */
    function validPhone($phone)
    {
        //Eliminate all the non digit char
        $phone = preg_replace('/[^\d]/', '', $phone);

        return (strlen($phone) == 10 || (strlen($phone) == 11 && preg_match('/^1/', $phone)));
    }

    /**
     * @param $uploadFile
     * @return bool
     */
    function validImg($uploadFile)
    {
        return ($uploadFile["error"] == 0 &&
            ($uploadFile["type"] == "image/gif" ||
                $uploadFile["type"] == "image/jpeg" ||
                $uploadFile["type"] == "image/png") &&
            $uploadFile["size"] < 500000
        );
    }
}