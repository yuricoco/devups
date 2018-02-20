<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Dfile {

    public $uploaddir;
    private $file;


    private function wd_remove_accents($str, $charset = 'utf-8') {
        $str = htmlentities($str, ENT_NOQUOTES, $charset);

        $str = preg_replace('#&([A-za-z])(?:acute|cedil|caron|circ|grave|orn|ring|slash|th|tilde|uml);#', '\1', $str);
        $str = preg_replace('#&([A-za-z]{2})(?:lig);#', '\1', $str); // pour les ligatures e.g. '&oelig;'
        $str = preg_replace('#&[^;]+;#', '', $str); // supprime les autres caractères
        $str = str_replace(' ', '_', $str); // supprime les autres caractères

        return strtolower($str);
    }

    /**
      @param $default Dans le cas ou le developpeur voudrait spécifier sa propre image par défaut
     */
    private function filepath($str, $charset = 'utf-8') {
        $str = htmlentities($str, ENT_NOQUOTES, $charset);

        $str = $this->wd_remove_accents($str);
        return $str . '/';
    }

    private function chdirectory($filepath) {
//	if(file_exists(UPLOAD_RESSOURCE2.$filepath))
//            return UPLOAD_RESSOURCE2.$filepath;
        if (!file_exists(UPLOAD_DIR . $filepath))
            mkdir(UPLOAD_DIR . $filepath, 0777, true);

        return UPLOAD_DIR . $filepath;
    }

    public function __construct($file, $entity = null) {
        if ($entity) {
            $this->uploaddir = strtolower(get_class($entity));
            $entityname = $this->uploaddir;
        }

        if ($entity && isset($_FILES[$entityname . '_form']) and $_FILES[$entityname . '_form']['error'][$file] == 0) {

//            $_files = [
                $this->name = $_FILES[$entityname . '_form']['name'][$file];
                $this->tmp_name = $_FILES[$entityname . '_form']['tmp_name'][$file];
                $this->error = $_FILES[$entityname . '_form']['error'][$file];
                $this->size = $_FILES[$entityname . '_form']['size'][$file];
//            ];
            $this->file = $_FILES[$entityname . '_form'];
//            $result = call_user_func(array($entity, $uploadmethod), $_files);
        }
        elseif (is_string($file) && isset($_FILES[$file]) && $_FILES[$file]['error'] == 0) {
            $this->name = $_FILES[$file]['name'];
            $this->size = $_FILES[$file]['size'];
            $this->tmp_name = $_FILES[$file]['tmp_name'];
            $this->error = $_FILES[$file]['error'];
            $this->file = $_FILES[$file];
        } else {
            $this->error = true;
            $this->message[] = "no file found";
        }

        $this->file_name = $this->name;
        $this->extension = strtolower(pathinfo($this->name, PATHINFO_EXTENSION));
        if (in_array($this->extension, EXTENSION_IMAGE)) {
            $this->type = "image";
        } elseif (in_array($this->extension, EXTENSION_AUDIO)) {
            $this->type = "audio";
        } elseif (in_array($this->extension, EXTENSION_VIDEO)) {
            $this->type = "video";
        } elseif (in_array($this->extension, EXTENSION_DOCUMENT)) {
            $this->type = "document";
        } elseif (in_array($this->extension, EXTENSION_ARCHIVE)) {
            $this->type = "archive";
        } else {
            $this->type = "text";
        }
    }

    public function control($param = ["size" => 0, "extension" => []]) {
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

    public static function init($file) {
        $dfile = new Dfile($file);
        return $dfile;
    }

    public function sanitize() {
        $this->file_name = $this->wd_remove_accents($this->name);
        return $this;
    }

    public function hashname() {
        $datetime = new DateTime();
        $name = sha1($this->name . $datetime->getTimestamp());
        $this->file_name = $name . "." . $this->extension;

        return $this;
    }

    public function rename($newname, $sanitize = false) {
        if ($sanitize) {
            $this->file_name = $this->wd_remove_accents($newname);
        } else {
            $this->file_name = $newname;
        }
    }

    public function move() {
        return $this->moveto($this->uploaddir);
    }

    public function moveto($path, $absolut = false) {

        if ($this->error) {
//            die(Bugmanager::getError(__CLASS__, __METHOD__, __LINE__, $this->message, $this->file));
            return array("success" => false, 'err' => implode(" || ", $this->message));
        }
        if (isset($this->error) && UPLOAD_ERR_OK !== $this->error) {
            return array("success" => false, 'err' => 'Une erreur interne a empêché l\'uplaod de l\'image');
        }

        if (!$absolut)
            $path = $this->chdirectory($this->filepath($path));

        if (move_uploaded_file($this->tmp_name, $path . $this->file_name)) {

            return array("success" => true,
                "file" => [
                    'name' => $this->name,
                    'size' => $this->size,
                    'type' => $this->type,
                    'path' => $path,
                    'hashname' => $this->file_name,
                    'extension' => $this->extension,
                ],
                'detail' => 'upload success');
        } else {
            return array("success" => false, 'err' => 'Problème lors de l\'uploadage !');
        }
    }

    public static function show($image, $path = '', $default = 'default/no_image.jpg') {

        $up = new UploadFile();

        $path = $up->filepath($path);

        if ($image && file_exists(UPLOAD_DIR . $path . $image))
            $image = SRC_FILE . $path . $image;
//            elseif($image && file_exists($path.$image))
//                    $image = $path.$image;
        else
            $image = asset($default);

        return $image;
    }

    
    /**
     * delete the file named $image
     * 
     * @param type $name_file the name of the file you want to delete
     * @return boolean true if file delete an array if the file doesn't exist
     */
    public static function deleteFile($name_file, $path = '', $absolute = false) {

        $up = new UploadFile();

        if ($absolute) {
            $path2 = $path;
        } else {
            $path2 = $up->chdirectory($up->filepath($path));
        }


        if ($name_file != '' && file_exists($path2 . $name_file)) {
            unlink($path2 . $name_file);
            return array('success' => true);
        } else {
            return array('success' => false, 'err' => 'ce fichier n\'existe pas!', "file" => $path2 . $name_file);
        }
    }

    public function deleteDir($dir) {
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
