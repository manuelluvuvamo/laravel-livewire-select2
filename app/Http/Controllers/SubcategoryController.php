<?php

namespace App\Http\Controllers;

use App\Models\SubCategory;
use Illuminate\Http\Request;

class SubcategoryController extends Controller
{
     public function index()
    {
        return view('subcategory.index');
    }

    public function create()
    {
        return view('subcategory.create');
    }

    public function edit(SubCategory $subcategory)
    {
        return view('subcategory.edit', compact('subcategory'));
    }
}
