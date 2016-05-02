<?php
/**
 * @Entity @Table(name="sales")
 **/
class Sales
{
    /** @Id @Column(type="integer") @GeneratedValue **/
    protected $id;
    /** @Column(type="string") **/
    protected $product_name;
    /** @Column(type="integer") **/
    protected $quantity;
    /** @Column(type="datetime") **/
    protected $dta_sale;


    public function getId()
    {
        return $this->id;
    }

    public function getProduct_Name()
    {
        return $this->product_name;
    }
    public function getQuantity()
    {
        return $this->quantity;
    }
    public function getDta_Sale()
    {
        return $this->dta_sale;
    }

    public function setProduct_Name($product_name)
    {
        $this->product_name = $product_name;
    }
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }
    public function setDta_Sale($dta_sale)
    {
        $this->dta_sale = $dta_sale;
    }
}