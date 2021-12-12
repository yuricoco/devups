<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


class Dfile
{

    public static $EXTENSION_IMAGE = array('jpg', 'jpeg', 'png', 'gif');
    public static $EXTENSION_AUDIO = array('mp3', 'aac', 'wma', 'ogg', 'flac', "wav");
    public static $EXTENSION_VIDEO = array('mp4', 'avi', 'mov', 'mkv', 'webm', 'ogg', 'crdownload');
    public static $EXTENSION_DOCUMENT = array('pdf', 'docx', 'doc', 'txt', 'ico', 'xls', 'xlsx', 'ppt', 'pptx');
    public static $EXTENSION_ARCHIVE = array('rar', 'zip', 'iso');
    /**
     * @var bool
     */
    private static $multiple = false;

    public $uploaddir;
    private $file;
    private $original = true;
    private $compressionquality = 80;
    private $file_name = "";
    private $constraintfiletype = null;
    private $type;


    public static function fileadapter($url, $name = "", $imgdir = ["style" => "max-width : 100%; max-height: 200px"])
    {

        $ext = Dfile::getextension($name);
        if (in_array($ext, Dfile::$EXTENSION_IMAGE)) {
            return '<img ' . Form::serialysedirective($imgdir) . ' src="' . $url . '" alt="' . $name . '" />';
        } elseif (in_array($ext, Dfile::$EXTENSION_DOCUMENT)) {
            if ($ext == "pdf")
                return '<embed type="application/PDF"  src="' . $url . '" width="100%" height="200" />' . $name . '';
            else
                return '<a href="' . $url . '" download="' . $name . '" >' . $name . '</a>';
        } elseif (in_array($ext, Dfile::$EXTENSION_ARCHIVE)) {
            return '<a href="' . $url . '" download="' . $name . '" >' . $name . '</a>';
        } else {
            return "no file";
        }

    }

    public static function getimageatbase64($path, $default = 'no_image.jpg')
    {
        if (file_exists($path)) {
            $type = pathinfo($path, PATHINFO_EXTENSION);
            $data = file_get_contents($path);
            return 'data:image/' . $type . ';base64,' . base64_encode($data);
        }

        $data = file_get_contents(ROOT . "web/assets/default/" . $default);
        return 'data:image/jpg;base64,' . base64_encode($data);
    }

    public static function getaudioatbase64($path)
    {
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        return 'data:audio/' . $type . ';base64,' . base64_encode($data);
    }

    public static function uploadchunk($uploaddir)
    {
        $dfile = new Dfile(null);
        $path = self::chdirectory(self::filepath($uploaddir));
        $hashname = $_GET['hashName'];
        $filename = $_GET['fileName'];

        $xmlstr = file_get_contents('php://input');

        $is_ok = false;
        while (!$is_ok) {
            $file = fopen($path . $hashname, "ab");

            if (flock($file, LOCK_EX)) {
                fwrite($file, $xmlstr);
                flock($file, LOCK_UN);
                fclose($file);
                $is_ok = true;
            } else {
                fclose($file);
                sleep(3);
            }
        }

        return ["filename" => $filename,
            "hashname" => $hashname,
            "show" => Dfile::show($hashname, $uploaddir),
            "size" => $_GET['filesize'],
            "extension" => $_GET['extension']
        ];

    }

    public function setcompressionquality($quality)
    {
        $this->compressionquality = $quality;
    }

    private static function wd_remove_accents($str, $charset = 'utf-8')
    {
        $str = htmlentities($str, ENT_NOQUOTES, $charset);

        $str = preg_replace('#&([A-za-z])(?:acute|cedil|caron|circ|grave|orn|ring|slash|th|tilde|uml);#', '\1', $str);
        $str = preg_replace('#&([A-za-z]{2})(?:lig);#', '\1', $str); // pour les ligatures e.g. '&oelig;'
        $str = preg_replace('#&[^;]+;#', '', $str); // supprime les autres caractères
        $str = str_replace(' ', '_', $str); // supprime les autres caractères

        return strtolower($str);
    }

    function setUploaddir($uploaddir)
    {
        $this->uploaddir = $uploaddir;
        return $this;
    }

    /**
     * @param $default Dans le cas ou le developpeur voudrait spécifier sa propre image par défaut
     */
    private static function filepath($str, $charset = 'utf-8')
    {
        $str = htmlentities($str, ENT_NOQUOTES, $charset);

        $str = self::wd_remove_accents($str);
        return $str . '/';
    }

    private static function chdirectory($filepath)
    {
//	if(file_exists(UPLOAD_RESSOURCE2.$filepath))
//            return UPLOAD_RESSOURCE2.$filepath;
        if (!file_exists(UPLOAD_DIR . $filepath))
            mkdir(UPLOAD_DIR . $filepath, 0777, true);

        return UPLOAD_DIR . $filepath;
    }

    public static function makedir($filepath)
    {
//	if(file_exists(UPLOAD_RESSOURCE2.$filepath))
//            return UPLOAD_RESSOURCE2.$filepath;
        if (!file_exists(UPLOAD_DIR . $filepath))
            mkdir(UPLOAD_DIR . $filepath, 0777, true);

        return UPLOAD_DIR . $filepath;
    }

    public $errornofile = false;
    public $namewithoutextension = "";
    public $extension = "";
    public $collection = [];

    public function __construct($file, $entity = null)
    {

        if (!$file) {
            return $this;
        }


        if ($entity) {
            $this->uploaddir = strtolower(get_class($entity));
            $entityname = $this->uploaddir;
        }

        if ($entity && isset($_FILES[$entityname . '_form']) && isset($_FILES[$entityname . '_form']['error'][$file]) &&
            $_FILES[$entityname . '_form']['error'][$file] == 0) {

//            $_files = [
            $this->name = $_FILES[$entityname . '_form']['name'][$file];
            $this->tmp_name = $_FILES[$entityname . '_form']['tmp_name'][$file];
            $this->error = $_FILES[$entityname . '_form']['error'][$file];
            $this->size = $_FILES[$entityname . '_form']['size'][$file];
//            ];
            $this->file = $_FILES[$entityname . '_form'];
//            $result = call_user_func(array($entity, $uploadmethod), $_files);
            /*} elseif (is_string($file) && file_exists(UPLOAD_DIR . $file)) {
                $this->name = $_FILES[$file]['name'];
                $this->size = $_FILES[$file]['size'];
                $this->tmp_name = $_FILES[$file]['tmp_name'];
                $this->error = $_FILES[$file]['error'];
                $this->file = $_FILES[$file];*/
        } elseif (is_string($file) && isset($_FILES[$file])) {
            if (self::$multiple) {
                for ($i = 0; $i < count($_FILES[$file]["name"]); $i++){
                    //foreach ($_FILES[$file] as $i => $item) {
                    $collection = [
                        "name" => $_FILES[$file]['name'][$i],
                        "size" => $_FILES[$file]['size'][$i],
                        "tmp_name" => $_FILES[$file]['tmp_name'][$i],
                        "error" => $_FILES[$file]['error'][$i],
                    ];
                    //var_dump($collection);
                    //var_dump($_FILES[$file]);
                    //die;
                    $collection["file"] = $collection;
                    $this->collection[] = $collection;
                }

                //dv_dump($this->collection);
                $this->name = $collection['name'];
                $this->size = $collection['size'];
                $this->tmp_name = $collection['tmp_name'];
                $this->error = $collection['error'];
                $this->file = $collection["file"];
            } else if ($_FILES[$file]['error'] == 0) {

                $this->name = $_FILES[$file]['name'];
                $this->size = $_FILES[$file]['size'];
                $this->tmp_name = $_FILES[$file]['tmp_name'];
                $this->error = $_FILES[$file]['error'];
                $this->file = $_FILES[$file];

            }
        } else {
            $this->errornofile = true;
            $this->error = true;
            $this->message[] = "no file found";
            return $this;
        }

        $this->file_name = $this->name;

        $this->imagesize = $this->getsize($this->tmp_name);
        $this->extension = self::getextension($this->name);
        $this->settype();
        if ($this->file_name == "blob") {
            $this->extension = "png";
            $this->file_name .= ".png";
            $this->name .= ".png";
        }
        // dv_dump($this->file_name, $this->extension);
        $this->namewithoutextension = str_replace("." . $this->extension, "", $this->file_name);
    }


    private function getsize($file)
    {
        return getimagesize($file);
    }

    public static function getextension($name)
    {
        return strtolower(pathinfo($name, PATHINFO_EXTENSION));
    }

    private function settype()
    {
        if (in_array($this->extension, self::$EXTENSION_IMAGE)) {
            $this->type = "image";
        } elseif (in_array($this->extension, self::$EXTENSION_AUDIO)) {
            $this->type = "audio";
        } elseif (in_array($this->extension, self::$EXTENSION_VIDEO)) {
            $this->type = "video";
        } elseif (in_array($this->extension, self::$EXTENSION_DOCUMENT)) {
            $this->type = "document";
        } elseif (in_array($this->extension, self::$EXTENSION_ARCHIVE)) {
            $this->type = "archive";
        } else {
            $this->type = "text";
        }
    }

    public function control($param = ["size" => 0, "extension" => []])
    {
        extract($param);
        if ($size && $this->size <= $size) {
            $this->error = true;
            $this->message[] = "Le fichier audio doit etre inferieur a $size octet !";
        }

        if ($extension && in_array($this->extension, $extension)) {
            $this->error = true;
            $this->message[] = "Le fichier audio doit etre inferieur a $size octet !";
        }
    }

    public static function init($file)
    {
        $dfile = new Dfile($file);
        return $dfile;
    }

    public static function initMultiple($file)
    {
        self::$multiple = true;
        $dfile = new Dfile($file);
        return $dfile;
    }

    public function sanitize($key = "")
    {
        $this->file_name = self::wd_remove_accents($key . $this->name);
        return $this;
    }


    public function saveoriginal($param)
    {
        $this->original = $param;
        return $this;
    }

    public function hashname()
    {
        $datetime = new DateTime();
        $name = sha1($this->name . $datetime->getTimestamp());
        $this->file_name = $name . "." . $this->extension;

        return $this;
    }

    /**
     * @param array $resize []
     * @param string $sufix r-
     * @param string $uploaddir ""
     * @param bool $crop true
     * @param int $quality 80
     * @return $this
     */
    public function addresize($resize = [], $sufix = "r-", $uploaddir = "", $crop = true, $quality = 80)
    {
        $this->imagetoresize[] = ["resize" => $resize, "sufix" => $sufix, "uploaddir" => $uploaddir, "crop" => $crop, "quality" => $quality];

        return $this;
    }

    function setfile_name($filename)
    {
        $this->file_name = $filename;
        $this->extension = self::getextension($filename);
        $this->namewithoutextension = str_replace("." . $this->extension, "", $this->file_name);
        return $this;
    }

    public function resizethisimage($relative_url)
    {
        if (!$this->file_name) {
            $array = explode("/", $relative_url);
            $this->file_name = end($array);
        }

        $source_url = UPLOAD_DIR . $relative_url;
        if (!file_exists($source_url))
            return false;

        $this->imagesize = $this->getsize($source_url);
        $this->extension = self::getextension($relative_url);
        $this->settype();

        if (!empty($this->imagetoresize)) {

            foreach ($this->imagetoresize as $imagetoresize) {
                $this->resizeimage($source_url, $imagetoresize);
            }

            /*if ($this->validation())
                return $this->error;*/
        }

        return array("success" => true,
            "file" => [
                'hashname' => $this->file_name,
                'imagesize' => $this->imagesize,
                //'error' => $this->error,
            ],
            'detail' => 'upload success');
    }

    private function resizeimage($source_url, $param)
    {
        extract($param);

        $tocrop = false;
        if (!$uploaddir)
            $uploaddir = $this->uploaddir;

        $uploaddir = self::chdirectory(self::filepath($uploaddir));
//        list($width, $height) = $this->imagesize;
        $imagesize = $this->imagesize;


        $ratio_orig = $imagesize[0] / $imagesize[1];

        if ($resize[0])
            $largeur = $resize[0];
        else {
            $resize[0] = $imagesize[0];
            $largeur = $imagesize[0];
        }

        if (isset($resize[1]) && $resize[1])
            $hauteur = $resize[1];
        else {
            $resize[1] = $imagesize[1];
            $hauteur = $imagesize[1];
        }

        $mod = $imagesize[0] % $largeur;
        $mod += $imagesize[1] % $hauteur;

        if ($mod > 0 && $crop) {
            $tocrop = true;
            $centerx = 0;
            $centery = 0;
            if ($largeur == $hauteur) {
                if ($imagesize[0] >= $imagesize[1]) {
                    $largeur = $hauteur * $ratio_orig;
                    $centerx = $largeur / 2 - $resize[0] / 2;
                }

                if ($imagesize[0] <= $imagesize[1]) {
                    $hauteur = $largeur / $ratio_orig;
                    $centery = $hauteur / 2 - $resize[1] / 2;
                }
            } elseif ($resize[0] > $resize[1]) {
                //$largeur = $hauteur * $ratio_orig;
                $hauteur = $largeur / $ratio_orig;
                $centerx = $largeur / 2 - $resize[0] / 2;
            } else {
                $largeur = $hauteur * $ratio_orig;

                //$hauteur = $largeur / $ratio_orig;
                $centerx = $largeur / 2 - $resize[0] / 2;
                $centery = $hauteur / 2 - $resize[1] / 2;
            }
            if ($centerx < 0)
                $centerx = -($centerx);

            if ($centery < 0)
                $centery = -($centery);

            if (is_array($crop)) {
                $pos_x = $crop[0];
                $pos_y = $crop[1];
            }

//            die(var_dump($resize, $hauteur, $imagesize[1], $resize[1], $centery));
        } else {

            if ($largeur / $hauteur > $ratio_orig) {
                $largeur = $hauteur * $ratio_orig;
            } else {
                $hauteur = $largeur / $ratio_orig;
            }
        }

        $filename = $uploaddir . $sufix . $this->file_name;
//        $filename = $uploaddir . str_replace("." . $this->extension, "", $this->file_name) . $sufix . "." . $this->extension;
        $newimage = imagecreatetruecolor($largeur, $hauteur) or die("Erreur");

        //dv_dump($this->file_name, $this->extension);
        if (in_array($this->extension, array('jpg', 'jpeg', 'png'))) {
            if (in_array($this->extension, array('jpg', 'jpeg'))) {
                $image = imagecreatefromjpeg($source_url);

                if (imagecopyresampled($newimage, $image, 0, 0, 0, 0, $largeur, $hauteur, $imagesize[0], $imagesize[1])) {

                    if ($tocrop) {
                        $newimage = imagecrop($newimage, ["x" => 0, "y" => 0, "width" => $resize[0], "height" => $resize[1]]);
                    }

                    if (!imagejpeg($newimage, $filename, $quality)) {
                        $this->message[] = 'Le jpeg n\'a pas pu etre converti correctement';
                    }
//                else
//                    chmod($filename, 755);
                }
            } elseif ($this->extension == 'png') {

                imagealphablending($newimage, false);
                imagesavealpha($newimage, true);

                $source = imagecreatefrompng($source_url);
                imagealphablending($source, true);

                imagecopyresampled($newimage, $source, 0, 0, 0, 0, $largeur, $hauteur, $imagesize[0], $imagesize[1]);

                if ($tocrop) {
                    $newimage = imagecrop($newimage, ["x" => 0, "y" => 0, "width" => $resize[0], "height" => $resize[1]]);
                }

                if (!imagepng($newimage, $filename, 8))
                    $this->message[] = 'Le png n\'a pas pu etre converti correctement';
//            else
//                chmod($filename, 755);
            }
        } elseif ($this->extension == 'gif') {

            $image = imagecreatefromgif($source_url);
            if (!imagegif($image, $filename, $quality))
                $this->message[] = 'Le png n\'a pas pu etre converti correctement';
//            else
//                chmod($filename, 755);
        }
    }

    public function rename($newname, $sanitize = false)
    {
        if ($sanitize) {
            $this->file_name = self::wd_remove_accents($newname);
        } else {
            $this->file_name = $newname;
        }
        $this->namewithoutextension = str_replace("." . $this->extension, "", $this->file_name);
        return $this;
    }

    public static function d_rename($oldname, $newname, $oldpath = "", $newpath = "", $ext = "")
    {
        $path = UPLOAD_DIR;
        if ($oldpath) {
            $path = UPLOAD_DIR . $oldpath;
        }
        if ($newpath)
            $newpath = UPLOAD_DIR . $newpath;
        else
            $newpath = $path;

        if (file_exists($path . "/" . $oldname))
            rename($path . "/" . $oldname, $newpath . "/" . $newname . $ext);

    }

    public $converto = "";

    public function setConverto($val)
    {
        $this->converto = $val;
        return $this;
    }

    public function upload()
    {
        return $this->moveto($this->uploaddir);
    }

    private function validation()
    {

        if ($this->constraintfiletype && $this->type != $this->constraintfiletype) {
//            die(Bugmanager::getError(__CLASS__, __METHOD__, __LINE__, $this->message, $this->file));
            $this->error = array("success" => false, 'err' => "The file type is not valid for the contraint ");
            return true;
        } elseif ($this->error) {
//            die(Bugmanager::getError(__CLASS__, __METHOD__, __LINE__, $this->message, $this->file));
            $this->error = array("success" => false, 'err' => implode(" || ", $this->message));
            return true;
        } elseif (isset($this->error) && UPLOAD_ERR_OK !== $this->error) {
            $this->error = array("success" => false, 'err' => 'Une erreur interne a empêché l\'uplaod de l\'image');
            return true;
        }
        return false;
    }

    public function setConstraintfiletype($type = "image")
    {
        $this->constraintfiletype = $type;
        return $this;
    }

    public function uploadMultiple($callback_before = null, $callback_after = null)
    {
        $data = [];
        foreach ($this->collection as $i => $item) {
            $this->name = $item['name'];
            $this->size = $item['size'];
            $this->tmp_name = $item['tmp_name'];
            $this->error = $item['error'];
            $this->file = $item;

            if(is_callable($callback_before))
                $data = $callback_before($this);
            //$this->file_name = $this->name;
            $this->imagesize = $this->getsize($this->tmp_name);
            $this->extension = self::getextension($this->name);
            $this->settype();
            if ($this->name == "blob") {
                $this->extension = "png";
                $this->file_name .= ".png";
                $this->name .= ".png";
            }

            $this->namewithoutextension .= "-".($i+1);
            $this->file_name = $this->namewithoutextension.".".$this->extension;
            $result = $this->moveto($this->uploaddir);

            if(!$result["success"])
                return $result;

            if(is_callable($callback_after))
                $callback_after($result, $data);

        }
    }


    public function moveto($path, $absolut = false)
    {

        if ($this->validation())
            return $this->error;

        $this->uploaddir = $path;

        if (!$absolut)
            $path = self::chdirectory(self::filepath($path));

        if (move_uploaded_file($this->tmp_name, $path . "tmp_" . $this->file_name)) {

            if (!empty($this->imagetoresize)) {

                foreach ($this->imagetoresize as $imagetoresize) {
                    $this->resizeimage($path . "tmp_" . $this->file_name, $imagetoresize);
                }

                if ($this->original):
                    // rename the file
                    self::d_rename("tmp_" . $this->file_name, $this->file_name, $this->uploaddir);
                else:
                    $this->unlink($path . "tmp_" . $this->file_name);
                endif;

                if ($this->validation())
                    return $this->error;
            } elseif ($this->type === "image") {
                // rename the file
                self::d_rename("tmp_" . $this->file_name, $this->file_name, $this->uploaddir);
                $this->resizeimage($path . $this->file_name,
                    ["resize" => [$this->imagesize[0], $this->imagesize[1]], "sufix" => "", "uploaddir" => $this->uploaddir, "crop" => false, "quality" => $this->compressionquality]);

            } else {
                // rename the file
                self::d_rename("tmp_" . $this->file_name, $this->file_name, $this->uploaddir);

            }

            if (in_array($this->converto, ["jpg", "jpeg", "png", "tiff"]) && $this->extension != $this->converto) {
                if (in_array($this->extension, ["jpg", "jpeg"]))
                    $input = imagecreatefromjpeg(UPLOAD_DIR . $this->uploaddir . '/' . $this->file_name);
                else
                    $input = imagecreatefrompng(UPLOAD_DIR . $this->uploaddir . '/' . $this->file_name);

                $width = imagesx($input);
                $height = imagesy($input);
                $output = imagecreatetruecolor($width, $height);
                $white = imagecolorallocate($output, 255, 255, 255);
                imagefilledrectangle($output, 0, 0, $width, $height, $white);
                imagecopy($output, $input, 0, 0, 0, 0, $width, $height);
                if ($this->converto == "png")
                    $result = imagepng($output, UPLOAD_DIR . $this->uploaddir . '/' . $this->namewithoutextension . "." . $this->converto);
                elseif (in_array($this->converto, ["jpg", "jpeg"]))
                    $result = imagejpeg($output, UPLOAD_DIR . $this->uploaddir . '/' . $this->namewithoutextension . "." . $this->converto);

            }

            //chmod($path . $this->file_name, 755);
            return array("success" => true,
                "file" => [
                    'name' => $this->name,
                    'size' => $this->size,
                    'type' => $this->type,
                    'path' => $path,
                    'uploaddir' => $this->uploaddir,
                    'imagesize' => $this->imagesize,
                    'hashname' => $this->file_name,
                    'extension' => $this->extension,
                ],
                'detail' => 'upload success');
        } else {
            return array("success" => false, 'err' => 'Problème lors de l\'uploadage !');
        }
    }

    public static function show($image, $path = '', $default = 'no_image.jpg', $hidesrc = false)
    {

        $path = self::filepath($path);
//        $ext = $up->getextension($image);
//        if (in_array($ext, self::$EXTENSION_IMAGE)){
//
//        }
        if ($image && file_exists(UPLOAD_DIR . $path . $image)) {
            if ($hidesrc)
                $image = __env . "web/fileheader.php?src=" . $path . $image;
            else
                $image = SRC_FILE . $path . $image;
        } else
            $image = d_assets($default);

        return $image;
    }

    public static function exist($image, $path = '')
    {
        if ($image && file_exists(UPLOAD_DIR . $path . $image))
            return true;

        return false;
    }

    public function addvariante($param)
    {
        $this->variante[] = $param;
        return $this;
    }

    private function unlink($src_file)
    {
        unlink($src_file);
    }

    /**
     * delete the file named $image
     *
     * @param string $name_file the name of the file you want to delete
     * @return boolean true if file delete an array if the file doesn't exist
     */
    public static function deleteFile($name_file, $path = '', $absolute = false)
    {

        if ($absolute) {
            $path2 = $path;
        } else {
            $path2 = self::chdirectory(self::filepath($path));
        }


        if ($name_file != '' && file_exists($path2 . $name_file)) {
            unlink($path2 . $name_file);
            return array('success' => true);
        } else {
            return array('success' => false, 'err' => 'ce fichier n\'existe pas!', "file" => $path2 . $name_file);
        }
    }

    public function deleteDir($dir)
    {
        if (file_exists($dir)) {
            $files = array_diff(scandir($dir), array('.', '..'));
            foreach ($files as $file) {
                (is_dir("$dir/$file") && !is_link($dir)) ? $this->deleteDir("$dir/$file") : unlink("$dir/$file");
            }
            return rmdir($dir);
        } else {
            return $dir;
        }
    }

}

