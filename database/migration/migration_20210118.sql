     CREATE TABLE dv_image (id INT AUTO_INCREMENT NOT NULL, reference VARCHAR(123) NOT NULL, name VARCHAR(123) NOT NULL, description LONGTEXT DEFAULT NULL, image VARCHAR(255) NOT NULL, size DOUBLE PRECISION DEFAULT NULL, width DOUBLE PRECISION DEFAULT NULL, height DOUBLE PRECISION DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, deleted_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB;
     ALTER TABLE emailmodel ADD style LONGTEXT DEFAULT NULL;