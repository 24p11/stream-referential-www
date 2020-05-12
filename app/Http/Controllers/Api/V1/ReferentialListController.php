<?php


namespace App\Http\Controllers\Api\V1;


use App\Http\Resources\Concept as ConceptResource;
use App\Model\Concept;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ReferentialListController extends BaseApiV1Controller
{
    private $request;
    private $referential;

    /**
     * @OA\Get(
     *   path="/referential/list/{referential}",
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
     *         name="name",
     *         in="query",
     *         description="name",
     *         required=false,
     *         @OA\Schema(
     *             type="string"
     *         ),
     *         style="form"
     *     ),
     *     @OA\Parameter(
     *         name="value",
     *         in="query",
     *         description="value",
     *         required=false,
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
     *   summary="Allow to perform search on metadata table in name and value columns",
     *   @OA\Response(response=200, description="successful operation")
     * )
     *
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param $referential
     * @return array|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request, $referential)
    {
        $this->request = $request;
        $this->referential = $referential;

        $concepts = $this->concept()
            ->take(5000)
            ->get();


        return collect(ConceptResource::collection($concepts))
            ->unique('id')
            ->values()
            ->all();
    }

    private function concept(): Builder
    {
        $query = Concept::with(['metadata' => $this->metadata()])
            ->join('metadata', 'concept.vocabulary_id_concept_code', '=', 'metadata.concept_id')
            ->select(['*', 'concept.id as id'])
            ->where('vocabulary_id', $this->referential)
            ->orderBy('score', 'desc');

        $this->whereMetadata($query);
        $this->dateCondition($query);

        return $query;
    }

    private function metadata(): \Closure
    {
        return function ($query) {
            $this->whereMetadata($query);
            $this->dateCondition($query);
        };
    }

    private function whereMetadata($query)
    {
        $name = $this->request->get('name');
        $value = $this->request->get('value');

        if ($name) {
            $query->where('name', $name);
        }
        if ($value) {
            $query->where('value', $value);
        }

        if ($name || $value) {
            $query->where('concept_id', 'like', "{$this->referential}%");
        } else {
            $query->where('metadata.id', false);
        }
    }

    private function dateCondition($query, $table = 'metadata')
    {
        $dateValidity = $this->request->get('date_validity');
        if ($dateValidity) {
            $query->whereRaw("? BETWEEN $table.start_date AND IFNULL($table.end_date, CURDATE() + INTERVAL 1000 YEAR)", $dateValidity);
        } else {
            $query;
        }
    }
}
