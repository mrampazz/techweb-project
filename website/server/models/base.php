<?php

// base class with member properties and methods
class Base 
{
    const ID_KEY = "id";
    const CREATED_KEY = "created_at";
    const UPDATED_KEY = "updated_at";

    var $id;
    var $createdAt;
    var $updatedAt;

    public function __set( $name, $value ) {
        switch ($name)
        {
            case self::ID_KEY: 
                $this->id = $value;
                break;
            case self::CREATED_KEY: 
                $this->createdAt = $value;
                break;
            case self::UPDATED_KEY: 
                $this->updatedAt = $value;
                break;
            default: break;
        }
    }
}

?>