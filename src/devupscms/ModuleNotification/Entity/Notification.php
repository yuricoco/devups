<?php 
        // user \dclass\devups\model\Model;
    /**
     * @Entity @Table(name="notification")
     * */
    class Notification extends Model implements JsonSerializable{

        /**
         * @Id @GeneratedValue @Column(type="integer")
         * @var int
         * */
        protected $id;
        /**
         * @Column(name="entity", type="string" , length=55 )
         * @var string
         **/
        protected $entity;
        /**
         * @Column(name="entityid", type="integer"  )
         * @var integer
         **/
        protected $entityid;

        /**
         * @Column(name="content", type="string" , length=255 , nullable=true)
         * @var string
         **/
        protected $content;
        

        
        public function __construct($id = null){
            
                if( $id ) { $this->id = $id; }   
                          
}

        public function getId() {
            return $this->id;
        }
        public function getEntity() {
            return $this->entity;
        }

        public function setEntity($entity) {
            $this->entity = $entity;
        }
        
        public function getEntityid() {
            return $this->entityid;
        }

        public function setEntityid($entityid) {
            $this->entityid = $entityid;
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
                                'entity' => $this->entity,
                                'entityid' => $this->entityid,
                                'content' => $this->content,
                ];
        }

}
