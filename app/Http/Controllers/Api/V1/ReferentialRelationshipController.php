<?php


namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\ConceptRelationship;
use App\Model\Concept;
use App\Util\KeyUtils;
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
     *         description="referential the first referential",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         ),
     *         style="form"
     *     ),
     *     @OA\Parameter(
     *         name="related_referential",
     *         in="query",
     *         description="related_referential the second referential",
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

        $referentialCode = $request->get('referential_code');
        if ($referentialCode) {
            $concept = Concept::with('conceptRelationships')
                ->where('vocabulary_id', $referential)
                ->where('vocabulary_id_concept_code', KeyUtils::key($referential, $referentialCode))
                ->get();
            return ConceptRelationship::collection($concept);
        } else {
            return [];
        }
    }
}
