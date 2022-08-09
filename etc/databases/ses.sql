-- MySQL dump 10.13  Distrib 8.0.29, for macos12 (x86_64)
--
-- Host: 127.0.0.1    Database: ses
-- ------------------------------------------------------
-- Server version	8.0.30
/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */
;

/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */
;

/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */
;

/*!50503 SET NAMES utf8mb4 */
;

/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */
;

/*!40103 SET TIME_ZONE='+00:00' */
;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */
;

/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */
;

/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */
;

/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */
;

--
-- Table structure for table administradores
--
DROP TABLE
  IF EXISTS administradores;

/*!40101 SET @saved_cs_client     = @@character_set_client */
;

/*!50503 SET character_set_client = utf8mb4 */
;

CREATE TABLE
  administradores (
    id int NOT NULL AUTO_INCREMENT,
    usuario varchar(50) NOT NULL,
    nombres varchar(50) NOT NULL,
    apellidos varchar(50) NOT NULL,
    password varchar(100) NOT NULL,
    PRIMARY KEY (id)
  ) ENGINE = MyISAM AUTO_INCREMENT = 2 DEFAULT CHARSET = latin1;

/*!40101 SET character_set_client = @saved_cs_client */
;

--
-- Dumping data for table administradores
--
LOCK TABLES administradores WRITE;

/*!40000 ALTER TABLE administradores DISABLE KEYS */
;

INSERT INTO
  administradores
VALUES
  (
    1,
    'admin',
    'Administrador',
    'del sistema',
    '21232f297a57a5a743894a0e4a801fc3'
  );

/*!40000 ALTER TABLE administradores ENABLE KEYS */
;

UNLOCK TABLES;

--
-- Table structure for table candidatos
--
DROP TABLE
  IF EXISTS candidatos;

/*!40101 SET @saved_cs_client     = @@character_set_client */
;

/*!50503 SET character_set_client = utf8mb4 */
;

CREATE TABLE
  candidatos (
    id int NOT NULL AUTO_INCREMENT,
    nombres varchar(50) NOT NULL,
    apellidos varchar(50) NOT NULL,
    representante int NOT NULL,
    PRIMARY KEY (id)
  ) ENGINE = MyISAM AUTO_INCREMENT = 7 DEFAULT CHARSET = latin1;

/*!40101 SET character_set_client = @saved_cs_client */
;

--
-- Dumping data for table candidatos
--
LOCK TABLES candidatos WRITE;

/*!40000 ALTER TABLE candidatos DISABLE KEYS */
;

INSERT INTO
  candidatos
VALUES
  (1, 'José', 'Borrero', 1),
  (2, 'Diego Fernando', 'Libreros Barrera', 1),
  (3, 'VOTO EN BLANCO', '', 1),
  (4, 'Iván', 'Marín', 2),
  (5, 'Ricardo', 'Quevedo', 2),
  (6, 'VOTO EN BLANCO', '', 2);

/*!40000 ALTER TABLE candidatos ENABLE KEYS */
;

UNLOCK TABLES;

--
-- Table structure for table categorias
--
DROP TABLE
  IF EXISTS categorias;

/*!40101 SET @saved_cs_client     = @@character_set_client */
;

/*!50503 SET character_set_client = utf8mb4 */
;

CREATE TABLE
  categorias (
    id int NOT NULL AUTO_INCREMENT,
    nombre varchar(100) NOT NULL,
    descripcion varchar(100) NOT NULL,
    PRIMARY KEY (id)
  ) ENGINE = MyISAM AUTO_INCREMENT = 3 DEFAULT CHARSET = latin1;

/*!40101 SET character_set_client = @saved_cs_client */
;

--
-- Dumping data for table categorias
--
LOCK TABLES categorias WRITE;

/*!40000 ALTER TABLE categorias DISABLE KEYS */
;

INSERT INTO
  categorias
VALUES
  (1, 'Personero', 'Candidatos a la personería'),
  (2, 'Consejo', 'Candidatos al Consejo Directivo');

/*!40000 ALTER TABLE categorias ENABLE KEYS */
;

UNLOCK TABLES;

--
-- Table structure for table control
--
DROP TABLE
  IF EXISTS control;

/*!40101 SET @saved_cs_client     = @@character_set_client */
;

/*!50503 SET character_set_client = utf8mb4 */
;

CREATE TABLE
  control (
    id int NOT NULL AUTO_INCREMENT,
    c_fecha date NOT NULL,
    c_hora time NOT NULL,
    c_ip varchar(20) NOT NULL,
    c_accion varchar(50) NOT NULL,
    c_idest int NOT NULL,
    PRIMARY KEY (id)
  ) ENGINE = MyISAM DEFAULT CHARSET = latin1;

/*!40101 SET character_set_client = @saved_cs_client */
;

--
-- Dumping data for table control
--
LOCK TABLES control WRITE;

/*!40000 ALTER TABLE control DISABLE KEYS */
;

/*!40000 ALTER TABLE control ENABLE KEYS */
;

UNLOCK TABLES;

--
-- Table structure for table estudiantes
--
DROP TABLE
  IF EXISTS estudiantes;

/*!40101 SET @saved_cs_client     = @@character_set_client */
;

/*!50503 SET character_set_client = utf8mb4 */
;

CREATE TABLE
  estudiantes (
    id int NOT NULL AUTO_INCREMENT,
    dni int unsigned NOT NULL,
    grado int NOT NULL,
    nombres varchar(50) NOT NULL,
    apellidos varchar(50) NOT NULL,
    clave varchar(100) NOT NULL,
    PRIMARY KEY (id)
  ) ENGINE = MyISAM AUTO_INCREMENT = 2 DEFAULT CHARSET = latin1;

/*!40101 SET character_set_client = @saved_cs_client */
;

--
-- Dumping data for table estudiantes
--
LOCK TABLES estudiantes WRITE;

/*!40000 ALTER TABLE estudiantes DISABLE KEYS */
;

INSERT INTO
  estudiantes
VALUES
  (
    1,
    96009842,
    11,
    'Sanders Smith',
    'Gutiérrez Mena',
    '827ccb0eea8a706c4c34a16891f84e7b'
  );

/*!40000 ALTER TABLE estudiantes ENABLE KEYS */
;

UNLOCK TABLES;

--
-- Table structure for table general
--
DROP TABLE
  IF EXISTS general;

/*!40101 SET @saved_cs_client     = @@character_set_client */
;

/*!50503 SET character_set_client = utf8mb4 */
;

CREATE TABLE
  general (
    id int NOT NULL AUTO_INCREMENT,
    institucion varchar(100) NOT NULL,
    descripcion varchar(100) NOT NULL,
    activo varchar(1) NOT NULL,
    clave varchar(1) NOT NULL,
    PRIMARY KEY (id)
  ) ENGINE = MyISAM AUTO_INCREMENT = 2 DEFAULT CHARSET = latin1;

/*!40101 SET character_set_client = @saved_cs_client */
;

--
-- Dumping data for table general
--
LOCK TABLES general WRITE;

/*!40000 ALTER TABLE general DISABLE KEYS */
;

INSERT INTO
  general
VALUES
  (
    1,
    'IDETEC',
    'Instituto Departamental Técnico Comercial',
    'S',
    'N'
  );

/*!40000 ALTER TABLE general ENABLE KEYS */
;

UNLOCK TABLES;

--
-- Table structure for table grados
--
DROP TABLE
  IF EXISTS grados;

/*!40101 SET @saved_cs_client     = @@character_set_client */
;

/*!50503 SET character_set_client = utf8mb4 */
;

CREATE TABLE
  grados (
    id int NOT NULL AUTO_INCREMENT,
    grado varchar(15) NOT NULL,
    PRIMARY KEY (id)
  ) ENGINE = MyISAM AUTO_INCREMENT = 12 DEFAULT CHARSET = latin1;

/*!40101 SET character_set_client = @saved_cs_client */
;

--
-- Dumping data for table grados
--
LOCK TABLES grados WRITE;

/*!40000 ALTER TABLE grados DISABLE KEYS */
;

INSERT INTO
  grados
VALUES
  (1, 'PRIMERO'),
  (2, 'SEGUNDO'),
  (3, 'TERCERO'),
  (4, 'CUARTO'),
  (5, 'QUINTO'),
  (6, 'SEXTO'),
  (7, 'SEPTIMO'),
  (8, 'OCTAVO'),
  (9, 'NOVENO'),
  (10, 'DECIMO'),
  (11, 'UNDECIMO');

/*!40000 ALTER TABLE grados ENABLE KEYS */
;

UNLOCK TABLES;

--
-- Table structure for table voto
--
DROP TABLE
  IF EXISTS voto;

/*!40101 SET @saved_cs_client     = @@character_set_client */
;

/*!50503 SET character_set_client = utf8mb4 */
;

CREATE TABLE
  voto (
    id int NOT NULL AUTO_INCREMENT,
    id_estudiante int NOT NULL,
    candidato int NOT NULL,
    PRIMARY KEY (id)
  ) ENGINE = MyISAM DEFAULT CHARSET = latin1;

/*!40101 SET character_set_client = @saved_cs_client */
;

--
-- Dumping data for table voto
--
LOCK TABLES voto WRITE;

/*!40000 ALTER TABLE voto DISABLE KEYS */
;

/*!40000 ALTER TABLE voto ENABLE KEYS */
;

UNLOCK TABLES;

/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */
;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */
;

/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */
;

/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */
;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */
;

/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */
;

/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */
;

/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */
;

-- Dump completed on 2022-08-09 18:10:04
