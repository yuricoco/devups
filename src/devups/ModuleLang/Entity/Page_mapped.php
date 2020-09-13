<?php 
        // user \dclass\devups\model\Model;
    /**
     * @Entity @Table(name="page_mapped")
     * */
    class Page_mapped extends Model implements JsonSerializable{

        /**
         * @Id @GeneratedValue @Column(type="integer")
         * @var int
         * */
        protected $id;
        /**
         * @Column(name="base_url", type="string" , length=255 )
         * @var string
         **/
        protected $base_url;
        

        
        public function __construct($id = null){
            
                if( $id ) { $this->id = $id; }   
                          
}

        public function getId() {
            return $this->id;
        }
        public function getBase_url() {
            return $this->base_url;
        }

        public function setBase_url($base_url) {
            $this->base_url = $base_url;
        }
        
        
        public function jsonSerialize() {
                return [
                        'id' => $this->id,
                                'base_url' => $this->base_url,
                ];
        }
        
}
