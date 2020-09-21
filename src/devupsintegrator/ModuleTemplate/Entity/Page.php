<?php 
        // user \dclass\devups\model\Model;
    /**
     * @Entity @Table(name="page")
     * */
    class Page extends Model implements JsonSerializable{

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
         * @var \Hooks
         */
        public $hooks;


        
        public function __construct($id = null){
            
                if( $id ) { $this->id = $id; }   
                          
			$this->hooks = [];
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
         *	@return \Hooks
         */
        function getHooks() {
            return $this->hooks;
        }
        function setHooks($hooks){
            $this->hooks = $hooks;
        }
        
        function addHooks(\Hooks $hooks){
            $this->hooks[] = $hooks;
        }
        
        function collectHooks(){
            $this->hooks = $this->__hasmany('hooks');
            return $this->hooks;
        }
        
                        
        
        public function jsonSerialize() {
                return [
                    'id' => $this->id,
                    'label' => $this->label,
                    'hooks' => $this->hooks,
                ];
        }
        
}
