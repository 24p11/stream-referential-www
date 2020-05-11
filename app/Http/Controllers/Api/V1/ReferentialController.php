<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\Concept as ConceptResource;
use App\Model\Concept;
use App\Service\FullTextSearchService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ReferentialController extends BaseApiV1Controller
{
    private $fullTextSearchService;

    public function __construct(FullTextSearchService $fullTextSearchService)
    {
        $this->fullTextSearchService = $fullTextSearchService;
    }

    /**
     * @OA\Get(
     *   path="/referential/{referential}",
     *   tags={"Referential"},
     *   @OA\Parameter(
     *         name="referential",
     *         in="path",
     *         description="CIM10, CCAM...",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         ),
     *         style="form"
     *     ),
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         description="search term",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         ),
     *         style="form"
     *     ),
     *     @OA\Parameter(
     *         name="start_date",
     *         in="query",
     *         description="start date YYYY-MM-DD",
     *         required=false,
     *         @OA\Schema(
     *          type="string",
     *          format="date-time",
     *         ),
     *         style="form"
     *     ),
     *     @OA\Parameter(
     *         name="end_date",
     *         in="query",
     *         description="end date YYYY-MM-DD",
     *         required=false,
     *         @OA\Schema(
     *          type="string",
     *          format="date-time",
     *         ),
     *         style="form"
     *     ),
     *   summary="Allow to perform search on concept table in concept_code and concept_name columns",
     *   @OA\Response(response=200, description="successful operation")
     * )
     *
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param $referential
     * @return array|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
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
            ->where('start_date', '>=', $startDate ?? $currentDate)
            ->whereRaw('IFNULL(end_date, CURDATE()) <= ?', $endDate ?? $currentDate);
    }
}
