<?php
session_start();
$username = htmlspecialchars($_POST['username']);
$count_order = htmlspecialchars($_POST['count_order'] ?? '');
$restaurant = htmlspecialchars($_POST['restaurant'] ?? '');
$type_pay = isset($_POST['type_pay']) ? 1 : 0;
$type_boxing = htmlspecialchars($_POST['type_boxing'] ?? '');

$errors = [];
if (empty($username)) {
    $errors[] = "Имя не может быть пустым";
}
if (!filter_var($count_order, FILTER_VALIDATE_INT)) {
    $errors[] = "Некорректное количество блюд";
}
if (empty($restaurant)) {
    $errors[] = "Выберите ресторан";
}
if (empty($type_boxing)) {
    $errors[] = "Выберите тип коробки";
}

if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
    header("Location: index.php");
    exit();
}

require_once 'ApiClient.php';
$api = new ApiClient();

$url = 'https://www.themealdb.com/api/json/v1/1/random.php'; 
$apiData = $api->request($url);

$_SESSION['api_data'] = $apiData;


$_SESSION['username'] = $username;
$_SESSION['count_order'] = $count_order;
$line = $username . ";" . $count_order . ";" . $restaurant . ";" . $type_pay . ";" . $type_boxing . "\n";
file_put_contents("data.txt", $line, FILE_APPEND);

require 'db.php';
require 'Order.php';

$order = new Order($pdo);
$order->add($username, $restaurant, $count_order, $type_pay, $type_boxing);

header("Location: index.php");
exit();
