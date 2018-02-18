<?php 
    /**
     * @Entity @Table(name="subcategory")
     * */
    class Subcategory extends \Model implements JsonSerializable{

        /**
         * @Id @GeneratedValue @Column(type="integer")
         * @var int
         * */
        protected $id;
        /**
         * @Column(name="name", type="string" , length=22 )
         * @var string
         **/
        private $name; 
        
        /**
         * @ManyToOne(targetEntity="\Category")
         * , inversedBy="reporter"
         * @var \Category
         */
        public $category;


        
        public function __construct($id = null){
            
                if( $id ) { $this->id = $id; }   
                          
	$this->category = new Category();
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
         *	@return \Category
         */
        function getCategory() {
            $this->category = $this->__belongto("category");
            return $this->category;
        }
        
        function setCategory(\Category $category) {
            $this->category = $category;
        }
                        
        
        public function jsonSerialize() {
                return [
                        'id' => $this->id,
                                'name' => $this->name,
                                'category' => $this->category,
                ];
        }
        
}
