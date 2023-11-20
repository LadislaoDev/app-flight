<?php

namespace App\Http\Controllers;

use App\Models\Type;
use Illuminate\Http\Request;
use App\Http\Resources\Type\TypeCollection;

class TypeController extends Controller
{
    private $type;

    public function __construct(Type $type)
    {
        $this->type = $type;
    }

    public function index()
    {
        $types = $this->type->all();
        return new TypeCollection($types);
    }
}
