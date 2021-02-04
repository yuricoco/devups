     ALTER TABLE dv_image ADD position_id INT DEFAULT NULL;
     ALTER TABLE dv_image ADD CONSTRAINT FK_40FCDD59DD842E46 FOREIGN KEY (position_id) REFERENCES tree_item (id);
     CREATE INDEX IDX_40FCDD59DD842E46 ON dv_image (position_id);
