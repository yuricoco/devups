     CREATE TABLE dvups_component (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, deleted_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB;
     ALTER TABLE dvups_module ADD dvups_component_id INT DEFAULT NULL, CHANGE name name VARCHAR(50) NOT NULL;
     ALTER TABLE dvups_module ADD CONSTRAINT FK_EC710C07CA110089 FOREIGN KEY (dvups_component_id) REFERENCES dvups_component (id);
     CREATE INDEX IDX_EC710C07CA110089 ON dvups_module (dvups_component_id);
     CREATE TABLE dvups_role_dvups_component (id INT AUTO_INCREMENT NOT NULL, dvups_component_id INT DEFAULT NULL, dvups_role_id INT DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, deleted_at DATETIME DEFAULT NULL, INDEX IDX_506ABAD5CA110089 (dvups_component_id), INDEX IDX_506ABAD57D324ADF (dvups_role_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB;
     ALTER TABLE dvups_role_dvups_component ADD CONSTRAINT FK_506ABAD5CA110089 FOREIGN KEY (dvups_component_id) REFERENCES dvups_component (id);
     ALTER TABLE dvups_role_dvups_component ADD CONSTRAINT FK_506ABAD57D324ADF FOREIGN KEY (dvups_role_id) REFERENCES dvups_role (id);
     ALTER TABLE dvups_component ADD label VARCHAR(50) NOT NULL;
     CREATE TABLE configuration (id INT AUTO_INCREMENT NOT NULL, _key VARCHAR(150) NOT NULL, _value VARCHAR(255) NOT NULL, _type VARCHAR(150) DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, deleted_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB;
     ALTER TABLE dvups_component ADD url VARCHAR(25) DEFAULT NULL;
     ALTER TABLE dvups_entity CHANGE name name VARCHAR(50) NOT NULL, CHANGE label label VARCHAR(50) NOT NULL;
     ALTER TABLE dvups_module ADD url VARCHAR(25) DEFAULT NULL, CHANGE label label VARCHAR(50) NOT NULL;
