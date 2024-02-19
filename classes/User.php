<?php

class User {

    private $id;
    private $username;
    private $password;
    private $accessLevel;
    private $companyId;

    public function __construct($id) {
        $data = find('users', $id);
        $this->id = $id;
        $this->username = $data['username'];
        $this->password = $data['password'];
        $this->accessLevel = $data['access_level'];
        $this->companyId = $data['company_id'];
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
    public function getUsername() {
        return $this->username;
    }

    /**
     * @return mixed
     */
    public function getPassword() {
        return $this->password;
    }

    /**
     * @return mixed
     */
    public function getAccessLevel() {
        return $this->accessLevel;
    }

    /**
     * @return mixed
     */
    public function getCompanyId() {
        return $this->companyId;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password): void {
        $this->password = $password;
    }
}