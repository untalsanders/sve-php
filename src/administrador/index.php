<?php

declare(strict_types=1);

require APP_ROOT . '/src/funciones.php';

$institución = execQuery('SELECT * FROM institucion');

if (!isset($_POST['envia_acceso'])) {
    include_once("ingreso.phtml");
} else {
    /**
     * VALIDACION DE INGRESO AL SISTEMA
     */
    if ($_POST['usuario'] == "") {
        include_once("encabezado.phtml");
        print "<strong>No ha escrito el nombre de usuario<br>";
        print "<br/><a href='javascript:history.go(-1)'>Volver al formulario</a></strong></div></body></html>";
        exit();
    }

    if ($_POST['clave'] == "") {
        include_once("encabezado.phtml");
        print "<strong>No ha escrito la contraseña de acceso<br>";
        print "<br><a href='javascript:history.go(-1)'>Volver al formulario</a></strong></div></body></html>";
        exit();
    }
    $clave = md5($_POST['clave']);

    try {
        $administradores = execQuery(sprintf("SELECT id, nombres, apellidos FROM administradores WHERE usuario = %s AND password = %s", comillas($_POST['usuario']), comillas($clave)));
    } catch (Exception $e) {
        print($e->getMessage());

    }

    if (count($administradores) > 0) {
        //**** Creamos la cookie
        setcookie("VotaDatAdmin", $administradores['id'], time() + 3600);
        echo '<!doctype html>';
        echo '<html>';
        echo '<head>';
        echo '<meta charset="utf-8">';
        echo '<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">';
        echo '<title>' . $institución['nombre'] . ' - Administración SVE</title>';
        echo '</head>';
        echo '<body>';
        echo '<div align="center">';
        $accion = "Ingreso_Admin-" . $_POST['usuario'];
        logControl($accion, $administradores['id']);
        echo '<h2>Bienvenido(A): ' . $administradores['nombres'] . ' ' . $administradores['apellidos'] . '</h2>';
        echo '<table style="font-weight:bold";>';
        echo '<thead><tr><th>MENÚ DE ADMINISTRACIÓN</th></tr></thead>';
        echo '<tr><td><a href="resultados.php" title="Consultar resultados de votación"><img src="assets/icons/box.png" border="0" alt="Folder" /> Resultados de votación</a></td></tr>';
        echo '<tr><td><a href="general.php" title="Consulta de estudiantes por grado"><img src="assets/icons/folder.png" border="0" alt="Folder" /> Consulta de estudiantes por grado</a></td></tr>';
        if ($administradores['id'] == 1) {
            echo '<tr><td><a href="candidatos.php" title="Candidatos"><img src="assets/icons/datos.png" border="0" alt="Folder" /> Lista de Candidatos</a></td></tr>';
            echo '<tr><td><a href="importar.php" title="Importar datos"><img src="assets/icons/book.png" border="0" alt="Datos" /> Importar datos estudiantes</a></td></tr>';
            echo '<tr><td><a href="administradores.php?id=' . md5($administradores['id']) . ')" title="Administradores del sistema"><img src="assets/icons/users.png" border="0" alt="Datos" /> Administradores del sistema</a></td></tr>';
            echo '<tr><td><a href="configuraciones.php" title="Configuración general"><img src="assets/icons/hoja.png" border="0" alt="Config" /> Configuración general</a></td></tr>';
        }
        echo '<tr><td><a href="bitacora.php" title="Bitácora del sistema"><img src="assets/icons/find.png" border="0" alt="bitácora" /> Bitácora del sistema</a></td></tr>';
        echo '<tr><td><a href="cambiarclave.php?id=' . md5($administradores['id']) . ')" title="Cambiar contraseña de acceso"><img src="assets/icons/clave.png" border="0" alt="Clave" /> Cambiar contraseña</a></td></tr>';
        echo '<tr><td><a href="/salir" title="Salir del sistema"><img src="assets/icons/salir.png" border="0" alt="Salir" /> Salir del sistema</a></td></tr>';
        echo '</table>';
        echo '</div>';
        echo '<script src="assets/js/bundle.js"></script>';
        echo '</body>';
        echo '</html>';
    } else {
        setcookie("VotaDatAdmin", "", time() - 3600);
        include_once("encabezado.phtml");
        $accion = "Fallido_Admin-" . $_POST['usuario'];
        logControl($accion, 0);
        echo '<table>';
        echo '<tr><td class="cen" colspan="2"><strong>Datos de ingreso inválidos<br><br>';
        echo '<a href="javascript:history.go(-1)">Volver a intentar</a></strong></td></tr>';
        echo '</table></div></body></html>';
    }
}
