<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Concept as ConceptResource;
use App\Model\Concept;
use App\Service\FullTextSearchService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ReferentialController extends Controller
{
    private $fullTextSearchService;

    public function __construct(FullTextSearchService $fullTextSearchService)
    {
        $this->fullTextSearchService = $fullTextSearchService;
    }

    public function referential(Request $request, $referential)
    {
        $search = $request->get('search');
        if ($search) {
            $searching = $this->fullTextSearchService->prepareSearchingWords($search);
            $concepts = $this->concepts($referential, $searching, $request)
                ->take(100)
                ->get();
            return ConceptResource::collection($concepts);
        } else {
            return [];
        }
    }

    private function concepts($referential, $searching, Request $request): Builder
    {
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');

        $query = Concept::with(['metadata' => $this->metadataBetween($startDate, $endDate)])
            ->where('vocabulary_id', $referential)
            ->whereRaw("MATCH (concept_code, concept_name) AGAINST (? IN BOOLEAN MODE)", $searching)
            ->orderBy('score', 'desc');

        $this->dateCondition($query, $startDate, $endDate);

        return $query;
    }

    private function metadataBetween($startDate, $endDate): \Closure
    {
        return function ($query) use ($startDate, $endDate) {
            return $this->dateCondition($query, $startDate, $endDate);
        };
    }

    private function dateCondition($query, $startDate, $endDate)
    {
        $currentDate = date('Y-m-d');
        return $query
            ->where('start_date', '<=', $startDate ?? $currentDate)
            ->whereRaw('IFNULL(end_date, CURDATE()) >= ?', $endDate ?? $currentDate);
    }
}
