<?php
/**
 * Created by PhpStorm.
 * User: Mingjie Deng
 * Date: 2018/2/25
 * Time: 18:54
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
 * Class DataObject
 *
 * This class represents a common data object
 */
abstract class DataObject {

    protected $data = array();

    /**
     * DataObject constructor.
     * @param $data
     */
    public function __construct( $data )
    {
        foreach ( $data as $key => $value ) {
            if ( array_key_exists( $key, $this->data ) )
                $this->data[$key] = $value;
        }
    }

    /**
     * DataObject setter using an array
     * @param $data
     */
    public function setData( $data )
    {
        foreach ( $data as $key => $value ) {
            if ( array_key_exists( $key, $this->data ) )
                $this->data[$key] = $value;
        }
    }

    /**
     * DataObject getter
     *
     * @param $field
     * @return mixed
     */
    public function getValue( $field )
    {
        if ( array_key_exists( $field, $this->data ) ) {
            return $this->data[$field];
        } else {
            die("Field not found");
        }
    }

    /**
     * DataObject getter with html encoding
     *
     * @param $field
     * @return string
     */
    public function getValueEncoded( $field )
    {
        return htmlspecialchars( $this->getValue( $field ) );
    }

    /**
     * Connect to database
     *
     * @return PDO
     */
    protected static function connect()
    {
        try {
            $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
            $conn->setAttribute( PDO::ATTR_PERSISTENT, true );
            $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
        } catch ( PDOException $e ) {
            die("Connection failed: " . $e->getMessage() );
        }
        return $conn;
    }

    /**
     * Disconnect database
     * @param $conn
     */
    protected static function disconnect( $conn )
    {
        $conn = "";
    }
}