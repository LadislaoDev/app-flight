<?php

namespace App\Http\Resources\Type;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\Type\TypeResource;

class TypeCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return $this->collection->transform(function($type){
            return new TypeResource($type);
        });
    }
}
