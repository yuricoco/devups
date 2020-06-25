<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Database
 *
 * @author yuri coco
 */
class Database {
	
    protected $link;
    protected $dbname;
	
    public function __construct() {
        
        $user = dbuser;
        $pass = dbpassword;
        $dsn = 'mysql:host='.dbhost.';dbname='. dbname;
        $this->dbname = dbname;
        
        try {
                $this->link = new PDO($dsn, $user, $pass);
        } catch (PDOException $e) {
                //die( "Erreur ! : ". $e->getMessage() );
                $this->exist = false;
                // connexion à Mysql sans base de données
                $pdo = new PDO('mysql:host=localhost', $user, $pass);

                // création de la requête sql
                // on teste avant si elle existe ou non (par sécurité)
                $requete = "CREATE DATABASE IF NOT EXISTS `".dbname."` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci";

                // on prépare et on exécute la requête
                $pdo->prepare($requete)->execute();

        }
        
    }

    /**
     * @return PDO
     */
    public function link(){
        return $this->link;
    }

}