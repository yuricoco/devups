<?php 
        // user \dclass\devups\model\Model;
    /**
     * @Entity @Table(name="dv_image")
     * */
    class Dv_image extends Model implements JsonSerializable{

        /**
         * @Id @GeneratedValue @Column(type="integer")
         * @var int
         * */
        protected $id;
        /**
         * @Column(name="reference", type="string" , length=123 )
         * @var string
         **/
        protected $reference;
        /**
         * @Column(name="name", type="string" , length=123 )
         * @var string
         **/
        protected $name;
        /**
         * @Column(name="description", type="text"  , nullable=true)
         * @var text
         **/
        protected $description;
        /**
         * @Column(name="image", type="string" , length=255 )
         * @var string
         **/
        protected $image;
        /**
         * @Column(name="size", type="float"  , nullable=true)
         * @var float
         **/
        protected $size;
        /**
         * @Column(name="width", type="float"  , nullable=true)
         * @var float
         **/
        protected $width;
        /**
         * @Column(name="height", type="float"  , nullable=true)
         * @var float
         **/
        protected $height; 
        

        
        public function __construct($id = null){
            
                if( $id ) { $this->id = $id; }   
                          
}

        public function getId() {
            return $this->id;
        }
        public function getReference() {
            return $this->reference;
        }

        public function setReference($reference) {
            $this->reference = $reference;
        }
        
        public function getName() {
            return $this->name;
        }

        public function setName($name) {
            $this->name = $name;
        }
        
        public function getDescription() {
            return $this->description;
        }

        public function setDescription($description) {
            $this->description = $description;
        }
        
                        
        public function uploadImage($file = 'image') {
            $dfile = self::Dfile($file);
            if(!$dfile->errornofile){
            
                $filedir = 'dv_image/';
                $url = $dfile
                    ->hashname()
                    ->moveto($filedir);
    
                if (!$url['success']) {
                    return 	array(	'success' => false,
                        'error' => $url);
                }
    
                $this->image = $url['file']['hashname'];            
            }
        }     
             
        public function srcImage() {
            return Dfile::show($this->image, 'dv_image');
        }
        public function showImage() {
            $url = Dfile::show($this->image, 'dv_image');
            return Dfile::fileadapter($url, $this->image);
        }
        
        public function getImage() {
            return $this->image;
        }

        public function setImage($image) {
            $this->image = $image;
        }
        
        public function getSize() {
            return $this->size;
        }

        public function setSize($size) {
            $this->size = $size;
        }
        
        public function getWidth() {
            return $this->width;
        }

        public function setWidth($width) {
            $this->width = $width;
        }
        
        public function getHeight() {
            return $this->height;
        }

        public function setHeight($height) {
            $this->height = $height;
        }
        
        
        public function jsonSerialize() {
                return [
                    'id' => $this->id,
                    'reference' => $this->reference,
                    'name' => $this->name,
                    'description' => $this->description,
                    'image' => $this->image,
                    'size' => $this->size,
                    'width' => $this->width,
                    'height' => $this->height,
                ];
        }
        
}
