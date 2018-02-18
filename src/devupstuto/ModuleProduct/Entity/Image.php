<?php 
    /**
     * @Entity @Table(name="image")
     * */
    class Image extends \Model implements JsonSerializable{

        /**
         * @Id @GeneratedValue @Column(type="integer")
         * @var int
         * */
        protected $id;
        /**
         * @Column(name="image", type="string" , length=255 )
         * @var string
         **/
        private $image; 
        

        
        public function __construct($id = null){
            
                if( $id ) { $this->id = $id; }   
                          
}

        public function getId() {
            return $this->id;
        }
					
        public function showImage() {
            return UploadFile::show($this->image, 'image');
        }
        
        public function getImage() {
            return $this->image;
        }

        public function uploadImage($image) {
            
            $path = 'image';
            UploadFile::deleteFile($this->image, $path);
            	
            $result = UploadFile::image($path, $image);
            if($result['success']){
                $this->image = $result['file']['hashname'];
            }

            return $result;
        }
        
        public function jsonSerialize() {
                return [
                        'id' => $this->id,
                                'image' => $this->image,
                ];
        }
        
}
