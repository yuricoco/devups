<?php 
    /**
     * @Entity @Table(name="product")
     * */
    class Product extends \Model implements JsonSerializable, DatatableOverwrite {

        /**
         * @Id @GeneratedValue @Column(type="integer")
         * @var int
         * */
        protected $id;
        /**
         * @Column(name="name", type="string" , length=25 )
         * @var string
         **/
        private $name;
        /**
         * @Column(name="price", type="text"  )
         * @var text
         **/
        private $price;
        /**
         * @Column(name="description", type="text"  )
         * @var text
         **/
        private $description; 
        
        /**
         * @ManyToOne(targetEntity="\Category")
         * , inversedBy="reporter"
         * @var \Category
         */
        public $category;

        /**
         * manyToMany
         * @var \Stock
         */
        public $stock;


        
        public function __construct($id = null){
            
                if( $id ) { $this->id = $id; }   
                          
	$this->category = new Category();
			$this->stock = [];
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
        
        public function getPrice() {
            return $this->price;
        }

        public function setPrice($price) {
            $this->price = $price;
        }
        
        public function getDescription() {
            return $this->description;
        }

        public function setDescription($description) {
            $this->description = $description;
        }
        
        /**
         *  manyToOne
         *	@return \Category
         */
        function getCategory() {
            $this->category = $this->category->__show();
            return $this->category;
        }
        function setCategory(\Category $category) {
            $this->category = $category;
        }
                        
        /**
         *  manyToMany
         *	@return \Stock
         */
        function getStock() {
            return $this->stock;
        }
        function setStock($stock){
            $this->stock = $stock;
        }
        
        function addStock(\Stock $stock){
            $this->stock[] = $stock;
        }
        
        function collectStock(){
            $this->stock = $this->__hasmany('stock');
            return $this->stock;
        }
        
                        
        
        public function jsonSerialize() {
                return [
                        'id' => $this->id,
                                'name' => $this->name,
                                'price' => $this->price,
                                'description' => $this->description,
                                'category' => $this->category,
                                'stock' => $this->stock,
                ];
        }

        /**
         * overwrite the edit button either by changing one of the array parameter of devups default button send in parameter
         * or design an custom html element.
         *
         * @param $btarray the array model of the devupsbutton
         * @return mixed Array | string
         */
        public function editAction($btarray)
        {
            // TODO: Implement editAction() method.
        }

        /**
         * overwrite the show button either by changing one of the array parameter of devups default button send in parameter
         * or design an custom html element.
         *
         * @param $btarray the array model of the devupsbutton
         * @return mixed Array | string
         */
        public function showAction($btarray)
        {
            // TODO: Implement showAction() method.
        }

        /**
         * overwrite the delete button either by changing one of the array parameter of devups default button send in parameter
         * or design an custom html element.
         *
         * @param $btarray the array model of the devupsbutton
         * @return mixed Array | string
         */
        public function deleteAction($btarray)
        {
            // TODO: Implement deleteAction() method.
        }

        public static function nameSearch($attr)
        {
            return $attr;
        }

    }
