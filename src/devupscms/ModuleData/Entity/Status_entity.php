<?php 
        // user \dclass\devups\model\Model;
    /**
     * @Entity @Table(name="status_entity")
     * */
    class Status_entity extends Model implements JsonSerializable{

        /**
         * @Id @GeneratedValue @Column(type="integer")
         * @var int
         * */
        protected $id;
        /**
         * @Column(name="color", type="string" , length=25 )
         * @var string
         **/
        protected $color;
        /**
         * @Column(name="position", type="integer"  )
         * @var integer
         **/
        protected $position; 
        
        /**
         * @ManyToOne(targetEntity="\Status")
         * @var \Status
         */
        public $status;

        /**
         * @ManyToOne(targetEntity="\Dvups_entity")
         * @var \Dvups_entity
         */
        public $dvups_entity;


        
        public function __construct($id = null){
            
                if( $id ) { $this->id = $id; }   
                          
	$this->status = new Status();
	$this->dvups_entity = new Dvups_entity();
}

        public function getId() {
            return $this->id;
        }
        public function getColor() {
            return $this->color;
        }

        public function setColor($color) {
            $this->color = $color;
        }
        
        public function getPosition() {
            return $this->position;
        }

        public function setPosition($position) {
            $this->position = $position;
        }
        
        /**
         *  manyToOne
         *	@return \Status
         */
        function getStatus() {
            $this->status = $this->status->__show();
            return $this->status;
        }
        function setStatus(\Status $status) {
            $this->status = $status;
        }
                        
        /**
         *  manyToOne
         *	@return \Dvups_entity
         */
        function getDvups_entity() {
            $this->dvups_entity = $this->dvups_entity->__show();
            return $this->dvups_entity;
        }
        function setDvups_entity(\Dvups_entity $dvups_entity) {
            $this->dvups_entity = $dvups_entity;
        }
                        
        
        public function jsonSerialize() {
                return [
                    'id' => $this->id,
                    'color' => $this->color,
                    'position' => $this->position,
                    'status' => $this->status,
                    'dvups_entity' => $this->dvups_entity,
                ];
        }
        
}
