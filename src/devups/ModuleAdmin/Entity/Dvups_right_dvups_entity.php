<?php 
    
    /**
     * @Entity @Table(name="dvups_right_dvups_entity")
     * */
    class Dvups_right_dvups_entity extends Model implements JsonSerializable{

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
         * @ManyToOne(targetEntity="\Dvups_right")
         * @JoinColumn(onDelete="cascade")
         * @var \Dvups_right
         */
        public $dvups_right;


        
        public function __construct($id = null){
            
                if( $id ) { $this->id = $id; }   
                          
	$this->dvups_entity = new Dvups_entity();
	$this->dvups_right = new Dvups_right();
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
         *	@return \Dvups_right
         */
        function getDvups_right() {
            return $this->dvups_right;
        }
        function setDvups_right(\Dvups_right $dvups_right) {
            $this->dvups_right = $dvups_right;
        }
                        
                        
        public function scan_entity_core(){
            return Core::__extract(__DIR__, $this);
        }
        
        public function jsonSerialize() {
                return [
                                'dvups_entity' => $this->dvups_entity,
                                'dvups_right' => $this->dvups_right,
                ];
        }
        
}
