<?php

namespace MKulpa\PageFields\Models;

use October\Rain\Database\Model;
use October\Rain\Filesystem\Filesystem;
use System\Models\File;

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
}