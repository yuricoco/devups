<?php 
    
    /**
     * @Entity @Table(name="dvups_role_dvups_module")
     * */
    class Dvups_role_dvups_module extends Model implements JsonSerializable{

        /**
         * @Id @GeneratedValue @Column(type="integer")
         * @var int
         * */
        protected $id;
        
        /**
         * @ManyToOne(targetEntity="\Dvups_module")
         * @JoinColumn(onDelete="cascade")
         * @var \Dvups_module
         */
        public $dvups_module;

        /**
         * @ManyToOne(targetEntity="\Dvups_role")
         * @JoinColumn(onDelete="cascade")
         * @var \Dvups_role
         */
        public $dvups_role;


        
        public function __construct($id = null){
            
                if( $id ) { $this->id = $id; }   
                          
	$this->dvups_module = new Dvups_module();
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
         *	@return \Dvups_module
         */
        function getDvups_module() {
            return $this->dvups_module;
        }
        function setDvups_module(\Dvups_module $dvups_module) {
            $this->dvups_module = $dvups_module;
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
                                'dvups_module' => $this->dvups_module,
                                'dvups_role' => $this->dvups_role,
                ];
        }
        
}
