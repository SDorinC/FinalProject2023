<?php

class Transaction {

    private $id;
    private $partnerName;
    private $partnerRegistrationCode;
    private $transactionNumber;
    private $transactionDate;
    private $companyId;
    private $transactionProducts;
    private $transactionType;
    private $total;
    private $paid;

    public function __construct($id) {
        $data = find('transactions', $id);
        $this->id = $id;
        $this->partnerName = $data['partner_name'];
        $this->partnerRegistrationCode = $data['partner_registration_code'];
        $this->transactionNumber = $data['transaction_number'];
        $this->transactionDate = $data['transaction_date'];
        $this->companyId = $data['company_id'];
        $this->transactionProducts = $data['transaction_products'];
        $this->transactionType = $data['transaction_type'];
        $this->total = $data['total'];
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
    public function getPartnerName() {
        return $this->partnerName;
    }

    /**
     * @return mixed
     */
    public function getPartnerRegistrationCode() {
        return $this->partnerRegistrationCode;
    }

    /**
     * @return mixed
     */
    public function getTransactionNumber() {
        return $this->transactionNumber;
    }

    /**
     * @return mixed
     */
    public function getTransactionDate() {
        return $this->transactionDate;
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
    public function getTransactionProducts() {
        return $this->transactionProducts;
    }

    /**
     * @return mixed
     */
    public function getTransactionType() {
        return $this->transactionType;
    }

    /**
     * @return mixed
     */
    public function getTotal() {
        return $this->total;
    }

    /**
     * @return mixed
     */
    public function getPaid() {
        return $this->paid;
    }


}