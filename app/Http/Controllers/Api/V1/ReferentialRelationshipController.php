<?php


namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\ConceptRelationship;
use App\Model\Concept;
use App\Util\KeyUtils;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ReferentialRelationshipController extends BaseApiV1Controller
{
    private $request;
    private $referential;

    /**
     * @OA\Get(
     *   path="/referential/relationship/{referential}",
     *   tags={"Referential"},
     *     @OA\Parameter(
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
     *         name="referential_code",
     *         in="query",
     *         description="referential code",
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
     *   summary="Search concept having a related concept association",
     *   @OA\Response(response=200, description="successful operation")
     * )
     *
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param $referential
     * @return array|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function referentialRelationship(Request $request, $referential)
    {
        $this->request = $request;
        $this->referential = $referential;

        $referentialCode = $this->request->get('referential_code');
        if ($referentialCode) {
            $concept = $this->concepts($referentialCode)->get();
            return ConceptRelationship::collection($concept);
        } else {
            return [];
        }
    }

    private function concepts($referentialCode): Builder
    {
        $query = Concept::with(['conceptRelationships', 'metadata' => $this->metadataBetween()])
            ->where('vocabulary_id', $this->referential)
            ->where('vocabulary_id_concept_code', KeyUtils::key($this->referential, $referentialCode));

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
