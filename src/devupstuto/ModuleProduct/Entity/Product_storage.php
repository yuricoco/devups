<?php 
    /**
     * @Entity @Table(name="product_storage")
     * */
    class Product_storage extends \Model implements JsonSerializable{

        /**
         * @Id @GeneratedValue @Column(type="integer")
         * @var int
         * */
        protected $id; 
        
        /**
         * @ManyToOne(targetEntity="\Storage")
         * , inversedBy="reporter"
         * @var \Storage
         */
        public $storage;

        /**
         * @ManyToOne(targetEntity="\Product")
         * , inversedBy="reporter"
         * @var \Product
         */
        public $product;


        
        public function __construct($id = null){
            
                if( $id ) { $this->id = $id; }   
                          
	$this->storage = new Storage();
	$this->product = new Product();
}

        public function getId() {
            return $this->id;
        }
        /**
         *  manyToOne
         *	@return \Storage
         */
        function getStorage() {
            //$this->storage = $this->__belongto("storage");
            return $this->storage;
        }
        function setStorage(\Storage $storage) {
            $this->storage = $storage;
        }
                        
        /**
         *  manyToOne
         *	@return \Product
         */
        function getProduct() {
            //$this->product = $this->__belongto("product");
            return $this->product;
        }
        function setProduct(\Product $product) {
            $this->product = $product;
        }
                        
        
        public function jsonSerialize() {
                return [
                        'id' => $this->id,
                                'storage' => $this->storage,
                                'product' => $this->product,
                ];
        }
        
}
