<?php
class Order {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function add($username, $restaurant, $count_order, $type_pay, $type_boxing) {
        $stmt = $this->pdo->prepare(
            "INSERT INTO orders (username, restaurant, count_order, type_pay, type_boxing) VALUES (?, ?, ?, ?, ?)"
        );
        $stmt->execute([$username, $restaurant, $count_order, $type_pay, $type_boxing]);
    }

    public function getAll() {
        $stmt = $this->pdo->query("SELECT * FROM orders");
        return $stmt->fetchAll();
    }
}