<?php
session_start();

// Limpa todas as variáveis de sessão
$_SESSION = array();

// Se desejar destruir completamente a sessão, apaga também o cookie da sessão
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Destroi a sessão
session_destroy();

// Redireciona o usuário para a página de login ou para qualquer outra página desejada
header("Location: ../login-page.html");
exit();
