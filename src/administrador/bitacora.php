<?php

require_once("../funciones.php");
require_once("../conexionBD.php");

$db = conectarse();

//***Leer variables del sistema******

$estado = $db->query("select * from general");
$leer = $estado->fetch_array(MYSQLI_ASSOC);
//****** Verificamos si existe la cookie *****/
if (isset($_COOKIE['VotaDatAdmin'])) {
    echo '<!DOCTYPE html>';
    echo '<html>';
    echo '<head>';
    echo '<meta charset="utf-8">';
    echo '<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">';
    echo '<title>' . $leer['institucion'] . ' - Bit�cora del sistema</title>';
    echo '<link href="../estilo4.css" rel="stylesheet" type="text/css" />';
    echo '</head>';
    echo '<body>';
    echo '<h1>' . $leer['institucion'] . '</h1>';
    echo '<h2>BITÁCORA DEL SISTEMA</h2>';
    echo '<div align="center">';
    //*****Seleccionar fecha********
    echo '<table><tr><td class="center">';
    echo '<form name="bitacora" action="bitacora.php" method="post">';
    echo '<strong>Seleccione una fecha </strong>';
    $ffdia = date("d");
    echo '<label for="fdia">Día:</label>';
    echo '<select name="fdia" title="Seleccione el d�a">';
    for ($i = 1; $i <= 31; $i++) {
        if ($i == $ffdia) {
            echo '<option value="' . $i . '" selected>' . $i . '</option>';
        } else {
            echo '<option value="' . $i . '">' . $i . '</option>';
        }
    }
    echo '</select> ';

    $ffmes = date("m");
    echo '<label for="fmes">Mes:</label>';
    echo '<select name="fmes" title="Seleccione el mes">';
    for ($i = 1; $i <= 12; $i++) {
        if ($i == $ffmes) {
            echo '<option value="' . $i . '" selected>' . $i . '</option>';
        } else {
            echo '<option value="' . $i . '">' . $i . '</option>';
        }
    }
    echo '</select> ';

    $ffano = date("Y");
    echo '<label for="fano">Año:</label>';
    echo '<select name="fano" title="Seleccione el año">';
    for ($i = $ffano; $i >= 1990; $i--) {
        echo '<option value="' . $i . '">' . $i . '</option>';
    }
    echo '</select> ';
    echo '<input type="submit" name="envia_reg" value="Ok" title="Ver registros de la fecha seleccionada" /></form>';
    echo '</td></tr></table>';
    //*****Muestra tabla con registros del sistemas *******
    if (isset($_POST['envia_reg'])) {
        $ContReg = 0;
        $fecha = $_POST['fano'] . '-' . $_POST['fmes'] . '-' . $_POST['fdia'];
        echo '<br><p class="cen"><strong>Registros fecha: ';
        echo $_POST['fdia'] . '/' . $_POST['fmes'] . '/' . $_POST['fano'];
        echo '</strong></p><table>';
        echo '<thead><tr><th>No.</th><th>Hora</th><th>IP</th><th>Acción</th><th>ID</th></tr></thead>';
        $resp = $db->query(sprintf("select * from control where c_fecha=%s", comillas($fecha)));
        while ($row = $resp->fetch_array(MYSQLI_ASSOC)) {
            $ContReg = $ContReg + 1;
            echo '<tr>';
            echo '<td class="cen">' . $ContReg . '</td>';
            echo '<td class="cen">' . $row['c_hora'] . '</td>';
            echo '<td class="cen">' . $row['c_ip'] . '</td>';
            echo '<td>' . $row['c_accion'] . '</td>';
            echo '<td class="cen">' . $row['c_idest'] . '</td>';
            echo '</tr>';
        }
        if ($ContReg == 0) {
            echo '<tr><td class="cen" colspan="5"><strong>No existen registros para esta fecha</strong></td></tr>';
        }
    }
    echo '</table><br>';
    echo '</div>';
    echo '</body>';
    echo '</html>';
} else {
    include_once("encabezado.phtml");
    echo '<table>';
    echo '<tr><td class="cen"><strong>Su sesión ha finalizado, por favor vuelva a ingresar al sistema</strong></td></tr>';
    echo '</table></div></body></html>';
}

$db->close();
