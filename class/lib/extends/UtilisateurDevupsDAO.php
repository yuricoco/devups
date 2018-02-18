<?php 

    class UtilisateurDevupsDAO extends DBAL{

        public function findByConnectic($login, $pwd){
            $req = $this->link->prepare("SELECT * FROM utilisateur WHERE login= ? and password = ?");
            $req->execute(array($login, sha1($pwd)));
            $instanceUser = $req->fetchObject('Utilisateur');

            if($instanceUser == null)
					$instanceUser = array('Login ou mot de passe incorrect.');

            return $instanceUser;
        }

        public function selectall(Utilisateur $utilisateur){
            //$query = $this->link->query("select * from utilisateur WHERE id != ".$utilisateur->getId());
            $array = $query = $this->findAllByCritereDbal("WHERE id != 1 AND id != ".$utilisateur->getId());
            return $array;
        }

        public function selectButAdmin(){
            $query = $this->findAllByCritereDbal("WHERE id != 1");
            
            //$array = $this->instance($query->fetchAll(PDO::FETCH_CLASS, 'Utilisateur'));
            return $query;
        }

    }
