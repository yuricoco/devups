<?php 
        // user \dclass\devups\model\Model;
    /**
     * @Entity @Table(name="hooks")
     * */
    class Hooks extends Model implements JsonSerializable{

        /**
         * @Id @GeneratedValue @Column(type="integer")
         * @var int
         * */
        protected $id;
        /**
         * @Column(name="label", type="string" , length=50 )
         * @var string
         **/
        protected $label; 
        
        /**
         * manyToMany
         * @var \Block
         */
        public $block;


        
        public function __construct($id = null){
            
                if( $id ) { $this->id = $id; }   
                          
			$this->block = [];
}

        public function getId() {
            return $this->id;
        }
        public function getLabel() {
            return $this->label;
        }

        public function setLabel($label) {
            $this->label = $label;
        }
        
        /**
         *  manyToMany
         *	@return \Block
         */
        function getBlock() {
            return $this->block;
        }
        function setBlock($block){
            $this->block = $block;
        }
        
        function addBlock(\Block $block){
            $this->block[] = $block;
        }
        
        function collectBlock(){
            $this->block = $this->__hasmany('block');
            return $this->block;
        }
        
                        
        
        public function jsonSerialize() {
                return [
                    'id' => $this->id,
                    'label' => $this->label,
                    'block' => $this->block,
                ];
        }
        
}
