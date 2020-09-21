<?php 
        // user \dclass\devups\model\Model;
    /**
     * @Entity @Table(name="hooks_block")
     * */
    class Hooks_block extends Model implements JsonSerializable{

        /**
         * @Id @GeneratedValue @Column(type="integer")
         * @var int
         * */
        protected $id; 
        
        /**
         * @ManyToOne(targetEntity="\Block")
         * @var \Block
         */
        public $block;

        /**
         * @ManyToOne(targetEntity="\Hooks")
         * @var \Hooks
         */
        public $hooks;


        
        public function __construct($id = null){
            
                if( $id ) { $this->id = $id; }   
                          
	$this->block = new Block();
	$this->hooks = new Hooks();
}

        public function getId() {
            return $this->id;
        }
        /**
         *  manyToOne
         *	@return \Block
         */
        function getBlock() {
            $this->block = $this->block->__show();
            return $this->block;
        }
        function setBlock(\Block $block) {
            $this->block = $block;
        }
                        
        /**
         *  manyToOne
         *	@return \Hooks
         */
        function getHooks() {
            $this->hooks = $this->hooks->__show();
            return $this->hooks;
        }
        function setHooks(\Hooks $hooks) {
            $this->hooks = $hooks;
        }
                        
        
        public function jsonSerialize() {
                return [
                    'id' => $this->id,
                    'block' => $this->block,
                    'hooks' => $this->hooks,
                ];
        }
        
}
