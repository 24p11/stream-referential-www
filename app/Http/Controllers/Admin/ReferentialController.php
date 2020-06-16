<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Vocabulary;
use Illuminate\Http\Request;

class ReferentialController extends Controller
{
    public function list()
    {
        return view('admin.referential.list', ['vocabularies' => Vocabulary::all()]);
    }

    public function manage($referential)
    {
        return view('admin.referential.manage');
    }

    public function edit(Request $request, $referential)
    {
        $vocabulary = Vocabulary::find($referential);
        if ($request->isMethod('put')) {
            $vocabulary->description = $request->input('description');
            $vocabulary->save();

            return redirect()->route('admin.list', $referential);
        }

        return view('admin.referential.edit', [
            'vocabulary' => $vocabulary
        ]);
    }

    public function metadataDictionary()
    {
        return view('admin.referential.metadata_dictionary');
    }

    public function listDictionary()
    {
        return view('admin.referential.list_dictionary');
    }

    public function details($referential)
    {
        return view('admin.referential.details');
    }
}
