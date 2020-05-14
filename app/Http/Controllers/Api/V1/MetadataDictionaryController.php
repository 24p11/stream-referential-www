<?php


namespace App\Http\Controllers\Api\V1;


use App\Model\MetadataDictionary;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class MetadataDictionaryController extends BaseApiV1Controller
{
    /**
     * @OA\Get(
     *   path="/metadata_dictionary",
     *   tags={"Metadata dictionary"},
     *   summary="List of all metadata dictionary",
     *   @OA\Parameter(
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
     *   @OA\Response(response=200, description="successful operation")
     * )
     *
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return array|AnonymousResourceCollection
     */
    public function dictionaries(Request $request)
    {
        $dateValidity = $request->get('date_validity');
        if ($dateValidity) {
            return MetadataDictionary::whereRaw('? BETWEEN start_date AND IFNULL(end_date, CURDATE() + INTERVAL 1000 YEAR)', $dateValidity)->get();
        } else {
            return MetadataDictionary::all();
        }
    }

    /**
     * @OA\Get(
     *   path="/metadata_dictionary/{referential}",
     *   tags={"Metadata dictionary"},
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
     *   summary="Return metadata dictionary",
     *   @OA\Response(response=200, description="successful operation")
     * )
     *
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param $referential
     * @return array|AnonymousResourceCollection
     */
    public function dictionary(Request $request, $referential)
    {
        $dateValidity = $request->get('date_validity');
        if ($dateValidity) {
            return MetadataDictionary::where('vocabulary_id', $referential)
                ->whereRaw('? BETWEEN start_date AND IFNULL(end_date, CURDATE() + INTERVAL 1000 YEAR)', $dateValidity)
                ->get();
        } else {
            return MetadataDictionary::where('vocabulary_id', $referential)->get();
        }
    }

    /**
     * @OA\Put(
     *   path="/metadata_dictionary/{metadata_dictionary}",
     *   tags={"Metadata dictionary"},
     *   @OA\Parameter(
     *         name="metadata_dictionary",
     *         in="path",
     *         description="Metadata dictionay id",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         ),
     *         style="form"
     *     ),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="id",
     *                     type="int"
     *                 ),
     *                @OA\Property(
     *                     property="description",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="start_date",
     *                     type="date"
     *                 ),
     *                 @OA\Property(
     *                     property="end_date",
     *                     type="date"
     *                 ),
     *                 example={ "description": "description", "type": "type", "start_date": "2020-03-01", "end_date": "2020-02-02" },
     *             )
     *         )
     *     ),
     *   summary="Return metadata dictionary",
     *   @OA\Response(response=200, description="successful operation")
     * )
     * @param Request $request
     * @param MetadataDictionary $metadataDictionary
     * @return JsonResponse
     */
    public function update(Request $request, MetadataDictionary $metadataDictionary)
    {
        $metadataDictionary->update($request->all());

        return response()->json($metadataDictionary, 200);
    }
}
