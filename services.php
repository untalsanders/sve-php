<?php

require 'conexionBD.php';

$db = conectarse();

function datosInstitucion(): array {
    global $db;
    $sql = 'SELECT * FROM general';
    $queryResult = $db->query($sql);
    $data = $queryResult->fetch_assoc();
    return $data;
}

function isSystemActive(): bool {
    $data = datosInstitucion();
    return $data['activo'] == 'S' ? true : false;
}

function usePassword(): bool {
    $data = datosInstitucion();
    return $data['clave'] == 'S' ? true : false;
}
