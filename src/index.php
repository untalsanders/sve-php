<?php

declare(strict_types=1);

require "funciones.php";
require 'conexionBD.php';

$db = conectarse();
$institución = execQuery('SELECT * FROM institucion');

if ($institución['activo'] == 'S') {
    if (!isset($_POST['envia_consulta'])) {
        include_once("ingresa.phtml");
    } else {
        /**
         * VALIDACIÓN DE INGRESO AL SISTEMA
         */
        if ($_POST['documento'] != "") {
            $DocEst = $_POST['documento'];
        } else {
            include_once("encabezado.phtml");
            print("<strong>No ha escrito el número de documento<br>");
            print "<br><a href='javascript:history.go(-1)'>Volver al formulario</a></strong></div></body></html>";
            exit();
        }

        /**
         * Se valida la contraseña del estudiante si el sistema la solicita
         */
        if ($institución['clave'] == 'S') {
            if ($_POST['contra'] != "") {
                $ContraEst = md5($_POST['contra']);
            } else {
                include_once("encabezado.phtml");
                print "<strong>No ha escrito la contraseña de acceso<br>";
                print "<br><a href='javascript:history.go(-1)'>Volver al formulario</a></strong></div></body></html>";
                exit();
            }
            $query1 = execQuery(sprintf("SELECT id FROM estudiantes WHERE documento=%s AND clave=%s", comillas($DocEst), comillas($ContraEst)));
            if (!$query1) {
                include_once("encabezado.phtml");
                print "<strong>La contraseña de acceso es inválida<br>";
                print "<br><a href='javascript:history.go(-1)'>Volver al formulario</a></strong></div></body></html>";
                exit();
            }
        }

        /**
         * VALIDAMOS QUE EL ESTUDIANTE NO HAYA VOTADO
         */
        $query2 = execQuery(sprintf("SELECT id_estudiante FROM estudiantes as t1, voto as t2 WHERE t1.documento=%s AND t1.id=t2.id_estudiante", comillas($DocEst)));
        if ($query2) {
            $action = "Intento-IngresoDuplicado";
            logControl($db, $action, $query2['id_estudiante']);
            include_once("encabezado.phtml");
            print "<strong>No puede ingresar</strong><br>Su voto ya está registrado en el sistema.<br>";
            print "<br><strong><a href='javascript:history.go(-1)'>Volver al formulario</a></strong></div></body></html>";
            exit();
        }

        $query3 = execQuery(sprintf("select id,nombres,apellidos,grado from estudiantes where documento=%s", comillas($DocEst)));
        if ($query3) {
            $IdEncrip = md5($query3['id']);
            /**
             * Creamos la cookie
             */
            setcookie("DataVota", $DocEst, time() + 3600);
            echo '<!doctype html">';
            echo '<html>';
            echo '<head>';
            echo '<meta charset="utf-8">';
            echo '<title>' . $institución['institucion'] . ' - Tarjetón de votación</title>';
            echo '<link href="estilo4.css" rel="stylesheet" type="text/css">';
            echo '</head>';
            echo '<body>';
            echo '<div align="center">';
            $action = "Ingreso-" . $DocEst;
            logControl($db, $action, $query3['id']);
            echo '<div class="nombrevota"; font-weight: bold;">ESTUDIANTE: ' . $query3['nombres'] . ' ' . $query3['apellidos'] . '</div>';
            echo '<img src="iconos/EscudoColombia.png" style="display:scroll;position:fixed; top:35px;left:150px;" width="110" alt="Escudo de Colombia" />';
            echo '<img src="iconos/EscudoColegio.png" style="display:scroll;position:fixed; top:35px;right:150px;" width="130" alt="Escudo de Colegio" /><br>';
            //Variable que guarda las categor�as que se muestran en el tarjet�n
            $catarj = "";
            echo '<form name="votacion" action="votacion.php" method="post">';
            echo '<h2>' . $institución['institucion'] . '<br>';
            echo $institución['descripcion'] . '<br></h2>';
            echo '<table style="font-weight:bold";>';
            echo '<thead><tr><th>TARJETÓN ELECTORAL</th></tr></thead>';
            echo '<tr>';
            echo '<td>';
            //Leemos la lista de categor�as que aparecer�n en el tarjet�n
            $query4 = execQuery("SELECT * FROM categorias ORDER BY id");
            while ($query4) {
                // Verificamos si existe un grado con el mismo nombre de la categoría
                // para tener en cuenta para las votaciones de los candidatos por grado.
                $vrep = 0;
                $resp9 = execQuery("select * from grados");
                while ($row9 = $resp9->fetch_array(MYSQLI_ASSOC)) {
                    $grados[$row9["id"]] = $row9["grado"];
                    if (cambiaMayuscula($row5['nombre']) == cambiaMayuscula($row9['grado'])) {
                        $vrep = 1;
                    }
                }
                // Se muestran los candidatos por grado (pertenecen al mismo grado del estudiante) o de otras categorías
                if ((cambiaMayuscula($grados[$row['grado']]) == cambiaMayuscula($row5['nombre']))  or ($vrep == 0)) {
                    //*****Contar el total de candidatos por categoria******//
                    $sql = sprintf("select count(nombres) from candidatos where representante=%d", $row5['id']);
                    $resp8 = $db->query($sql);
                    $row8 = $resp8->fetch_array(MYSQLI_ASSOC);
                    if ($row8['count(nombres)'] > 0) {
                        $catarj = $catarj . $row5['id'] . ",";
                        echo '<div align="center">';
                        echo '<table style="font-weight:bold";>';
                        echo '<thead><tr><th colspan="' . $row8['count(nombres)'] . '" class="vto";>' . $row5['descripcion'] . '</th></tr></thead>';
                        echo '<tr>';
                        # MOSTRAR CANDIDATOS
                        $sql = sprintf("select * from candidatos where representante=%d order by apellidos DESC", $row5['id']);
                        $resp3 = $db->query($sql);
                        while ($row3 = $resp3->fetch_array(MYSQLI_ASSOC)) {
                            echo '<td class="cen cd">';
                            if ((file_exists('fotos/' . $row3['id'] . '.jpg')) || (file_exists('fotos/' . $row3['id'] . '.png')) || (file_exists('fotos/' . $row3['id'] . '.gif'))) {
                                if (file_exists('fotos/' . $row3['id'] . '.jpg')) {
                                    echo '<img src="fotos/' . $row3['id'] . '.jpg" width="100" alt="Candidato" onClick = "document.getElementById (\'candidato' . $row3['id'] . '\').checked = true;" /><br>';
                                } elseif (file_exists('fotos/' . $row3['id'] . '.png')) {
                                    echo '<img src="fotos/' . $row3['id'] . '.png" width="100" alt="Candidato" onClick = "document.getElementById (\'candidato' . $row3['id'] . '\').checked = true;" /><br>';
                                } elseif (file_exists('fotos/' . $row3['id'] . '.gif')) {
                                    echo '<img src="fotos/' . $row3['id'] . '.gif" width="100" alt="Candidato" onClick = "document.getElementById (\'candidato' . $row3['id'] . '\').checked = true;" /><br>';
                                }
                            } else {
                                echo '<img src="fotos/sinfoto.png" alt="Candidato" onClick = "document.getElementById (\'candidato' . $row3['id'] . '\').checked = true;" /><br>';
                            }
                            echo '<input type="radio" name="categoria' . $row5['id'] . '" id ="candidato' . $row3['id'] . '" value="' . $row3['id'] . '" />';
                            echo '<strong>' . $row3['nombres'] . ' ' . $row3['apellidos'] . '</strong>';
                            echo '</td>';
                        }
                        echo '</tr>';
                        echo '</table></div><br>';
                    }
                }
            }
            //***Si el tarjet�n no tiene candidatos se muestra un mensaje
            if ($catarj == "") {
                echo '<strong>No existen candidatos para votar, por favor comuníquese con el administrador del sistema.</strong>';
                echo '</td>';
                echo '</tr>';
                echo '</table>';
                echo '</div><br>';
            } else {
                echo '</td>';
                echo '</tr>';
                echo '</table>';
                echo '</div><br>';
                echo '<div class="cen">';
                echo '<input type="hidden" name="idvoto" value="' . $row['id'] . '">';
                // Eliminamos la última coma "," de la lista de categorías
                $catarj = trim($catarj, ',');
                echo '<input type="hidden" name="catarj" value="' . $catarj . '">';
                echo '<input type="submit" name="envia_voto" value="Votar" title="Registrar voto" />';
                echo '</div>';
            }
            echo '</form>';
            echo '</body>';
            echo '</html>';
        } else {
            setcookie("DataVota", "", time() - 3600);
            include_once("encabezado.phtml");
            $action = "IngresoFallido-" . $DocEst;
            LogControl($db, $action, 0);
            echo '<table>';
            echo '<tr><td class="cen" colspan="2"><strong>El documento escrito no está registrado en el sistema<br><br>';
            print "<strong><a href='javascript:history.go(-1)'>Volver a intentarlo</a></strong></td></tr>";
            echo '</table></div></body></html>';
        }
    }
} else {
    include_once("encabezado.phtml");
}
