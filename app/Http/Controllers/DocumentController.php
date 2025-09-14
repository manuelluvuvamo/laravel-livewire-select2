<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    public function index()
    {
        return view('document.index');
    }

    public function create()
    {
        return view('document.create');
    }

    public function edit(Document $document)
    {
        return view('document.edit', compact('document'));
    }
}
