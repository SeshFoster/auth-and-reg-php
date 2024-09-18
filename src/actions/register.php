<?php


require_once __DIR__ . '/../helpers.php';

$uploadPath = null;
$name = $_POST['name'] ?? null ;
$email = $_POST['email'] ?? null;
$password = $_POST['password'] ??  null;
$passwordConfirmation = $_POST['password_confirmation']??  null;
$avatar = $_FILES['avatar'] ?? null;

addOldValue('name', $name);

if(empty($name)) {
    addValidationsError('name', 'неверное имя');
}


if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
    addOldValue(key: 'email', value: $email);
    addValidationsError('email', 'Указана неверная почта');
}

if(empty($password)) {
    addValidationsError('password', 'Пароль пустой');
}

if($password != $passwordConfirmation) {
    addValidationsError('password', 'Пароли не совпадают');
}

if(!empty($avatar)) {
    $types = ['image/jpeg', 'image/png'];

    if(!in_array($avatar['type'], $types)) {
        addValidationsError('avatar', 'Изображение профиля имеет не верный формат');
    }

    if(($avatar['size'] / 1000000) >= 1) {
        addValidationsError('avatar', 'Изображение должно быть меньше 1 МБ');
    }
}

if(!empty($_SESSION['validation'])) {
    // redirect('/register.php');
}

if(!empty($avatar)) {
   $avatarPath = uploadFile($avatar, 'avatar');
}

$pdo = getPDO();

$query = "INSERT INTO users (name, email, avatar, password) VALUES (:name, :email, :avatar, :password)";
$params = [
    'name' => $name, 
     'email' => $email,
     'avatar' => $avatarPath,
     'password' => password_hash($password, PASSWORD_DEFAULT)
];

$stmt = $pdo->prepare($query);

try{
    $stmt->execute($params);
} catch(\Exception $e) {
    die($e->getMessage());
}
?>