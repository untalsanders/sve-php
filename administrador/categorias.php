<?php

require_once("../funciones.php");
require_once("../conexionBD.php");

$db = conectarse();

//***Leer variables del sistema******
$estado = $db->query("SELECT * FROM general");
$leer = $estado->fetch_array(MYSQLI_ASSOC);

//****** Verificamos si existe la cookie *****/
if (isset($_COOKIE['VotaDatAdmin'])) {
    //****Agregar una nueva categoría*******
    if (isset($_POST['envia_categoria'])) {
        if ((borraEspacios($_POST['nombre_cat']) != "") and (borraEspacios($_POST['descripcion_cat']) != "")) {
            $fnombre_cat = borraEspacios($_POST['nombre_cat']);
            $fdescripcion_cat = borraEspacios($_POST['descripcion_cat']);
        } else {
            include_once("encabezado.phtml");
            print "<strong>Debe llenar todos los campos<br>";
            print "<br><a href='javascript:history.go(-1)'>Volver al formulario</a></strong></div></body></html>";
            exit;
        }

        //*****Validamos que no exista una  categoría duplicada****
        $duplica = 0;
        $resp3 = $db->query("select * from categorias");
        while ($row3 = $resp3->fetch_array(MYSQLI_ASSOC)) {
            if (cambiaMayuscula($fnombre_cat) == cambiaMayuscula($row3["nombre"])) {
                $duplica = 1;
            }
        }
        if ($duplica == 1) {
            include_once("encabezado.phtml");
            print "<strong>Ya existe una categoría con este nombre<br>";
            print "<br><a href='javascript:history.go(-1)'>Volver al formulario</a></strong></div></body></html>";
            exit;
        }

        //******Guardamos los datos en la BD ******
        $cons_sql  = sprintf("INSERT INTO categorias(nombre,descripcion) VALUES(%s,%s)", comillas($fnombre_cat), comillas($fdescripcion_cat));
        $db->query($cons_sql);

        //****obtener el id de la categoria guardada
        $id_cat = $db->insert_id;

        //******Guardamos los datos de control ******
        $ffecha = date("Y-m-d");
        $fhora = date("G:i:s");
        $fip = $_SERVER['REMOTE_ADDR'];
        $faccion = "Admin_Crea_Categoria (id:" . $id_cat . ")";
        $cons_sql5  = sprintf("INSERT INTO control(c_fecha,c_hora,c_ip,c_accion,c_idest) VALUES(%s,%s,%s,%s,%d)", comillas($ffecha), comillas($fhora), comillas($fip), comillas($faccion), $_COOKIE['VotaDatAdmin']);
        $db->query($cons_sql5);
    }
    //****Actualizar informaci�n de la categoria*******
    if (isset($_POST['edita_cat'])) {
        if (($_POST['nombre_cat'] != "") and ($_POST['descripcion_cat'] != "")) {
            $fnombre_cat = borraEspacios($_POST['nombre_cat']);
            $fdescripcion_cat = borraEspacios($_POST['descripcion_cat']);
        } else {
            include_once("encabezado.phtml");
            print "<strong>Debe llenar todos los campos<br>";
            print "<br><a href='javascript:history.go(-1)'>Volver al formulario</a></strong></div></body></html>";
            exit;
        }
        //****Actualizar en la BD*******
        $cons_sql3  = sprintf("UPDATE categorias SET nombre=%s, descripcion=%s WHERE id=%d", comillas($fnombre_cat), comillas($fdescripcion_cat), $_POST['identificador']);
        $db->query($cons_sql3);

        //******Guardamos los datos de control ******
        $ffecha = date("Y-m-d");
        $fhora = date("G:i:s");
        $fip = $_SERVER['REMOTE_ADDR'];
        $faccion = "Admin_Actualiza_Categoria (id:" . $_POST['identificador'] . ")";
        $cons_sql5  = sprintf("INSERT INTO control(c_fecha,c_hora,c_ip,c_accion,c_idest) VALUES(%s,%s,%s,%s,%d)", comillas($ffecha), comillas($fhora), comillas($fip), comillas($faccion), $_COOKIE['VotaDatAdmin']);
        $db->query($cons_sql5);
    }
    echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';
    echo '<html>';
    echo '<head>';
    echo '<title>' . $leer['institucion'] . ' - Categorías de votación</title>';
    echo '<link href="../estilo4.css" rel="stylesheet" type="text/css" />';
    echo '</head>';
    echo '<body>';
    echo '<h1>' . $leer['institucion'] . '</h1>';
    echo '<h2>CATEGORÍAS DE VOTACIÓN</h2>';
    echo '<div align="center">';
    //*****Formulario para agregar una categoría *******
    if ((isset($_GET['agrega'])) and ($_GET['agrega'] == "ok")) {
        echo '<form name="addcat" action="categorias.php" method="post">';
        echo '<table>';
        echo '<tr>';
        echo '<td style="text-align:right;"><label for="nombre_cat">';
        echo '<strong>Nombre:</strong>';
        echo '</label></td>';
        echo '<td><input type="text" name="nombre_cat" size="30" maxlength="50" title="Escriba el nombre de la categoria" />';
        echo '</td></tr>';
        echo '<tr>';
        echo '<td style="text-align:right;"><label for="descripcion_cat">';
        echo '<strong>Descripción:</strong>';
        echo '</label></td>';
        echo '<td><input type="text" name="descripcion_cat" size="30" maxlength="50" title="Escriba la descripción de la categoría" />';
        echo '</td></tr>';

        echo '<tr><td class="cen" colspan="2"><input type="submit" name="envia_categoria" value="Guardar" title="Agregar categoría" />&nbsp&nbsp&nbsp&nbsp';
        echo '<input type="button" name="Cancel" value="Cancelar" onclick="window.location =\'categorias.php\' "/></td></tr>';
        echo '</form></table>';
    } else {
        echo '<div class=cen>';
        echo '<strong><a href="categorias.php?agrega=ok" title="Agregar categoría">Agregar categoría</a></strong>';
        echo '</div>';
    }

    //*****Formulario para editar categoría *******
    if ((isset($_GET['id'])) and (isset($_GET['editar'])) and ($_GET['editar'] == "ok")) {
        $resp4 = $db->query(sprintf("select * from categorias where md5(id)=%s", comillas($_GET['id'])));
        if ($row4 = $resp4->fetch_array(MYSQLI_ASSOC)) {
            echo '<br><form name="editacat" action="categorias.php" method="post">';
            echo '<table>';
            echo '<tr>';
            echo '<td style="text-align:right;"><label for="nombre_cat">';
            echo '<strong>Nombre:</strong>';
            echo '</label></td>';
            echo '<td><input type="text" name="nombre_cat" value="' . $row4['nombre'] . '" size="30" maxlength="50" title="Escriba el nombre de la categor�a" />';
            echo '</td></tr>';
            echo '<tr>';
            echo '<td style="text-align:right;"><label for="descripcion_cat">';
            echo '<strong>Descripci�n:</strong>';
            echo '</label></td>';
            echo '<td><input type="text" name="descripcion_cat" value="' . $row4['descripcion'] . '" size="30" maxlength="50" title="Escriba la descripción de la categoría" />';
            echo '</td></tr>';
            echo '<input type="hidden" name="identificador" value="' . $row4['id'] . '" />';
            echo '<tr><td class="cen" colspan="2"><input type="submit" name="edita_cat" value="Guardar" title="Agregar categoría" />&nbsp&nbsp&nbsp&nbsp';
            echo '<input type="button" name="Cancel" value="Cancelar" onclick="window.location =\'categorias.php\' "/></td></tr>';
            echo '</form></table>';
        } else {
            echo '<table>';
            echo '<tr><td class="cen"><strong>No hay datos para la categoría</strong></td></tr>';
            echo '</table>';
        }
    }
    //******Mostrar mensaje para borrar categoría*******
    if ((isset($_GET['id'])) and (isset($_GET['elimina'])) and ($_GET['elimina'] == "0")) {
        $resp5 = $db->query(sprintf("select * from categorias where md5(id)=%s", comillas($_GET['id'])));
        if ($row5 = $resp5->fetch_array(MYSQLI_ASSOC)) {
            //****Verificar que no existan candidatos para eliminar la categoría******
            $resp9 = $db->query(sprintf("select id from candidatos where representante=%d", $row5['id']));
            if (!$row9 = $resp9->fetch_array(MYSQLI_ASSOC)) {
                echo '<br><div class="cen"><strong>';
                echo '¿Desea borrar la categoría ' . $row5['nombre'] . ' del sistema? ';
                echo '<a href="categorias.php?id=' . $_GET['id'] . '&elimina=1" title="Borrar categoría del sistema">Si</a>&nbsp&nbsp&nbsp&nbsp';
                echo '<a href="categorias.php" title="Cancelar la eliminaci�n de la categoría">No</a>';
                echo '</strong></div>';
            } else {
                echo '<br><strong>Advertencia: Debe borrar primero los candidatos que pertenecen a la categoría ' . $row5['nombre'] . '.</strong>';
            }
        } else {
            echo '<table>';
            echo '<tr><td class="cen"><strong>No hay datos para la categor�a</strong></td></tr>';
            echo '</table>';
        }
    }

    //*****Eliminar categoría******
    if ((isset($_GET['id'])) and (isset($_GET['elimina'])) and ($_GET['elimina'] == "1")) {
        $resp6 = $db->query(sprintf("select * from categorias where md5(id)=%s", comillas($_GET['id'])));
        $row6 = $resp6->fetch_array(MYSQLI_ASSOC);
        $resp2 = $db->query(sprintf("delete from categorias where md5(id)=%s", comillas($_GET['id'])));

        //******Guardamos los datos de control ******
        $ffecha = date("Y-m-d");
        $fhora = date("G:i:s");
        $fip = $_SERVER['REMOTE_ADDR'];
        $faccion = "Admin_Borra_Categor�a (Nombre:" . $row6['nombre'] . ")";
        $cons_sql5  = sprintf("INSERT INTO control(c_fecha,c_hora,c_ip,c_accion,c_idest) VALUES(%s,%s,%s,%s,%d)", comillas($ffecha), comillas($fhora), comillas($fip), comillas($faccion), $_COOKIE['VotaDatAdmin']);
        $db->query($cons_sql5);
    }

    //****MUESTRA LA TABLA DE CATEGORÍAS******
    echo '<br><table>';
    echo '<thead><tr><th>NOMBRE</th><th colspan="2">OPCIONES</th></tr></thead>';
    $ContAdm = 0;
    $resp = $db->query(sprintf("select * from categorias order by id"));
    while ($row = $resp->fetch_array(MYSQLI_ASSOC)) {
        echo '<tr>';
        echo '<td>' . $row['nombre'] . ' (' . $row['descripcion'] . ')</td>';
        echo '<td class="cen"><a href="categorias.php?id=' . md5($row['id']) . '&editar=ok" title="Editar categoría"><img src="../iconos/lapiz.png" border="0" width="20px" border="0" alt="Editar" /></a></td>';
        echo '<td class="cen"><a href="categorias.php?id=' . md5($row['id']) . '&elimina=0" title="Borrar categoría"><img src="../iconos/delete.png" border="0" alt="Borrar" /></a></td></tr>';
        $ContAdm = $ContAdm + 1;
    }
    if ($ContAdm == 0) {
        echo '<tr><td colspan="3"><strong>No existe informaci�n para mostrar</strong></td></tr>';
    }
    echo '</table><br>';
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
