<?php

namespace Blog\Traits;

trait ResourceReference {

    public function getRefAttribute() {
        return [
            '_self' => route($this->table . '::get', ['id' => $this->attributes[$this->primaryKey]]),
        ];
    }

}