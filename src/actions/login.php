<?

require_once __DIR__ . '/../helpers.php';

// email -> find() -> user->password == form.password -> auth()

$email = $_POST['email'] ?? null;
$password = $_POST['password'] ?? null;

if(empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    addOldValue('email', $email);
    addValidationsError('email', 'Неверный формат электронной почты');
    setMessage('error', 'Ошибка валидации');
    Header('Location: /web_site/index.php');
}

$user = findUser($email);

if(!$user) {
    setMessage('error', 'Пользователь $email не найден');
    Header('Location: /web_site/index.php');
}

if(!password_verify($password, $user['password'])){
    setMessage('error', 'Неверный пароль');
    Header('Location: /web_site/index.php');
};

$_SESSION['user']['id'] = $user['id'];
Header('Location: /web_site/home.php');