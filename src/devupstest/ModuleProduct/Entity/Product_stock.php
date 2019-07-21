<?php 
    /**
     * @Entity @Table(name="product_stock")
     * */
    class Product_stock extends \Model implements JsonSerializable{

        /**
         * @Id @GeneratedValue @Column(type="integer")
         * @var int
         * */
        protected $id; 
        
        /**
         * @ManyToOne(targetEntity="\Stock")
         * , inversedBy="reporter"
         * @var \Stock
         */
        public $stock;

        /**
         * @ManyToOne(targetEntity="\Product")
         * , inversedBy="reporter"
         * @var \Product
         */
        public $product;


        
        public function __construct($id = null){
            
                if( $id ) { $this->id = $id; }   
                          
	$this->stock = new Stock();
	$this->product = new Product();
}

        public function getId() {
            return $this->id;
        }
        /**
         *  manyToOne
         *	@return \Stock
         */
        function getStock() {
            $this->stock = $this->stock->__show();
            return $this->stock;
        }
        function setStock(\Stock $stock) {
            $this->stock = $stock;
        }
                        
        /**
         *  manyToOne
         *	@return \Product
         */
        function getProduct() {
            $this->product = $this->product->__show();
            return $this->product;
        }
        function setProduct(\Product $product) {
            $this->product = $product;
        }
                        
        
        public function jsonSerialize() {
                return [
                        'id' => $this->id,
                                'stock' => $this->stock,
                                'product' => $this->product,
                ];
        }
        
}
