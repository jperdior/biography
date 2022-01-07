<?php

namespace App\Model;

class Product{

    private $id;

    private $name;

    private $description;

    private $amount;

    private $currency;

    private $idPrice;


    public function __construct(){}


    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of idPrice
     */
    public function getIdPrice()
    {
        return $this->idPrice;
    }

    /**
     * Set the value of idPrice
     *
     * @return  self
     */
    public function setIdPrice($idPrice)
    {
        $this->idPrice = $idPrice;

        return $this;
    }

    /**
     * Get the value of description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the value of description
     *
     * @return  self
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get the value of amount
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set the value of amount
     *
     * @return  self
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get the value of currency
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * Set the value of currency
     *
     * @return  self
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;

        return $this;
    }
}