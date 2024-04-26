-- colpazdb.roles definition
CREATE TABLE roles
(
  `id` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador único autoincremental',
  `name` VARCHAR(255) NOT NULL COMMENT 'Nombre del rol',
  `functions` VARCHAR(255) NOT NULL COMMENT 'Funciones asociadas al rol',
  `created` DATETIME NOT NULL COMMENT 'Fecha y hora de creación del registro',
  `modified` TIMESTAMP NOT NULL COMMENT 'Marca de tiempo que se actualiza al modificar el registro',
  `is_active` TINYINT NOT NULL DEFAULT 1 COMMENT 'Indicador de activación (1 para activo, 0 para inactivo)',
  `idr` INT(11) NOT NULL DEFAULT 0 COMMENT 'Campo que almacena el id unico de la sede',
  `custom_fields` LONGTEXT COMMENT 'Campo personalizado para almacenar información adicional' CHECK (json_valid(`custom_fields`)),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin COMMENT='Tabla que almacena información sobre roles de usuarios.';

-- AVCONTROL.menus definition
CREATE TABLE menus
(
    `id` INT(11) AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(100) NOT NULL,
    `route` VARCHAR(200),
    `identification` VARCHAR(200),
    `group` VARCHAR(150),
    `created` DATETIME NOT NULL,
    `modified` TIMESTAMP NOT NULL,
    `is_active` TINYINT(11) DEFAULT 1,
    `custom_fields` LONGTEXT CHECK (json_valid(`custom_fields`))
) ENGINE=InnoDB DEFAULT charset=utf8mb4 COLLATE=utf8mb4_bin;

-- AVCONTROL.menu_roles definition
CREATE TABLE menu_roles
(
    `id` INT(11) AUTO_INCREMENT PRIMARY KEY,
    `menu_id` INT(11) NOT NULL,
    `role_id` INT(11) NOT NULL,
    `permission` VARCHAR(2) NOT NULL,
    `created` DATETIME NOT NULL,
    `modified` TIMESTAMP NOT NULL,
    `is_active` TINYINT(11) DEFAULT 1,
    `custom_fields` LONGTEXT CHECK (json_valid(`custom_fields`)),
    FOREIGN KEY (menu_id) REFERENCES menus (id),
    FOREIGN KEY (role_id) REFERENCES roles (id),
    INDEX idx_menu_id (menu_id) USING BTREE,
    INDEX idx_role_id (role_id) USING BTREE
) ENGINE=InnoDB DEFAULT charset=utf8mb4 COLLATE=utf8mb4_bin;


-- colpazdb.assessments definition
CREATE TABLE assessments
(
  `id` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador único autoincremental',
  `title` VARCHAR(255) NOT NULL COMMENT 'Titulo de la evaluacion',
  `comment` VARCHAR(255) NOT NULL COMMENT 'Comentarios de la evaluacion',
  `date_limit` DATE NOT NULL COMMENT 'Fecha limite de la evaluacion',
  `percentage` DECIMAL(18, 2) NOT NULL COMMENT 'Valor de porcentaje de la evaluacion',
  `status` INT(11) NOT NULL COMMENT 'Estado de la evaluacion',
  `file` LONGTEXT COMMENT 'Archivo relacionado con la actividad',
  `created` DATETIME NOT NULL COMMENT 'Fecha y hora de creación del registro',
  `modified` TIMESTAMP NOT NULL COMMENT 'Marca de tiempo que se actualiza al modificar el registro',
  `is_active` TINYINT NOT NULL DEFAULT 1 COMMENT 'Indicador de activación (1 para activo, 0 para inactivo)',
  `idr` INT(11) NOT NULL DEFAULT 0 COMMENT 'Campo que almacena el id unico de la sede',
  `custom_fields` LONGTEXT COMMENT 'Campo personalizado para almacenar información adicional' CHECK (json_valid(`custom_fields`)),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin COMMENT='Tabla que almacena información sobre actividades.';

-- colpazdb.identification_types definition
CREATE TABLE identification_types
(
    `id` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador único autoincremental',
    `name` VARCHAR(200) NOT NULL COMMENT 'Nombre del tipo de identificación',
    `created` DATETIME NOT NULL COMMENT 'Fecha y hora de creación del registro',
    `modified` TIMESTAMP NOT NULL COMMENT 'Marca de tiempo que se actualiza al modificar el registro',
    `is_active` TINYINT NOT NULL DEFAULT 1 COMMENT 'Indicador de activación (1 para activo, 0 para inactivo)',
    `idr` INT(11) NOT NULL DEFAULT 0 COMMENT 'Campo que almacena el id unico de la sede',
    `custom_fields` LONGTEXT COMMENT 'Campo personalizado para almacenar información adicional' CHECK (json_valid(`custom_fields`)),
    PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin COMMENT='Tabla que almacena información sobre los tipos de identificación.';

-- colpazdb.users definition
CREATE TABLE users
(
    `id` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador único autoincremental',
    `name` VARCHAR(255) NOT NULL COMMENT 'Nombre del usuario',
    `lastname` VARCHAR(255) NOT NULL COMMENT 'Apellido del usuario',
    `username` VARCHAR(255) NOT NULL COMMENT 'Nombre de usuario, único en la base de datos',
    `email` VARCHAR(255) NOT NULL COMMENT 'Dirección de correo electrónico, único en la base de datos',
    `password_hash` VARCHAR(255) NOT NULL COMMENT 'Clave de seguridad aplicando el algoritmo Hash',
    `password_reset_token` VARCHAR(255) NOT NULL COMMENT 'Token para restablecer la clave, único en la base de datos',
    `sex` VARCHAR(10) NOT NULL COMMENT 'Género del usuario',
    `identification_type_id` INT NOT NULL COMMENT 'ID del tipo de identificación',
    `identification` VARCHAR(20) NOT NULL COMMENT 'Número de identificación, único en la base de datos',
    `created` DATETIME NOT NULL COMMENT 'Fecha y hora de creación del registro',
    `modified` TIMESTAMP NOT NULL COMMENT 'Marca de tiempo que se actualiza al modificar el registro',
    `is_active` TINYINT NOT NULL DEFAULT 1 COMMENT 'Indicador de activación (1 para activo, 0 para inactivo)',
    `phone` VARCHAR(20) NOT NULL COMMENT 'Número de teléfono principal, único en la base de datos',
    `phone2` VARCHAR(20) COMMENT 'Número de teléfono secundario',
    `birthdate` DATE NOT NULL COMMENT 'Fecha de nacimiento del usuario',
    `validate` TINYINT DEFAULT 0 COMMENT 'Indicador de validación para ingreso a la plataforma (1 para validado, 0 para no validado)',
    `email_confirmed_token` VARCHAR(255) COMMENT 'Token de confirmación de correo electrónico, único en la base de datos',
    `is_update_google` TINYINT(2) DEFAULT 0 COMMENT 'Permitir actualizar ciertos campos del perfil cuando se registra por Google',
    `sms_code` VARCHAR(6) COMMENT 'Código de SMS para validación',
    `profile_image` LONGTEXT COMMENT 'Campo que almacena la imagen de perfil del usuario',
    `api_key` VARCHAR(255) COMMENT 'Clave de API para el usuario, único en la base de datos',
    `role_id` INT(11) NOT NULL COMMENT 'ID del rol del usuario',
    `idr` INT(11) NOT NULL DEFAULT 0 COMMENT 'Campo que almacena el id unico de la sede',
    `custom_fields` LONGTEXT COMMENT 'Campo personalizado para almacenar información adicional' CHECK (json_valid(`custom_fields`)),
    PRIMARY KEY (`id`) USING BTREE,
	UNIQUE KEY `unique_fields_user1` (`phone`, `email`, `username`) USING BTREE,
	UNIQUE KEY `unique_fields_user2` (`identification`, `email_confirmed_token`, `password_reset_token`) USING BTREE,
    FOREIGN KEY (`identification_type_id`) REFERENCES `identification_types` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
    FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
    INDEX `idx_identification_type_id` (`identification_type_id`) USING BTREE COMMENT 'indice para mejorar el rendimiento en búsquedas por identification_type_id',
    INDEX `idx_role_id` (`role_id`) USING BTREE COMMENT 'indice para mejorar el rendimiento en búsquedas por role_id'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin COMMENT 'Tabla que almacena información sobre los usuarios de la plataforma.';

-- colpazdb.periods definition
CREATE TABLE periods
(
	`id` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador unico autoincremental',
    `name` VARCHAR(255) NOT NULL COMMENT 'Nombre o descripcion del periodo academico',
    `created` DATETIME NOT NULL COMMENT 'Fecha y hora de creacion del registro',
    `modified` TIMESTAMP NOT NULL COMMENT 'Marca de tiempo que se actualiza al modificar el registro',
    `is_active` TINYINT NOT NULL DEFAULT 1 COMMENT 'Indicador de activacion (1 para activo, 0 para inactivo)',
    `idr` INT(11) NOT NULL DEFAULT 0 COMMENT 'Campo que almacena el id unico de la sede',
    `custom_fields` LONGTEXT COMMENT 'Campo personalizado para almacenar informacion adicional' CHECK (json_valid(`custom_fields`)),
    PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin COMMENT 'Tabla que almacena informacion sobre las cabeceras del foro de la plataforma.';

-- colpazdb.headers definition
CREATE TABLE headers
(
	`id` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador unico autoincremental',
    `classroom_id` INT(11) NOT NULL COMMENT 'Identificador del aula asociado a una cabecera',
    `topic` VARCHAR(255) NOT NULL COMMENT 'Nombre o descripcion del tema asociado',
    `created` DATETIME NOT NULL COMMENT 'Fecha y hora de creacion del registro',
    `modified` TIMESTAMP NOT NULL COMMENT 'Marca de tiempo que se actualiza al modificar el registro',
    `is_active` TINYINT NOT NULL DEFAULT 1 COMMENT 'Indicador de activacion (1 para activo, 0 para inactivo)',
    `idr` INT(11) NOT NULL DEFAULT 0 COMMENT 'Campo que almacena el id unico de la sede',
    `custom_fields` LONGTEXT COMMENT 'Campo personalizado para almacenar informacion adicional' CHECK (json_valid(`custom_fields`)),
    PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin COMMENT 'Tabla que almacena informacion sobre las cabeceras del foro de la plataforma.';

-- colpazdb.user_headers definition
CREATE TABLE user_headers
(
    `id` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador unico autoincremental',
    `user_id` INT(11) NOT NULL COMMENT 'Identificador del usuario asociado al encabezado',
    `header_id` INT(11) NOT NULL COMMENT 'Identificador del encabezado asociado al usuario',
    `created` DATETIME NOT NULL COMMENT 'Fecha y hora de creacion del registro',
    `modified` TIMESTAMP NOT NULL COMMENT 'Marca de tiempo que se actualiza al modificar el registro',
    `is_active` TINYINT NOT NULL DEFAULT 1 COMMENT 'Indicador de activacion (1 para activo, 0 para inactivo)',
    `idr` INT(11) NOT NULL DEFAULT 0 COMMENT 'Campo que almacena el id unico de la sede',
    `custom_fields` LONGTEXT COMMENT 'Campo personalizado para almacenar informacion adicional' CHECK (json_valid(`custom_fields`)),
    PRIMARY KEY (`id`) USING BTREE,
    FOREIGN KEY (`user_id`) REFERENCES users (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
    FOREIGN KEY (`header_id`) REFERENCES headers (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
    INDEX `idx_user_id` (`user_id`) USING BTREE COMMENT 'indice para mejorar el rendimiento en búsquedas por user_id',
    INDEX `idx_header_id` (`header_id`) USING BTREE COMMENT 'indice para mejorar el rendimiento en búsquedas por header_id'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin COMMENT 'Tabla que establece la relacion entre usuarios y encabezados.';

-- colpazdb.course_forums definition
CREATE TABLE course_forums
(
	`id` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador unico autoincremental',
    `header_id` INT(11) NOT NULL COMMENT 'Identificador del encabezado asociado al foro del curso',
    `comment` LONGTEXT COMMENT 'Comentario del foro del curso',
    `file` LONGTEXT COMMENT 'Archivo de ayuda relacionado con el curso',
    `created` DATETIME NOT NULL COMMENT 'Fecha y hora de creacion del registro',
    `modified` TIMESTAMP NOT NULL COMMENT 'Marca de tiempo que se actualiza al modificar el registro',
    `is_active` TINYINT NOT NULL DEFAULT 1 COMMENT 'Indicador de activacion (1 para activo, 0 para inactivo)',
    `idr` INT(11) NOT NULL DEFAULT 0 COMMENT 'Campo que almacena el id unico de la sede',
    `custom_fields` LONGTEXT COMMENT 'Campo personalizado para almacenar informacion adicional' CHECK (json_valid(`custom_fields`)),
    PRIMARY KEY (`id`) USING BTREE,
    FOREIGN KEY (`header_id`) REFERENCES headers (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
    INDEX `idx_header_id` (`header_id`) USING BTREE COMMENT 'indice para mejorar el rendimiento en búsquedas por header_id'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin COMMENT 'Tabla que almacena informacion sobre los foros de cursos.';


-- colpazdb.courses definition
CREATE TABLE courses
(
	`id` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador unico autoincremental',
    `name` VARCHAR(255) NOT NULL COMMENT 'Nombre del curso',
    `description` VARCHAR(500) COMMENT 'Descripcion del curso',
    `token` VARCHAR(500) COMMENT 'Token del curso (clave unica)',
	`key_access` VARCHAR(255) COMMENT 'Llave generada para matricula manual para el estudiante',
    `created` DATETIME NOT NULL COMMENT 'Fecha y hora de creacion del registro',
    `modified` TIMESTAMP NOT NULL COMMENT 'Marca de tiempo que se actualiza al modificar el registro',
    `is_active` TINYINT NOT NULL DEFAULT 1 COMMENT 'Indicador de activacion (1 para activo, 0 para inactivo)',
    `idr` INT(11) NOT NULL DEFAULT 0 COMMENT 'Campo que almacena el id unico de la sede',
    `custom_fields` LONGTEXT COMMENT 'Campo personalizado para almacenar informacion adicional' CHECK (json_valid(`custom_fields`)),
    PRIMARY KEY (`id`) USING BTREE,
    UNIQUE KEY `unique_fields_course1` (`token`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin COMMENT 'Tabla que almacena informacion sobre los cursos academicos.';

-- colpazdb.degrees definition
CREATE TABLE degrees
(
	`id` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador unico autoincremental',
    `name` VARCHAR(255) NOT NULL COMMENT 'Nombre del grado académico',
    `created` DATETIME NOT NULL COMMENT 'Fecha y hora de creacion del registro',
    `modified` TIMESTAMP NOT NULL COMMENT 'Marca de tiempo que se actualiza al modificar el registro',
    `is_active` TINYINT NOT NULL DEFAULT 1 COMMENT 'Indicador de activacion (1 para activo, 0 para inactivo)',
    `idr` INT(11) NOT NULL DEFAULT 0 COMMENT 'Campo que almacena el id unico de la sede',
    `custom_fields` LONGTEXT COMMENT 'Campo personalizado para almacenar informacion adicional' CHECK (json_valid(`custom_fields`)),
    PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin COMMENT 'Tabla que almacena informacion sobre los grados academicos.';

-- colpazdb.classrooms definition
CREATE TABLE classrooms
(
	`id` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador unico autoincremental',
    `name` VARCHAR(255) NOT NULL COMMENT 'Nombre del aula académica',
	`degree_id` INT(11) NOT NULL COMMENT 'Identificador del grado asociado al aula',
    `created` DATETIME NOT NULL COMMENT 'Fecha y hora de creacion del registro',
    `modified` TIMESTAMP NOT NULL COMMENT 'Marca de tiempo que se actualiza al modificar el registro',
    `is_active` TINYINT NOT NULL DEFAULT 1 COMMENT 'Indicador de activacion (1 para activo, 0 para inactivo)',
    `idr` INT(11) NOT NULL DEFAULT 0 COMMENT 'Campo que almacena el id unico de la sede',
    `custom_fields` LONGTEXT COMMENT 'Campo personalizado para almacenar informacion adicional' CHECK (json_valid(`custom_fields`)),
    PRIMARY KEY (`id`) USING BTREE,
	FOREIGN KEY (`degree_id`) REFERENCES degrees (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
	INDEX `idx_course_id` (`degree_id`) USING BTREE COMMENT 'indice para mejorar el rendimiento en búsquedas por degree_id'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin COMMENT 'Tabla que almacena informacion sobre los grados academicos.';

-- colpazdb.user_courses definition
CREATE TABLE teacher_courses
(
	`id` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador unico autoincremental',
    `user_id` INT(11) NOT NULL COMMENT 'Identificador del usuario asociado al curso',
    `course_id` INT(11) NOT NULL COMMENT 'Identificador del curso asociado al usuario',
    `period_id` INT(11) NOT NULL COMMENT 'Identificador del periodo asociado al usuario',
    `classroom_id` INT(11) NOT NULL COMMENT 'Identificador del aula asociado al usuario',
    `degree_id` INT(11) NOT NULL COMMENT 'Identificador del aula asociado al usuario',
    `created` DATETIME NOT NULL COMMENT 'Fecha y hora de creacion del registro',
    `modified` TIMESTAMP NOT NULL COMMENT 'Marca de tiempo que se actualiza al modificar el registro',
    `is_active` TINYINT NOT NULL DEFAULT 1 COMMENT 'Indicador de activacion (1 para activo, 0 para inactivo)',
    `idr` INT(11) NOT NULL DEFAULT 0 COMMENT 'Campo que almacena el id unico de la sede',
    `custom_fields` LONGTEXT COMMENT 'Campo personalizado para almacenar informacion adicional' CHECK (json_valid(`custom_fields`)),
    PRIMARY KEY (`id`) USING BTREE,
    FOREIGN KEY (`user_id`) REFERENCES users (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
    FOREIGN KEY (`course_id`) REFERENCES courses (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
    FOREIGN KEY (`period_id`) REFERENCES periods (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
    FOREIGN KEY (`classroom_id`) REFERENCES classrooms (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
    FOREIGN KEY (`degree_id`) REFERENCES degrees (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
    INDEX `idx_user_id` (`user_id`) USING BTREE COMMENT 'indice para mejorar el rendimiento en búsquedas por user_id',
    INDEX `idx_course_id` (`course_id`) USING BTREE COMMENT 'indice para mejorar el rendimiento en búsquedas por course_id',
    INDEX `idx_period_id` (`period_id`) USING BTREE COMMENT 'indice para mejorar el rendimiento en búsquedas por period_id',
    INDEX `idx_classroom_id` (`classroom_id`) USING BTREE COMMENT 'indice para mejorar el rendimiento en búsquedas por classroom_id',
    INDEX `idx_degree_id` (`degree_id`) USING BTREE COMMENT 'indice para mejorar el rendimiento en búsquedas por degree_id'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin COMMENT 'Tabla que almacena informacion sobre los cursos academicos.';

-- colpazdb.student_teachers definition
CREATE TABLE student_teachers
(
    `id` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador unico autoincremental',
    `user_id` INT(11) NOT NULL COMMENT 'Identificador del usuario/estudiante asociado al curso',
    `teacher_course_id` INT(11) NOT NULL COMMENT 'Identificador del profesor del curso asociado al estudiante',
    `period_id` INT(11) NOT NULL COMMENT 'Identificador del periodo academico asociado al usuario',
    `created` DATETIME NOT NULL COMMENT 'Fecha y hora de creacion del registro',
    `modified` TIMESTAMP NOT NULL COMMENT 'Marca de tiempo que se actualiza al modificar el registro',
    `is_active` TINYINT NOT NULL DEFAULT 1 COMMENT 'Indicador de activacion (1 para activo, 0 para inactivo)',
    `idr` INT(11) NOT NULL DEFAULT 0 COMMENT 'Campo que almacena el id unico de la sede',
    `custom_fields` LONGTEXT COMMENT 'Campo personalizado para almacenar informacion adicional' CHECK (json_valid(`custom_fields`)),
    PRIMARY KEY (`id`) USING BTREE,
    FOREIGN KEY (`user_id`) REFERENCES users (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
    FOREIGN KEY (`teacher_course_id`) REFERENCES teacher_courses (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
    FOREIGN KEY (`period_id`) REFERENCES periods (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
    INDEX `idx_user_id` (`user_id`) USING BTREE COMMENT 'indice para mejorar el rendimiento en búsquedas por user_id',
    INDEX `idx_teacher_course_id` (`teacher_course_id`) USING BTREE COMMENT 'indice para mejorar el rendimiento en búsquedas por teacher_course_id',
    INDEX `idx_period_id` (`period_id`) USING BTREE COMMENT 'indice para mejorar el rendimiento en búsquedas por period_id'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin COMMENT 'Tabla que almacena informacion sobre los cursos academicos.';

-- colpazdb.header_contents definition
CREATE TABLE header_contents
(
    `id` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador unico autoincremental',
    `supplementary_file` LONGTEXT COMMENT 'Archivo complementario con la cabecera del contenido',
    `curriculum_file` LONGTEXT COMMENT 'Archivo plan de estudios con la cabecera del contenido',
    `header_video` LONGTEXT COMMENT 'Almacenar video relacionado con el contenido',
    `teacher_course_id` INT(11) NOT NULL COMMENT 'Identificador unico del docente por curso asociado',
    `created` DATETIME NOT NULL COMMENT 'Fecha y hora de creacion del registro',
    `modified` TIMESTAMP NOT NULL COMMENT 'Marca de tiempo que se actualiza al modificar el registro',
    `is_active` TINYINT NOT NULL DEFAULT 1 COMMENT 'Indicador de activacion (1 para activo, 0 para inactivo)',
    `idr` INT(11) NOT NULL DEFAULT 0 COMMENT 'Campo que almacena el id unico de la sede',
    `custom_fields` LONGTEXT COMMENT 'Campo personalizado para almacenar informacion adicional' CHECK (json_valid(`custom_fields`)),
    PRIMARY KEY (`id`) USING BTREE,
    FOREIGN KEY (`teacher_course_id`) REFERENCES teacher_courses (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
    INDEX `idx_teacher_course_id` (`teacher_course_id`) USING BTREE COMMENT 'indice para mejorar el rendimiento en búsquedas por teacher_course_id'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin COMMENT 'Tabla que almacena informacion sobre los contenidos de las evaluaciones.';


-- colpazdb.contents definition
CREATE TABLE contents
(
	`id` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador unico autoincremental',
    `description` VARCHAR(500) COMMENT 'Descripcion del contenido',
    `title` VARCHAR(255) NOT NULL COMMENT 'Titulo del contenido',
    `file` LONGTEXT COMMENT 'Archivo relacionado con el contenido',
    `video` LONGTEXT COMMENT 'Almacenar video relacionado con el contenido',
    `header_content_id` INT(11) NOT NULL COMMENT 'Identificador unico de la cabecera del contenido asociada',
    `created` DATETIME NOT NULL COMMENT 'Fecha y hora de creacion del registro',
    `modified` TIMESTAMP NOT NULL COMMENT 'Marca de tiempo que se actualiza al modificar el registro',
    `is_active` TINYINT NOT NULL DEFAULT 1 COMMENT 'Indicador de activacion (1 para activo, 0 para inactivo)',
    `status` TINYINT NOT NULL DEFAULT 1 COMMENT 'Indicador del estado del contenido (1 para disponible, 0 para no disponible)',
    `idr` INT(11) NOT NULL DEFAULT 0 COMMENT 'Campo que almacena el id unico de la sede',
    `custom_fields` LONGTEXT COMMENT 'Campo personalizado para almacenar informacion adicional' CHECK (json_valid(`custom_fields`)),
    PRIMARY KEY (`id`) USING BTREE,
    FOREIGN KEY (`header_content_id`) REFERENCES header_contents (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
    INDEX `idx_header_content_id` (`header_content_id`) USING BTREE COMMENT 'indice para mejorar el rendimiento en búsquedas por header_content_id'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin COMMENT 'Tabla que almacena informacion sobre los contenidos de las evaluaciones.';

-- colpazdb.activities definition
CREATE TABLE activities
(
	`id` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador unico autoincremental',
    `title` VARCHAR(150) NOT NULL COMMENT 'Titulo de la evaluacion',
    `description` VARCHAR(255) NOT NULL COMMENT 'Descripcion de la evaluacion',
    `percentage` VARCHAR(100) NOT NULL COMMENT 'Porcentaje que vale la evaluacion',
    `date` DATE NOT NULL COMMENT 'Fecha limite de la evaluacion',
    `content_id` INT(11) NOT NULL COMMENT 'Identificador del contenido relacionado con la evaluacion',
    `created` DATETIME NOT NULL COMMENT 'Fecha y hora de creacion del registro',
    `modified` TIMESTAMP NOT NULL COMMENT 'Marca de tiempo que se actualiza al modificar el registro',
    `is_active` TINYINT NOT NULL DEFAULT 1 COMMENT 'Indicador de activacion (1 para activo, 0 para inactivo)',
    `idr` INT(11) NOT NULL DEFAULT 0 COMMENT 'Campo que almacena el id unico de la sede',
    `custom_fields` LONGTEXT COMMENT 'Campo personalizado para almacenar informacion adicional' CHECK (json_valid(`custom_fields`)),
    PRIMARY KEY (`id`) USING BTREE,
    FOREIGN KEY (`content_id`) REFERENCES contents (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
    INDEX `idx_content_id` (`content_id`) USING BTREE COMMENT 'indice para mejorar el rendimiento en búsquedas por content_id'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin COMMENT 'Tabla que almacena informacion sobre las evaluaciones.';

-- colpazdb.submitted_activities definition
CREATE TABLE submitted_activities
(
	`id` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador unico autoincremental',
    `comment` VARCHAR(500) COMMENT 'Comentario asociado a la evaluacion',
    `topic` VARCHAR(150) COMMENT 'Tema de la evaluacion',
    `activity_id` INT(11) NOT NULL COMMENT 'Identificador de la actividad asociado a la entrega',
    `user_id` INT(11) NOT NULL COMMENT 'Identificador del usuario asociado a la entrega',
    `file` LONGTEXT COMMENT 'Contenido o referencia al archivo de la evaluacion',
    `created` DATETIME NOT NULL COMMENT 'Fecha y hora de creacion del registro',
    `modified` TIMESTAMP NOT NULL COMMENT 'Marca de tiempo que se actualiza al modificar el registro',
    `is_active` TINYINT NOT NULL DEFAULT 1 COMMENT 'Indicador de activacion (1 para activo, 0 para inactivo)',
    `idr` INT(11) NOT NULL DEFAULT 0 COMMENT 'Campo que almacena el id unico de la sede',
    `custom_fields` LONGTEXT COMMENT 'Campo personalizado para almacenar informacion adicional' CHECK (json_valid(`custom_fields`)),
    PRIMARY KEY (`id`) USING BTREE,
    FOREIGN KEY (`activity_id`) REFERENCES activities (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
    FOREIGN KEY (`user_id`) REFERENCES users (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
    INDEX `idx_activity_id` (`activity_id`) USING BTREE COMMENT 'indice para mejorar el rendimiento en busquedas por activity_id',
    INDEX `idx_user_id` (`user_id`) USING BTREE COMMENT 'indice para mejorar el rendimiento en busquedas por user_id'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin COMMENT 'Tabla que almacena las evaluaciones subidas por los usuarios.';

-- colpazdb.marks definition
CREATE TABLE marks
(
    `id` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador unico autoincremental',
	`submitted_activity_id` INT(11) NOT NULL COMMENT 'Identificador de la actividad asociado a la nota',
    `mark_value` INT(11) NOT NULL COMMENT 'Campo para almacenar el valor de la nota',
    `created` DATETIME NOT NULL COMMENT 'Fecha y hora de creacion del registro',
    `modified` TIMESTAMP NOT NULL COMMENT 'Marca de tiempo que se actualiza al modificar el registro',
    `idr` INT(11) NOT NULL DEFAULT 0 COMMENT 'Campo que almacena el id unico de la sede',
    `is_active` TINYINT NOT NULL DEFAULT 1 COMMENT 'Indicador de activacion (1 para activo, 0 para inactivo)',
    `custom_fields` LONGTEXT COMMENT 'Campo personalizado para almacenar informacion adicional' CHECK (json_valid(`custom_fields`)),
    PRIMARY KEY (`id`) USING BTREE,
    FOREIGN KEY (`submitted_activity_id`) REFERENCES submitted_activities (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
    INDEX `idx_submitted_activity_id` (`submitted_activity_id`) USING BTREE COMMENT 'indice para mejorar el rendimiento en búsquedas por submitted_activity_id'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin COMMENT 'Tabla que establece la relacion entre usuarios y evaluaciones.';

-- colpazdb.auths definition
CREATE TABLE auths
(
	`id` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador unico autoincremental',
    `user_id` INT(11) NOT NULL COMMENT 'Identificador del usuario asociado a la autenticacion',
    `source_id` INT(11) NOT NULL COMMENT 'Identificador de la fuente de autenticación',
    `created` DATETIME NOT NULL COMMENT 'Fecha y hora de creacion del registro',
    `modified` TIMESTAMP NOT NULL COMMENT 'Marca de tiempo que se actualiza al modificar el registro',
    `is_active` TINYINT NOT NULL DEFAULT 1 COMMENT 'Indicador de activacion (1 para activo, 0 para inactivo)',
    `source` VARCHAR(255) NOT NULL COMMENT 'Fuente de autenticación (p. ej., nombre de la plataforma)',
    `idr` INT(11) NOT NULL DEFAULT 0 COMMENT 'Campo que almacena el id unico de la sede',
    `custom_fields` LONGTEXT COMMENT 'Campo personalizado para almacenar informacion adicional' CHECK (json_valid(`custom_fields`)),
    PRIMARY KEY (`id`) USING BTREE,
    FOREIGN KEY (`user_id`) REFERENCES users (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
    INDEX `idx_user_id` (`user_id`) USING BTREE COMMENT 'indice para mejorar el rendimiento en búsquedas por user_id'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin COMMENT 'Tabla que almacena informacion sobre las autenticaciones de usuarios.';

-- colpazdb.audits definition
CREATE TABLE audits
(
	`id` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador unico autoincremental',
    `actions` INT(11) NOT NULL COMMENT 'Acciones que realice el usuario',
	`created` DATETIME NOT NULL COMMENT 'Fecha y hora de creacion del registro',
    `modified` TIMESTAMP NOT NULL COMMENT 'Marca de tiempo que se actualiza al modificar el registro',
    `is_active` TINYINT NOT NULL DEFAULT 1 COMMENT 'Indicador de activacion (1 para activo, 0 para inactivo)',
    `idr` INT(11) NOT NULL DEFAULT 0 COMMENT 'Campo que almacena el id unico de la sede',
    `custom_fields` LONGTEXT COMMENT 'Campo personalizado para almacenar informacion adicional' CHECK (json_valid(`custom_fields`)),
    PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin COMMENT 'Tabla que almacena informacion sobre auditorias realizadas.';

-- colpazdb.user_audits definition
CREATE TABLE user_audits
(
	`id` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador unico autoincremental',
	`user_id` INT(11) NOT NULL COMMENT 'Identificador del usuario asociado',
    `audit_id` INT(11) NOT NULL COMMENT 'Identificador de la auditoria asociada',
    `created` DATETIME NOT NULL COMMENT 'Fecha y hora de creacion del registro',
    `modified` TIMESTAMP NOT NULL COMMENT 'Marca de tiempo que se actualiza al modificar el registro',
    `is_active` TINYINT NOT NULL DEFAULT 1 COMMENT 'Indicador de activacion (1 para activo, 0 para inactivo)',
    `idr` INT(11) NOT NULL DEFAULT 0 COMMENT 'Campo que almacena el id unico de la sede',
    `custom_fields` LONGTEXT COMMENT 'Campo personalizado para almacenar informacion adicional' CHECK (json_valid(`custom_fields`)),
    PRIMARY KEY (`id`) USING BTREE,
    FOREIGN KEY (`user_id`) REFERENCES users (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
    FOREIGN KEY (`audit_id`) REFERENCES audits (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
    INDEX `idx_user_id` (`user_id`) USING BTREE COMMENT 'indice para mejorar el rendimiento en búsquedas por user_id',
    INDEX `idx_audit_id` (`audit_id`) USING BTREE COMMENT 'indice para mejorar el rendimiento en búsquedas por audit_id'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin COMMENT 'Tabla que almacena las acciones de las auditorias de usuarios.';

-- colpazdb.campuses definition
CREATE TABLE campuses
(
	`idr` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador unico autoincremental',
    `name` VARCHAR(255) NOT NULL COMMENT 'Nombre de la sede',
	`description` VARCHAR(255) COMMENT 'Descripcion de la sede',
    `created` DATETIME NOT NULL COMMENT 'Fecha y hora de creacion del registro',
    `modified` TIMESTAMP NOT NULL COMMENT 'Marca de tiempo que se actualiza al modificar el registro',
    `is_active` TINYINT NOT NULL DEFAULT 1 COMMENT 'Indicador de activacion (1 para activo, 0 para inactivo)',
    `custom_fields` LONGTEXT COMMENT 'Campo personalizado para almacenar informacion adicional' CHECK (json_valid(`custom_fields`)),
    PRIMARY KEY (`idr`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin COMMENT 'Tabla que almacena las sedes que maneja el colegio.';

-- colpazdb.zones definition
CREATE TABLE zones
(
	`id` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador unico autoincremental',
    `name` VARCHAR(255) NOT NULL COMMENT 'Nombre de la zona de la sede',
    `created` DATETIME NOT NULL COMMENT 'Fecha y hora de creacion del registro',
    `modified` TIMESTAMP NOT NULL COMMENT 'Marca de tiempo que se actualiza al modificar el registro',
    `is_active` TINYINT NOT NULL DEFAULT 1 COMMENT 'Indicador de activacion (1 para activo, 0 para inactivo)',
    `idr` INT(11) NOT NULL DEFAULT 0 COMMENT 'Campo que almacena el id unico de la sede',
    `custom_fields` LONGTEXT COMMENT 'Campo personalizado para almacenar informacion adicional' CHECK (json_valid(`custom_fields`)),
    PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin COMMENT 'Tabla que almacena las zonas que maneja cada sede.';

-- colpazdb.user_zones definition
CREATE TABLE user_zones
(
	`id` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador unico autoincremental',
    `user_id` INT(11) NOT NULL,
    `zone_id` INT(11) NOT NULL,
    `created` DATETIME NOT NULL COMMENT 'Fecha y hora de creacion del registro',
    `modified` TIMESTAMP NOT NULL COMMENT 'Marca de tiempo que se actualiza al modificar el registro',
    `is_active` TINYINT NOT NULL DEFAULT 1 COMMENT 'Indicador de activacion (1 para activo, 0 para inactivo)',
    `idr` INT(11) NOT NULL DEFAULT 0 COMMENT 'Campo que almacena el id unico de la sede',
    `custom_fields` LONGTEXT COMMENT 'Campo personalizado para almacenar informacion adicional' CHECK (json_valid(`custom_fields`)),
    PRIMARY KEY (`id`) USING BTREE,
    FOREIGN KEY (`user_id`) REFERENCES users (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
    FOREIGN KEY (`zone_id`) REFERENCES zones (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
    INDEX `idx_user_id` (`user_id`) USING BTREE,
    INDEX `idx_zone_id` (`zone_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin COMMENT 'Tabla que almacena los usuarios por zona que maneja cada sede.';

/* ========================== Crear vistas ============================================= */

-- colpazdb.view_roles definition
CREATE VIEW view_roles AS
SELECT * FROM roles;

-- colpazdb.view_identification definition
CREATE VIEW view_identifications AS
SELECT * FROM identification_types;

/* Vista de usuarios */
CREATE VIEW view_users AS
SELECT * FROM users;

/* Vista de usuario, identificacion y rol */
CREATE VIEW view_userIdentificationRol AS
SELECT users.name AS nameUser, users.lastname, users.identification, users.email, identification_types.name AS nameIdentification, roles.name
FROM users
INNER JOIN identification_types ON users.identification_type_id = identification_types.id
INNER JOIN roles ON users.role_id = roles.id;

/* Vista de grados academicos */
CREATE VIEW view_classrooms AS
SELECT * FROM classrooms;

/* =============================== Crear procedimientos almacenados de inserción ============================ */

/* Procedimiento de insercion de rol */
CREATE PROCEDURE sp_InsertRol(
	rol_name VARCHAR(255),
    rol_functions VARCHAR(255),
    rol_created DATETIME,
    rol_idr INT(11)
)
INSERT INTO roles (name, functions, created, idr)
VALUES (rol_name, rol_functions, rol_created, rol_idr);

/* Procedimiento de insercion de identificacion */
CREATE PROCEDURE sp_InsertIdentification(
	identification_name VARCHAR(255),
    identification_created DATETIME
)
INSERT INTO identification_types (name, created)
VALUES (identification_name, identification_created);

/* Procedimiento de insercion de usuario */
CREATE PROCEDURE sp_InsertUser(
    user_name VARCHAR(255),
    user_lastname VARCHAR(255),
    user_username VARCHAR(255),
    user_email VARCHAR(255),
    user_password_hash VARCHAR(255),
    user_password_reset_token VARCHAR(255),
    user_sex VARCHAR(10),
    user_identification_type_id INT(11),
    user_identification VARCHAR(20),
    user_email_confirmed_token VARCHAR(255),
    user_sms_code VARCHAR(6),
    user_birthdate DATE,
    user_created DATETIME,
    user_profile_image LONGTEXT,
    user_phone VARCHAR(20),
    user_validate TINYINT,
    user_api_key VARCHAR(255),
    user_role_id INT(11),
    user_idr INT(11)
)
INSERT INTO users (name, lastname, username, email, password_hash, password_reset_token, sex, identification_type_id, identification, email_confirmed_token, sms_code, birthdate, created, profile_image, phone, validate, api_key, role_id, idr)
VALUES (user_name, user_lastname, user_username, user_email, user_password_hash, user_password_reset_token, user_sex, user_identification_type_id, user_identification, user_email_confirmed_token, user_sms_code, user_birthdate, user_created, user_profile_image, user_phone, user_validate, user_api_key, user_role_id, user_idr);

/* Procedimiento de insercion de autenticación */
CREATE PROCEDURE sp_InsertAuth(
	auth_user_id INT(11),
    auth_source_id INT(11),
    auth_created DATETIME,
    auth_source VARCHAR(255)
)
INSERT INTO auths (user_id, source_id, created, source)
VALUES (auth_user_id, auth_source_id, auth_created, auth_source);

/* Procedimiento de insercion de cursos */
CREATE PROCEDURE sp_InsertCourse(
	course_name VARCHAR(255),
    course_description VARCHAR(255),
    course_created DATETIME
)
INSERT INTO courses (name, description, created)
VALUES (course_name, course_description, course_created);

/* Procedimiento de insercion de grados academicos */
CREATE PROCEDURE sp_InsertDegree(
	degree_name VARCHAR(255),
	degree_created DATETIME,
    degree_idr INT(11)
)
INSERT INTO degrees(name, created, idr)
VALUES (degree_name, degree_created, degree_idr);

-- colpazdb.insertCampuses definition
CREATE PROCEDURE sp_InsertCampuses(
	campuses_name VARCHAR(255),
    campuses_description VARCHAR(255),
    campuses_created DATETIME
)
INSERT INTO campuses (name, description, created)
VALUES (campuses_name, campuses_description, campuses_created);

/* Procedimiento de insercion de envio de evaluaciones */
CREATE PROCEDURE sp_InsertActivitySubmissions(
	activity_submi_description VARCHAR(255),
    activity_submi_mark FLOAT,
    activity_submi_topic VARCHAR(255),
    activity_submi_course_id INT,
    activity_submi_classroom_id INT,
    activity_submi_file LONGTEXT,
    activity_submi_created DATETIME
)
INSERT INTO activity_submissions (description, mark, topic, course_id, classroom_id, file, created)
VALUES (activity_submi_description, activity_submi_mark, activity_submi_topic, activity_submi_course_id, activity_submi_classroom_id, activity_submi_file, activity_submi_created);

/* Procedimiento de insercion de contenido de evaluaciones */
CREATE PROCEDURE sp_InsertContent(
	content_description VARCHAR(500),
    content_title VARCHAR(255),
    content_type INT,
    content_file LONGTEXT,
    content_course_id INT,
    content_created DATETIME
)
INSERT INTO contents (description, title, type, file, course_id, created)
VALUES (content_description, content_title, content_type, content_file, content_course_id, content_created);

/* Procedimiento de insercion de evaluaciones */
CREATE PROCEDURE sp_InsertActivity(
	activity_title VARCHAR(255),
    activity_description VARCHAR(500),
    activity_date_limit DATETIME,
    activity_course_id INT,
	activity_classroom_id INT,
    activity_activity_submission_id INT,
    activity_content_id INT,
    activity_created DATETIME
)
INSERT INTO activities (title, description, date_limit, course_id, classroom_id, activity_submission_id, content_id, created)
VALUES (activity_title, activity_description, activity_date_limit, activity_course_id, activity_classroom_id, activity_activity_submission_id, activity_content_id, activity_created);

/* Procedimiento de insercion de usuario_evaluacion_entregada */
CREATE PROCEDURE sp_InsertUserActivitySubmission(
	user_activity_userid INT,
    user_activity_activitysubmissionid INT
)
INSERT INTO user_activities (user_id, activity_submission_id)
VALUES (user_activity_userid, user_activity_activitysubmissionid);

/* ==================================== Crear procedimientos almacenados de actualizacion ============================ */

/* Procedimiento de actualización de usuario */
CREATE PROCEDURE sp_UpdateUser(
	user_username VARCHAR(255),
    user_birthdate DATE,
    user_phone VARCHAR(20),
	user_id INT
)
UPDATE users SET username = user_username, birthdate = user_birthdate, phone = user_phone WHERE id = user_id;

/* Procedimiento de actualización de grados academicos */
CREATE PROCEDURE sp_UpdateClassroom(
	classroom_id INT,
    classroom_new_name VARCHAR(255)
)
UPDATE classrooms SET name = classroom_new_name WHERE id = classroom_id;

/* ================================ Crear procedimientos almacenados de eliminar ========================= */

/* Procedimiento de eliminar usuario */
CREATE PROCEDURE sp_DeleteUser(
	user_id INT
)
UPDATE users SET is_active = 0 WHERE id = user_id;

/* Procedimiento de eliminar grado académico */
CREATE PROCEDURE sp_DeleteClassroom(
	classroom_id INT
)
UPDATE classrooms SET is_active = 0 WHERE id = classroom_id;

/* ======================= Insercion de registros por procedimientos almacenados ================= */

CALL sp_InsertRol ("SuperAdministrador", "Administrador general del programa", "2023-10-21", 0);
CALL sp_InsertRol ("Administrador", "Administrador de cada sede", "2023-10-21", 1);
CALL sp_InsertRol ("Docente", "Docente", "2023-10-21", 1);
CALL sp_InsertRol ("Estudiante", "Estudiante", "2023-10-21", 1);
CALL sp_InsertRol ("Usuario Provisional", "Navegacion", "2023-10-21", 1);
CALL sp_InsertIdentification ("Cédula", "2023-10-21");
CALL sp_InsertIdentification ("Tarjeta de Identidad", "2023-10-21");
CALL sp_InsertIdentification ("Registro Civil", "2023-10-21");
CALL sp_InsertIdentification ("Cédula de Extranjería", "2023-10-21");
CALL sp_InsertCampuses ("Sede General", "Sede General, para el administrador general del sistema", "2023-12-09 00:00:00");
CALL sp_InsertCampuses ("Colegio Centro Quipama", "Colegio ubicado en el casco urbano de Quipama", "2023-12-09 00:00:00");
CALL sp_InsertCampuses ("Colegio Floresta Quipama", "Colegio ubicado en la zona minera de Quipama", "2023-12-09 00:00:00");
CALL sp_InsertCampuses ("Colegio Cormal Quipama", "Colegio ubicado en la zona rural para Otanche de Quipama", "2023-12-09 00:00:00");
CALL sp_InsertUser ("Admin", "Superior", "admin", "admin@gmail.com", "$2y$10$0kFnZhqxkDdLl93Jb60cfuusVJ8X8w5H7cSV2eohrn55HsVFt1KTm", "0WREIsw8xwhwpm2Qvmd3RWFvsevQhmgM", "M", 1, "admin", "mWPaI4bf8EGpiqqgbgJfoSWSxXGWDhbSBzst6zzlBrQcboSFYb0w4ZpvWIkk", "1111", "2002-09-01", "2023-10-21", "nodisponible.jpg", "1234567890", 1, "85e672dc-db55-4ce9-ba3a-c604eea478aa", 1, 1);
CALL sp_InsertAuth(1, 1, "2023-12-08", "SYNC");
CALL sp_InsertDegree("Sexto","2023-10-21", 1);
CALL sp_InsertDegree("Septimo","2023-10-21", 1);
CALL sp_InsertDegree("Octavo","2023-10-21", 1);
CALL sp_InsertDegree("Noveno","2023-10-21", 1);
CALL sp_InsertDegree("Decimo","2023-10-21", 1);
CALL sp_InsertDegree("Undecimo","2023-10-21", 1);

/*======================== INSERTAR MENUS ACCESIBLES A USUARIOS =====================*/

INSERT INTO menus (name,route,identification,`group`,created,modified,is_active,custom_fields) VALUES
	 ('Dashboard','../home/','dashboard','Dashboard','2024-04-16 00:00:00','2024-04-16 11:26:45',1,NULL),
	 ('Usuarios','../users/','users','Gestion','2024-04-16 00:00:00','2024-04-16 11:26:45',1,NULL),
	 ('Tipo Identificaciones','../identificationTypes/','identificationTypes','Gestion','2024-04-16 00:00:00','2024-04-16 11:26:45',1,NULL),
	 ('Roles','../roles/','roles','Gestion','2024-04-16 00:00:00','2024-04-16 11:26:45',1,NULL),
	 ('Periodos','../periods/','periods','Gestion','2024-04-16 00:00:00','2024-04-16 11:26:45',1,NULL),
	 ('Grados','../degrees/','degrees','Gestion','2024-04-16 00:00:00','2024-04-16 11:26:45',1,NULL),
	 ('Aulas','../classrooms/','classrooms','Gestion','2024-04-16 00:00:00','2024-04-16 11:26:45',1,NULL),
	 ('Cursos','../courses/','courses','Gestion','2024-04-16 00:00:00','2024-04-16 11:26:45',1,NULL),
	 ('Alumnos Profesor','../studentTeachers/','studentTeachers','Gestion','2024-04-16 00:00:00','2024-04-16 11:26:45',1,NULL),
	 ('Cursos Profesor','../teacherCourses/','teacherCourses','Gestion','2024-04-16 00:00:00','2024-04-16 11:26:45',1,NULL),
	 ('Cabecera Contenido','../headerContents/','headerContents','Gestion','2024-04-16 00:00:00','2024-04-16 11:26:45',1,NULL),
	 ('Sedes','../campuses/','campuses','Gestion','2024-04-16 00:00:00','2024-04-16 11:26:45',1,NULL);

INSERT INTO menu_roles (menu_id,role_id,permission,created,modified,is_active,custom_fields) VALUES
	 (1,1,'No','2024-04-16 00:00:00','2024-04-16 11:26:45',1,NULL),
	 (2,1,'No','2024-04-16 00:00:00','2024-04-16 11:26:45',1,NULL),
	 (3,1,'No','2024-04-16 00:00:00','2024-04-16 11:26:45',1,NULL),
	 (4,1,'Si','2024-04-16 00:00:00','2024-04-16 11:26:45',1,NULL),
	 (5,1,'No','2024-04-16 00:00:00','2024-04-16 11:26:45',1,NULL),
	 (6,1,'No','2024-04-16 00:00:00','2024-04-16 11:26:45',1,NULL),
	 (7,1,'No','2024-04-16 00:00:00','2024-04-16 11:26:45',1,NULL),
	 (8,1,'No','2024-04-16 00:00:00','2024-04-16 11:26:45',1,NULL),
	 (9,1,'No','2024-04-16 00:00:00','2024-04-16 11:26:45',1,NULL),
	 (10,1,'No','2024-04-16 00:00:00','2024-04-16 11:26:45',1,NULL),
	 (11,1,'No','2024-04-16 00:00:00','2024-04-16 11:26:45',1,NULL),
	 (12,1,'No','2024-04-16 00:00:00','2024-04-16 11:26:45',1,NULL);
	 
INSERT INTO menu_roles (menu_id,role_id,permission,created,modified,is_active,custom_fields) VALUES
	 (1,2,'No','2024-04-16 00:00:00','2024-04-16 11:26:45',1,NULL),
	 (2,2,'No','2024-04-16 00:00:00','2024-04-16 11:26:45',1,NULL),
	 (3,2,'No','2024-04-16 00:00:00','2024-04-16 11:26:45',1,NULL),
	 (4,2,'Si','2024-04-16 00:00:00','2024-04-16 11:26:45',1,NULL),
	 (5,2,'No','2024-04-16 00:00:00','2024-04-16 11:26:45',1,NULL),
	 (6,2,'No','2024-04-16 00:00:00','2024-04-16 11:26:45',1,NULL),
	 (7,2,'No','2024-04-16 00:00:00','2024-04-16 11:26:45',1,NULL),
	 (8,2,'No','2024-04-16 00:00:00','2024-04-16 11:26:45',1,NULL),
	 (9,2,'No','2024-04-16 00:00:00','2024-04-16 11:26:45',1,NULL),
	 (10,2,'No','2024-04-16 00:00:00','2024-04-16 11:26:45',1,NULL),
	 (11,2,'No','2024-04-16 00:00:00','2024-04-16 11:26:45',1,NULL),
	 (12,2,'No','2024-04-16 00:00:00','2024-04-16 11:26:45',1,NULL);