<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Vocabulary;
use Illuminate\Http\Request;

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

    public function details($referential)
    {
        return view('admin.referential.details');
    }
}
