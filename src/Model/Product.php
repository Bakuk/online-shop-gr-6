<?php

namespace Model;

use Core\src\Model\Model;

class Product extends Model
{
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
            $productAll[] = new Product($product['id'], $product['title'],
                                        $product['price'], $product['descr'],
                                        $product['pictures']);
        }

        return  $productAll;
    }

    /**
     * @param $userId
     * @return Product[]
     */
    public static function getAllByUserId(int $userId): array
    {
        $sql = <<<SQL
                SELECT * FROM products p
                    INNER JOIN user_products up
                ON p.id = up.product_id
                    WHERE up.user_id = :user_id;
        SQL;

        $stmt = self::getPDO()->prepare($sql);
        $stmt->execute(['user_id' => $userId]);

        $data = $stmt->fetchAll();
        $productUser = [];
        foreach ($data as $product){
            $productUser[$product['id']] = new Product($product['id'],
                                                $product['title'],
                                                $product['price'],
                                                $product['descr'],
                                                $product['pictures']);
        }
        return $productUser;
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

    private function hydrateAll(array $data): array
    {

    }

}