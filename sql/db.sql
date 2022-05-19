-- Create user table 
CREATE TABLE IF NOT EXISTS blog_recetas.users (
    user_id INT(11) NOT NULL AUTO_INCREMENT,
    user_name VARCHAR(200) NOT NULL,
    user_email VARCHAR(250) NOT NULL,
    user_password VARCHAR(250) NOT NULL,
    user_rol INT(11) NOT NULL DEFAULT '0',
    user_status INT(1) NOT NULL DEFAULT '0',
    user_creat DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    user_update DATETIME on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (user_id),
    UNIQUE (user_email)
) ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS blog_recetas.cats (
    cat_id INT(11) NOT NULL AUTO_INCREMENT,
    cat_name VARCHAR(250) NOT NULL,
    cat_img VARCHAR(250) NOT NULL,
    cat_creat DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    cat_update DATETIME on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (cat_id)
) ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS blog_recetas.recetas (
    receta_id INT(11) NOT NULL AUTO_INCREMENT,
    receta_name VARCHAR(250) NOT NULL,
    receta_desc VARCHAR(250) NOT NULL,
    receta_img VARCHAR(250) NOT NULL,
    receta_content LONGTEXT NOT NULL,
    recetas_cat_id int(11) DEFAULT '0',
    recetas_author_id int(11) DEFAULT '0',
    recetas_status int(1) DEFAULT '0',
    receta_creat DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    receta_update DATETIME on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (receta_id)
) ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS blog_recetas.user_rol (
    rol_id int(11) NOT NULL AUTO_INCREMENT,
    rol_name VARCHAR(250) NOT NULL,
    PRIMARY KEY (rol_id)
) ENGINE = InnoDB;

-- Insertar roles
INSERT INTO
    `user_rol` (`rol_id`, `rol_name`)
VALUES
    (NULL, 'No registrado'),
    (NULL, 'usuario'),
    (NULL, 'editor'),
    (NULL, 'administrador');

-- reset table after testing
--SET
--    FOREIGN_KEY_CHECKS = 0;
--
--TRUNCATE table $ table_name;
--
--SET
--    FOREIGN_KEY_CHECKS = 1;