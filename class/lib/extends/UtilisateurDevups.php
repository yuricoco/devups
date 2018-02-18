<?php 
        class UtilisateurDevups extends UploadFile{

        /**
         * @param mixed $login
         */
        public function generateLogin()//on envoi une liste de login
        {
            $list = "1234567890";
            mt_srand((double)microtime()*10000);
            $generate="";
            while( strlen( $generate )< 4 ) {
                $generate .= $list[mt_rand(0, strlen($list)-1)];
            }
			
            if(strlen($this->nom) > 6)
                $alias = substr($this->nom, 0, -(strlen($this->nom) - 6));
            else
                $alias = $this->nom;
            
            $this->login = $this->wd_remove_accents($alias).$generate;
            $login = strtolower($this->login);
            return $login;
        }
        /**
         * @param mixed
         */
        public function generatePassword()
        {
            $list = "0123456789abcdefghijklmnopqrstvwxyz";
            mt_srand((double)microtime()*1000000);
            $password="";
            while( strlen( $password )< 8 ) {
                $password .= $list[mt_rand(0, strlen($list)-1)];
            }
            return $password;
        }

}
