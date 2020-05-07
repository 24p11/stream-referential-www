<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Concept as ConceptResource;
use App\Model\Concept;
use Illuminate\Http\Request;
use Transliterator;

class ReferentialController extends Controller
{
    public function referential(Request $request, $referential)
    {
        $search = $request->get('search');
        $transliterator = Transliterator::create('NFD; [:Nonspacing Mark:] Remove; NFC;');
        $searchingWords = array_map(function ($word) use ($transliterator) {
            return $this->fullTextExpression($word, $transliterator);
        }, preg_split("/\s|, /", $search));
        $searchingWords = array_filter($searchingWords);
        $searching = implode(' ', $searchingWords);


        $concepts = Concept::where('vocabulary_id', $referential)
            ->whereRaw("MATCH (concept_code, concept_name) AGAINST (? IN BOOLEAN MODE)", $searching)
            ->orderBy('score', 'desc')
            ->take(250)
            ->get();

        return ConceptResource::collection($concepts);
    }

    private function fullTextExpression(string $word, Transliterator $transliterator): ?string
    {
        $word = addslashes(mb_strtolower($transliterator->transliterate($word)));
        if (false === empty($word)) {
            if (1 === preg_match('/[+\-~*]/', $word)) {
                return '+"' . $word . '" ';
            } else if (strpos($word, "'")) {
                return '+(' . $word . '*) ';
            } else {
                return '+' . $word . '* ';
            }
        }

        return null;
    }
}
