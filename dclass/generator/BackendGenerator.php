<?php

class BackendGenerator {

    public function entityGenerator($entity) {

        $name = strtolower($entity->name);

        $antislash = str_replace(" ", "", " \ ");

        unset($entity->attribut[0]);

        $fichier = fopen('Entity/' . ucfirst($name) . '.php', 'w');

        fputs($fichier, "<?php 
    /**
     * @Entity @Table(name=\"" . $name . "\")
     * */
    class " . ucfirst($name) . " extends \Model implements JsonSerializable{\n");
        $method = "";
        $construteur = "
        public function __construct($" . "id = null){
            
                if( $" . "id ) { $" . "this->id = $" . "id; }   
                          ";
        $attrib = "";

        if (!empty($entity->relation)) {

            $construteur .= "";
            foreach ($entity->relation as $relation) {

                if ($relation->cardinality == 'manyToMany') {

                    $manytomany = [
                        "name" => $name."_".$relation->entity,
                        "ref" => null,
                        "attribut" => [],
                        "relation" => [
                            [
                            "entity" => $relation->entity,
                            "cardinality" => "manyToOne",
                            "nullable" => "not",
                            "ondelete" => "cascade",
                            "onupdate" => "cascade"
                            ],
                            [
                            "entity" => $name,
                            "cardinality" => "manyToOne",
                            "nullable" => "not",
                            "ondelete" => "cascade",
                            "onupdate" => "cascade"
                            ],
                        ]
                    ];

                    $construteur .= "\n\t\t\t$" . "this->" . $relation->entity . " = [];";

                    $attrib .= "
        /**
         * " . $relation->cardinality . "
         * @var " . $antislash . ucfirst($relation->entity) . "
         */
        public $" . $relation->entity . ";\n";

                $method .= "
        /**
         *  " . $relation->cardinality . "
         *	@return " . $antislash . ucfirst($relation->entity) . "
         */
        function get" . ucfirst($relation->entity) . "() {
            return $" . "this->" . $relation->entity . ";
        }";
                    $method .= "
        function set" . ucfirst($relation->entity) . "($" . $relation->entity . "){
            $" . "this->" . $relation->entity . " = $" . $relation->entity . ";
        }
        
        function add" . ucfirst($relation->entity) . "(" . $antislash . ucfirst($relation->entity) . " $" . $relation->entity . "){
            $" . "this->" . $relation->entity . "[] = $" . $relation->entity . ";
        }
        
        function collect" . ucfirst($relation->entity) . "(){
            $" . "this->" . $relation->entity . " = $" . "this->__hasmany('" . $relation->entity . "');
            return $" . "this->" . $relation->entity . ";
        }
        
                        ";
                } elseif ($relation->cardinality == 'oneToOne' or $relation->nullable == 'DEFAULT') {

                    $construteur .= "\n\t$" . "this->" . $relation->entity . " = new " . ucfirst($relation->entity) . "();";

                    $attrib .= "
        /**
         * @" . ucfirst($relation->cardinality) . "(targetEntity=\"" . $antislash . ucfirst($relation->entity) . "\")
         * , inversedBy=\"reporter\"
         * @var " . $antislash . ucfirst($relation->entity) . "
         */
        public $" . $relation->entity . ";\n";

                $method .= "
        /**
         *  " . $relation->cardinality . "
         *	@return " . $antislash . ucfirst($relation->entity) . "
         */
        function get" . ucfirst($relation->entity) . "() {
            $" . "this->". $relation->entity . " = $" . "this->" . $relation->entity . "->__show();
            return $" . "this->" . $relation->entity . ";
        }";
                    $method .= "
        function set" . ucfirst($relation->entity) . "(" . $antislash . ucfirst($relation->entity) . " $" . $relation->entity . " = null) {
            $" . "this->" . $relation->entity . " = $" . $relation->entity . ";
        }
                        ";
                } else {

                    $construteur .= "\n\t$" . "this->" . $relation->entity . " = new " . ucfirst($relation->entity) . "();";

                    $attrib .= "
        /**
         * @" . ucfirst($relation->cardinality) . "(targetEntity=\"" . $antislash . ucfirst($relation->entity) . "\")
         * , inversedBy=\"reporter\"
         * @var " . $antislash . ucfirst($relation->entity) . "
         */
        public $" . $relation->entity . ";\n";

                $method .= "
        /**
         *  " . $relation->cardinality . "
         *	@return " . $antislash . ucfirst($relation->entity) . "
         */
        function get" . ucfirst($relation->entity) . "() {
            $" . "this->". $relation->entity . " = $" . "this->" . $relation->entity . "->__show();
            return $" . "this->" . $relation->entity . ";
        }";
                    $method .= "
        function set" . ucfirst($relation->entity) . "(" . $antislash . ucfirst($relation->entity) . " $" . $relation->entity . ") {
            $" . "this->" . $relation->entity . " = $" . $relation->entity . ";
        }
                        ";
                }
            }
        }

        $construteur .= "\n}\n";

        $construt = "
        /**
         * @Id @GeneratedValue @Column(type=\"integer\")
         * @var int
         * */
        protected $" . "id;";
        $otherattrib = false;

//        if(isset($entity->attribut[1])){
//        var_dump($entity->attribut);
//        die;

        foreach ($entity->attribut as $attribut) {

            if($attribut->name == "id")
                continue;

            $length = "";
            $nullable = "";

            if (in_array($attribut->formtype, ["radio", "checkbox", "select"]) && isset($attribut->enum)) {
                $staticenum = [];
                foreach ($attribut->enum as $key => $enum){
                    $staticenum[] = " '$key' => '$enum'";
                }

                $construt .= "
        /**
         **/
        public static $" . strtoupper($attribut->name) . "S = [".implode(",", $staticenum)."];";

            }

            if ($attribut->datatype == "string") {
                $length = ', length=' . $attribut->size . '';
            }

            if ($attribut->nullable == 'default') {
                $nullable = ", nullable=true";
            }
            $defaultvalue = "";
            if (isset($attribut->defaultvalue) && !in_array($attribut->datatype, ['date', 'datetime', 'time'])) {
                $defaultvalue = " = " . $attribut->defaultvalue . ' ';
            }
            $construt .= "
        /**
         * @Column(name=\"" . $attribut->name . "\", type=\"" . $attribut->datatype . "\" $length $nullable)
         * @var " . $attribut->datatype . "
         **/
        private $" . $attribut->name . "$defaultvalue;";
        }
        $otherattrib = true;
//        }

        $construt .= " 
        " . $attrib . "

        " . $construteur . "
        public function getId() {
            return $" . "this->id;
        }";
        if ($otherattrib) {
            foreach ($entity->attribut as $attribut) {

                if($attribut->name == "id")
                    continue;

                if (in_array($attribut->formtype, ['document', 'image', 'music', 'video'])) {
                    $construt .= "
                        
        public function upload" . ucfirst($attribut->name) . "($"."file = '" . $attribut->name . "') {
            $"."dfile = self::Dfile($"."file);
            if(!$"."dfile->errornofile){
            
                $"."filedir = '" . $attribut->name . "/';
                $"."url = $"."dfile
                    ->hashname()
                    ->moveto($"."filedir);
    
                if (!$"."url['success']) {
                    return 	array(	'success' => false,
                        'error' => $"."url);
                }
    
                $"."this->" . $attribut->name . " = $"."url['file']['hashname'];            
            }
        }     
             
        public function show" . ucfirst($attribut->name) . "() {
            $"."url = Dfile::show($" . "this->" . $attribut->name . ", '" . $name . "');
            return Dfile::fileadapter($"."url, $"."this->" . $attribut->name . ");
        }
        
        public function get" . ucfirst($attribut->name) . "() {
            return $" . "this->" . $attribut->name . ";
        }

        public function set" . ucfirst($attribut->name) . "($" . $attribut->name . ") {
            $" . "this->" . $attribut->name . " = $" . $attribut->name . ";
        }
        ";
                } elseif (in_array($attribut->formtype, ['date', 'datepicker'])) {
                    $construt .= "

        public function get" . ucfirst($attribut->name) . "() {
                if(is_object($" . "this->" . $attribut->name . "))
                        return $" . "this->" . $attribut->name . ";
                else
                        return new DateTime($" . "this->" . $attribut->name . ");
        }

        public function set" . ucfirst($attribut->name) . "($" . $attribut->name . ") {
                    if(is_object($" . $attribut->name . "))
                            $" . "this->" . $attribut->name . " = $" . $attribut->name . ";
                    else
                            $" . "this->" . $attribut->name . " = new DateTime($" . $attribut->name . ");
        }";
                } elseif ($attribut->formtype == 'liste') {
                    $construt .= "
        public function get" . ucfirst($attribut->name) . "List() {
            return $" . "this->" . $attribut->name . ";
        }
		
        public function get" . ucfirst($attribut->name) . "() {
            return $" . "this->" . $attribut->name . ";
        }

        public function set" . ucfirst($attribut->name) . "($" . $attribut->name . ") {
            $" . "this->" . $attribut->name . " = $" . $attribut->name . ";
        }
        ";
                } else {
                    $construt .= "
        public function get" . ucfirst($attribut->name) . "() {
            return $" . "this->" . $attribut->name . ";
        }

        public function set" . ucfirst($attribut->name) . "($" . $attribut->name . ") {
            $" . "this->" . $attribut->name . " = $" . $attribut->name . ";
        }
        ";
                }
            }
        }
        $construt .= $method . "
        
        public function jsonSerialize() {
                return [
                        'id' => $" . "this->id,";
        foreach ($entity->attribut as $attribut) {
            $construt .= "
                                '" . $attribut->name . "' => $" . "this->" . $attribut->name . ",";
        }
        if (!empty($entity->relation)) {
            foreach ($entity->relation as $relation) {
                $construt .= "
                                '" . $relation->entity . "' => $" . "this->" . $relation->entity . ",";
            }
        }
        $construt .= "
                ];
        }
        ";

        fputs($fichier, $construt);
        fputs($fichier, "\n}\n");

        fclose($fichier);
        
        
        if(isset($manytomany)){
            $entitycollection = (object) $manytomany;
            $entitycollection->relation[0] = (object) $entitycollection->relation[0];
            $entitycollection->relation[1] = (object) $entitycollection->relation[1];
            
            $this->entityGenerator($entitycollection);
        }
        
    }

    /* 	CREATION DU CONTROLLER 	 */
    private function defaultCtrlContent($name, $entity){

        $contenu = "public function listView($" . "next = 1, $" . "per_page = 10){

            $" . "lazyloading = $" . "this->lazyloading(new " . ucfirst($name) . "(), $" . "next, $" . "per_page);

        self::$" . "jsfiles[] = " . ucfirst($name) . "::classpath('Ressource/js/" . $name . "Ctrl.js');

        $" . "this->entitytarget = '" . ucfirst($name) . "';
        $" . "this->title = \"Manage " . ucfirst($name) . "\";
        
        $" . "this->renderListView(" . ucfirst($name) . "Table::init($" . "lazyloading)->buildindextable()->render());

    }

    public function datatable($" . "next, $" . "per_page) {
        $" . "lazyloading = $" . "this->lazyloading(new " . ucfirst($name) . "(), $" . "next, $" . "per_page);
        return ['success' => true,
            'datatable' => " . ucfirst($name) . "Table::init($" . "lazyloading)->buildindextable()->getTableRest(),
        ];
    }

    public function createAction($" . $name . "_form = null){
        extract($" . "_POST);

        $" . $name . " = $" . "this->form_fillingentity(new " . ucfirst($name) . "(), $" . $name . "_form);\n ";
        // gestion des relations many to many dans le controller
        $mtm = [];
        $mtmedit = [];
        $iter = 0;
        if (!empty($entity->relation)) {
            //relation sera l'entité
            foreach ($entity->relation as $relation) {

                if ($relation->cardinality == "oneToOne") {
                    $contenu .= "
        //$" . $relation->entity . "Ctrl = new " . ucfirst($relation->entity) . "Controller();
        //extract(" . ucfirst($relation->entity) . "Controller::i()->createAction());
        $" . $relation->entity . " = $" . "this->form_fillingentity(new " . ucfirst($relation->entity) . "(), $" . $relation->entity . "_form);
        $" . $relation->entity . "->__insert();
        $" . $name . "->set" . ucfirst($relation->entity) . "($" . $relation->entity . "); ";
                }
            }
        }
        $contenu .= "\n" . implode($mtm, "\n");
        $otherattrib = false;
//        if (isset($entity->attribut[1])) {
//            $otherattrib = true;
        foreach ($entity->attribut as $attribut) {
//			for($i = 1; $i < count($entity->attribut); $i++){
            if (in_array($attribut->formtype, ['document', 'music', 'video', 'image'])){
                $otherattrib = true;
                $contenu .= "
        $".$name ."->upload" . ucfirst($attribut->name) . "();\n";
            }

            if (in_array($attribut->datatype, ['date', 'datetime', 'time']) && isset($attribut->defaultvalue)){
                $contenu .= "
        $".$name ."->set" . ucfirst($attribut->name) . "(new DateTime());\n";
            }

        }
//        }

        $contenu .= "
        if ( $" . "this->error ) {
            return 	array(	'success' => false,
                            '" . $name . "' => $" . $name . ",
                            'action' => 'create', 
                            'error' => $" . "this->error);
        }
        
        $" . "id = $" . $name . "->__insert();
        return 	array(	'success' => true,
                        '" . $name . "' => $" . $name . ",
                        'tablerow' => " . ucfirst($name) . "Table::init()->buildindextable()->getSingleRowRest($" . $name . "),
                        'detail' => '');

    }

    public function updateAction($" . "id, $" . $name . "_form = null){
        extract($" . "_POST);
            
        $" . $name . " = $" . "this->form_fillingentity(new " . ucfirst($name) . "($" . "id), $" . $name . "_form);

            "; //.implode($mtmedit, "\n")
        if ($otherattrib):
            foreach ($entity->attribut as $attribut) {
//                            for($i = 1; $i < count($entity->attribut); $i++){
                if (in_array($attribut->formtype, ['document', 'music', 'video', 'image']))
                    $contenu .= "
                        $".$name ."->upload" . ucfirst($attribut->name) . "();\n";
            }
        endif;
        $contenu .= "        
        if ( $" . "this->error ) {
            return 	array(	'success' => false,
                            '" . $name . "' => $" . $name . ",
                            'action_form' => 'update&id='.$" . "id,
                            'error' => $" . "this->error);
        }
        
        $" . $name . "->__update();
        return 	array(	'success' => true,
                        '" . $name . "' => $" . $name . ",
                        'tablerow' => " . ucfirst($name) . "Table::init()->buildindextable()->getSingleRowRest($" . $name . "),
                        'detail' => '');
                        
    }
    

    public function detailView($" . "id)
    {

        $" . "this->entitytarget = '" . ucfirst($name) . "';
        $" . "this->title = \"Detail " . ucfirst($name) . "\";

        $" . $name . " = " . ucfirst($name) . "::find($" . "id);

        $" . "this->renderDetailView(
            " . ucfirst($name) . "Table::init()
                ->builddetailtable()
                ->renderentitydata($" . $name . ")
        );

    }
    
    public function deleteAction($" . "id){
    ";
        //if ($otherattrib):
        if (false):
            // add and attribut to alert about media attib in entity
            foreach ($entity->attribut as $attribut) {
                if (in_array($attribut->formtype, ['document', 'image', 'musique', 'video']))
                    $contenu .= " 
        $" . $name . " = " . ucfirst($name) . "::find($" . "id);
        $" . $name . "->deleteFile($" . $name . "->get" . ucfirst($attribut->name) . "(), '" . $name . "');
        $" . $name . "->__delete()";
            }
        else:
            $contenu .= "  
            " . ucfirst($name) . "::delete($" . "id);";
        endif;
        $contenu .= "
        return 	array(	'success' => true, 
                        'detail' => ''); 
    }
    

    public function deletegroupAction($" . "ids)
    {

        " . ucfirst($name) . "::delete()->where(\"id\")->in($" . "ids)->exec();

        return array('success' => true,
                'detail' => ''); 

    }";

        return $contenu;

    }

    private function frontCtrlContent($name, $entity){
        $contenu = "public function ll($" . "next = 1, $" . "per_page = 10){

            return $" . "this->lazyloading(new " . ucfirst($name) . "(), $" . "next, $" . "per_page);

    }

    public function createAction($" . $name . "_form = null){
        $" . "rawdata = \Request::raw();
        $" . $name . " = $" . "this->hydrateWithJson(new " . ucfirst($name) . "(), $" . "rawdata[\"$name\"]);\n ";
        // gestion des relations many to many dans le controller
        $mtm = [];
        $mtmedit = [];
        $iter = 0;
        if (!empty($entity->relation)) {
            //relation sera l'entité
            foreach ($entity->relation as $relation) {

                if ($relation->cardinality == "oneToOne") {
                    $contenu .= "
                    
        $" . $relation->entity . " = $" . "this->hydrateWithJson(new " . ucfirst($relation->entity) . "(), $" . "rawdata[\"" . $relation->entity . "\"]);
        $" . $relation->entity . "->__insert();
        $" . $name . "->set" . ucfirst($relation->entity) . "($" . $relation->entity . "); ";
                }
            }
        }
        $contenu .= "\n" . implode($mtm, "\n");
        $otherattrib = false;
//        if (isset($entity->attribut[1])) {
//            $otherattrib = true;
        foreach ($entity->attribut as $attribut) {
//			for($i = 1; $i < count($entity->attribut); $i++){
            if (in_array($attribut->formtype, ['document', 'music', 'video', 'image'])){
                $otherattrib = true;
                $contenu .= "
        $".$name ."->upload" . ucfirst($attribut->name) . "();\n";
            }

            if (in_array($attribut->datatype, ['date', 'datetime', 'time']) && isset($attribut->defaultvalue)){
                $contenu .= "
        $".$name ."->set" . ucfirst($attribut->name) . "(new DateTime());\n";
            }

        }
//        }

        $contenu .= "
        
        $" . "id = $" . $name . "->__insert();
        return 	array(	'success' => true,
                        '" . $name . "' => $" . $name . ",
                        'detail' => '');

    }

    public function updateAction($" . "id, $" . $name . "_form = null){
        $" . "rawdata = \Request::raw();
            
        $" . $name . " = $" . "this->hydrateWithJson(new " . ucfirst($name) . "($" . "id), $" . "rawdata[\"$name\"]);

            "; //.implode($mtmedit, "\n")
        if ($otherattrib):
            foreach ($entity->attribut as $attribut) {
//                            for($i = 1; $i < count($entity->attribut); $i++){
                if (in_array($attribut->formtype, ['document', 'music', 'video', 'image']))
                    $contenu .= "
                        $".$name ."->upload" . ucfirst($attribut->name) . "();\n";
            }
        endif;
        $contenu .= "      
        
        $" . $name . "->__update();
        return 	array(	'success' => true,
                        '" . $name . "' => $" . $name . ",
                        'detail' => '');
                        
    }
    

    public function detailAction($" . "id)
    {

        $" . $name . " = " . ucfirst($name) . "::find($" . "id);

        return 	array(	'success' => true,
                        '" . $name . "' => $" . $name . ",
                        'detail' => '');
          
}       
";

        return $contenu;

    }

    public function controllerGenerator($entity, $listmodule) {
        //$datatablemodel = DvAdmin::buildindexdatatable($listmodule, $entity);
        $name = strtolower($entity->name);

        //if(__Generator::$ctrltype == 'front' || __Generator::$ctrltype == 'both'){
            $ctrlname = '' . ucfirst($name) . 'FrontController';
            $classController = fopen('Controller/' . $ctrlname . '.php', 'w');
            $extend = ucfirst($name) . 'Controller';
            $content = $this->frontCtrlContent($name, $entity);

            $contenu = "<?php \n

class " . $ctrlname . " extends $extend{

    $content

}\n";
            fputs($classController, $contenu);
            //fputs($classController, "\n}\n");
            fclose($classController);

        //}

        //if(__Generator::$ctrltype == 'both'){
            $ctrlname = '' . ucfirst($name) . 'Controller';
            $classController = fopen('Controller/' . $ctrlname . '.php', 'w');
            $extend = 'Controller';
            $content = $this->defaultCtrlContent($name, $entity);

            $contenu = "<?php \n

use DClass\devups\Datatable as Datatable;

class " . $ctrlname . " extends $extend{

    $content

}\n";
            fputs($classController, $contenu);
            //fputs($classController, "\n}\n");
            fclose($classController);

       // }

    }

    /* 	CREATION DU CONTROLLER 	 */

    public function tableGenerator($entity, $listmodule)
    {
        $datatablemodel = DvAdmin::buildindexdatatable($listmodule, $entity);
        $detailview = DvAdmin::builddetaildatatable($entity, $listmodule);

        $name = strtolower($entity->name);

        $classController = fopen('Datatable/' . ucfirst($name) . 'Table.php', 'w');

        $contenu = "<?php \n

use DClass\devups\Datatable as Datatable;

class " . ucfirst($name) . "Table extends Datatable{
    
    public $"."entity = \"" . $name . "\";

    public $"."datatablemodel = $datatablemodel;

    public function __construct($"."lazyloading = null, $"."datatablemodel = [])
    {
        parent::__construct($"."lazyloading, $"."datatablemodel);
    }

    public static function init($"."lazyloading = null){
        $"."dt = new " . ucfirst($name) . "Table($"."lazyloading);
        return $"."dt;
    }

    public function buildindextable(){

        // TODO: overwrite datatable attribute for this view

        return $"."this;
    }
    
    public function builddetailtable()
    {
        $"."this->datatablemodel = $detailview;
        // TODO: overwrite datatable attribute for this view
        return $"."this;
    }

}\n";
        fputs($classController, $contenu);
        //fputs($classController, "\n}\n");

        fclose($classController);

    }


    /* CREATION OF CORE */

    public function coreGenerator($entityname) {
        require ROOT . 'src/requires.php';
        global $em;

        $classmetadata = (array) $em->getClassMetadata("\\". $entityname);

        $classdevupsmetadata = [];
        $name = strtolower($entityname);

        $classdevupsmetadata["name"] = $name;
        foreach ($classmetadata["fieldMappings"] as $field){
            $length = "";
            if($field["length"])
                $length = $field["length"];

            $nullable = "not";
            if($field["nullable"])
                $nullable = "default";

            $dvfield = [
                "name" => $field["fieldName"],
                "visibility" => $field["fieldName"],
                "datatype" => $field["type"],
                "size" => $length,
                "nullable" => $nullable,
                "formtype" => $field["fieldName"],
            ];
            $classdevupsmetadata["attribut"][] = $dvfield;
        }

        foreach ($classmetadata["associationMappings"] as $field){
            $dvfield = [
                "entity" => $field["fieldName"],
                "cardinality" => "manyToOne",
                "nullable" => "not",
                "ondelete" => "cascade",
                "onupdate" => "cascade"
            ];
            $classdevupsmetadata["relation"][] = $dvfield;
        }

        if (!file_exists('Core')) {
            mkdir('Core', 0777);
        }

        $entitycore = fopen('Core/' . $name . 'Core.json', 'w+');
        $contenu = json_encode($classdevupsmetadata);
        fputs($entitycore, $contenu);

        fclose($entitycore);
    }

    /* CREATION DU FORM */

    public function formGenerator($entity, $listmodule) {

        $name = strtolower($entity->name);
        $traitement = new Traitement();

        /* if($name == 'utilisateur')
          return 0; */
        $field = '';
        unset($entity->attribut[0]);

        foreach ($entity->attribut as $attribut) {

            if($attribut->formtype == "none")
                continue;

            $field .= "
            $" . "entitycore->field['" . $attribut->name . "'] = [
                \"label\" => '" . ucfirst($attribut->name) . "', \n";

            if ($attribut->nullable == 'default') {
                $field .= "\t\t\tFH_REQUIRE => false,\n ";
            }

            if ($attribut->formtype == 'text' or $attribut->formtype == 'float') {
                $field .= "\t\t\t\"type\" => FORMTYPE_TEXT, 
                \"value\" => $" . $name . "->get" . ucfirst($attribut->name) . "(), ";
            } elseif ($attribut->formtype == 'integer' or $attribut->formtype == 'number') {
                $field .= "\t\t\t\"type\" => FORMTYPE_NUMBER, 
                \"value\" => $" . $name . "->get" . ucfirst($attribut->name) . "(),  ";
            } elseif ($attribut->formtype == 'textarea') {
                $field .= "\t\t\t\"type\" => FORMTYPE_" . strtoupper($attribut->formtype) . ", 
                \"value\" => $" . $name . "->get" . ucfirst($attribut->name) . "(), ";
            } elseif ($attribut->formtype == 'date') {
                $field .= "\t\t\t\"type\" => FORMTYPE_" . strtoupper($attribut->formtype) . ", 
                \"value\" => $" . $name . "->get" . ucfirst($attribut->name) . "(), ";
            } elseif ($attribut->formtype == 'time') {
                $field .= "\t\t\t\"type\" => FORMTYPE_" . strtoupper($attribut->formtype) . ", 
                \"value\" => $" . $name . "->get" . ucfirst($attribut->name) . "(), ";
            } elseif ($attribut->formtype == 'datetime') {
                $field .= "\t\t\t\"type\" => FORMTYPE_" . strtoupper($attribut->formtype) . ", 
                \"value\" => $" . $name . "->get" . ucfirst($attribut->name) . "(), ";
            } elseif ($attribut->formtype == 'datepicker') {
                $field .= "\t\t\t\"type\" => FORMTYPE_" . strtoupper($attribut->formtype) . ", 
                \"value\" => $" . $name . "->get" . ucfirst($attribut->name) . "(), ";
            } elseif ($attribut->formtype == 'radio') {
                $field .= "\t\t\t\"type\" => FORMTYPE_" . strtoupper($attribut->formtype) . ", 
                \"value\" => $" . $name . "->get" . ucfirst($attribut->name) . "(), ";
            } elseif ($attribut->formtype == 'email') {
                $field .= "\t\t\t\"type\" => FORMTYPE_" . strtoupper($attribut->formtype) . ", 
                \"value\" => $" . $name . "->get" . ucfirst($attribut->name) . "(), ";
            } elseif ($attribut->formtype == 'document') {
                $field .= "\t\t\t\"type\" => FORMTYPE_FILE,
                FH_FILETYPE => FILETYPE_" . strtoupper($attribut->formtype) . ",  
                \"value\" => $" . $name . "->get" . ucfirst($attribut->name) . "(),
                \"src\" => $" . $name . "->show" . ucfirst($attribut->name) . "(), ";
            } elseif ($attribut->formtype == 'video') {
                $field .= "\t\t\t\"type\" => FORMTYPE_FILE,
                \"filetype\" => FILETYPE_" . strtoupper($attribut->formtype) . ", 
                \"value\" => $" . $name . "->get" . ucfirst($attribut->name) . "(),
                \"src\" => $" . $name . "->show" . ucfirst($attribut->name) . "(), ";
            } elseif ($attribut->formtype == 'music') {
                $field .= "\"type\" => FORMTYPE_FILE,
                \"filetype\" => FILETYPE_" . strtoupper($attribut->formtype) . ", 
                \"value\" => $" . $name . "->get" . ucfirst($attribut->name) . "(),
                \"src\" => $" . $name . "->show" . ucfirst($attribut->name) . "(), ";
            } elseif ($attribut->formtype == 'image') {
                $field .= "\t\t\t\"type\" => FORMTYPE_FILE,
                \"filetype\" => FILETYPE_" . strtoupper($attribut->formtype) . ", 
                \"value\" => $" . $name . "->get" . ucfirst($attribut->name) . "(),
                \"src\" => $" . $name . "->show" . ucfirst($attribut->name) . "(), ";
            } else {
                $field .= "\"type\" => FORMTYPE_TEXT,
                \"value\" => $" . $name . "->get" . ucfirst($attribut->name) . "(), ";
            }

            $field .= "
            ];\n";
        }

        if (!empty($entity->relation)) {
            foreach ($entity->relation as $relation) {

                $entitylink = $traitement->relation($listmodule, $relation->entity);
                if(is_null($entitylink))
                    continue;

                $entrel = ucfirst(strtolower($relation->entity));
                $key = 0;
                $enititylinkattrname = "id";
                $entitylink->attribut = (array) $entitylink->attribut;

                if (isset($entitylink->attribut[1])) {
                    $key = 1;
                    $enititylinkattrname = $entitylink->attribut[$key]->name;
                }

                if ($relation->cardinality == 'manyToOne') {
                    $field .= "
                $" . "entitycore->field['" . $relation->entity . "'] = [
                    \"type\" => FORMTYPE_SELECT, 
                    \"value\" => $" . $name . "->get" . ucfirst($relation->entity) . "()->getId(),
                    \"label\" => '" . ucfirst($relation->entity) . "',
                    \"options\" => FormManager::Options_Helper('" . $enititylinkattrname . "', " . ucfirst($relation->entity) . "::allrows()),
                ];\n";
                } elseif ($relation->cardinality == 'oneToOne') {
                    $field .= "
                $" . "entitycore->field['" . $relation->entity . "'] = [
                    \"type\" => FORMTYPE_INJECTION, 
                    FH_REQUIRE => true,
                    \"label\" => '" . ucfirst($relation->entity) . "',
                    \"imbricate\" => " . ucfirst($relation->entity) . "Form::__renderForm(" . ucfirst($relation->entity) . "::getFormData($" . $name . "->" . $relation->entity . "->getId(), false)),
                ];\n";
                } elseif ($relation->cardinality == 'manyToMany') {
                    $field .= "
                $" . "entitycore->field['" . $relation->entity . "'] = [
                    \"type\" => FORMTYPE_CHECKBOX, 
                    \"values\" => FormManager::Options_Helper('" . $enititylinkattrname . "', $" . $name . "->get" . ucfirst($relation->entity) . "()),
                    \"label\" => '" . ucfirst($relation->entity) . "',
                    \"options\" => FormManager::Options_ToCollect_Helper('" . $enititylinkattrname . "', new " . ucfirst($relation->entity) . "(), $" . $name . "->get" . ucfirst($relation->entity) . "()),
                ];\n";
                }
            }
        }

        $contenu = "<?php \n
        
use Genesis as g;

    class " . ucfirst($name) . "Form extends FormManager{

        public static function formBuilder($" . "dataform, $" . "button = false) {
            $" . $name . " = new \\" . ucfirst($name) . "();
            extract($" . "dataform);
            $" . "entitycore = new Core($" . $name . ");
            
            $" . "entitycore->formaction = $" . "action;
            $" . "entitycore->formbutton = $" . "button;
            
            //$" . "entitycore->addcss('csspath');
                
            " . $field . "
            
            $" . "entitycore->addDformjs($" . "button);
            $" . "entitycore->addjs(" . ucfirst($name) . "::classpath('Ressource/js/".$name."Form'));
            
            return $" . "entitycore;
        }
        
        public static function __renderForm($" . "dataform, $" . "button = false) {
            return FormFactory::__renderForm(" . ucfirst($name) . "Form::formBuilder($" . "dataform,  $" . "button));
        }
        
        public static function getFormData($" . "id = null, $" . "action = \"create\")
        {
            if (!$" . "id):
                $" . $name . " = new " . ucfirst($name) . "();
                
                return [
                    'success' => true,
                    '" . $name . "' => $" . $name . ",
                    'action' => \"create\",
                ];
            endif;
            
            $" . $name . " = " . ucfirst($name) . "::find($" . "id);
            return [
                'success' => true,
                '" . $name . "' => $" . $name . ",
                'action' => \"update&id=\" . $"."id,
            ];

        }
        
        public static function render($" . "id = null, $" . "action = \"create\")
        {
            g::json_encode(['success' => true,
                'form' => self::__renderForm(self::getFormData($" . "id, $" . "action),true),
            ]);
        }

        public static function renderWidget($" . "id = null, $" . "action = \"create\")
        {
            Genesis::renderView(\"" . $name . ".formWidget\", self::getFormData($" . "id, $" . "action));
        }
        
    }
    ";
        $entityform = fopen('Form/' . ucfirst($name) . 'Form.php', 'w');
        fputs($entityform, $contenu);

        fclose($entityform);
    }

    /* CREATION DU FORM FIELD */

    private function formwidget($entity, $listmodule, $onetoone = true){
        $field = '';
        $traitement = new Traitement();
        $name = strtolower($entity->name);

        foreach ($entity->attribut as $attribut) {

            if($attribut->formtype == "none")
                continue;

            $field .= "<div class='form-group'>\n<label for='" . $attribut->name . "'>" . ucfirst($attribut->name) . "</label>\n";

//            if ($attribut->nullable == 'default') {
//                $field .= "\tFH_REQUIRE => false,\n ";
//            }

            if ($attribut->formtype == 'text' or $attribut->formtype == 'float') {
                $field .= "\t<?= Form::input('" . $attribut->name . "', $" . $name . "->get" . ucfirst($attribut->name) . "(), ['class' => 'form-control']); ?>\n";
            } elseif ($attribut->formtype == 'input' or $attribut->formtype == 'number') {
                $field .= "\t<?= Form::integer('" . $attribut->name . "', $" . $name . "->get" . ucfirst($attribut->name) . "(), ['class' => 'form-control']); ?>\n";
            } elseif ($attribut->formtype == 'textarea') {
                $field .= "\t<?= Form::textarea('" . $attribut->name . "', $" . $name . "->get" . ucfirst($attribut->name) . "(), ['class' => 'form-control']); ?>\n";
            } elseif ($attribut->formtype == 'date') {
                $field .= "\t<?= Form::input('" . $attribut->name . "', $" . $name . "->get" . ucfirst($attribut->name) . "(), ['class' => 'form-control']); ?>\n";
            } elseif ($attribut->formtype == 'time') {
                $field .= "\t<?= Form::input('" . $attribut->name . "', $" . $name . "->get" . ucfirst($attribut->name) . "(), ['class' => 'form-control']); ?>\n";
            } elseif ($attribut->formtype == 'datetime') {
                $field .= "\t<?= Form::input('" . $attribut->name . "', $" . $name . "->get" . ucfirst($attribut->name) . "(), ['class' => 'form-control']); ?>\n";
            } elseif ($attribut->formtype == 'datepicker') {
                $field .= "\t<?= Form::input('" . $attribut->name . "', $" . $name . "->get" . ucfirst($attribut->name) . "(), ['class' => 'form-control']); ?>\n";
            } elseif ($attribut->formtype == 'radio') {
                $field .= "\t<?= Form::input('" . $attribut->name . "', $" . $name . "->get" . ucfirst($attribut->name) . "(), ['class' => 'form-control']); ?>\n";
            } elseif ($attribut->formtype == 'email') {
                $field .= "\t<?= Form::email('" . $attribut->name . "', $" . $name . "->get" . ucfirst($attribut->name) . "(), ['class' => 'form-control']) ?>\n";
            } elseif (in_array($attribut->formtype, ['document', 'image', 'musique', 'video'])){

                $field .= "\t<?= Form::filepreview($" . $name . "->get" . ucfirst($attribut->name) . "(),
                $" . $name . "->show" . ucfirst($attribut->name) . "(),
                 ['class' => 'form-control'], 'image') ?>\n";

                if ($attribut->formtype == 'document') {
                    $field .= "\t<?= Form::file('" . $attribut->name . "', 
                $" . $name . "->get" . ucfirst($attribut->name) . "(),
                 ['class' => 'form-control'], 'document') ?>\n";
                } elseif ($attribut->formtype == 'video') {
                    $field .= "\t<?= Form::file('" . $attribut->name . "', 
                $" . $name . "->get" . ucfirst($attribut->name) . "(),
                 ['class' => 'form-control'], 'video') ?>\n";
                } elseif ($attribut->formtype == 'music') {
                    $field .= "\t<?= Form::file('" . $attribut->name . "', 
                $" . $name . "->get" . ucfirst($attribut->name) . "(),
                 ['class' => 'form-control'], 'audio') ?>\n";
                } elseif ($attribut->formtype == 'image') {
                    $field .= "\t<?= Form::file('" . $attribut->name . "', 
                $" . $name . "->get" . ucfirst($attribut->name) . "(),
                '',
                 ['class' => 'form-control'], 'image') ?>\n";

                }
            } else {
                $field .= "\t<?= Form::input('" . $attribut->name . "', $" . $name . "->get" . ucfirst($attribut->name) . "(), ['class' => 'form-control']) ?>\n";

            }

            $field .= " </div>\n";
        }

        if (!empty($entity->relation)) {
            foreach ($entity->relation as $relation) {

                $entitylink = $traitement->relation($listmodule, $relation->entity);

                $enititylinkattrname = "id";
                $entitylink->attribut = (array) $entitylink->attribut;

                if (isset($entitylink->attribut[1])) {
                    $key = 1;
                    $enititylinkattrname = $entitylink->attribut[$key]->name;
                }

                $field .= "<div class='form-group'>\n<label for='" . $relation->entity . "'>" . ucfirst($relation->entity) . "</label>\n";

                if ($relation->cardinality == 'manyToOne') {
                    $field .= "
                    <?= Form::select('" . $relation->entity . "', 
                    FormManager::Options_Helper('" . $enititylinkattrname . "', " . ucfirst($relation->entity) . "::allrows()),
                    $" . $name . "->get" . ucfirst($relation->entity) . "()->getId(),
                    ['class' => 'form-control']); ?>\n";

                } elseif ($relation->cardinality == 'oneToOne' && $onetoone) {
                    $field .= "<?php $" . $relation->entity . " = $" . $name . "->get" . ucfirst($relation->entity) . "(); ?>";
                    $field .= "
                    <?= Form::imbricate($" . $relation->entity . ") ?>";
                    $field .= $this->formwidget($entitylink, $listmodule, false);
                    $field .= "<?= Form::closeimbricate() ?>\n";
                } elseif ($relation->cardinality == 'manyToMany') {
                    //FormManager::Options_ToCollect_Helper('name', new Dvups_right(), $dvups_role->getDvups_right()
                    $field .= "
                    <?= Form::checkbox('" . $relation->entity . "', 
                    FormManager::Options_ToCollect_Helper('" . $enititylinkattrname . "', new " . ucfirst($relation->entity) . "(), $" . $name . "->get" . ucfirst($relation->entity) . "()),
                    FormManager::Options_Helper('" . $enititylinkattrname . "', $" . $name . "->get" . ucfirst($relation->entity) . "()),
                    ['class' => 'form-control']); ?>\n";
                }

                $field .= " </div>\n";
            }
        }

        return $field;

    }


    /* CREATION DU FORM FIELD */

    private function detailwidget($entity, $listmodule, $onetoone = true, $mother = false){

        $name = strtolower($entity->name);
        //$detailview = DvAdmin::builddetaildatatable($entity, $listmodule, $onetoone, $mother);
        //return $field;
        return "
        <div class=\"col-lg-12 col-md-12\">
                <?= " . ucfirst($name) . "Table::init()
                ->builddetailtable()
                ->renderentitydata($" . $name . "); ?>
        </div>
			";

    }

    public function detailWidgetGenerator($entity, $listmodule) {

        $name = strtolower($entity->name);

        /* if($name == 'utilisateur')
          return 0; */
        unset($entity->attribut[0]);
        $contenu = $this->detailwidget($entity, $listmodule);

        $entityform = fopen('Ressource/views/' . $name . '/detail.blade.php', 'w');
        //$entityform = fopen('Form/' . ucfirst($name) . 'DetailWidget.php', 'w');
        fputs($entityform, $contenu);

        fclose($entityform);
    }

    public function formWidgetGenerator($entity, $listmodule) {

        $name = strtolower($entity->name);

        /* if($name == 'utilisateur')
          return 0; */
        unset($entity->attribut[0]);
        $field = $this->formwidget($entity, $listmodule);

        $contenu = "
    <?php //Form::addcss(" . ucfirst($name) . " ::classpath('Ressource/js/".$name."')) ?>
    
    <?= Form::open($" . $name . ", [\"action\"=> \"$" . "action\", \"method\"=> \"post\"]) ?>

     " . $field . "
       
    <?= Form::submit(\"save\", ['class' => 'btn btn-success']) ?>
    
    <?= Form::close() ?>
    
    <?= Form::addDformjs() ?>    
    <?= Form::addjs(" . ucfirst($name) . "::classpath('Ressource/js/".$name."Form')) ?>
    ";

        $entityform = fopen('Ressource/views/' . $name . '/formWidget.blade.php', 'w');
        fputs($entityform, $contenu);

        fclose($entityform);
    }

    /* CREATION DU DAO */

    public function daoGenerator($entity) {
        $name = strtolower($entity->name);

        /* if($name == 'utilisateur')
          return 0; */

        $classDao = fopen('Dao/' . ucfirst($name) . 'DAO.php', 'w');
        $contenu = "<?php \n
	class " . ucfirst($name) . "DAO extends DBAL{
			
		public function __construct() {
			parent::__construct(new " . ucfirst($name) . "());
		}			
		
	}";

        fputs($classDao, $contenu);

        fclose($classDao);
    }

}
