<?php

class Product {

    private $id;
    private $name;
    private $price;
    private $vat;
    private $quantity;
    private $companyId;

    public function __construct($id) {
        $data = find('products', $id);
        $this->id = $id;
        $this->name = $data['name'];
        $this->price = $data['price'];
        $this->vat = $data['vat'];
        $this->quantity = $data['quantity'];
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
    public function getName() {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getPrice() {
        return $this->price;
    }

    /**
     * @return mixed
     */
    public function getVat() {
        return $this->vat;
    }

    /**
     * @return mixed
     */
    public function getQuantity() {
        return $this->quantity;
    }

    /**
     * @return mixed
     */
    public function getCompanyId() {
        return $this->companyId;
    }

    /**
     * @param mixed $quantity
     */
    public function setQuantity($quantity): void {
        $this->quantity = $quantity;
    }

    /**
     * @param mixed $price
     */
    public function setPrice($price): void {
        $this->price = $price;
    }
}