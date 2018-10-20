<?php 
    /**
     * @Entity @Table(name="testentity")
     * */
    class Testentity extends \Model implements JsonSerializable, DvupsTranslation{

        /**
         * @Id @GeneratedValue @Column(type="integer")
         * @var int
         * */
        protected $id;
        /**
         * @Column(name="name", type="string" , length=25 )
         * @var string
         **/
        protected $name;
        /**
         * @Column(name="description", type="text"  )
         * @var text
         **/
        protected $description;
        

        
        public function __construct($id = null){
            
                if( $id ) { $this->id = $id; }   
                          
}

        public function getId() {
            return $this->id;
        }
        public function getName($lang = false)
        {
            return $this->__gettranslate("name", $lang);
        }
        public function setName($name) {
            $this->name = $name;
        }
        
        public function getDescription($lang = "fr")
        {
            return $this->__gettranslate("description", $lang);
        }

        public function setDescription($description) {
            $this->description = $description;
        }
        
        
        public function jsonSerialize() {
                return [
                        'id' => $this->id,
                                'name' => $this->name,
                                'description' => $this->description,
                ];
        }

        public function dvupsTranslate()
        {
            extract($_POST);

            $this->__inittranslate("name", $this->name, "fr");
            $this->__inittranslate("name", $testentity_form["name_en"], "en");
            $this->__inittranslate("description", $this->description, "fr");
            $this->__inittranslate("description", $testentity_form["description_en"], "en");
        }
    }
