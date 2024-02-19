<?php

class Company {

private $id;
private $name;
private $registrationCode;
private $phone;
private $fullAddress;
private $county;
private $city;
private $dateAdded;

    public function __construct($id) {
        $data = find('companies', $id);
        $this->id = $id;
        $this->name = $data['name'];
        $this->registrationCode = $data['registration_code'];
        $this->phone = $data['phone'];
        $this->fullAddress = $data['full_address'];
        $this->county=$data['county'];
        $this->city=$data['city'];
        $this->dateAdded=$data['date_added'];
    }

    /**
     * @return mixed
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getRegistrationCode() {
        return $this->registrationCode;
    }

    /**
     * @return mixed
     */
    public function getPhone() {
        return $this->phone;
    }

    /**
     * @return mixed
     */
    public function getFullAddress() {
        return $this->fullAddress;
    }

    /**
     * @return mixed
     */
    public function getCounty() {
        return $this->county;
    }

    /**
     * @return mixed
     */
    public function getCity() {
        return $this->city;
    }

    /**
     * @return mixed
     */
    public function getDateAdded() {
        return $this->dateAdded;
    }
}