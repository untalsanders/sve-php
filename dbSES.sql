--
-- Table User
--
CREATE TABLE user (
    id INT NOT NULL AUTO_INCREMENT,
    username VARCHAR(15) NOT NULL,
    password VARCHAR(100) NOT NULL,
    firstname VARCHAR(30) NOT NULL,
    lastname VARCHAR(30) NULL,
    created_at DATETIME DEFAULT NOW(),
    updated_at DATETIME DEFAULT NOW(),
    CONSTRAINT pk_user PRIMARY KEY (id,username),
    CONSTRAINT uq_user UNIQUE(username)
) ENGINE=InnoDB DEFAULT CHARSET=UTF8;
-- --------------------------------------------------------

--
-- Table User
--
CREATE TABLE person (
    id INT NOT NULL AUTO_INCREMENT,
    firstname VARCHAR(30) NOT NULL,
    lastname VARCHAR(30) NULL
) ENGINE=InnoDB DEFAULT CHARSET=UTF8;
-- --------------------------------------------------------


--
-- Table School
--
CREATE TABLE school (
    id INT NOT NULL AUTO_INCREMENT,
    name INT NOT NULL,
    description INT NULL,
    created_at DATETIME DEFAULT NOW(),
    updated_at DATETIME DEFAULT NOW(),
    code VARCHAR(20) NOT NULL,
    PRIMARY KEY (id),
    UNIQUE (code)
) ENGINE=InnoDB DEFAULT CHARSET=UTF8;
-- --------------------------------------------------------

--
-- Table Grade
--
CREATE TABLE IF NOT EXISTS grade (
    id INT(11) NOT NULL AUTO_INCREMENT,
    name VARCHAR(15) NOT NULL,
    created_at DATETIME DEFAULT NOW(),
    updated_at DATETIME DEFAULT NOW(),
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=UTF8;
-- --------------------------------------------------------

--
-- Tabla Candidatura
--
CREATE TABLE IF NOT EXISTS candidatura (
    id INT(11) NOT NULL AUTO_INCREMENT,
    name VARCHAR(15) NOT NULL,
    description TEXT,
    created_at DATETIME DEFAULT NOW(),
    updated_at DATETIME DEFAULT NOW(),
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=UTF8;
-- --------------------------------------------------------
