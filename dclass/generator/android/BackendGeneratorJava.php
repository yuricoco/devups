<?php

class BackendGeneratorJava {

    public function modelGenerator($entity, $package) {

        $name = strtolower($entity->name);

        unset($entity->attribut[0]);

        $fichier = fopen('Resource/java/' . $name."/models/" .ucfirst($name) . '.java', 'w');

        fputs($fichier, "package $package;
    
    public class " . ucfirst($name) . " {\n");
        $method = "";
        $construteur = "
        public " . ucfirst($name) . "(){ 
                          ";
        $attrib = "";

        if (!empty($entity->relation)) {

            $construteur .= "";
            foreach ($entity->relation as $relation) {

                if ($relation->cardinality == 'manyToMany') {

                    $attrib .= "
        public List<" . ucfirst($relation->entity) . "> " . $relation->entity . ";\n";

                $method .= "
        public List<" . ucfirst($relation->entity) . "> get" . ucfirst($relation->entity) . "() {
            return this." . $relation->entity . ";
        }";

                } elseif ($relation->cardinality == 'oneToOne' or $relation->nullable == 'DEFAULT') {

                    $attrib .= "
        private " . ucfirst($relation->entity) . " " . $relation->entity . ";\n";

                $method .= "
        public " . ucfirst($relation->entity) . " get" . ucfirst($relation->entity) . "() {
            return this." . $relation->entity . ";
        }";
                    $method .= "
        public void set" . ucfirst($relation->entity) . "(" . ucfirst($relation->entity) . " " . $relation->entity . ") {
            this." . $relation->entity . " = " . $relation->entity . ";
        }
                        ";
                } else {

                    $attrib .= "
        private " . ucfirst($relation->entity) . " " . $relation->entity . ";\n";

                $method .= "
        public " . ucfirst($relation->entity) . " get" . ucfirst($relation->entity) . "() {
            return this." . $relation->entity . ";
        }";
                    $method .= "
        public void set" . ucfirst($relation->entity) . "(" . ucfirst($relation->entity) . " " . $relation->entity . ") {
            this." . $relation->entity . " = " . $relation->entity . ";
        }
                        ";
                }
            }
        }

        $construteur .= "\n}\n";

        $construt = "
        protected int id;";
        $otherattrib = false;


        foreach ($entity->attribut as $attribut) {

            $datatype = $attribut->datatype;

            if ($attribut->datatype == "string" || $attribut->datatype == "text") {
                $datatype = 'String';
            }

            $construt .= "
        private " . $datatype . " " . $attribut->name . ";";
        }
        $otherattrib = true;
//        }

        $construt .= " 
        " . $attrib . "

        " . $construteur . "
        public int getId() {
            return this.id;
        }";
        if ($otherattrib) {
            foreach ($entity->attribut as $attribut) {

                if (in_array($attribut->formtype, ['document', 'image', 'music', 'video'])) {
                    $construt .= "
                    
        public String get" . ucfirst($attribut->name) . "() {
            return this." . $attribut->name . ";
        }

        public void set" . ucfirst($attribut->name) . "(String " . $attribut->name . ") {
            this." . $attribut->name . " = " . $attribut->name . ";
        }
        ";
                } elseif (in_array($attribut->formtype, ['date', 'datepicker'])) {
                    $construt .= "

        public String get" . ucfirst($attribut->name) . "() {
                return this." . $attribut->name . ";
        }

        public void set" . ucfirst($attribut->name) . "(String " . $attribut->name . ") {
                    this." . $attribut->name . " = " . $attribut->name . ";
        }";
                } elseif ($attribut->formtype == 'liste') {
                    $construt .= " ";
                } else {

                    $datatype = $attribut->datatype;

                    if ($attribut->datatype == "string" || $attribut->datatype == "text") {
                        $datatype = 'String';
                    }

                    $construt .= "
        public " . $datatype . " get" . ucfirst($attribut->name) . "() {
            return this." . $attribut->name . ";
        }

        public void set" . ucfirst($attribut->name) . "(" . $datatype . " " . $attribut->name . ") {
            this." . $attribut->name . " = " . $attribut->name . ";
        }
        ";
                }
            }
        }
        $construt .= $method;

        fputs($fichier, $construt);
        fputs($fichier, "\n}\n");

        fclose($fichier);

        
    }

    /* 	CREATION DU CONTROLLER 	 */

    public function activityGenerator($entity, $package) {
        $name = strtolower($entity->name);

        $classController = fopen('Resource/java/' . $name.'/activities/' . ucfirst($name) . 'DetailActivity.java', 'w');

        $contenu = "package $package;
        
import android.os.Bundle;

import $package.R;
import $package.core.activities.BaseActivity;

public class " . ucfirst($name) . "DetailActivity extends BaseActivity{

        private " . ucfirst($name) . " " . $name . ";
    
        @Override
        protected void onCreate(Bundle savedInstanceState) {
            super.onCreate(savedInstanceState);
            setContentView(R.layout.activity_" . $name . "_detail);
        
        }
    }
    ";
        fputs($classController, $contenu);
        fclose($classController);

        $classController = fopen('Resource/java/' . $name.'/activities/' . ucfirst($name) . 'ListActivity.java', 'w');

        $contenu = "package $package;
        
import android.os.Bundle;

import $package.R;
import $package.core.activities.BaseActivity;

public class " . ucfirst($name) . "ListActivity extends BaseActivity{

    private " . ucfirst($name) . " " . $name . ";

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_" . $name . "_list);
    
    }
}
    ";
        fputs($classController, $contenu);
        fclose($classController);

        $classController = fopen('Resource/java/' . $name.'/activities/' . ucfirst($name) . 'FormActivity.java', 'w');

        $contenu = "package $package;
        
import android.os.Bundle;

import $package.R;
import $package.core.activities.BaseActivity;

public class " . ucfirst($name) . "FormActivity extends BaseActivity{

    private " . ucfirst($name) . " " . $name . ";

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_" . $name . "_form);
    
    }
}
    ";
        fputs($classController, $contenu);
        fclose($classController);
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

            $field .= "
            " . "entitycore->field['" . $attribut->name . "'] = [
                \"label\" => '" . ucfirst($attribut->name) . "', \n";

            if ($attribut->nullable == 'default') {
                $field .= "\t\t\tFH_REQUIRE => false,\n ";
            }

            if ($attribut->formtype == 'text' or $attribut->formtype == 'float') {
                $field .= "\t\t\t\"type\" => FORMTYPE_TEXT, 
                \"value\" => " . $name . "->get" . ucfirst($attribut->name) . "(), ";
            } elseif ($attribut->formtype == 'integer' or $attribut->formtype == 'number') {
                $field .= "\t\t\t\"type\" => FORMTYPE_NUMBER, 
                \"value\" => " . $name . "->get" . ucfirst($attribut->name) . "(),  ";
            } elseif ($attribut->formtype == 'textarea') {
                $field .= "\t\t\t\"type\" => FORMTYPE_" . strtoupper($attribut->formtype) . ", 
                \"value\" => " . $name . "->get" . ucfirst($attribut->name) . "(), ";
            } elseif ($attribut->formtype == 'date') {
                $field .= "\t\t\t\"type\" => FORMTYPE_" . strtoupper($attribut->formtype) . ", 
                \"value\" => " . $name . "->get" . ucfirst($attribut->name) . "(), ";
            } elseif ($attribut->formtype == 'time') {
                $field .= "\t\t\t\"type\" => FORMTYPE_" . strtoupper($attribut->formtype) . ", 
                \"value\" => " . $name . "->get" . ucfirst($attribut->name) . "(), ";
            } elseif ($attribut->formtype == 'datetime') {
                $field .= "\t\t\t\"type\" => FORMTYPE_" . strtoupper($attribut->formtype) . ", 
                \"value\" => " . $name . "->get" . ucfirst($attribut->name) . "(), ";
            } elseif ($attribut->formtype == 'datepicker') {
                $field .= "\t\t\t\"type\" => FORMTYPE_" . strtoupper($attribut->formtype) . ", 
                \"value\" => " . $name . "->get" . ucfirst($attribut->name) . "(), ";
            } elseif ($attribut->formtype == 'radio') {
                $field .= "\t\t\t\"type\" => FORMTYPE_" . strtoupper($attribut->formtype) . ", 
                \"value\" => " . $name . "->get" . ucfirst($attribut->name) . "(), ";
            } elseif ($attribut->formtype == 'email') {
                $field .= "\t\t\t\"type\" => FORMTYPE_" . strtoupper($attribut->formtype) . ", 
                \"value\" => " . $name . "->get" . ucfirst($attribut->name) . "(), ";
            } elseif ($attribut->formtype == 'document') {
                $field .= "\t\t\t\"type\" => FORMTYPE_FILE,
                FH_FILETYPE => FILETYPE_" . strtoupper($attribut->formtype) . ",  
                \"value\" => " . $name . "->get" . ucfirst($attribut->name) . "(),
                \"src\" => " . $name . "->show" . ucfirst($attribut->name) . "(), ";
            } elseif ($attribut->formtype == 'video') {
                $field .= "\t\t\t\"type\" => FORMTYPE_FILE,
                \"filetype\" => FILETYPE_" . strtoupper($attribut->formtype) . ", 
                \"value\" => " . $name . "->get" . ucfirst($attribut->name) . "(),
                \"src\" => " . $name . "->show" . ucfirst($attribut->name) . "(), ";
            } elseif ($attribut->formtype == 'music') {
                $field .= "\"type\" => FORMTYPE_FILE,
                \"filetype\" => FILETYPE_" . strtoupper($attribut->formtype) . ", 
                \"value\" => " . $name . "->get" . ucfirst($attribut->name) . "(),
                \"src\" => " . $name . "->show" . ucfirst($attribut->name) . "(), ";
            } elseif ($attribut->formtype == 'image') {
                $field .= "\t\t\t\"type\" => FORMTYPE_FILE,
                \"filetype\" => FILETYPE_" . strtoupper($attribut->formtype) . ", 
                \"value\" => " . $name . "->get" . ucfirst($attribut->name) . "(),
                \"src\" => " . $name . "->show" . ucfirst($attribut->name) . "(), ";
            } else {
                $field .= "\"type\" => FORMTYPE_TEXT,
                \"value\" => " . $name . "->get" . ucfirst($attribut->name) . "(), ";
            }

            $field .= "
            ];\n";
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

                if ($relation->cardinality == 'manyToOne') {
                    $field .= "
                " . "entitycore->field['" . $relation->entity . "'] = [
                    \"type\" => FORMTYPE_SELECT, 
                    \"value\" => " . $name . "->get" . ucfirst($relation->entity) . "()->getId(),
                    \"label\" => '" . ucfirst($relation->entity) . "',
                    \"options\" => FormManager::Options_Helper('" . $enititylinkattrname . "', " . ucfirst($relation->entity) . "::allrows()),
                ];\n";
                } elseif ($relation->cardinality == 'oneToOne') {
                    $field .= "
                " . "entitycore->field['" . $relation->entity . "'] = [
                    \"type\" => FORMTYPE_INJECTION, 
                    FH_REQUIRE => true,
                    \"label\" => '" . ucfirst($relation->entity) . "',
                    \"imbricate\" => " . ucfirst($relation->entity) . "Form::__renderForm(" . $name . "->get" . ucfirst($relation->entity) . "()),
                ];\n";
                } elseif ($relation->cardinality == 'manyToMany') {
                    $field .= "
                " . "entitycore->field['" . $relation->entity . "'] = [
                    \"type\" => FORMTYPE_CHECKBOX, 
                    \"values\" => FormManager::Options_Helper('" . $enititylinkattrname . "', " . $name . "->get" . ucfirst($relation->entity) . "()),
                    \"label\" => '" . ucfirst($relation->entity) . "',
                    \"options\" => FormManager::Options_ToCollect_Helper('" . $enititylinkattrname . "', new " . ucfirst($relation->entity) . "(), " . $name . "->get" . ucfirst($relation->entity) . "()),
                ];\n";
                }
            }
        }

        $contenu = "<?php \n
    class " . ucfirst($name) . "Form extends FormManager{

        public static function formBuilder(\\" . ucfirst($name) . " " . $name . ", " . "action = null, " . "button = false) {
            " . "entitycore = new Core(" . $name . ");
            
            " . "entitycore->formaction = " . "action;
            " . "entitycore->formbutton = " . "button;
                
            " . $field . "

            return " . "entitycore;
        }
        
        public static function __renderForm(\\" . ucfirst($name) . " " . $name . ", " . "action = null, " . "button = false) {
            return FormFactory::__renderForm(" . ucfirst($name) . "Form::formBuilder(" . $name . ", " . "action, " . "button));
        }
        
    }
    ";
        $entityform = fopen('Form/' . ucfirst($name) . 'Form.php', 'w');
        fputs($entityform, $contenu);

        fclose($entityform);
    }

    /* CREATION DU DAO */

    public function adapterGenerator($entity, $package)
    {
        $name = strtolower($entity->name);

        /* if($name == 'utilisateur')
          return 0; */

        $classAdapter = fopen('Resource/java/' . $name.'/adapters/' . ucfirst($name) . 'Adapter.java', 'w');

        $contenu = "package $package;
        
import android.content.Intent;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.CardView;
import android.support.v7.widget.RecyclerView;
import android.util.Log;
import android.view.View;
import android.view.ViewGroup;
import android.widget.TextView;

import java.util.List;
        
import $package.R;
        
public class " . ucfirst($name) . "Adapter extends RecyclerView.Adapter<" . ucfirst($name) . "Adapter.MyRecyclerView> {
    private AppCompatActivity activity;
    private List<" . ucfirst($name) . "> " . $name . "s;

    public " . ucfirst($name) . "Adapter(AppCompatActivity activity) {
        this.activity = activity;
    }

    @Override
    public MyRecyclerView onCreateViewHolder(ViewGroup parent, int viewType) {
        return new MyRecyclerView(activity.getLayoutInflater().inflate(R.layout.list_item_" . $name . ", parent, false));
    }
    @Override
    public void onBindViewHolder(" . ucfirst($name) . "Adapter.MyRecyclerView holder, int position) {
        final " . ucfirst($name) . " " . $name . " = " . $name . "s.get(position);

        //holder.nkap_" . $name . "_title.setText(" . $name . ".getTitle());

        holder.itemView.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {

                Intent intent = new Intent(activity, " . ucfirst($name) . "DetailActivity.class);
                intent.putExtra(Intent.EXTRA_TEXT, Integer.parseInt(" . $name . ".getId()));
                activity.startActivity(intent);

            }
        });

    }

    public void set" . ucfirst($name) . "s(List<" . ucfirst($name) . "> " . $name . "s) {
        this." . $name . "s = " . $name . "s;
    }
    @Override
    public int getItemCount() {
        return " . $name . "s.size();
    }

    class MyRecyclerView extends RecyclerView.ViewHolder {
        //TextView nkap_" . $name . "_title;

        MyRecyclerView(View itemView) {
            super(itemView);
            //nkap_" . $name . "_title = itemView.findViewById(R.id.label_" . $name . ");
        }
    }

}";

        fputs($classAdapter, $contenu);
        fclose($classAdapter);

    }
    /* CREATION DU DAO */

    public function servicesGenerator($entity, $package) {
        $name = strtolower($entity->name);

        /* if($name == 'utilisateur')
          return 0; */

        $classDao = fopen('Resource/java/' . $name.'/services/' . ucfirst($name) . 'WebServiceClient.java', 'w');
        $contenu = "package $package;
        
    import java.util.List;
    import retrofit2.Call;
	
	public class " . ucfirst($name) . "WebServiceClient extends WebServiceClient{
			private final static String TAG = " . ucfirst($name) . "WebServiceClient.class.getName();

    private static " . ucfirst($name) . "WebServiceClient instance;

    public static " . ucfirst($name) . "WebServiceClient getInstance() {
        if (instance == null) {
            instance = new " . ucfirst($name) . "WebServiceClient();
        }
        return instance;
    }

    public " . ucfirst($name) . "WebServiceClientInterface webServiceClientInterface;

    public " . ucfirst($name) . "WebServiceClient() {
        super();
        webServiceClientInterface = WebServiceClientFactory.build(" . ucfirst($name) . "WebServiceClientInterface.class);
    }

    public Promise get" . ucfirst($name) . "s(WebServiceDataRequest<" . ucfirst($name) . "DataRequest> dataRequest) {
        Call<WebServiceDataResponse<List<" . ucfirst($name) . ">>> call = webServiceClientInterface.get" . ucfirst($name) . "s(getHeaderMap(), dataRequest);
        return executeCall(call);
    }

    public Promise get" . ucfirst($name) . "(long id) {
        Call<WebServiceDataResponse<" . ucfirst($name) . ">> call = webServiceClientInterface.get" . ucfirst($name) . "(getHeaderMap(), id);
        return executeCall(call);
    }

    public Promise create" . ucfirst($name) . "(" . ucfirst($name) . " operation) {
        WebServiceDataRequest<" . ucfirst($name) . "> dataRequest = new WebServiceDataRequest<>(SessionManager.getInstance().getToken(null), operation);
        Call<WebServiceDataResponse<" . ucfirst($name) . ">> call = webServiceClientInterface.create" . ucfirst($name) . "(getHeaderMap(), dataRequest);
        return executeCall(call);
    }

    public Promise update" . ucfirst($name) . "(" . ucfirst($name) . " operation) {
        WebServiceDataRequest<" . ucfirst($name) . "> dataRequest = new WebServiceDataRequest<>(SessionManager.getInstance().getToken(null), operation);
        Call<WebServiceDataResponse<" . ucfirst($name) . ">> call = webServiceClientInterface.update" . ucfirst($name) . "(getHeaderMap(), operation.getId(), dataRequest);
        return executeCall(call);
    }

    public Promise delete" . ucfirst($name) . "(long operationId) {
        Delete" . ucfirst($name) . "DataRequest deleteTransferDataRequest = new Delete" . ucfirst($name) . "DataRequest(operationId);
        WebServiceDataRequest<Delete" . ucfirst($name) . "DataRequest> dataRequest = new WebServiceDataRequest<>(SessionManager.getInstance().getToken(null), deleteTransferDataRequest);
        Call<WebServiceDataResponse<DeleteResponse>> call = webServiceClientInterface.delete" . ucfirst($name) . "(getHeaderMap(), dataRequest);
        return executeCall(call);
    }	
		
	}";

        fputs($classDao, $contenu);
        fclose($classDao);

        $classDao = fopen('Resource/java/' . $name.'/services/' . ucfirst($name) . 'WebServiceClientInterface.java', 'w');
        $contenu = "package $package;

import java.util.List;
import java.util.Map;

import retrofit2.Call;
import retrofit2.http.Body;
import retrofit2.http.GET;
import retrofit2.http.HTTP;
import retrofit2.http.HeaderMap;
import retrofit2.http.POST;
import retrofit2.http.Path;

public interface " . ucfirst($name) . "WebServiceClientInterface{
        
    
    @POST(\"/Api/" . ucfirst($name) . "s\")
    Call<WebServiceDataResponse<List<" . ucfirst($name) . ">>> get" . ucfirst($name) . "s(@HeaderMap Map<String, String> headers, @Body WebServiceDataRequest<" . ucfirst($name) . "DataRequest> dataRequest);

    @GET(\"/Api/" . ucfirst($name) . "/{id}\")
    Call<WebServiceDataResponse<" . ucfirst($name) . ">> get" . ucfirst($name) . "(@HeaderMap Map<String, String> headers, @Path(\"id\") long id);

    @POST(\"/Api/" . ucfirst($name) . "\")
    Call<WebServiceDataResponse<" . ucfirst($name) . ">> create" . ucfirst($name) . "(@HeaderMap Map<String, String> headers, @Body WebServiceDataRequest dataRequest);

    @POST(\"/Api/" . ucfirst($name) . "/{id}\")
    Call<WebServiceDataResponse<" . ucfirst($name) . ">> update" . ucfirst($name) . "(@HeaderMap Map<String, String> headers, @Path(\"id\") long id, @Body WebServiceDataRequest dataRequest);

    @HTTP(method = \"DELETE\", path = \"/Api/" . ucfirst($name) . "\", hasBody = true)
    Call<WebServiceDataResponse<DeleteResponse>> delete" . ucfirst($name) . "(@HeaderMap Map<String, String> headers, @Body WebServiceDataRequest<Delete" . ucfirst($name) . "DataRequest> dataRequest);
    
    
}";

        fputs($classDao, $contenu);
        fclose($classDao);
    }

}
