<?php 
    /**
     * @Entity @Table(name="dvups_contentlang")
     * */
    class Dvups_contentlang extends \Model implements JsonSerializable{

        /**
         * @Id @GeneratedValue @Column(type="integer")
         * @var int
         * */
        protected $id;
        /**
         * @Column(name="content", type="text"  )
         * @var text
         **/
        private $content;
        /**
         * @Column(name="lang", type="string" , length=2 )
         * @var string
         **/
        private $lang; 
        
        /**
         * @ManyToOne(targetEntity="\Dvups_lang")
         * , inversedBy="reporter"
         * @var \Dvups_lang
         */
        public $dvups_lang;

        
        public function __construct($id = null){
            
                if( $id ) { $this->id = $id; }   
                          
	$this->dvups_lang = new Dvups_lang();
}

        public function getId() {
            return $this->id;
        }
        public function getContent() {
            return $this->content;
        }

        public function setContent($content) {
            $this->content = $content;
        }
        
        public function getLang() {
            return $this->lang;
        }

        public function setLang($lang) {
            $this->lang = $lang;
        }
        
        /**
         *  manyToOne
         *	@return \Dvups_lang
         */
        function getDvups_lang() {
            //$this->dvups_lang = $this->__belongto("dvups_lang");
            return $this->dvups_lang;
        }
        function setDvups_lang(\Dvups_lang $dvups_lang) {
            $this->dvups_lang = $dvups_lang;
        }
                        
        
        public function jsonSerialize() {
                return [
                        'id' => $this->id,
                                'content' => $this->content,
                                'lang' => $this->lang,
                                'dvups_lang' => $this->dvups_lang,
                ];
        }
        
}
