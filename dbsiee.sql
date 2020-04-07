--
-- Tabla Grado
--
CREATE TABLE IF NOT EXISTS grado (
    id INT(11) NOT NULL AUTO_INCREMENT,
    nombre VARCHAR(15) NOT NULL,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=UTF8;
-- --------------------------------------------------------

--
-- Tabla Candidatura
--
CREATE TABLE IF NOT EXISTS candidatura (
    id INT(11) NOT NULL AUTO_INCREMENT,
    nombre VARCHAR(15) NOT NULL,
    descripcion TEXT,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=UTF8;
-- --------------------------------------------------------
