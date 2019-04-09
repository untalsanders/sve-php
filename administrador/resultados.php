<?php

require_once("../funciones.php");
require_once("../conexionBD.php");

$db = conectarse();

//***Leer variables del sistema******
$estado = $db->query("select * from general");
$leer = $estado->fetch_array(MYSQLI_ASSOC);

//****** Verificamos si existe la cookie *****/
if (isset($_COOKIE['VotaDatAdmin'])) {
    echo '<!DOCTYPE html">';
    echo '<html>';
    echo '<head>';
    echo '<meta charset="utf-8">';
    echo '<title>' . $leer['institucion'] . ' - Resultados votaciones</title>';
    echo '<link href="../estilo4.css" rel="stylesheet" type="text/css">';
    echo '</head>';
    echo '<body>';
    echo '<h1>' . $leer['institucion'] . '</h1>';
    echo '<h2>RESULTADOS DE LAS VOTACIONES</h2>';

    $resp5 = $db->query("select * from categorias");
    while ($row5 = $resp5->fetch_array(MYSQLI_ASSOC)) {
        echo '<div align="center">';
        echo '<p class="txtinicial">RESULTADOS ' . cambiaMayuscula($row5['descripcion']) . '</p>';
        echo '<table>';
        echo '<thead><tr><th>GRADO</th>';
        $resp4 = $db->query(sprintf("select nombres,apellidos from candidatos where representante=%d order by apellidos DESC", $row5['id']));
        $w = 0;
        while ($row4 = $resp4->fetch_array(MYSQLI_ASSOC)) {
            echo '<th>';
            echo $row4['nombres'] . ' ' . $row4['apellidos'];
            echo '</th>';
            $ttl_colum[$w] = 0;
            $w = $w + 1;
        }
        echo '<th>TOTAL</th>';
        echo '</tr></thead>';

        $resp = $db->query("select * from grados");
        $ttl_acum = 0;
        while ($row = $resp->fetch_array(MYSQLI_ASSOC)) {
            $resp2 = $db->query(sprintf("select id from candidatos where representante=%d order by apellidos DESC", $row5['id']));
            echo '<tr>';
            $ContCol = 0;
            $ContRow = 0;
            echo '<td class="cen">' . $row['grado'] . '</td>';
            while ($row2 = $resp2->fetch_array(MYSQLI_ASSOC)) {
                $resp3 = $db->query(sprintf("select count(id_estudiante) from voto,estudiantes where grado=%d and candidato=%d and estudiantes.id=id_estudiante", $row['id'], $row2['id']));
                $row3 = $resp3->fetch_array(MYSQLI_ASSOC);
                echo '<td class="cen">' . $row3['count(id_estudiante)'] . '</td>';
                $ttl_colum[$ContCol] = $ttl_colum[$ContCol] + $row3['count(id_estudiante)'];
                $ContCol = $ContCol + 1;
                $ContRow = $ContRow + $row3['count(id_estudiante)'];
                $ttl_acum = $ttl_acum + $row3['count(id_estudiante)'];
            }
            echo '<td class="cen"><strong>' . $ContRow . '</strong></td>';
            echo '</tr>';
        }
        echo '<tr>';
        echo '<td><strong>TOTAL...</strong></td>';
        for ($i = 0; $i < $ContCol; $i++) {
            echo '<td class="cen"><strong>' . $ttl_colum[$i] . '</strong></td>';
        }
        echo '<td class="cen"><strong>' . $ttl_acum . '</strong></td>';
        echo '</tr>';

        echo '</table>';
        echo '</div>';
    }
    echo '</body>';
    echo '</html>';
} else {
    include_once("encabezado.phtml");
    echo '<table>';
    echo '<tr><td class="cen"><strong>Su sesión ha finalizado, por favor vuelva a ingresar al sistema</strong></td></tr>';
    echo '</table></div></body></html>';
}

$db->close();
