#!/usr/bin/env php
<?php

require_once "bootstrap.php";
$citys = (include "citys.php");
$rand_keys = array_rand( $citys, 1 );
$newPostcard = "Cartão Postal de " . $citys[$rand_keys];
$quantity = rand(1, 10);



$sale = new Sales();
$sale->setProduct_Name($newPostcard);
$sale->setQuantity($quantity);
$sale->setDta_Sale(date("d-m-Y H:i:s"));

$entityManager->persist($sale);
$entityManager->flush();

echo "Created sale with ID " . $sale->getId() . "\n";