<?php

class FinancialTransaction {

    private $id;
    private $description;
    private $value;
    private $day;
    private $month;
    private $year;
    private $type;
    private $companyId;

    public function __construct($id) {
        $data = find('paymentsAndRevenue', $id);
        $this->id = $id;
        $this->description = $data['description'];
        $this->value = $data['value'];
        $this->day = $data['day'];
        $this->month = $data['month'];
        $this->year = $data['year'];
        $this->type = $data['type'];
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
    public function getDescription() {
        return $this->description;
    }

    /**
     * @return mixed
     */
    public function getValue() {
        return $this->value;
    }

    /**
     * @return mixed
     */
    public function getDay() {
        return $this->day;
    }

    /**
     * @return mixed
     */
    public function getMonth() {
        return $this->month;
    }

    /**
     * @return mixed
     */
    public function getYear() {
        return $this->year;
    }

    /**
     * @return mixed
     */
    public function getType() {
        return $this->type;
    }

    /**
     * @return mixed
     */
    public function getCompanyId() {
        return $this->companyId;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description): void {
        $this->description = $description;
    }

    /**
     * @param mixed $value
     */
    public function setValue($value): void {
        $this->value = $value;
    }


}