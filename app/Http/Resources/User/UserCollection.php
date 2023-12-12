<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\User\UserResource;

class UserCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return $this->collection->transform(function($user){
            return new UserResource($user);
        });
    }
}
