     CREATE TABLE activity_sector (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(123) NOT NULL, description LONGTEXT DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, deleted_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB;
     CREATE TABLE enterprise (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(155) NOT NULL, about VARCHAR(155) NOT NULL, email VARCHAR(155) NOT NULL, logo VARCHAR(255) DEFAULT NULL, banner VARCHAR(255) DEFAULT NULL, telephone VARCHAR(15) NOT NULL, website VARCHAR(155) DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, deleted_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB;
     CREATE TABLE enterprise_activity_sector (id INT AUTO_INCREMENT NOT NULL, activity_sector_id INT DEFAULT NULL, enterprise_id INT DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, deleted_at DATETIME DEFAULT NULL, INDEX IDX_46B6CD33398DEFD0 (activity_sector_id), INDEX IDX_46B6CD33A97D1AC3 (enterprise_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB;
     CREATE TABLE enterprise_join_venture (id INT AUTO_INCREMENT NOT NULL, join_venture_id INT DEFAULT NULL, enterprise_id INT DEFAULT NULL, status VARCHAR(15) DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, deleted_at DATETIME DEFAULT NULL, INDEX IDX_AA556792F60805C4 (join_venture_id), INDEX IDX_AA556792A97D1AC3 (enterprise_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB;
     CREATE TABLE join_venture (id INT AUTO_INCREMENT NOT NULL, submission_id INT DEFAULT NULL, description LONGTEXT NOT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, deleted_at DATETIME DEFAULT NULL, INDEX IDX_28FC1519E1FD4933 (submission_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB;
     CREATE TABLE join_venture_enterprise (id INT AUTO_INCREMENT NOT NULL, enterprise_id INT DEFAULT NULL, join_venture_id INT DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, deleted_at DATETIME DEFAULT NULL, INDEX IDX_9C9563F4A97D1AC3 (enterprise_id), INDEX IDX_9C9563F4F60805C4 (join_venture_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB;
     CREATE TABLE job (id INT AUTO_INCREMENT NOT NULL, enterprise_id INT DEFAULT NULL, description LONGTEXT NOT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, deleted_at DATETIME DEFAULT NULL, INDEX IDX_FBD8E0F8A97D1AC3 (enterprise_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB;
     CREATE TABLE offer (id INT AUTO_INCREMENT NOT NULL, enterprise_id INT DEFAULT NULL, description LONGTEXT NOT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, deleted_at DATETIME DEFAULT NULL, INDEX IDX_29D6873EA97D1AC3 (enterprise_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB;
     CREATE TABLE submission (id INT AUTO_INCREMENT NOT NULL, enterprise_id INT DEFAULT NULL, offer_id INT DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, deleted_at DATETIME DEFAULT NULL, INDEX IDX_DB055AF3A97D1AC3 (enterprise_id), INDEX IDX_DB055AF353C674EE (offer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB;
     CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, post_id INT DEFAULT NULL, enterprise_id INT DEFAULT NULL, content LONGTEXT NOT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, deleted_at DATETIME DEFAULT NULL, INDEX IDX_9474526C4B89032C (post_id), INDEX IDX_9474526CA97D1AC3 (enterprise_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB;
     CREATE TABLE post (id INT AUTO_INCREMENT NOT NULL, enterprise_id INT DEFAULT NULL, content LONGTEXT DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, deleted_at DATETIME DEFAULT NULL, INDEX IDX_5A8A6C8DA97D1AC3 (enterprise_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB;
     CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, enterprise_id INT DEFAULT NULL, firstname VARCHAR(155) NOT NULL, lastname VARCHAR(155) NOT NULL, sex VARCHAR(5) NOT NULL, profile VARCHAR(255) DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, deleted_at DATETIME DEFAULT NULL, INDEX IDX_8D93D649A97D1AC3 (enterprise_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB;
     ALTER TABLE enterprise_activity_sector ADD CONSTRAINT FK_46B6CD33398DEFD0 FOREIGN KEY (activity_sector_id) REFERENCES activity_sector (id);
     ALTER TABLE enterprise_activity_sector ADD CONSTRAINT FK_46B6CD33A97D1AC3 FOREIGN KEY (enterprise_id) REFERENCES enterprise (id);
     ALTER TABLE enterprise_join_venture ADD CONSTRAINT FK_AA556792F60805C4 FOREIGN KEY (join_venture_id) REFERENCES join_venture (id);
     ALTER TABLE enterprise_join_venture ADD CONSTRAINT FK_AA556792A97D1AC3 FOREIGN KEY (enterprise_id) REFERENCES enterprise (id);
     ALTER TABLE join_venture ADD CONSTRAINT FK_28FC1519E1FD4933 FOREIGN KEY (submission_id) REFERENCES submission (id);
     ALTER TABLE join_venture_enterprise ADD CONSTRAINT FK_9C9563F4A97D1AC3 FOREIGN KEY (enterprise_id) REFERENCES enterprise (id);
     ALTER TABLE join_venture_enterprise ADD CONSTRAINT FK_9C9563F4F60805C4 FOREIGN KEY (join_venture_id) REFERENCES join_venture (id);
     ALTER TABLE job ADD CONSTRAINT FK_FBD8E0F8A97D1AC3 FOREIGN KEY (enterprise_id) REFERENCES enterprise (id);
     ALTER TABLE offer ADD CONSTRAINT FK_29D6873EA97D1AC3 FOREIGN KEY (enterprise_id) REFERENCES enterprise (id);
     ALTER TABLE submission ADD CONSTRAINT FK_DB055AF3A97D1AC3 FOREIGN KEY (enterprise_id) REFERENCES enterprise (id);
     ALTER TABLE submission ADD CONSTRAINT FK_DB055AF353C674EE FOREIGN KEY (offer_id) REFERENCES offer (id);
     ALTER TABLE comment ADD CONSTRAINT FK_9474526C4B89032C FOREIGN KEY (post_id) REFERENCES post (id);
     ALTER TABLE comment ADD CONSTRAINT FK_9474526CA97D1AC3 FOREIGN KEY (enterprise_id) REFERENCES enterprise (id);
     ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8DA97D1AC3 FOREIGN KEY (enterprise_id) REFERENCES enterprise (id);
     ALTER TABLE user ADD CONSTRAINT FK_8D93D649A97D1AC3 FOREIGN KEY (enterprise_id) REFERENCES enterprise (id);
     ALTER TABLE storage DROP active;
