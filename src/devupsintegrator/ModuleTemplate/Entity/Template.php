<?php
// user \dclass\devups\model\Model;

/**
 * @Entity @Table(name="template")
 * */
class Template extends Model implements JsonSerializable
{

    /**
     * @Id @GeneratedValue @Column(type="integer")
     * @var int
     * */
    protected $id;
    /**
     * @Column(name="header", type="string" , length=255 )
     * @var string
     **/
    protected $header;
    /**
     * @Column(name="footer", type="string" , length=255 )
     * @var string
     **/
    protected $footer;
    /**
     * @Column(name="logo", type="string" , length=255 )
     * @var string
     **/
    protected $logo;


    public function __construct($id = null)
    {

        if ($id) {
            $this->id = $id;
        }

    }

    public function getId()
    {
        return $this->id;
    }

    public function getHeader()
    {
        return $this->header;
    }

    public function setHeader($header)
    {
        $this->header = $header;
    }

    public function getFooter()
    {
        return $this->footer;
    }

    public function setFooter($footer)
    {
        $this->footer = $footer;
    }

    public function getLogo()
    {
        return $this->logo;
    }

    public function setLogo($logo)
    {
        $this->logo = $logo;
    }


    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'header' => $this->header,
            'footer' => $this->footer,
            'logo' => $this->logo,
        ];
    }

    public function extractXJoin($value){
        //$value = '[This] is a [test] string, [eat] my [shorts].';
        preg_match_all("/\(([^\)]*)\)/", $value, $matches);

        return $matches[1][0];
        //$pos = strpos($value, "<");

    }

    public function sanitize_media($content){

        $content = str_replace("src=\"js/", "src=\"{{__front}}js/", $content);
        $content = str_replace("href=\"css/", "href=\"{{__front}}css/", $content);
        $content = str_replace("src=\"images/", "src=\"{{__front}}images/", $content);
        return str_replace("src=\"img/", "src=\"{{__front}}img/", $content);

    }

    public function name_in_tree($output_dir, $default){

        $pathfile = explode("/", $default);
        $name = $pathfile[count($pathfile)-1];

        $file = $output_dir . str_replace($name,"", $default);
        if(count($pathfile)> 1 && !file_exists($file))
            mkdir($file, 0777, true);
        else
            $name = $default;

        return $default;
    }

    public function mapping(){
        $separator = '/';

//If the first three characters PHP_OS are equal to "WIN",
//then PHP is running on a Windows operating system.
        if (strcasecmp(substr(PHP_OS, 0, 3), 'WIN') == 0) {
            $isWindows = true;
            $separator = '\\';
        }

        $root_path = UPLOAD_DIR . "template/HTML" ;
        $file_ext = array(
            "html",
        );

        $files = scanDir::scan($root_path, $file_ext, true);
        $output_dir = ROOT."web/views/";
        foreach ($files as $file){

            $enable_process = false;
            $exploded = explode($separator, str_replace($root_path, "", $file));
            $srcimage = $exploded[count($exploded) - 1];
            $ext = pathinfo($srcimage, PATHINFO_EXTENSION);
            $filename = str_replace("." . $ext, "", $srcimage);
            $content = "";
            $handle = fopen($file, "r");

            if ($handle) {
                while (($line = fgets($handle)) !== false) {
                    // process the line read.
                    //var_dump($line);

                    if($wrapper = strstr($line, '@dis_layout')){
                        $enable_process = true;
                        $layout_name = $this->extractXJoin($wrapper);
                        $this->name_in_tree($output_dir, $this->extractXJoin($wrapper));
                        $layout_content = "";
                        echo "layout ".$layout_name." start <br>";
                        continue;
                    }
                    if($wrapper = strstr($line, '@die_layout')){
                        $layout_content .= $content;

                        writein($output_dir.$layout_name.".blade.php", $this->sanitize_media($layout_content));

                        echo "layout ".$layout_name." created <br>";
                        break;
                    }

                    if($wrapper = strstr($line, '@dis_page')){
                        $enable_process = true;
                        $layout_content = $content;
                        $meta = explode(":", $this->extractXJoin($wrapper));
                        $page_extend_layout = $meta[0];
                        $filename = $this->name_in_tree($output_dir, $meta[1]);

                        $content = "";


                        echo "page ".$filename." start <br>";
                        continue;
                    }

                    if($wrapper = strstr($line, '@die_page')){

                        // todo: persist the page for seo and other stuff
                        // todo: create methodView() in templateFrontController

                        $page = "
@extends('$page_extend_layout')
@section('container')
    $content
@endsection
                        ";
                        writein($output_dir.$filename.".blade.php", $this->sanitize_media($page));
                        $content = "";

                        echo "page ".$filename." created <br>";
                        continue;

                    }

                    if($enable_process)
                        $content .= $line."";
                    //break;
                }

                fclose($handle);
            } else {
                // error opening the file.
                echo  "error";
            }

            //writein(ROOT."web/views/test/".$filename.".blade.php", $content);

            //break;

        }

    }

}
