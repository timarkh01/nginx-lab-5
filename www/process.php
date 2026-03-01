<?php
session_start();
$username = htmlspecialchars($_POST['username']);
$count_order = htmlspecialchars($_POST['count_order'] ?? '');

$errors = [];
if(empty($username)) $errors[] = "Имя не может быть пустым";
if(!filter_var($count_order, FILTER_VALIDATE_INT)) $errors[] = "Некорректный count_order";

if(!empty($errors)){
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
$line = $username . ";" . $count_order . "\n";
file_put_contents("data.txt", $line, FILE_APPEND);
header("Location: index.php");
exit();
