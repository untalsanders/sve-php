<?php

require "../conexionBD.php";
require "../funciones.php";

$institución = execQuery('SELECT * FROM institucion');

//****** Verificamos si existe la cookie *****/
if (isset($_COOKIE['VotaDatAdmin'])) {

    //******Verificar que existan categorías para crear candidatos
    $categorias = execQuery("SELECT * FROM categorias");
    if (!$categorias) {
        include_once("encabezado.phtml");
        print "<strong>Debe crear primero las categorias de votación<br>";
        exit();
    }

    //****Agregar nuevo candidato*******
    if (isset($_POST['envia_candi'])) {
        if ((borraEspacios($_POST['nombres_candi']) != "") and (borraEspacios($_POST['representante_candi']) != "")) {
            $fnombres_candi = cambiaMayuscula($_POST['nombres_candi']);
            $fapellidos_candi = cambiaMayuscula($_POST['apellidos_candi']);
            $frepresentante_candi = $_POST['representante_candi'];
        } else {
            include_once("encabezado.phtml");
            print "<strong>Debe llenar todos los campos<br>";
            print "<br><a href='javascript:history.go(-1)'>Volver al formulario</a></strong></div></body></html>";
            exit();
        }

        //******Guardamos los datos en la BD ******
        $query  = sprintf("INSERT INTO candidatos (nombres,apellidos,representante) VALUES(%s,%s,%d)", comillas($fnombres_candi), comillas($fapellidos_candi), $frepresentante_candi);
        execQuery($query);

        //****obtener el id del candidato  guardado
        $id_candi = $db->insert_id;

        //******Guardamos los datos de control ******
        $ffecha = date("Y-m-d");
        $fhora = date("G:i:s");
        $fip = $_SERVER['REMOTE_ADDR'];
        $faccion = "Admin_Crea_Candidato (id:" . $id_candi . ")";
        $cons_sql5  = sprintf("INSERT INTO control(c_fecha,c_hora,c_ip,c_accion,c_idest) VALUES(%s,%s,%s,%s,%d)", comillas($ffecha), comillas($fhora), comillas($fip), comillas($faccion), $_COOKIE['VotaDatAdmin']);
        $db->query($cons_sql5);
    }
    //****Actualizar información de candidato*******
    if (isset($_POST['edita_candi'])) {
        if (($_POST['nombres_candi'] != "") and ($_POST['representante_candi'] != "")) {
            $fnombres_candi = borraEspacios($_POST['nombres_candi']);
            $fapellidos_candi = cambiaMayuscula(borraEspacios($_POST['apellidos_candi']));
            $frepresentante_candi = $_POST['representante_candi'];
        } else {
            include_once("encabezado.phtml");
            print "<strong>Debe llenar todos los campos<br>";
            print "<br><a href='javascript:history.go(-1)'>Volver al formulario</a></strong></div></body></html>";
            exit();
        }
        //****Actualizar en la BD*******
        $cons_sql3  = sprintf("UPDATE candidatos SET nombres=%s, apellidos=%s, representante=%d WHERE id=%d", comillas($fnombres_candi), comillas($fapellidos_candi), $frepresentante_candi, $_POST['identificador']);
        $db->query($cons_sql3);

        //******Guardamos los datos de control ******
        $ffecha = date("Y-m-d");
        $fhora = date("G:i:s");
        $fip = $_SERVER['REMOTE_ADDR'];
        $faccion = "Admin_Actualiza_Candidato (id:" . $_POST['identificador'] . ")";
        $cons_sql5  = sprintf("INSERT INTO control(c_fecha,c_hora,c_ip,c_accion,c_idest) VALUES(%s,%s,%s,%s,%d)", comillas($ffecha), comillas($fhora), comillas($fip), comillas($faccion), $_COOKIE['VotaDatAdmin']);
        $db->query($cons_sql5);
    }
    echo '<!DOCTYPE html>';
    echo '<html>';
    echo '<head>';
    echo '<meta charset="utf-8">';
    echo '<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">';
    echo '<title>' . $institución['nombre'] . ' - Lista de candidatos</title>';
    echo '<link href="../estilo4.css" rel="stylesheet" type="text/css" />';
    echo '</head>';
    echo '<body>';
    echo '<h1>' . $institución['nombre'] . '</h1>';
    echo '<h2>LISTA DE CANDIDATOS</h2>';
    echo '<div align="center">';

    /*
     * Formulario para agregar candidato
     */
    if ((isset($_GET['agrega'])) and ($_GET['agrega'] == "ok")) {
        echo '<form name="addcandi" action="candidatos.php" method="post">';
        echo '<table>';
        echo '<tr>';
        echo '<td style="text-align:right;"><label for="nombres_candi">';
        echo '<strong>Nombres:</strong>';
        echo '</label></td>';
        echo '<td><input type="text" name="nombres_candi" size="30" maxlength="50" title="Escriba los nombres del candidato" />';
        echo '</td></tr>';
        echo '<tr>';
        echo '<td style="text-align:right;"><label for="apellidos_candi">';
        echo '<strong>Apellidos:</strong>';
        echo '</label></td>';
        echo '<td><input type="text" name="apellidos_candi" size="30" maxlength="50" title="Escriba los apellidos del candidato" />';
        echo '</td></tr>';

        echo '<tr>';
        echo '<td style="text-align:right;"><label for="representante_candi">';
        echo '<strong>Representante para:</strong>';
        echo '</label></td>';
        echo '<td><select name="representante_candi" title="Seleccione el tipo de representante.">';
        $resp7 = $db->query("SELECT * FROM categorias");
        while ($row7 = $resp7->fetch_array(MYSQLI_ASSOC)) {
            echo '<option value="' . $row7['id'] . '">' . $row7['nombre'] . '</option>';
        }
        echo '</select></td></tr>';

        echo '<tr><td class="cen" colspan="2"><input type="submit" name="envia_candi" value="Guardar" title="Agregar candidato" />&nbsp&nbsp&nbsp&nbsp';
        echo '<input type="button" name="Cancel" value="Cancelar" onclick="window.location =\'candidatos.php\' "/></td></tr>';
        echo '</form></table>';
    } else {
        echo '<div class="cen">';
        echo '<strong><a href="candidatos.php?agrega=ok" title="Agregar candidato">Agregar candidato</a></strong>';
        echo '</div>';
    }

    /*
     * Formulario para editar candidato
     */
    if ((isset($_GET['id'])) and (isset($_GET['editar'])) and ($_GET['editar'] == "ok")) {
        $resp4 = $db->query(sprintf("SELECT * FROM candidatos WHERE md5(id)=%s", comillas($_GET['id'])));
        if ($row4 = $resp4->fetch_array(MYSQLI_ASSOC)) {
            echo '<br><form name="editacandi" action="candidatos.php" method="post">';
            echo '<table>';
            echo '<tr>';
            echo '<td style="text-align:right;"><label for="nombres_candi">';
            echo '<strong>Nombres:</strong>';
            echo '</label></td>';
            echo '<td><input type="text" name="nombres_candi" value="' . $row4['nombres'] . '" size="30" maxlength="50" title="Escriba los nombres del candidato" />';
            echo '</td></tr>';
            echo '<tr>';
            echo '<td style="text-align:right;"><label for="apellidos_candi">';
            echo '<strong>Apellidos:</strong>';
            echo '</label></td>';
            echo '<td><input type="text" name="apellidos_candi" value="' . $row4['apellidos'] . '" size="30" maxlength="50" title="Escriba los apellidos del candidato" />';
            echo '</td></tr>';

            echo '<tr>';
            echo '<td style="text-align:right;"><label for="representante_candi">';
            echo '<strong>Representante para:</strong>';
            echo '</label></td>';
            echo '<td><select name="representante_candi" title="Seleccione el tipo de representante.">';
            $resp7 = $db->query("SELECT * FROM categorias");
            while ($row7 = $resp7->fetch_array(MYSQLI_ASSOC)) {
                if ($row4['representante'] == $row7['id']) {
                    echo '<option value="' . $row7['id'] . '" selected>' . $row7['nombre'] . '</option>';
                } else {
                    echo '<option value="' . $row7['id'] . '">' . $row7['nombre'] . '</option>';
                }
            }

            echo '</select></td></tr>';

            echo '<input type="hidden" name="identificador" value="' . $row4['id'] . '" />';

            echo '<tr><td class="cen" colspan="2"><input type="submit" name="edita_candi" value="Guardar" title="Agregar Candidato" />&nbsp&nbsp&nbsp&nbsp';
            echo '<input type="button" name="Cancel" value="Cancelar" onclick="window.location =\'candidatos.php\' "/></td></tr>';
            echo '</form></table>';
        } else {
            echo '<table>';
            echo '<tr><td class="cen"><strong>No hay datos de candidatos</strong></td></tr>';
            echo '</table>';
        }
    }

    /*
     * Mostrar mensaje para borrar candidato
     */
    if ((isset($_GET['id'])) and (isset($_GET['elimina'])) and ($_GET['elimina'] == "0")) {
        $resp5 = $db->query(sprintf("SELECT * FROM candidatos WHERE md5(id)=%s", comillas($_GET['id'])));
        if ($row5 = $resp5->fetch_array(MYSQLI_ASSOC)) {
            //Verificar que no existan votos para borrar el candidato
            $resp3 = $db->query(sprintf("SELECT id from voto WHERE candidato=%d", $row5['id']));
            if (!$row3 = $resp3->fetch_array(MYSQLI_ASSOC)) {
                echo '<br><div class="cen"><strong>';
                echo '¿Desea borrar el candidato ' . $row5['nombres'] . ' ' . $row5['apellidos'] . ' del sistema? ';
                echo '<a href="candidatos.php?id=' . $_GET['id'] . '&elimina=1" title="Borrar candidato del sistema">Si</a>&nbsp&nbsp&nbsp&nbsp';
                echo '<a href="candidatos.php" title="Cancelar la eliminación del candidato">No</a>';
                echo '</strong></div>';
            } else {
                echo '<br><strong>Advertencia: No puede borrar el candidato ' . $row5['nombres'] . ' ' . $row5['apellidos'] . ', ya que existen votos para él.</strong>';
            }
        } else {
            echo '<table>';
            echo '<tr><td class="cen"><strong>No hay datos para el candidato</strong></td></tr>';
            echo '</table>';
        }
    }

    /*
     * Eliminar candidato
     */
    if ((isset($_GET['id'])) and (isset($_GET['elimina'])) and ($_GET['elimina'] == "1")) {
        $resp6 = $db->query(sprintf("SELECT * FROM candidatos WHERE md5(id)=%s", comillas($_GET['id'])));
        $row6 = $resp6->fetch_array(MYSQLI_ASSOC);
        ($resp6);
        $resp2 = $db->query(sprintf("DELETE FROM candidatos WHERE md5(id)=%s", comillas($_GET['id'])));

        //Borrar archivo de la foto del candidato
        if (file_exists("../fotos/" . $row6['id'] . ".jpg")) {
            unlink("../fotos/" . $row6['id'] . ".jpg");
        }
        if (file_exists("../fotos/" . $row6['id'] . ".png")) {
            unlink("../fotos/" . $row6['id'] . ".png");
        }
        if (file_exists("../fotos/" . $row6['id'] . ".gif")) {
            unlink("../fotos/" . $row6['id'] . ".gif");
        }

        //******Guardamos los datos de control ******
        $ffecha = date("Y-m-d");
        $fhora = date("G:i:s");
        $fip = $_SERVER['REMOTE_ADDR'];
        $faccion = "Admin_Borra_Candidato (" . $row6['nombres'] . " " . $row6['apellidos'] . ")";
        $cons_sql5  = sprintf("INSERT INTO control(c_fecha,c_hora,c_ip,c_accion,c_idest) VALUES(%s,%s,%s,%s,%d)", comillas($ffecha), comillas($fhora), comillas($fip), comillas($faccion), $_COOKIE['VotaDatAdmin']);
        $db->query($cons_sql5);
    }

    /*
     * MUESTRA LA LISTA DE CANDIDATOS
     */
    $resp9 = $db->query("SELECT * FROM categorias");
    while ($row9 = $resp9->fetch_array(MYSQLI_ASSOC)) {
        $categorias[$row9["id"]] = $row9["nombre"];
    }
    echo '<br><table>';
    echo '<thead><tr><th colspan="2">CANDIDATO</th><th colspan="3">OPCIONES</th></tr></thead>';
    $ContAdm = 0;
    $resp = $db->query(sprintf("SELECT * FROM candidatos ORDER BY representante, apellidos DESC"));
    while ($row = $resp->fetch_array(MYSQLI_ASSOC)) {
        echo '<tr>';
        echo '<td class="cen">';
        if ((file_exists('../fotos/' . $row['id'] . '.jpg')) || (file_exists('../fotos/' . $row['id'] . '.png')) || (file_exists('../fotos/' . $row['id'] . '.gif'))) {
            if (file_exists('../fotos/' . $row['id'] . '.jpg')) {
                echo '<img src="../fotos/' . $row['id'] . '.jpg" width="100" alt="FotoCandidato">';
            } elseif (file_exists('../fotos/' . $row['id'] . '.png')) {
                echo '<img src="../fotos/' . $row['id'] . '.png" width="100" alt="FotoCandidato">';
            } elseif (file_exists('../fotos/' . $row['id'] . '.gif')) {
                echo '<img src="../fotos/' . $row['id'] . '.gif" width="100" alt="FotoCandidato">';
            }
        } else {
            echo '<img src="../fotos/sinfoto.png" alt="FotoCandidato">';
        }
        echo '</td>';
        echo '<td>' . $row['nombres'] . ' ' . $row['apellidos'] . ' (' . $categorias[$row['representante']] . ')</td>';
        echo '<td class="cen"><a href="foto.php?id=' . md5($row['id']) . '&editar=ok" title="Cambiar foto"><img src="../iconos/foto.png" border="0" width="20px" border="0" alt="Foto" /></a></td>';
        echo '<td class="cen"><a href="candidatos.php?id=' . md5($row['id']) . '&editar=ok" title="Editar candidato"><img src="../iconos/lapiz.png" border="0" width="20px" border="0" alt="Editar" /></a></td>';
        echo '<td class="cen"><a href="candidatos.php?id=' . md5($row['id']) . '&elimina=0" title="Borrar candidato"><img src="../iconos/delete.png" border="0" alt="Borrar" /></a></td></tr>';
        $ContAdm = $ContAdm + 1;
    }
    if ($ContAdm == 0) {
        echo '<tr><td colspan="5"><strong>No existe información para mostrar</strong></td></tr>';
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
