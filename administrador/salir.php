<?php

declare(strict_types=1);

/**
 * Eliminar cookie de sesión
 */
setcookie("VotaDatAdmin", "", time()-3600);

/**
 * Redireccionar página web
 */
header("Location: /administrador");

exit();
