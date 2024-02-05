<?php

namespace Model;

use Controller\ProductController;

class Product extends Model  {

    private int $id;
    private string $title;
    private string $price;
    private string $desr;
    private  string $pictures;

    public function __construct(int $id, string $title, string $price, string $desr, string $pictures)
    {
        $this->id = $id;
        $this->title = $title;
        $this->price = $price;
        $this->desr = $desr;
        $this->pictures = $pictures;
    }

    public static function getAll(): array {

        $stmt = self::getPDO()->query('SELECT * FROM products');
        $data = $stmt->fetchAll();
        $productAll = [];
        foreach ($data as $product){
            $productAll[] = new Product($product['id'], $product['title'], $product['price'], $product['descr'], $product['pictures']);
        }

        return  $productAll;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getPrice(): string
    {
        return $this->price;
    }

    public function getDesr(): string
    {
        return $this->desr;
    }

    public function getPictures(): string
    {
        return $this->pictures;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function setPrice(string $price): void
    {
        $this->price = $price;
    }

    public function setDesr(string $desr): void
    {
        $this->desr = $desr;
    }

    public function setPictures(string $pictures): void
    {
        $this->pictures = $pictures;
    }
}