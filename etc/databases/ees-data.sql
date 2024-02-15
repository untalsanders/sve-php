-- grades
INSERT INTO grades
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

-- roles
INSERT INTO roles VALUES (1, 'admin', 'System administrator'), (2, 'student', 'Student of school');
-- people
INSERT INTO people VALUES (1, 'Sanders', 'Gutiérrez', '96009842', '1988-11-21 22:30:43');
-- users
INSERT INTO users VALUES (1, 'sanders', md5('S3cret'), 1, NOW(), NOW());
