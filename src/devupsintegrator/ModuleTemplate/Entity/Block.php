<?php 
        // user \dclass\devups\model\Model;
    /**
     * @Entity @Table(name="block")
     * */
    class Block extends Model implements JsonSerializable{

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
         * @var \Article
         */
        public $article;


        
        public function __construct($id = null){
            
                if( $id ) { $this->id = $id; }   
                          
			$this->article = [];
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
         *	@return \Article
         */
        function getArticle() {
            return $this->article;
        }
        function setArticle($article){
            $this->article = $article;
        }
        
        function addArticle(\Article $article){
            $this->article[] = $article;
        }
        
        function collectArticle(){
            $this->article = $this->__hasmany('article');
            return $this->article;
        }
        
                        
        
        public function jsonSerialize() {
                return [
                    'id' => $this->id,
                    'label' => $this->label,
                    'article' => $this->article,
                ];
        }
        
}
