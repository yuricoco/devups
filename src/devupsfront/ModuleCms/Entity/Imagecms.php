<?php 
        // user \dclass\devups\model\Model;
    /**
     * @Entity @Table(name="imagecms")
     * */
    class Imagecms extends Model implements JsonSerializable{

        /**
         * @Id @GeneratedValue @Column(type="integer")
         * @var int
         * */
        protected $id;
        /**
         * @Column(name="width_size", type="string" , length=255 )
         * @var string
         **/
        protected $width_size;

        public function __construct($id = null){
            
                if( $id ) { $this->id = $id; }   
                          
}

        public function getId() {
            return $this->id;
        }
        public function getWidth_size() {
            return $this->width_size;
        }

        public function setWidth_size($width_size) {
            $this->width_size = $width_size;
        }
        
        
        public function jsonSerialize() {
                return [
                        'id' => $this->id,
                                'width_size' => $this->width_size,
                ];
        }
        
}
