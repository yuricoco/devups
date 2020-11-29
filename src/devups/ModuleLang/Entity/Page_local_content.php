<?php 
        // user \dclass\devups\model\Model;
    /**
     * @Entity @Table(name="page_local_content")
     * */
    class Page_local_content extends Model implements JsonSerializable{

        /**
         * @Id @GeneratedValue @Column(type="integer")
         * @var int
         * */
        protected $id; 
        
        /**
         * @ManyToOne(targetEntity="\Page_mapped")
         * @JoinColumn(onDelete="set null")
         * @var \Page_mapped
         */
        public $page_mapped;

        /**
         * @ManyToOne(targetEntity="\Local_content")
         * @JoinColumn(onDelete="set null")
         * @var \Local_content
         */
        public $local_content;


        
        public function __construct($id = null){
            
                if( $id ) { $this->id = $id; }   
                          
	$this->page_mapped = new Page_mapped();
	$this->local_content = new Local_content();
}

        public function getId() {
            return $this->id;
        }
        /**
         *  manyToOne
         *	@return \Page_mapped
         */
        function getPage_mapped() {
            $this->page_mapped = $this->page_mapped->__show();
            return $this->page_mapped;
        }
        function setPage_mapped(\Page_mapped $page_mapped) {
            $this->page_mapped = $page_mapped;
        }
                        
        /**
         *  manyToOne
         *	@return \Local_content
         */
        function getLocal_content() {
            $this->local_content = $this->local_content->__show();
            return $this->local_content;
        }
        function setLocal_content(\Local_content $local_content) {
            $this->local_content = $local_content;
        }
                        
        
        public function jsonSerialize() {
                return [
                        'id' => $this->id,
                                'page_mapped' => $this->page_mapped,
                                'local_content' => $this->local_content,
                ];
        }
        
}
