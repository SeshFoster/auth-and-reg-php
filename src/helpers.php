<?php

session_start();

require_once __DIR__ . '/config.php';

function hasValidationError(string $fielName): bool 
{
    return isset($_SESSION['validation'][$fielName]);
}


function addValidationsError(string $fielName, string $message) {
    $_SESSION['validation'][$fielName] = $message;
}

// function redirect(string $path) {
//     header('Location: $path');
//     die();
// }

function validationErrorAtern(string $fielName) {
    echo isset($_SESSION['validation'][$fielName]) ? 'aria-invalid="true"' : '';
}

function validationErrorMessage(string $fielName) {
    $message = $_SESSION['validation'][$fielName] ?? '';
    unset($_SESSION['validation'][$fielName]);
    echo $message;
}

function addOldValue(string $key, mixed $value) {
    $_SESSION['old'][$key] = $value;
}

function old(string $key){ 
    $value = $_SESSION['old'][$key] ?? '';
    unset($_SESSION['old'][$key]);
    return $value;
}

function setMessage(string $key, string $message) {
    $_SESSION['message'][$key] = $message;
}

function hashMessage(string $key): bool {
    return isset($_SESSION['message'][$key]);
}

function findUser(string $email):array|bool {
    $pdo = getPDO();

    $stmt = $pdo->prepare("SELECT * FROM users WHERE `email` = :email");
    $stmt->execute(['email' => $email]);
    return $stmt->fetch(\PDO::FETCH_ASSOC);
}


function getMessage(string $key): string {
    $message = $_SESSION['message'][$key] ?? '';
    unset($_SESSION['message'][$key]);
    return $message;
}

function uploadFile(array $file, string $fielName, string $prefix = "")
{
    $uploadPath = __DIR__ . '../uploads';

    if(!is_dir($uploadPath)) {
        mkdir($uploadPath, 0777, true);
    }

    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    $fielName = $prefix . time() . ".$ext";

    if(!move_uploaded_file($file['tmp_name'], "$uploadPath/$fielName")) {
        die("Ошибка при загрузке файла");
    }

    return "uploads/$fielName";
}

function getPDO():PDO {
    try{
         return new \PDO('mysql:host=' . DB_HOST . ';charset=utf8;dbname=' . DB_NAME, DB_USER, DB_PASSWORD);
    } catch(\PDOException $e) {
        die($e->getMessage());
    }
} 

function currentUser():array|bool {
    $pdo = getPDO();

    if(!isset($_SESSION['user'])) {
        return false;
    }

    $userId = $_SESSION['user']['id'] ?? null;

    $stmt = $pdo->prepare("SELECT * FROM users WHERE `id` = :id");
    $stmt->execute(['id' => $userId]);
    return $stmt->fetch(\PDO::FETCH_ASSOC);
}