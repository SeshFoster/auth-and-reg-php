<?

require_once __DIR__ . '/src/helpers.php';

$user = currentUser();

?>

<!DOCTYPE html>
<html lang="ru" data-theme="light">
<head>
    <meta charset="UTF-8">
    <title>AreaWeb - авторизация и регистрация</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@1/css/pico.min.css">
    <link rel="stylesheet" href="assets/app.css">
</head>
<body>

<div class="card home">
    <img
        class="avatar"
        src="<? echo $user['avatar']; ?>"
        alt="<? echo $user['name']; ?>"
    >
    <h1>Привет, <? echo $user['name']; ?></h1>
    <a href="#" role="button">Выйти из аккаунта</a>
</div>

<script src="assets/app.js"></script>
</body>
</html>