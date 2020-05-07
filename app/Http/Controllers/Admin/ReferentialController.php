<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Vocabulary;

class ReferentialController extends Controller
{
    public function list()
    {
        // Vocabulary::all()->dump();
        return view('admin.referential.list', ['vocabularies' => Vocabulary::all()]);
    }

    public function manage($referential)
    {
        return view('admin.referential.manage');
    }

    public function edit($referential)
    {
        return view('admin.referential.edit');
    }

    public function details($referential)
    {
        return view('admin.referential.details');
    }
}
