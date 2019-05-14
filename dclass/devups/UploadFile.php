<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UploadFile
 *
 * @author yuri coco
 *
 */
class UploadFile extends stdClass {

    /**
     *
     * @persist(false)
     */
    //protected $path;

    public function __construct() {
        //$this->path = [];
    }

    public static function __FILE_SANITIZE($entity, $file) {

        $uploadmethod = 'upload' . ucfirst($file);

        if (!method_exists($entity, $uploadmethod)) {
            var_dump(" You may create method " . $uploadmethod . " as specify in the doc. ");
            die;
        }

        $entityname = strtolower(get_class($entity));

        if (isset($_FILES[$entityname . '_form']) and $_FILES[$entityname . '_form']['error'][$file] == 0) {

            $_files = [
                'name' => $_FILES[$entityname . '_form']['name'][$file],
                'type' => $_FILES[$entityname . '_form']['type'][$file],
                'tmp_name' => $_FILES[$entityname . '_form']['tmp_name'][$file],
                'error' => $_FILES[$entityname . '_form']['error'][$file],
                'size' => $_FILES[$entityname . '_form']['size'][$file],
            ];

            $result = call_user_func(array($entity, $uploadmethod), $_files);
        }

        if (isset($result)) {

            if (!$result['success']) {
//                var_dump($_files); 
//                die;
                return false;
            }
            return true;
        } else {
            return false;
//            die( var_dump( ['success' => false, 'err' => "not file found!" ] ) );
        }
    }

    public function wd_remove_accents($str, $charset = 'utf-8') {
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
    public function filepath($str, $charset = 'utf-8') {
        $str = htmlentities($str, ENT_NOQUOTES, $charset);

        $str = $this->wd_remove_accents($str);
        return $str . '/';
    }

    public function chdirectory($filepath) {
//	if(file_exists(UPLOAD_RESSOURCE2.$filepath))
//            return UPLOAD_RESSOURCE2.$filepath;
        if (!file_exists(UPLOAD_DIR . $filepath))
            mkdir(UPLOAD_DIR . $filepath, 0777, true);

        return UPLOAD_DIR . $filepath;
    }

    public static function music($path = 'uploads/', $music = null, $nom = null) {
        //$this->path = $path;
        $up = new UploadFile();

        $path2 = $up->chdirectory($up->filepath($path));
        extract($music);
        if ($size <= 20097152) {
            $extension = pathinfo($name, PATHINFO_EXTENSION);
            // On verifie l'extension du fichier
            if (in_array(strtolower($extension), array('mp3', 'aac', 'wma', 'ogg', 'flac'))) {
                if (isset($error) && UPLOAD_ERR_OK === $error) {

                    if ($nom == "hash") {

                        $datetime = new DateTime();
                        $name = sha1($name . $datetime->getTimestamp());
                        $file_name = $name . '.' . $extension;
                    } elseif ($nom == '')
                        $file_name = $up->wd_remove_accents($name);
                    else
                        $file_name = $up->wd_remove_accents($name);

                    if (move_uploaded_file($tmp_name, $path2 . $file_name)) {

                        $message = array("success" => true,
                            "file" => [
                                'name' => $name,
                                'size' => $size,
                                'path' => $path2,
                                'hashname' => $file_name,
                                'extension' => $extension,
                            ],
                            'detail' => 'upload success');
                    } else {
                        $message = array("success" => false, 'err' => 'Problème lors de l\'upload !');
                    }
                } else {
                    $message = array("success" => false, 'err' => 'Une erreur interne a empêché l\'uplaod de l\'image');
                }
            } else {
                $message = array("success" => false, 'err' => 'L\'extension du fichier est incorrecte !');
            }
        } else {
            $message = array("success" => false, 'err' => 'Le fichier audio doit etre inferieur a 20 mega !');
        }

        return $message;
    }

    public static function video($path = 'uploads', $video = null, $nom = null) {
        //$this->path = $path;
        $up = new UploadFile();

        $path2 = $up->chdirectory($up->filepath($path));
        extract($video);
        if ($size <= 500097152) {
            $extension = pathinfo($name, PATHINFO_EXTENSION);
            // On verifie l'extension du fichier
            if (in_array(strtolower($extension), array('mp4', 'avi', 'mov', 'mkv', 'webm', 'ogg', 'crdownload'))) {
                if (isset($error) && UPLOAD_ERR_OK === $error) {
                    if ($nom == "hash") {

                        $datetime = new DateTime();
                        $name = sha1($name . $datetime->getTimestamp());
                        $file_name = $name . '.' . $extension;
                    } elseif ($nom == '')
                        $file_name = $up->wd_remove_accents($name);
                    else
                        $file_name = $up->wd_remove_accents($name);

                    if (move_uploaded_file($tmp_name, $path2 . $file_name)) {

                        $message = array("success" => true,
                            "file" => [
                                'name' => $name,
                                'size' => $size,
                                'path' => $path2,
                                'hashname' => $file_name,
                                'extension' => $extension,
                            ],
                            'detail' => 'upload success');
                    } else {
                        $message = array("success" => false, 'err' => 'Problème lors de l\'upload !');
                    }
                } else {
                    $message = array("success" => false, 'err' => 'Une erreur interne a empêché l\'uplaod de l\'image');
                }
            } else {
                $message = array("success" => false, 'err' => 'L\'extension du fichier est incorrecte !');
            }
        } else {
            $message = array("success" => false, 'err' => 'Le fichier video doit etre inferieur a 500 mega !');
        }

        return $message;
    }

    /**
     * 
     * @param \String $path
     * le chemin vers le fichier
     * 
     * @param \File $image
     * c'est le fichier image
     * 
     * @param \String $nom
     * le nom de l'image au cas où l'utilisateur ou alors le programmeur voudrait changer
     * nom de l'image uploadée
     * 
     * @param type $multiple
     * ce comporte comme un boolean pour spécifier si oui ou non on fait un uploadage d'un ou de
     * plusieurs images en même temps.
     * 
     * @param \Integer $nbimage
     * sert de compteur pour l'uploadage multiple. c'est un attribut hérité de la class UploadMultipleFile
     * il est réinitialisé lorsque toutes les images sont supprimées.
     * 
     * @param \Array $resize un tableau qui a la largeur et la hauter pour le redimensionnement
     * 
     * @param \Boolean $original true pour conserver l'image original 
     * 
     * @return \Array 
     */
    public static function image($path = 'uploads/', $image, $nom = null, $multiple = null, $nbimage = null, $resize = null, $original = false, $crop = null, $prefix = ["", "r_"]) {
        //$this->path = $path;
        $up = new UploadFile();

        $path2 = $up->chdirectory($up->filepath($path));

        if ($image != null and $multiple == null and $resize == null) {
            $retour = $up->image1($up->filepath($path), $path2, $image, false, $nom, $crop);
        } elseif ($image != null and $multiple == null and is_array($resize)) {
            $retour = $up->resizeimage($up->filepath($path), $path2, $image, $resize, $nom, $original, $crop, $prefix);
        }
        /* elseif($nom != null) */
        return $retour;
    }

    private function sanitizepath($path) {
        return str_replace("//", "/", $path);
    }

    public static function cropimage($img_src, $img_dst, $crop = ["x" => 0, "y" => 0, "width" => 270, "height" => 270], $quality = 80, $tocrop = true) {

        $uf = new UploadFile();

        $datetime = new DateTime();
        $hashname = sha1($datetime->getTimestamp());
        $img_dst = $uf->sanitizepath($img_dst);
//        $img_src = UPLOAD_DIR . $img_src;
        $img_src = UPLOAD_DIR . $uf->sanitizepath($img_src);

        if (!file_exists($img_src)) {
            return array("success" => false,
                'detail' => 'file not exits');
        }

        $extension = strtolower(pathinfo($img_src, PATHINFO_EXTENSION));
        $imagesize = getimagesize($img_src);

        $ratio_orig = $imagesize[0] / $imagesize[1];

        $largeur = $crop['width'];
        $hauteur = $crop['height'];

        if ($largeur / $hauteur > $ratio_orig) {
            $hauteur = $largeur / $ratio_orig;
        } else {//if ($hauteur/$largeur > $ratio_orig) 
            $largeur = $hauteur * $ratio_orig;
        }

        $NouvelleImage = imagecreatetruecolor($largeur, $hauteur) or die("Erreur");

        if (in_array(strtolower($extension), array('jpg', 'jpeg'))) {
            $image = imagecreatefromjpeg($img_src);
        } elseif (strtolower($extension) == 'png') {
            $image = imagecreatefrompng($img_src);
            imagealphablending($image, true);

            imagealphablending($NouvelleImage, false);
            imagesavealpha($NouvelleImage, true);
        } else {
            $image = imagecreatefromgif($img_src);
        }


//        $x = $hauteur/2;
        if (imagecopyresampled($NouvelleImage, $image, 0, 0, 0, 0, $largeur, $hauteur, $imagesize[0], $imagesize[1])) {

            if ($tocrop) {
                $imagecroped = imagecrop($NouvelleImage, $crop);
            } else {
                $imagecroped = $NouvelleImage;
            }

            if (in_array(strtolower($extension), array('jpg', 'jpeg'))) {
                $success = imagejpeg($imagecroped, UPLOAD_DIR . $img_dst, $quality);
            } elseif (strtolower($extension) == 'png') {
                $success = imagepng($imagecroped, UPLOAD_DIR . $img_dst);
            } else {
                $success = imagegif($imagecroped, UPLOAD_DIR . $img_dst);
            }

            if (!$success) {
                $message = array("success" => false,
                    'detail' => 'upload failed');
                return $message;
            } else {
                $message = array("success" => true,
                    "file" => [
                        'hashname' => $hashname,
                        'extension' => $extension,
                    ],
                    'detail' => 'upload success');
                return $message;
//            imagejpeg($NouvelleImage, UPLOAD_RESSOURCE.$scanpage->getPath()."c_".$scanpage->getPage(), 80);
            }
        }
    }

    public function base64_to_jpeg($base64_string, $output_file) {
        // open the output file for writing
//        $ifp = fopen( UPLOAD_RESSOURCE.$output_file, 'wb' ); 
        // split the string on commas
        // $data[ 0 ] == "data:image/png;base64"
        // $data[ 1 ] == <actual base64 string>
        $data = explode(',', $base64_string);

        // we could add validation here with ensuring count( $data ) > 1
//        fwrite( $ifp, base64_decode( $data[ 1 ] ) );
//        $im = imagecreatefromstring(base64_decode( $data[ 1 ] ));
//        (resize)
        $this->compress_image(base64_decode($data[1]), UPLOAD_DIR . $output_file, 80, null);

        // clean up the file resource
//        fclose( $ifp ); 

        return $output_file;
    }

    private function compress_image($source_url, $destination_url, $quality, $extension = 'jpg', $crop = null) {
        if ($extension == null) {
            $image = imagecreatefromstring($source_url);

            if (!imagejpeg($image, $destination_url, $quality))
                return false;
            else
                return true;
        }
        elseif (in_array($extension, array('jpg', 'jpeg'))) {

            $image = imagecreatefromjpeg($source_url);

            if (!imagejpeg($image, $destination_url, $quality))
                return false;
            else
                return true;
        }elseif ($extension == "gif") {
            $image = imagecreatefromgif($source_url);
            if (!imagegif($image, $destination_url, $quality))
                return false;
            else
                return true;
        }elseif ($extension == "png") {
            $imagesize = getimagesize($source_url);

            $thumb = imagecreatetruecolor($imagesize[0], $imagesize[1]);
            imagealphablending($thumb, false);
            imagesavealpha($thumb, true);

            $source = imagecreatefrompng($source_url);
            imagealphablending($source, true);

            imagecopyresampled($thumb, $source, 0, 0, 0, 0, $imagesize[0], $imagesize[1], $imagesize[0], $imagesize[1]);

            if (!imagepng($thumb, $destination_url, 8))
                return false;
            else
                return true;
        }
    }

    private function image1($path, $path2, $image, $multiple = FALSE, $own_name = '', $iterat = 0, $resize = [], $original = false) {

        $name = $image['name'];
        $size = $image['size'];
        $tmp_name = $image['tmp_name'];
        $error = $image['error'];

        if ($size <= 10097152) {
            $extension = pathinfo($name, PATHINFO_EXTENSION);
            // On verifie l'extension du fichier
            if (in_array(strtolower($extension), array('jpg', 'gif', 'png', 'jpeg'))) {
                if (isset($error) && UPLOAD_ERR_OK === $error) {

                    if ($own_name == '')
                        $file_name = $this->wd_remove_accents($name);
                    elseif ($own_name == "hash") {

                        $datetime = new DateTime();
                        $name = sha1($name . $datetime->getTimestamp());
                        $file_name = $name . '.' . $extension;
                    } else {
                        $file_name = $this->wd_remove_accents($own_name);
                    }

                    if ($this->compress_image($tmp_name, $path2 . $file_name, 100, $extension)) {

                        $message = array("success" => true,
                            "file" => [
                                'hashname' => $file_name,
                                'extension' => $extension,
                            ],
                            'detail' => 'upload success');
                    } else {
                        $message = array("success" => false, 'err' => 'Problème lors de l\'upload !');
                    }
                } else {
                    $message = array("success" => false, 'err' => 'Une erreur interne a empêché l\'uplaod de l\'image');
                }
            } else {
                $message = array("success" => false, 'err' => 'L\'extension du fichier est incorrecte !');
            }
        } else {
            $message = array("success" => false, 'err' => 'L\'image doit etre inferieur a 10 mega !');
        }

        return $message;
    }

    private function resizeimage($path, $path2, $image, $resize, $other_name = '', $original = false, $crop = null, $prefix = ["", "r_"]) {
        $nom = $image['name'];
        $tmp_name = $image['tmp_name'];
        $quality = 80;
        $qualitypng = 8;

        $extension = strtolower(pathinfo($image['name'], PATHINFO_EXTENSION));

        if ($image['size'] <= 10097152) {
            // On verifie l'extension du fichier
            if (in_array(strtolower($extension), array('jpg', 'gif', 'png', 'jpeg'))) {

                if ($other_name == "hash") {

                    $datetime = new DateTime();
                    $name = sha1($nom . $datetime->getTimestamp());
                    $file_name = $name . '.' . $extension;
                } elseif ($other_name != '')
                    $file_name = $this->wd_remove_accents($other_name);
                else
                    $file_name = $this->wd_remove_accents($nom);

                if (in_array($extension, array('jpg', 'jpeg'))) {
                    $image = imagecreatefromjpeg($tmp_name);
                } elseif ($extension == 'png') {
                    $image = imagecreatefrompng($tmp_name);
                } elseif ($extension == 'gif') {
                    $image = imagecreatefromgif($tmp_name);
                }

                $tailleImage = getimagesize($tmp_name);

                if ($original && $crop != null) {

//                                    $largeur = $crop[CROP_BOX_W];
//                                    $hauteur = $tailleImage[1];
                    $NouvelleImage2 = imagecreatetruecolor($crop[CROP_BOX_W], $crop[CROP_BOX_H]) or die("Erreur");


                    $ratio_orig = $tailleImage[0] / $tailleImage[1];
                    $ratio_origbloc = $crop[CROP_BOX_W] / $crop[CROP_BOX_H];

//                                    $ratio_orig = $ratio_orig * $ratio_origbloc;
//                                    if($tailleImage[1] > $crop[CROP_BOX_H])
//                                        $hauteur = $crop[CROP_BOX_H];
//                                    else
//                                        $hauteur = $tailleImage[1];
//                                    if($tailleImage[0] > $crop[CROP_BOX_W])
//                                        $largeur = $crop[CROP_BOX_W];
//                                    else
//                                        $largeur = $tailleImage[0];

                    $posrat_x = 0;
                    $posrat_y = 0;

//                                    if ((int)$crop[0]) {
                    $largeur = $tailleImage[1] * $ratio_orig;
//                                        $posrat_x = $crop[CROP_POS_X]*$ratio_orig;
//                                    } else{//if ($hauteur/$largeur > $ratio_orig) 
                    $hauteur = $largeur / $ratio_orig;
//                                        $posrat_y = $crop[CROP_POS_Y]/$ratio_orig;
//                                    }

                    if (imagecopyresampled($NouvelleImage2, $image, 0, 0, -$crop[0] - $posrat_x, -$crop[1] + $posrat_y, $largeur, $hauteur, $tailleImage[0], $tailleImage[1])) {
                        if (!imagejpeg($NouvelleImage2, $path2 . $prefix[1] . $file_name, 80)) {
                            return array("success" => false, 'err' => 'Le jpeg n\'a pas pu etre converti correctement');
                        }
                    }
//                                    var_dump($crop);
//                                    die;
                } elseif ($original) {
                    $this->compress_image($tmp_name, $path2 . $prefix[1] . $file_name, $quality, $extension);
                }

                $message = array("success" => true,
                    "file" => [
                        'name' => $image['name'],
                        'size' => $image['size'],
                        'path' => $path2,
                        'hashname' => $file_name,
                        'extension' => $extension,
                    ],
                    'detail' => 'upload success');

                if (is_array($resize[0])) {
                    foreach ($resize as $i => $array) {
                        $error = $this->saveimage($path2, $image, $file_name, $extension, $tailleImage, $array, $quality, $prefix, $i . "_", $tmp_name);
                    }
                } else
                    $error = $this->saveimage($path2, $image, $file_name, $extension, $tailleImage, $resize, $quality, $prefix, "", $tmp_name);

                if (!$error["success"])
                    $message = $error;
            } else {
                $retour = array("success" => false, 'err' => 'L\'extension du fichier est incorrecte !');
            }
        } else {
            $retour = array("success" => false, 'err' => 'L\'image doit etre inferieur a 10 mega !');
        }

        return $message;
    }

    private function saveimage($path2, $image, $file_name, $extension, $tailleImage, $resize, $quality, $prefix, $i = "", $tmp_name = "") {

        $largeur = $resize[0];
        if (isset($resize[1]))
            $hauteur = $resize[1];
        else
            $hauteur = $tailleImage[1];

        $ratio_orig = $tailleImage[0] / $tailleImage[1];

        if ($largeur / $hauteur > $ratio_orig) {
            $largeur = $hauteur * $ratio_orig;
        } else {//if ($hauteur/$largeur > $ratio_orig) 
            $hauteur = $largeur / $ratio_orig;
        }

        $NouvelleImage = imagecreatetruecolor($largeur, $hauteur) or die("Erreur");

        if (imagecopyresampled($NouvelleImage, $image, 0, 0, 0, 0, $largeur, $hauteur, $tailleImage[0], $tailleImage[1])) {
            imagedestroy($image);

            $message = array("success" => true, 'detail' => 'upload success');

            if (in_array($extension, array('jpg', 'jpeg'))) {
                if (!imagejpeg($NouvelleImage, $path2 . $prefix[0] . $i . $file_name, $quality)) {
                    $message = array("success" => false, 'err' => 'Le jpeg n\'a pas pu etre converti correctement');
                }
            } elseif ($extension == 'png') {
                if (!$this->compress_image($tmp_name, $path2 . $prefix[0] . $i . $file_name, $quality, $extension)) {
//						if(!imagepng($NouvelleImage, $path2.$file_name, $qualitypng, PNG_FILTER_UP)){
                    $message = array("success" => false, 'err' => 'Le png n\'a pas pu etre converti correctement');
                }
            } elseif ($extension == 'gif') {
                if (!$this->compress_image($tmp_name, $path2 . $prefix[0] . $i . $file_name, $quality, $extension)) {
//						if(!imagegif($NouvelleImage, $path2.$file_name, $quality)){
                    $message = array("success" => false, 'err' => 'Le gif n\'a pas pu etre converti correctement');
                }
            }
        } else {
            $message = array("success" => false, 'err' => 'L\'image doit etre inferieur a 1,5 mega !');
        }

        return $message;
    }

    public static function file($path, $fichier, $own_name = null, $multiple = FALSE, $iterat = 0) {

        $up = new UploadFile();

        $path2 = $up->chdirectory($up->filepath($path));

        $name = $fichier['name'];
        $size = $fichier['size'];
        $tmp_name = $fichier['tmp_name'];
        $error = $fichier['error'];

        if ($size <= 100097152) {
            $extension = pathinfo($name, PATHINFO_EXTENSION);
            // On verifie l'extension du fichier
            if (in_array(strtolower($extension), array('pdf', 'docx', 'doc', 'txt', 'ico', 'xls', 'xlsx', 'ppt', 'pptx', 'zip'))) {
                if (isset($error) && UPLOAD_ERR_OK === $error) {
                    if ($multiple) {
                        $alias = substr($name, 0, -(strlen($extension)));
                        if (strlen($alias) > 6) {
                            $alias = substr($alias, 0, -(strlen($alias) - 6));
                        }
                        $file_name = $up->wd_remove_accents($own_name . $alias . $iterat);
                    } elseif ($own_name == "hash") {

                        $datetime = new DateTime();
                        $name = sha1($name . $datetime->getTimestamp());
                        $file_name = $name;
                    } elseif ($own_name) {
                        $file_name = $up->wd_remove_accents($own_name);
                    } else {
                        $file_name = $up->wd_remove_accents($name);
                    }
                    if (move_uploaded_file($tmp_name, $path2 . $file_name)) {

                        $message = array("success" => true,
                            "file" => [
                                'name' => $image['name'],
                                'size' => $image['size'],
                                'path' => $path2,
                                'hashname' => $file_name,
                                'extension' => $extension,
                            ],
                            'detail' => 'upload success');
                    } else {
                        $message = array("success" => false, 'err' => 'Problème lors de l\'uploadage !');
                    }
                } else {
                    $message = array("success" => false, 'err' => 'Une erreur interne a empêché l\'uplaod du fichier');
                }
            } else {
                $message = array("success" => false, 'err' => 'L\'extension du fichier est incorrecte !');
            }
        } else {
            $message = array("success" => false, 'err' => 'Le fichier doit etre inferieur a 1,5 mega !');
        }

        return $message;
    }

    /**
     * delete the file named $image
     * 
     * @param type $name_file the name of the file you want to delete
     * @return boolean true if file delete an array if the file doesn't exist
     */
    public static function deleteFile($name_file, $path = '', $resize = false, $absolute = false) {

        $up = new UploadFile();

        if ($absolute) {
            $path2 = $path;
        } else {
            $path2 = $up->chdirectory($up->filepath($path));
        }

        if ($resize) {
            $file = $up->bothimages($path2, $name_file);
            //$retour = $this->deleteFile($name_file[0]);
            if (file_exists($file[1]) || file_exists($file[0])) {
                if ($file[0] != '' && file_exists($file[0]))
                    unlink($file[0]);
                if ($file[1] != '' && file_exists($file[1]))
                    unlink($file[1]);

                return array('success' => true);
            }else {
                return array('success' => false, 'err' => 'ce fichier n\'existe pas!');
            }
        } else {

            if ($name_file != '' && file_exists($path2 . $name_file)) {
                unlink($path2 . $name_file);
                return array('success' => true);
            } else {
                return array('success' => false, 'err' => 'ce fichier n\'existe pas!', "file" => $path2 . $name_file);
            }
        }
    }

    public static function show($image, $path = '', $default = 'no_image.jpg') {

        $up = new UploadFile();

        $path = $up->filepath($path);

        if ($image && file_exists(UPLOAD_DIR . $path . $image))
            $image = SRC_FILE . $path . $image;
//            elseif($image && file_exists($path.$image))
//                    $image = $path.$image;
        else
            $image = SRC_FILE . $default;

        return $image;
    }

    public function bothimages($path2, $file_name) {
        if ($file_name != '') {
//            $path2 = $this->chdirectory($this->filepath($path));
            $grand = "|" . $path2 . "g_" . $file_name;
            $petit = "p_" . $file_name; //
            $image = $path2 . $petit . $grand;
            return explode('|', $image);
        } else {
            return false;
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
