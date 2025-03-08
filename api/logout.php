<?php
session_start();

// Удаляем все сессионные переменные
session_unset();

// Уничтожаем сессию
session_destroy();

// Перенаправляем пользователя на страницу логина
header("Location: ../login_page.html");
exit();
