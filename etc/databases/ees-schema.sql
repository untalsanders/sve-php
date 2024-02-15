--
-- Table people
--
CREATE TABLE IF NOT EXISTS people
(
    id              INT         NOT NULL AUTO_INCREMENT,
    firstname       VARCHAR(30) NOT NULL,
    lastname        VARCHAR(30) NULL,
    document_number VARCHAR(15),
    birthdate       DATE        NULL,
    CONSTRAINT pk_people PRIMARY KEY (id)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;

-- --------------------------------------------------------
--
-- Table roles
--
CREATE TABLE IF NOT EXISTS roles
(
    id          INT          NOT NULL AUTO_INCREMENT,
    name        VARCHAR(15)  NOT NULL,
    description VARCHAR(100) NOT NULL,
    CONSTRAINT pk_roles PRIMARY KEY (id),
    CONSTRAINT uq_name UNIQUE (name)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;

-- --------------------------------------------------------
--
-- Table users
--
CREATE TABLE IF NOT EXISTS users
(
    id         INT          NOT NULL AUTO_INCREMENT,
    username   VARCHAR(15)  NOT NULL,
    password   VARCHAR(100) NOT NULL,
    role_id    INT          NOT NULL,
    created_at DATETIME DEFAULT NOW(),
    updated_at DATETIME DEFAULT NOW(),
    CONSTRAINT pk_users PRIMARY KEY (id),
    CONSTRAINT fk_roles FOREIGN KEY (role_id) REFERENCES roles (id),
    CONSTRAINT uq_username UNIQUE (username)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;

-- --------------------------------------------------------
--
-- Table people_users
--
CREATE TABLE IF NOT EXISTS people_users
(
    users_id  INT NOT NULL,
    people_id INT NOT NULL,
    CONSTRAINT fk_users FOREIGN KEY (users_id) REFERENCES users (id),
    CONSTRAINT fk_people FOREIGN KEY (people_id) REFERENCES people (id),
    CONSTRAINT pk_people_users PRIMARY KEY (users_id, people_id)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;

-- --------------------------------------------------------
--
-- Table schools
--
CREATE TABLE IF NOT EXISTS schools
(
    id          INT         NOT NULL AUTO_INCREMENT,
    name        INT         NOT NULL,
    description INT         NULL,
    is_active   INT      DEFAULT 0,
    code        VARCHAR(20) NOT NULL,
    created_at  DATETIME DEFAULT NOW(),
    updated_at  DATETIME DEFAULT NOW(),
    CONSTRAINT pk_schools PRIMARY KEY (id),
    CONSTRAINT uq_code UNIQUE (code)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;

-- --------------------------------------------------------
--
-- Table grades
--
CREATE TABLE IF NOT EXISTS grades
(
    id   INT(11)     NOT NULL AUTO_INCREMENT,
    name VARCHAR(15) NOT NULL,
    CONSTRAINT pk_grades PRIMARY KEY (id)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;

-- --------------------------------------------------------
--
-- Table categories
--
CREATE TABLE IF NOT EXISTS categories
(
    id          INT          NOT NULL AUTO_INCREMENT,
    name        VARCHAR(100) NOT NULL,
    description varchar(100) NOT NULL,
    created_at  DATETIME DEFAULT NOW(),
    updated_at  DATETIME DEFAULT NOW(),
    CONSTRAINT pk_categories PRIMARY KEY (id)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;

-- --------------------------------------------------------
--
-- Table candidatures
--
CREATE TABLE IF NOT EXISTS candidatures
(
    id          INT(11)     NOT NULL AUTO_INCREMENT,
    name        VARCHAR(15) NOT NULL,
    description TEXT,
    created_at  DATETIME DEFAULT NOW(),
    updated_at  DATETIME DEFAULT NOW(),
    CONSTRAINT pk_candidatures PRIMARY KEY (id)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;

-- --------------------------------------------------------
