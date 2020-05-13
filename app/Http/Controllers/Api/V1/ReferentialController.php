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
    private $request;
    private $referential;

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
     *         description="CIM10, CCAM, GHM, DMI...",
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
     *         name="date_validity",
     *         in="query",
     *         description="YYYY-MM-DD if provided will check this date is between start_date and end_date interval",
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
        $this->request = $request;
        $this->referential = $referential;

        $search = $request->get('search');
        if ($search) {
            $searching = $this->fullTextSearchService->prepareSearchingWords($search);
            $concepts = $this->concepts($searching)
                ->take(100)
                ->get();
            return ConceptResource::collection($concepts);
        } else {
            return [];
        }
    }

    private function concepts($searching): Builder
    {
        $query = Concept::with(['metadata' => $this->metadataBetween()])
            ->where('vocabulary_id', $this->referential)
            ->whereRaw("MATCH (concept_code, concept_name) AGAINST (? IN BOOLEAN MODE)", $searching)
            ->orderBy('score', 'desc');

        $this->dateCondition($query);

        return $query;
    }

    private function metadataBetween(): \Closure
    {
        return function ($query) {
            $this->dateCondition($query);
        };
    }

    private function dateCondition($query)
    {
        $dateValidity = $this->request->get('date_validity');
        if ($dateValidity) {
            $query->whereRaw('? BETWEEN start_date AND IFNULL(end_date, CURDATE() + INTERVAL 1000 YEAR)', $dateValidity);
        } else {
            $query;
        }
    }
}
