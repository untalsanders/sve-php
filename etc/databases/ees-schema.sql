--
-- Table document_types
-- TARJETA DE IDENTIDAD, CÉDULA
--
CREATE TABLE IF NOT EXISTS document_types (
    id INT NOT NULL AUTO_INCREMENT,
    type_name VARCHAR(50) NOT NULL,
    created_at DATETIME DEFAULT NOW(),
    updated_at DATETIME DEFAULT NOW(),
    CONSTRAINT pk_document_types PRIMARY KEY (id),
    CONSTRAINT uq_type_name UNIQUE (type_name)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

--
-- Table documents
--
CREATE TABLE IF NOT EXISTS documents (
    id INT NOT NULL AUTO_INCREMENT,
    document_number VARCHAR(50) NOT NULL,
    type_document_id INT NOT NULL,
    created_at DATETIME DEFAULT NOW(),
    updated_at DATETIME DEFAULT NOW(),
    CONSTRAINT pk_documents PRIMARY KEY (id),
    CONSTRAINT uq_document_number UNIQUE (document_number),
    CONSTRAINT fk_document_types FOREIGN KEY (type_document_id) REFERENCES document_types (id)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

--
-- Table people
--
CREATE TABLE IF NOT EXISTS people (
    id INT NOT NULL AUTO_INCREMENT,
    firstname VARCHAR(30) NOT NULL,
    lastname VARCHAR(30) NULL,
    document_id INT NOT NULL,
    birthdate DATE NULL,
    created_at DATETIME DEFAULT NOW(),
    updated_at DATETIME DEFAULT NOW(),
    CONSTRAINT pk_people PRIMARY KEY (id),
    CONSTRAINT fk_documents FOREIGN KEY (document_id) REFERENCES documents (id)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

--
-- Table roles
--
CREATE TABLE IF NOT EXISTS roles (
    id INT NOT NULL AUTO_INCREMENT,
    role_name VARCHAR(15) NOT NULL,
    role_description VARCHAR(100) NOT NULL,
    created_at DATETIME DEFAULT NOW(),
    updated_at DATETIME DEFAULT NOW(),
    CONSTRAINT pk_roles PRIMARY KEY (id),
    CONSTRAINT uq_role_name UNIQUE (role_name)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

--
-- Table users
--
CREATE TABLE IF NOT EXISTS users (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    username VARCHAR(15)  NOT NULL,
    email varchar(100) NOT NULL,
    password VARCHAR(100) NOT NULL,
    role_id INT NOT NULL,
    people_id INT NOT NULL,
    created_at DATETIME DEFAULT NOW(),
    updated_at DATETIME DEFAULT NOW(),
    CONSTRAINT pk_users PRIMARY KEY (id),
    CONSTRAINT fk_roles FOREIGN KEY (role_id) REFERENCES roles (id),
    CONSTRAINT fk_people FOREIGN KEY (people_id) REFERENCES people (id),
    CONSTRAINT uq_username UNIQUE (username),
    CONSTRAINT uq_user_email UNIQUE (email)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

--
-- Table user_meta
--
CREATE TABLE user_meta (
  meta_id int NOT NULL AUTO_INCREMENT,
  user_id int unsigned NOT NULL,
  meta_key varchar(255)  DEFAULT NULL,
  meta_value longtext,
  created_at DATETIME DEFAULT NOW(),
  updated_at DATETIME DEFAULT NOW(),
  CONSTRAINT pk_user_meta PRIMARY KEY (meta_id, user_id),
  CONSTRAINT fk_users_user_id FOREIGN KEY (user_id) REFERENCES users(id)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

--
-- Table schools
--
CREATE TABLE IF NOT EXISTS schools (
    id INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    description VARCHAR(100) NULL,
    is_active TINYINT DEFAULT 0,
    code VARCHAR(20) NOT NULL,
    created_at DATETIME DEFAULT NOW(),
    updated_at DATETIME DEFAULT NOW(),
    CONSTRAINT pk_schools PRIMARY KEY (id),
    CONSTRAINT uq_name UNIQUE (name),
    CONSTRAINT uq_code UNIQUE (code)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

--
-- Table grades
--
CREATE TABLE IF NOT EXISTS grades (
    id INT(11) NOT NULL AUTO_INCREMENT,
    name VARCHAR(15) NOT NULL,
    CONSTRAINT pk_grades PRIMARY KEY (id)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

--
-- Table categories
--
CREATE TABLE IF NOT EXISTS categories (
    id INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    description varchar(100) NOT NULL,
    created_at DATETIME DEFAULT NOW(),
    updated_at DATETIME DEFAULT NOW(),
    CONSTRAINT pk_categories PRIMARY KEY (id)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

--
-- Table candidatures
--
CREATE TABLE IF NOT EXISTS candidatures (
    id INT(11) NOT NULL AUTO_INCREMENT,
    name VARCHAR(15) NOT NULL,
    description TEXT,
    created_at DATETIME DEFAULT NOW(),
    updated_at DATETIME DEFAULT NOW(),
    CONSTRAINT pk_candidatures PRIMARY KEY (id)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;
