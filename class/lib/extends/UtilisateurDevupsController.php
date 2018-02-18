<?php 

    class UtilisateurDevupsController extends Controller{

        public function changepwAction(Utilisateur $utilisateur){
            
            extract($_POST);
            if (sha1($oldpwd) == $utilisateur->getPassword()){
                $utilisateur->setPassword(sha1($newpwd));
                return $this->utilisateurDao->update($utilisateur);
            }else{
                //return false;
                echo 'rien';
            }
        }
     
        public function deconnexionAction($utilisateur){
              /*$connexionDao = new ConnexionDAO();
              $UTILISATEURdao = new UtilisateurDAO();

              $connexion = $connexionDao->findByUTILISATEUR($utilisateur);
              $connexion->setDateFinConnexion(date('Y-m-d-H-i-s'));
              $connexionDao->update($connexion);
              $utilisateur->setEtat(false);
              $UTILISATEURdao->update($utilisateur);
              if(isset($_SESSION['utilisateur_isl'])){
                  $_SESSION = array();
                  session_destroy();
              }*/
                $_SESSION[UTILISATEUR] = array();
                session_destroy();
                return true;
        }

        public function connexionAction($login, $password){

                //$connexionDao = new ConnexionDAO();
                //$mdp = sha1($password);
                $utilisateur = $this->utilisateurDao->findByConnectic($login, $password);
                $_SESSION[UTILISATEUR] = serialize($utilisateur);

                if(!is_array($utilisateur) and is_object($utilisateur)){
                    /*if($utilisateur->getEtat()){
                        $this->deconnexionAction($utilisateur);
                        return  array('err' => 'Votre compte est connect�; Reprenez ou d�connecter vous d\'abord si connect�!!');
                    }else{*/
                        //$utilisateur->setEtat(true);
                        //$UTILISATEURdao->update($utilisateur);
                        //$connexion = new Connexion(date("Y-m-d-H-i-s"), date("Y-m-d-H-i-s", strtotime("0000-00-00-00-00-00")), $utilisateur->getIdUTILISATEUR());
                        //$connexionDao->create($connexion);
                        return 'ok';
                    //}
                }else{
                    return array('err' => 'login ou mot de passe incorrecte!');
                }
            //}
        }
		

    }
