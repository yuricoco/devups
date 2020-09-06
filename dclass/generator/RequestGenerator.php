<?php

class RequestGenerator
{
    protected $link;
    private $exist;

    public function __construct()
    {
        $this->exist = true;
    }

    public static function databasecreate($bdname)
    {

        $rqg = new RequestGenerator();

        $rqg->connexion($bdname);

    }

    public function connexion($dbname)
    {
        $user = dbuser;
        $pass = dbpassword;
        $dsn = 'mysql:host=' . dbhost . ';dbname=' . $dbname;
        try {
            $this->link = new PDO($dsn, $user, $pass);
        } catch (PDOException $e) {
            //die( "Erreur ! : ". $e->getMessage() );
            $this->exist = false;
            // connexion à Mysql sans base de données
            $pdo = new PDO('mysql:host=' . dbhost, $user, $pass);

            // création de la requête sql
            // on teste avant si elle existe ou non (par sécurité)
            $requete = "CREATE DATABASE IF NOT EXISTS `" . $dbname . "` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci";

            // on prépare et on exécute la requête
            $pdo->prepare($requete)->execute();

            $this->connexion($dbname);
        }

        // dans le cas ou la bd existe deja on la supprime avant de la recreer encore
        if ($this->exist) {
            $requete = 'DROP DATABASE ' . $dbname;
            $this->link->prepare($requete)->execute();
            $this->exist = false;

            $pdo = new PDO('mysql:host=' . dbhost, $user, $pass);
            $requete = "CREATE DATABASE IF NOT EXISTS `" . $dbname . "` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci";
            $pdo->prepare($requete)->execute();

            $this->link = new PDO($dsn, $user, $pass);
        }

    }

    function create($project)
    {
        //extract($_POST);
        $this->connexion($project->name . '_bd');

        $dumpsql = $this->dumpsql($project);
        $this->force($dumpsql);

        return $dumpsql;
    }

    function force($dumpsql)
    {

        $query = $this->link->prepare($dumpsql);
        $query->execute() or die(print_r($query->errorInfo()));

    }

    public function dumpsql($project)
    {

        /*----- création du fichier de la base de données. -------*/

        $entities = [];
        $modules = [];
        $entity_role = [];
        $module_role = [];

        $identity = 2; //nombre de gestion prédéfini
        $idmodule = 1;
        foreach ($project->listmodule as $module) {
            $idmodule++;
            $modules[] = "($idmodule, '" . $module->name . "', '" . $project->name . "')";
            $module_role[] = "( $idmodule, 1)";
            foreach ($module->listentity as $entity) {
                $identity++;
                $entities[] = "($identity, '" . strtolower($entity->name) . "', $idmodule)";

                $entity_role[] = "( $identity, 1)";
            }
        }

        $path = __DIR__ . '/config_data.sql';
        $dvupsadminsql = file_get_contents($path);


        $devups = "
                    -- phpMyAdmin SQL Dump
                    -- version 4.1.14
                    -- http://www.phpmyadmin.net
                    --
                    -- Client :  127.0.0.1
                    -- Généré le :  Ven 18 Mars 2016 à 15:36
                    -- Version du serveur :  5.6.17
                    -- Version de PHP :  5.5.12

                    SET SQL_MODE = 'NO_AUTO_VALUE_ON_ZERO';
                    SET time_zone = '+00:00';


                    /*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
                    /*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
                    /*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
                    /*!40101 SET NAMES utf8 */;

                    " . $dvupsadminsql . " 
                            
                            INSERT INTO `dvups_module` (`id`, `name`, `project`) VALUES
                            " . implode(',', $modules) . ";

                            INSERT INTO `dvups_entity` (`id`, `name`, `dvups_module_id`) VALUES
                            " . implode(',', $entities) . " ;
                            

                            INSERT INTO `dvups_role_dvups_module` ( `dvups_module_id`, `dvups_role_id`) VALUES
                            " . implode(',', $module_role) . ";
                            
                            INSERT INTO `dvups_role_dvups_entity` ( `dvups_entity_id`, `dvups_role_id`) VALUES
                            " . implode(',', $entity_role) . ";
                            
                        ";

        $contenu = $devups . "\n";

        //foreach($module as $sn){
        $attributrelie = array();
        $relation = array();
        foreach ($project->listmodule as $module) {
            //$repertoire = str_replace($antislash, "/", $module->module);
            foreach ($module->listentity as $entity) {

                $keys = array();
                //$contenu .= "\t\tentitye '".$repertoire."/Entity/".ucfirst($entity->name).".php';\n";
                $contenu .= "
                                            -- --------------------------------------------------------

                                            --
                                            -- Structure de la table `" . $entity->name . "`
                                            --

                                            CREATE TABLE IF NOT EXISTS `" . $entity->name . "` (
                                      \t\t`id` int(11) NOT NULL AUTO_INCREMENT";
                foreach ($entity->attribut as $attribut) {
                    if ($attribut->name != 'id') {
                        if ($attribut->datatype != 'string') {
                            $contenu .= ",\n\t\t\t\t\t\t\t`" . $attribut->name . "` " . $attribut->datatype . " " . $attribut->nullable . " NULL";
                        } elseif ($attribut->datatype == 'integer') {
                            $contenu .= ",\n\t\t\t\t\t\t\t`" . $attribut->name . "` int(11) " . $attribut->nullable . " NULL";
                        } elseif ($attribut->datatype == 'string') {
                            $contenu .= ",\n\t\t\t\t\t\t\t`" . $attribut->name . "` varchar(" . $attribut->size . ") " . $attribut->nullable . " NULL";
                        }
                    }
                }
                if (!empty($entity->relation)) {
                    foreach ($entity->relation as $relation) {
                        // and !in_array($entity, $attributrelie)
                        if ($relation->cardinality != 'manyToMany') {
                            $keys[] = $relation->entity;
                            $contenu .= ",\n\t\t\t\t\t\t\t`" . $relation->entity . "_id` int(11) " . $relation->nullable . " NULL";

                            if (!in_array($entity, $attributrelie))
                                $attributrelie[] = $entity;

                        }
                    }
                }
                $contenu .= "\n,
                                            PRIMARY KEY `id` (`id`)";
                if (!empty($keys)) {
                    foreach ($keys as $key) {
                        $contenu .= "\n\t\t\t\t\t\t\t,KEY `" . $key . "_id` (`" . $key . "_id`)";
                    }
                }
                $contenu .= "
                                            ) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;
                                            \n\n";

            }

        }

        if (!empty($attributrelie)) {
            foreach ($attributrelie as $entity) {
                $i = 1;
                $j = 1;
                $contenu .= "\n
                                    -- --------------------------------------------------------

                                    --
                                    -- Contraintes pour la table `" . $entity->name . "`
                                    --

                                    ALTER TABLE `" . $entity->name . "`";
                foreach ($entity->relation as $relation) {
                    if ($relation->cardinality != 'manyToMany') {
                        if ($i == $j + 1) {
                            $j = $i;
                            $contenu .= ",";
                        }
                        $contenu .= "
                                                    ADD CONSTRAINT `" . $entity->name . "_ibfk_" . $i . "` FOREIGN KEY (`" . $relation->entity . "_id`) REFERENCES `" . $relation->entity . "` (`id`)
                                                    ";
                        if ($relation->ondelete != 'RESTRICT') {
                            $contenu .= " ON DELETE " . $relation->ondelete;
                        }
                        if ($relation->onupdate != 'RESTRICT') {
                            $contenu .= " ON UPDATE " . $relation->onupdate;
                        }
                        $i++;
                    }
                }
                $contenu .= ";";
            }
        }
        //}

        return $devups;

    }

}