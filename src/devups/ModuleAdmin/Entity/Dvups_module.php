<?php 
    
/**
 * @Entity @Table(name="dvups_module")
 * */
    class Dvups_module extends Model implements JsonSerializable{

    /**
     * @Id @GeneratedValue @Column(type="integer")
     * @var int
     * */
        private $id;
    /**
     * @Column(name="name", type="string" , length=255 )
     * @var string
     * */
        private $name; 
    /**
     * @Column(name="project", type="string" , length=255 )
     * @var string
     * */
        private $project; 
        

        
        public function __construct($id = null){
            
                if( $id ) { $this->id = $id; }   
                          
}

        public function getId() {
            return $this->id;
        }

        public function setId($id) {
            $this->id = $id;
        }
        public function getName() {
            return $this->name;
        }

        public function setName($name) {
            $this->name = $name;
        }
        
        function getProject() {
            return $this->project;
        }

        function setProject($project) {
            $this->project = $project;
        }
                    
        public function jsonSerialize() {
                return [
                                'name' => $this->name,
                ];
        }
        
}
