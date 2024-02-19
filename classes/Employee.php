<?php

class Employee {

    private $id;
    private $firstName;
    private $lastName;
    private $personalIdNumber;
    private $grossSalary;
    private $employmentDate;
    private $companyId;
    private $paid;

    public function __construct($id) {
        $data = find('employees', $id);
        $this->id = $id;
        $this->firstName = $data['first_name'];
        $this->lastName = $data['last_name'];
        $this->personalIdNumber = $data['personal_id_number'];
        $this->grossSalary = $data['gross_salary'];
        $this->employmentDate = $data['employment_date'];
        $this->companyId = $data['company_id'];
        $this->paid = $data['paid'];
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
    public function getFirstName() {
        return $this->firstName;
    }

    /**
     * @return mixed
     */
    public function getLastName() {
        return $this->lastName;
    }

    /**
     * @return mixed
     */
    public function getPersonalIdNumber() {
        return $this->personalIdNumber;
    }

    /**
     * @return mixed
     */
    public function getGrossSalary() {
        return $this->grossSalary;
    }

    /**
     * @return mixed
     */
    public function getEmploymentDate() {
        return $this->employmentDate;
    }

    /**
     * @return mixed
     */
    public function getCompanyId() {
        return $this->companyId;
    }

    /**
     * @return mixed
     */
    public function getPaid() {
        return $this->paid;
    }

    /**
     * @param mixed $firstName
     */
    public function setFirstName($firstName): void {
        $this->firstName = $firstName;
    }

    /**
     * @param mixed $lastName
     */
    public function setLastName($lastName): void {
        $this->lastName = $lastName;
    }

    /**
     * @param mixed $personalIdNumber
     */
    public function setPersonalIdNumber($personalIdNumber): void {
        $this->personalIdNumber = $personalIdNumber;
    }

    /**
     * @param mixed $grossSalary
     */
    public function setGrossSalary($grossSalary): void {
        $this->grossSalary = $grossSalary;
    }

    /**
     * @param mixed $employmentDate
     */
    public function setEmploymentDate($employmentDate): void {
        $this->employmentDate = $employmentDate;
    }
}