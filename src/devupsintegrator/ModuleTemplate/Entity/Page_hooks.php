<?php 
        // user \dclass\devups\model\Model;
    /**
     * @Entity @Table(name="page_hooks")
     * */
    class Page_hooks extends Model implements JsonSerializable{

        /**
         * @Id @GeneratedValue @Column(type="integer")
         * @var int
         * */
        protected $id; 
        
        /**
         * @ManyToOne(targetEntity="\Hooks")
         * @var \Hooks
         */
        public $hooks;

        /**
         * @ManyToOne(targetEntity="\Page")
         * @var \Page
         */
        public $page;


        
        public function __construct($id = null){
            
                if( $id ) { $this->id = $id; }   
                          
	$this->hooks = new Hooks();
	$this->page = new Page();
}

        public function getId() {
            return $this->id;
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
                        
        /**
         *  manyToOne
         *	@return \Page
         */
        function getPage() {
            $this->page = $this->page->__show();
            return $this->page;
        }
        function setPage(\Page $page) {
            $this->page = $page;
        }
                        
        
        public function jsonSerialize() {
                return [
                    'id' => $this->id,
                    'hooks' => $this->hooks,
                    'page' => $this->page,
                ];
        }
        
}
