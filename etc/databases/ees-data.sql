-- grades
INSERT INTO grades (name) VALUES
    ('PRIMERO'),
    ('SEGUNDO'),
    ('TERCERO'),
    ('CUARTO'),
    ('QUINTO'),
    ('SEXTO'),
    ('SÉPTIMO'),
    ('OCTAVO'),
    ('NOVENO'),
    ('DÉCIMO'),
    ('UNDÉCIMO');

-- roles
INSERT INTO roles (role_name, role_description) VALUES ('ADMIN', 'System administrator'), ('STUDENT', 'Student of school');
-- document_types
INSERT INTO document_types (type_name) VALUES ('TARJETA DE IDENTIDAD'), ('CÉDULA');
-- documents
INSERT INTO documents (document_number, type_document_id) VALUES ('96009842', 1);
-- people
INSERT INTO people (firstname, lastname, document_id, birthdate) VALUES ('Sanders', 'Gutiérrez', 1, '1988-11-21');
-- users
INSERT INTO users (username, email, password, role_id, people_id) VALUES ('untalsanders', 'ing.sanders@gmail.com', md5('S3cret'), 1, 1);

-- schools
INSERT INTO schools (name, is_active, code) VALUES ('Instituto Educativo Técnico Comercial', 1, 'fab456');

