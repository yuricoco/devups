<?php 
        // user \dclass\devups\model\Model;
    /**
     * @Entity @Table(name="request_history")
     * */
    class Request_history extends Model implements JsonSerializable{

        /**
         * @Id @GeneratedValue @Column(type="integer")
         * @var int
         * */
        protected $id;
        /**
         * @Column(name="query", type="text"  )
         * @var text
         **/
        protected $query; 
        

        
        public function __construct($id = null){
            
                if( $id ) { $this->id = $id; }   
                          
}

        public function getId() {
            return $this->id;
        }
        public function getQuery() {
            return $this->query;
        }

        public function setQuery($query) {
            $this->query = $query;
        }
        
        
        public function jsonSerialize() {
                return [
                    'id' => $this->id,
                    'query' => $this->query,
                ];
        }
        
}
