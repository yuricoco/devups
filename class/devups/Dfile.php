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
        } elseif (is_string($file) && isset($_FILES[$file]) && $_FILES[$file]['error'] == 0) {
            $this->name = $_FILES[$file]['name'];
            $this->size = $_FILES[$file]['size'];
            $this->tmp_name = $_FILES[$file]['tmp_name'];
            $this->error = $_FILES[$file]['error'];
            $this->file = $_FILES[$file];
        } else {
            $this->error = true;
            $this->message[] = "no file found";
            return $this;
        }

        $this->file_name = $this->name;
        $this->imagesize = getimagesize($this->tmp_name);

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

    public function addresize($resize = [], $sufix = "-r", $uploaddir = "", $crop = true, $quality = 80) {
        $this->imagetoresize[] = ["resize" => $resize, "sufix" => $sufix, "uploaddir" => $uploaddir, "crop" => $crop, "quality" => $quality];

        return $this;
    }

    private function resizeimage($source_url, $param) {
        extract($param);

        $tocrop = false;
        if (!$uploaddir)
            $uploaddir = $this->uploaddir;

        $uploaddir = $this->chdirectory($this->filepath($uploaddir));
//        list($width, $height) = $this->imagesize;
        $imagesize = $this->imagesize;
        $largeur = $resize[0];
        if (isset($resize[1]))
            $hauteur = $resize[1];
        else
            $hauteur = $imagesize[1];

        $ratio_orig = $imagesize[0] / $imagesize[1];

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
            } elseif ($largeur > $hauteur) {
                $largeur = $hauteur * $ratio_orig;
                $centerx = $largeur / 2 - $resize[0] / 2;
            } else {
                $largeur = $hauteur * $ratio_orig;
                $hauteur = $largeur / $ratio_orig;
                $centerx = $largeur / 2 - $resize[0] / 2;
                $centery = $hauteur / 2 - $resize[1] / 2;
            }
            if ($centerx < 0)
                $centerx = -($centerx );

            if ($centery < 0)
                $centery = -($centery );

//            die(var_dump($resize, $hauteur, $imagesize[1], $resize[1], $centery));
        } else {

            if ($largeur / $hauteur > $ratio_orig) {
                $largeur = $hauteur * $ratio_orig;
            } else {
                $hauteur = $largeur / $ratio_orig;
            }
        }

        $filename = $uploaddir . str_replace("." . $this->extension, "", $this->file_name) . $sufix . "." . $this->extension;
        $newimage = imagecreatetruecolor($largeur, $hauteur) or die("Erreur");

        if (in_array($this->extension, array('jpg', 'jpeg'))) {
            $image = imagecreatefromjpeg($source_url);
            if (imagecopyresampled($newimage, $image, 0, 0, 0, 0, $largeur, $hauteur, $imagesize[0], $imagesize[1])) {

                if ($tocrop) {
                    $newimage = imagecrop($newimage, ["x" => $centerx, "y" => 0, "width" => $resize[0], "height" => $resize[1]]);
                }

                if (!imagejpeg($newimage, $filename, $quality)) {
                    $this->message[] = 'Le jpeg n\'a pas pu etre converti correctement';
                }
            }
        } elseif ($this->extension == 'png') {

            imagealphablending($newimage, false);
            imagesavealpha($newimage, true);

            $source = imagecreatefrompng($source_url);
            imagealphablending($source, true);

            imagecopyresampled($newimage, $source, 0, 0, 0, 0, $largeur, $hauteur, $imagesize[0], $imagesize[1]);

            if ($tocrop) {
                $newimage = imagecrop($newimage, ["x" => $centerx, "y" => $centery, "width" => $resize[0], "height" => $resize[1]]);
            }

            if (!imagepng($newimage, $filename, 8))
                $this->message[] = 'Le png n\'a pas pu etre converti correctement';
        } elseif ($this->extension == 'gif') {

            $image = imagecreatefromgif($source_url);
            if (!imagegif($image, $filename, $quality))
                $this->message[] = 'Le png n\'a pas pu etre converti correctement';
        }
    }

    public function rename($newname, $sanitize = false) {
        if ($sanitize) {
            $this->file_name = $this->wd_remove_accents($newname);
        } else {
            $this->file_name = $newname;
        }
        return $this;
    }

    public function move() {
        return $this->moveto($this->uploaddir);
    }

    private function validation() {

        if ($this->error) {
//            die(Bugmanager::getError(__CLASS__, __METHOD__, __LINE__, $this->message, $this->file));
            $this->error = array("success" => false, 'err' => implode(" || ", $this->message));
            return true;
        } elseif (isset($this->error) && UPLOAD_ERR_OK !== $this->error) {
            $this->error = array("success" => false, 'err' => 'Une erreur interne a empêché l\'uplaod de l\'image');
            return true;
        }
        return false;
    }

    public function moveto($path, $absolut = false) {

        if ($this->validation())
            return $this->error;

        $this->uploaddir = $path;

        if (!$absolut)
            $path = $this->chdirectory($this->filepath($path));

        if (move_uploaded_file($this->tmp_name, $path . $this->file_name)) {

            if (!empty($this->imagetoresize)) {

                foreach ($this->imagetoresize as $imagetoresize) {
                    $this->resizeimage($path . $this->file_name, $imagetoresize);
                }
                if ($this->validation())
                    return $this->error;
            }

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
