<?php 
        // user \dclass\devups\model\Model;
    /**
     * @Entity @Table(name="social_network")
     * */
    class Social_network extends Model implements JsonSerializable{

        /**
         * @Id @GeneratedValue @Column(type="integer")
         * @var int
         * */
        protected $id;
        /**
         * @Column(name="name", type="string" , length=150 )
         * @var string
         **/
        protected $name;
        /**
         * @Column(name="logo", type="string" , length=255, nullable=true )
         * @var string
         **/
        protected $logo;
        

        
        public function __construct($id = null){
            
                if( $id ) { $this->id = $id; }   
                          
}

        public function getId() {
            return $this->id;
        }
        public function getName() {
            return $this->name;
        }

        public function setName($name) {
            $this->name = $name;
        }
        
                        
        public function uploadLogo($file = 'logo') {
            $dfile = self::Dfile($file);
            if(!$dfile->errornofile){
            
                $filedir = 'logo/';
                $url = $dfile
                    ->hashname()
                    ->moveto($filedir);
    
                if (!$url['success']) {
                    return 	array(	'success' => false,
                        'error' => $url);
                }
    
                $this->logo = $url['file']['hashname'];            
            }
        }     
             
        public function showLogo() {
            $url = Dfile::show($this->logo, 'social_network');
            return Dfile::fileadapter($url, $this->logo);
        }
        
        public function getLogo() {
            return $this->logo;
        }

        public function setLogo($logo) {
            $this->logo = $logo;
        }
        
        
        public function jsonSerialize() {
                return [
                        'id' => $this->id,
                                'name' => $this->name,
                                'logo' => $this->logo,
                ];
        }
        
}
