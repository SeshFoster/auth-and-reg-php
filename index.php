<?

require_once __DIR__ . '/src/helpers.php';

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

<form class="card" action="src/actions/login.php" method="POST">
    <h2>Вход</h2>

    <? if(hashMessage('error')): ?>
        <div class="notice error"><? echo getMessage('error'); ?></div>
    <? endif; ?>

        <!-- <div class="notice success">Какое-то сообщение</div> -->

    <label for="name">
        Email
        <input
            type="text"
            id="email"
            name="email"
            placeholder="ivan@areaweb.su"
            value="<?php echo old('email'); ?>"
            <?php validationErrorAtern('email'); ?>
        >
        <?php if(hasValidationError('emai')): ?>
        <small><?php validationErrorMessage('email'); ?></small>
        <?php endif; ?>
    </label>

    <label for="password">
        Пароль
        <input
            type="password"
            id="password"
            name="password"
            placeholder="******"
        >
    </label>

    <button
        type="submit"
        id="submit"
    >Продолжить</button>
</form>

<p>У меня еще нет <a href="register.php">аккаунта</a></p>

<script src="assets/app.js"></script>
</body>
</html>