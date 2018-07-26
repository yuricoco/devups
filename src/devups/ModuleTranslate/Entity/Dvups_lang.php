<?php 
    /**
     * @Entity @Table(name="dvups_lang")
     * */
    class Dvups_lang extends \Model implements JsonSerializable{

        /**
         * @Id @GeneratedValue @Column(type="integer")
         * @var int
         * */
        protected $id;
        /**
         * @Column(name="lable", type="string" , length=150 )
         * @var string
         **/
        private $lable;
        /**
         * @Column(name="_table", type="string" , length=55 )
         * @var string
         **/
        private $_table;
        /**
         * @Column(name="_row", type="integer"  )
         * @var integer
         **/
        private $_row;
        /**
         * @Column(name="lang", type="string" , length=2 )
         * @var string
         **/
        private $lang;
        /**
         * @Column(name="content", type="text"  )
         * @var text
         **/
        private $content; 
        

        
        public function __construct($id = null){
            
                if( $id ) { $this->id = $id; }   
                          
}

        public function getId() {
            return $this->id;
        }
        public function getLable() {
            return $this->lable;
        }

        public function setLable($lable) {
            $this->lable = $lable;
        }
        
        public function get_table() {
            return $this->_table;
        }

        public function set_table($_table) {
            $this->_table = $_table;
        }
        
        public function get_row() {
            return $this->_row;
        }

        public function set_row($_row) {
            $this->_row = $_row;
        }
        
        public function getLang() {
            return $this->lang;
        }

        public function setLang($lang) {
            $this->lang = $lang;
        }
        
        public function getContent() {
            return $this->content;
        }

        public function setContent($content) {
            $this->content = $content;
        }
        
        
        public function jsonSerialize() {
                return [
                        'id' => $this->id,
                                'lable' => $this->lable,
                                '_table' => $this->_table,
                                '_row' => $this->_row,
                                'lang' => $this->lang,
                                'content' => $this->content,
                ];
        }
        
}
