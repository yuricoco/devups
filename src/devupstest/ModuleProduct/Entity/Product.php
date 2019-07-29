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
         * @Column(name="name", type="string" , length=55 )
         * @var string
         **/
        protected $name;

        /**
         * @Column(name="namecanonical", type="string" , length=55, nullable=true )
         * @var string
         **/
        protected $namecanonical = "";

        /**
         * @Column(name="code", type="string" , length=25, nullable=true )
         * @var string
         **/
        protected $code = "";
        /**
         * @Column(name="price", type="integer" , nullable=true )
         * @var string
         **/
        protected $price = "";

        /**
         * @Column(name="description", type="text", nullable=true  )
         * @var text
         **/
        protected $description;

        /**
         * @ManyToOne(targetEntity="\Category", cascade={"persist"})
         * , inversedBy="reporter"
         * @var \Category
         */
        public $category;


        public function __construct($id = null)
        {

            if ($id) {
                $this->id = $id;
            }

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

        public function editAction($btarray){
//            $btarray['content'] = 'moi meme';
//            return $btarray;
            //return '<button type="button" class="" > moi meme</button>';
        }

        public function showAction($btarray)
        {
            // TODO: Implement showAction() method.
        }

        public function deleteAction($btarray)
        {
            // TODO: Implement deleteAction() method.
        }

    }
