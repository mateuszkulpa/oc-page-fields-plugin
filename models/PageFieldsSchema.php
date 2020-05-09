<?php

namespace MKulpa\PageFields\Models;

use October\Rain\Database\Model;
use October\Rain\Filesystem\Filesystem;

class PageFieldsSchema extends Model
{
    public function loadSchema($schemaPath)
    {
        $fileSystem = new Filesystem();
        if ($fileSystem->exists($schemaPath))
            $this->content = $fileSystem->get($schemaPath);
        else
            $this->content = "";
        return $this;
    }

    public static function saveSchema($schemaPath, $content){
        $fileSystem = new Filesystem();
        $fileSystem->put($schemaPath, $content);
    }

    public static function deleteSchema($schemaPath) {
        $fileSystem = new Filesystem();
        $fileSystem->delete($schemaPath);
    }
}