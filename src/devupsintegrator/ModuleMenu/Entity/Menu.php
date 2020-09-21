<?php 
        // user \dclass\devups\model\Model;
    /**
     * @Entity @Table(name="menu")
     * */
    class Menu extends Model implements JsonSerializable{

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
         * @ManyToOne(targetEntity="\Page")
         * @var \Page
         */
        public $page;

        
        public function __construct($id = null){
            
                if( $id ) { $this->id = $id; }   
                          
	$this->page = new Page();

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
                        
        /**
         *  manyToOne
         *	@return \Article
         */
        function getArticle() {
            $this->article = $this->article->__show();
            return $this->article;
        }
        function setArticle(\Article $article) {
            $this->article = $article;
        }
                        
        
        public function jsonSerialize() {
                return [
                    'id' => $this->id,
                    'label' => $this->label,
                    'page' => $this->page,
                    'article' => $this->article,
                ];
        }
        
}
