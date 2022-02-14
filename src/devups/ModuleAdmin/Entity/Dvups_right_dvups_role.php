<?php 
    
    /**
     * @Entity @Table(name="dvups_right_dvups_role")
     * */
    class Dvups_right_dvups_role extends Model implements JsonSerializable{

        /**
         * @Id @GeneratedValue @Column(type="integer")
         * @var int
         * */
        protected $id;
        
        /**
         * @ManyToOne(targetEntity="\Dvups_role")
         * @JoinColumn(onDelete="cascade")
         * @var \Dvups_role
         */
        public $dvups_role;

        /**
         * @ManyToOne(targetEntity="\Dvups_right")
         * @JoinColumn(onDelete="cascade")
         * @var \Dvups_right
         */
        public $dvups_right;


        
        public function __construct($id = null){
            
                if( $id ) { $this->id = $id; }   
                          
	$this->dvups_role = new Dvups_role();
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
         *	@return \Dvups_role
         */
        function getDvups_role() {
            return $this->dvups_role;
        }
        function setDvups_role(\Dvups_role $dvups_role) {
            $this->dvups_role = $dvups_role;
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
                                'dvups_role' => $this->dvups_role,
                                'dvups_right' => $this->dvups_right,
                ];
        }
        
}
