<?php 
    
    /**
     * @Entity @Table(name="dvups_role_dvups_entity")
     * */
    class Dvups_role_dvups_entity extends Model implements JsonSerializable{

        /**
         * @Id @GeneratedValue @Column(type="integer")
         * @var int
         * */
        protected $id;
        
        /**
         * @ManyToOne(targetEntity="\Dvups_entity")
         * @JoinColumn(onDelete="cascade")
         * @var \Dvups_entity
         */
        public $dvups_entity;

        /**
         * @ManyToOne(targetEntity="\Dvups_role")
         * @JoinColumn(onDelete="cascade")
         * @var \Dvups_role
         */
        public $dvups_role;


        
        public function __construct($id = null){
            
                if( $id ) { $this->id = $id; }   
                          
	$this->dvups_entity = new Dvups_entity();
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
         *	@return \Dvups_entity
         */
        function getDvups_entity() {
            return $this->dvups_entity;
        }
        function setDvups_entity(\Dvups_entity $dvups_entity) {
            $this->dvups_entity = $dvups_entity;
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
                                'dvups_entity' => $this->dvups_entity,
                                'dvups_role' => $this->dvups_role,
                ];
        }
        
}
