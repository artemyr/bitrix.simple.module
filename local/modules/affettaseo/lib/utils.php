<?php

namespace Bitrix\Affettaseo;

use Cutil;
use CFile;
use COption;

class Utils {
    public static function custom_resize_image($file_id, $arSize, $name, $resizeType = BX_RESIZE_IMAGE_PROPORTIONAL)
    {
        /**
         * resize and rename image for seo
         * compiled images store in custom folder
         * and need more dick space.
         * if you need maro space
         * you can off or remove module
         * and remove image folder
         */
        $active = COption::GetOptionString("affettaseo", "MODULE_ACTIVE") == 'Y';
        if(!$active){
            return ['src' => CFile::GetPath($file_id)];
        }

        if($resizeType == BX_RESIZE_IMAGE_EXACT) $resType = '1';
        elseif($resizeType == BX_RESIZE_IMAGE_PROPORTIONAL) $resType = '2';
        elseif($resizeType == BX_RESIZE_IMAGE_PROPORTIONAL_ALT) $resType = '3';
        else $resType = '4';

        $arParams = array("replace_space" => "_", "replace_other" => "_");
        $trans = Cutil::translit($name, "ru", $arParams);

        $new_file_path = "/upload/my_resize_cache/" . $file_id . $arSize['width'] . $arSize['height'] . $resType . "/" . $trans . ".jpeg";

        $sourceFile = $_SERVER['DOCUMENT_ROOT'] . CFile::GetPath($file_id);

        $arResult['src'] = $new_file_path;
        $arResult['height'] = $arSize['height'];
        $arResult['width'] = $arSize['width'];
        $arResult['size'] = $arSize['width'] * $arSize['height'];

        /**
         * image exists - return it
         */
        if(file_exists($_SERVER['DOCUMENT_ROOT'] . $new_file_path)) return $arResult;



        /**
         * image don't exists - compil it
         */
        if(!is_dir($_SERVER['DOCUMENT_ROOT'] ."/upload/my_resize_cache")) mkdir($_SERVER['DOCUMENT_ROOT'] ."/upload/my_resize_cache");

        $new_file_path = $_SERVER['DOCUMENT_ROOT'] . $new_file_path;

        $rif = CFile::ResizeImageFile( // уменьшение картинки для превью
            $sourceFile,
            $new_file_path,
            $arSize,
            $resizeType,
            $arWaterMark = array(),
            $jpgQuality = false,
            $arFilters  = false
        );

        if(!$rif){
            return ['src' => CFile::GetPath($file_id)];
        }

        return $arResult;
    }
}