<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use Illuminate\Http\Request;

class PublicResourceController extends Controller
{
    public function index()
    {
        $resources = Resource::with('category')
            ->where('status', 'available')
            ->get();
            
        return view('resources.public-index', compact('resources'));
    }

    public function show(Resource $resource)
    {
        return view('resources.public-show', compact('resource'));
    }
}
