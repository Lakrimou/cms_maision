<?php
/**
 * Created by PhpStorm.
 * User: POSTE 7
 * Date: 22/05/2017
 * Time: 10:36
 */

namespace ModuleBundle;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploader
{


    public $targetDir;

    public function __construct($targetDir) {
        $this->targetDir = $targetDir;
    }

    public function upload(UploadedFile $file) {
        $fileName = md5(uniqid()) . '.' . $file->guessExtension();

        $file->move($this->targetDir, $fileName);

        return $fileName;
    }



}