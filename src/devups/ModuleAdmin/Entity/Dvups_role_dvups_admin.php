<?php 
    
    /**
     * @Entity @Table(name="dvups_role_dvups_admin")
     * */
    class Dvups_role_dvups_admin extends Model implements JsonSerializable{

        /**
         * @Id @GeneratedValue @Column(type="integer")
         * @var int
         * */
        protected $id;
        
        /**
         * @ManyToOne(targetEntity="\Dvups_admin")
         * @JoinColumn(onDelete="cascade")
         * @var \Dvups_admin
         */
        public $dvups_admin;

        /**
         * @ManyToOne(targetEntity="\Dvups_role")
         * @JoinColumn(onDelete="cascade")
         * @var \Dvups_role
         */
        public $dvups_role;


        
        public function __construct($id = null){
            
                if( $id ) { $this->id = $id; }   
                          
	$this->dvups_admin = new Dvups_admin();
	$this->dvups_role = new Dvups_role();
}

        public function getId() {
            return $this->id;
        }

        public function setId($id) {
            $this->id = $id;
        }
        /**
         *  manyToOne
         *	@return \Dvups_admin
         */
        function getDvups_admin() {
            return $this->dvups_admin;
        }
        function setDvups_admin(\Dvups_admin $dvups_admin) {
            $this->dvups_admin = $dvups_admin;
        }
                        
        /**
         *  manyToOne
         *	@return \Dvups_role
         */
        function getDvups_role() {
            return $this->dvups_role;
        }
        function setDvups_role(\Dvups_role $dvups_role) {
            $this->dvups_role = $dvups_role;
        }
                        
                        
        public function scan_entity_core(){
            return Core::__extract(__DIR__, $this);
        }
        
        public function jsonSerialize() {
                return [
                                'dvups_admin' => $this->dvups_admin,
                                'dvups_role' => $this->dvups_role,
                ];
        }
        
}
