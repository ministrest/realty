<?php
namespace goodman\models;

class Images extends Model
{
    public $pk = "id_images";
    public $table = "images";

    function img_resize($src, $dest, $width = 110, $height = 110, $rgb = 0xFFFFFF, $quality = 90)
    {
        if (!file_exists($src)) {
            return false;
        }
        $size = getimagesize($src);
        if ($size === false) {
            return false;
        }
        $format = strtolower(substr($size['mime'], strpos($size['mime'], '/') + 1));
        $icfunc = 'imagecreatefrom' . $format;
        if (!function_exists($icfunc)) {
            return false;
        }
        $x_ratio = $width / $size[0];
        $y_ratio = $height / $size[1];
        if ($height == 0) {
            $y_ratio = $x_ratio;
            $height = $y_ratio * $size[1];
        } elseif ($width == 0) {
            $x_ratio = $y_ratio;
            $width = $x_ratio * $size[0];
        }
        $ratio = min($x_ratio, $y_ratio);
        $use_x_ratio = ($x_ratio == $ratio);
        $new_width = $use_x_ratio ? $width : floor($size[0] * $ratio);
        $new_height = !$use_x_ratio ? $height : floor($size[1] * $ratio);
        $new_left = $use_x_ratio ? 0 : floor(($width - $new_width) / 2);
        $new_top = !$use_x_ratio ? 0 : floor(($height - $new_height) / 2);
        $isrc = $icfunc($src);
        $idest = imagecreatetruecolor($width, $height);
        imagefill($idest, 0, 0, $rgb);
        imagecopyresampled($idest, $isrc, $new_left, $new_top, 0, 0, $new_width, $new_height, $size[0], $size[1]);
        imagejpeg($idest, $dest, $quality);
        imagedestroy($isrc);
        imagedestroy($idest);
        return true;
    }

    public function uploadImage($file)
    {
        $blacklist = array(".php", ".phtml", ".php3", ".php4");
        foreach ($blacklist as $item) {
            if (preg_match("/$item\$/i", $file['name'])) { // not allow uploading PHP files
                return false;
            }
        }
        $imageinfo = getimagesize($file['tmp_name']);
        if ($imageinfo['mime'] != 'image/gif' && $imageinfo['mime'] != 'image/jpeg' && $imageinfo['mime'] != 'image/png') { //only accept GIF and JPEG images
            return false;
        }
        $uploaddir = ROOTDIR . '/inc/i/avatar/';
        $uploadfile = $uploaddir . basename($file['name']);
        if ($this->img_resize($file['tmp_name'],$uploadfile,300,300)) return true;
        return false;
    }

    public function upload($file)
    {
        if (!empty($file['tmp_name']) && !$file['error'] && $file['size'] > 0) {
            // Проверяем чтобы файл был нужного типа
            $extension = $file['type'];
            $accentExtension = array('image/png', 'image/jpeg', 'image/gif');
            if (!in_array($extension, $accentExtension)) {
                return 'not image';
            }
            // Создаем новое имя файла
            $filenameNew = md5(time()) . '.' . pathinfo($file['name'], PATHINFO_EXTENSION);

            // перемещаем его в нужную папку
            $filePath = ROOTDIR . '/uploads/objects/' . $filenameNew;
            move_uploaded_file($file['tmp_name'], $filePath);

            // Возвращаем имя файла
            return $filenameNew;
        } else {
            return 'error';
        }
    }

    public function uploadphoto($file)
    {
        if (!empty($file['tmp_name']) && !$file['error'] && $file['size'] > 0) {
            // Проверяем чтобы файл был нужного типа
            $extension = $file['type'];
            $accentExtension = array('image/png', 'image/jpeg', 'image/gif');
            if (!in_array($extension, $accentExtension)) {
                return 'not image';
            }
            // Создаем новое имя файла
            $filenameNew = md5(time()) . '.' . pathinfo($file['name'], PATHINFO_EXTENSION);

            // перемещаем его в нужную папку
            $filePath = ROOTDIR . '/uploads/objects/' . $filenameNew;
            move_uploaded_file($file['tmp_name'], $filePath);

            // делаем превьюшку
            $image = new \Image($filePath); // relative to UI search path
            $image = $image->resize(556, 319, false);
            $image->crop(556, 319, ($image->width - 556) / 2, ($image->height - 319) / 2)
                ->save(ROOTDIR . '/uploads/objects/thumbs/' . $filenameNew);

            // Возвращаем имя файла
            return $filenameNew;
        } else {
            return 'error';
        }
    }

    public function delimg($id)
    {

        return true;
    }
}