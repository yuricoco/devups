<?php 
    /**
     * @Entity @Table(name="town")
     * */
    class Town extends \Model implements JsonSerializable{

        /**
         * @Id @GeneratedValue @Column(type="integer")
         * @var int
         * */
        protected $id;
        /**
         * @Column(name="name", type="string" , length=255 )
         * @var string
         **/
        protected $name;
        
        /**
         * @ManyToOne(targetEntity="\Department")
         * , inversedBy="reporter"
         * @var \Department
         */
        public $department;


        
        public function __construct($id = null){
            
                if( $id ) { $this->id = $id; }   
                          
	$this->department = new Department();
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
        
        /**
         *  manyToOne
         *	@return \Department
         */
        function getDepartment() {
            $this->department = $this->department->__show();
            return $this->department;
        }
        function setDepartment(\Department $department) {
            $this->department = $department;
        }
                        
        
        public function jsonSerialize() {
                return [
                        'id' => $this->id,
                                'name' => $this->name,
                                'department' => $this->department,
                ];
        }
        
}
