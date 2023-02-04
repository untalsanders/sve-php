<?php

require_once("../funciones.php");
require_once("../conexionBD.php");

$db = conectarse();

/*
 * Leer variables del sistema
 */
$estado = $db->query("SELECT * FROM general");
$leer = $estado->fetch_array(MYSQLI_ASSOC);

/**
 * Verificamos si existe la cookie
 */
if (isset($_COOKIE['VotaDatAdmin'])) {
    echo '<!doctype html>';
    echo '<html>';
    echo '<head>';
    echo '<meta charset="utf-8">';
    echo '<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale =1">';
    echo '<title>' . $leer['institucion'] . ' - Consulta por grados</title>';
    echo '<link href="../estilo4.css" rel="stylesheet" type="text/css" />';
    echo '</head>';
    echo '<body>';
    echo '<h1>' . $leer['institucion'] . '</h1>';
    echo '<h2>CONSULTA POR GRADOS</h2>';
    echo '<div align="center">';
    echo '<table>';
    echo '<thead><tr><th>GRADO</th><th>REGISTRADOS</th></tr></thead>';
    $ContReg = 0;
    $resp = $db->query("SELECT * FROM grados");
    while ($row = $resp->fetch_array(MYSQLI_ASSOC)) {
        $sql = sprintf("select count(estudiantes.id) as num_estudiantes from estudiantes where grado=%d", $row['id']);
        $resp2 = $db->query($sql);
        $row2 = $resp2->fetch_array(MYSQLI_ASSOC);
        echo '<tr>';
        echo '<td><a href="consulta.php?id=' . $row['id'] . '" title="Clic para consultar ' . $row['grado'] . '">' . $row['grado'] . '</a></td>';
        echo '<td class="cen">' . $row2['num_estudiantes'] . '</td></tr>';
        $ContReg = $ContReg + $row2['num_estudiantes'];
    }
    echo '<tr>';
    echo '<td><strong>Total registrados...</strong></td>';
    echo '<td class="cen"><strong>' . $ContReg . '</strong></td></tr>';
    echo '</table>';
    echo '</div>';
    echo '</body>';
    echo '</html>';
} else {
    include_once("encabezado.phtml");
    echo '<table>';
    echo '<tr><td class="cen"><strong>Su sesi�n ha finalizado, por favor vuelva a ingresar al sistema</strong></td></tr>';
    echo '</table></div></body></html>';
}

$db->close();
