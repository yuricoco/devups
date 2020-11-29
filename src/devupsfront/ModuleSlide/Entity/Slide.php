<?php 
        // user \dclass\devups\model\Model;
    /**
     * @Entity @Table(name="slide")
     * */
    class Slide extends Model implements JsonSerializable{

        /**
         * @Id @GeneratedValue @Column(type="integer")
         * @var int
         * */
        protected $id;
        /**
         * @Column(name="activated", type="string" , length=105 , nullable=true)
         * @var string
         **/
        protected $activated;
        /**
         * @Column(name="width_size", type="string" , length=5 , nullable=true)
         * @var string
         **/
        protected $width_size;
        /**
         * @Column(name="height_size", type="string" , length=5 , nullable=true)
         * @var string
         **/
        protected $height_size;
        /**
         * @Column(name="title", type="string" , length=55 , nullable=true)
         * @var string
         **/
        protected $title;
        /**
         * @Column(name="content", type="string" , length=255 , nullable=true)
         * @var string
         **/
        protected $content;
        /**
         * @Column(name="image", type="string" , length=255 )
         * @var string
         **/
        protected $image;
        /**
         * @Column(name="path", type="string" , length=150 , nullable=true)
         * @var string
         **/
        protected $path;
        /**
         * @Column(name="targeturl", type="string" , length=150 , nullable=true)
         * @var string
         **/
        protected $targeturl; 
        

        
        public function __construct($id = null){
            
                if( $id ) { $this->id = $id; }   
                          
}

        public function getId() {
            return $this->id;
        }
        public function getActivated() {
            return $this->activated;
        }

        public function setActivated($activated) {
            $this->activated = $activated;
        }
        
        public function getWidth_size() {
            return $this->width_size;
        }

        public function setWidth_size($width_size) {
            $this->width_size = $width_size;
        }
        
        public function getHeight_size() {
            return $this->height_size;
        }

        public function setHeight_size($height_size) {
            $this->height_size = $height_size;
        }
        
        public function getTitle() {
            return $this->title;
        }

        public function setTitle($title) {
            $this->title = $title;
        }
        
        public function getContent() {
            return $this->content;
        }

        public function setContent($content) {
            $this->content = $content;
        }
        
                        
        public function uploadImage($file = 'image') {
            $dfile = self::Dfile($file);
            if(!$dfile->errornofile){

                $filedir = 'slide/';
                $url = $dfile
                    ->hashname()
                    ->moveto($filedir);
    
                if (!$url['success']) {
                    return 	array(	'success' => false,
                        'error' => $url);
                }

                $this->setHeight_size($url['file']["imagesize"][1]);
                $this->setWidth_size($url['file']["imagesize"][0]);

                $this->image = $url['file']['hashname'];            
            }
        }     
             
        public function srcImage() {
            return Dfile::show($this->image, 'slide');
        }
        public function showImage() {
            $url = Dfile::show($this->image, 'slide');
            return Dfile::fileadapter($url, $this->image);
        }
        
        public function getImage() {
            return $this->image;
        }

        public function setImage($image) {
            $this->image = $image;
        }
        
        public function getPath() {
            return $this->path;
        }

        public function setPath($path) {
            $this->path = $path;
        }
        
        public function getTargeturl() {
            return $this->targeturl;
        }

        public function setTargeturl($targeturl) {
            $this->targeturl = $targeturl;
        }
        
        
        public function jsonSerialize() {
                return [
                    'id' => $this->id,
                    'activated' => $this->activated,
                    'width_size' => $this->width_size,
                    'height_size' => $this->height_size,
                    'title' => $this->title,
                    'content' => $this->content,
                    'image' => $this->image,
                    'path' => $this->path,
                    'targeturl' => $this->targeturl,
                ];
        }
        
}
