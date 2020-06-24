<?php


namespace App\Http\Controllers\Api\V1;


use App\Model\ListDictionary;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ListDictionaryController extends BaseApiV1Controller
{
    /**
     * @OA\Get(
     *   path="/list_dictionary",
     *   tags={"List dictionary"},
     *   summary="List of all list dictionary",
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
            return ListDictionary::whereRaw('? BETWEEN start_date AND IFNULL(end_date, CURDATE() + INTERVAL 1000 YEAR)', $dateValidity)->get();
        } else {
            return ListDictionary::all();
        }
    }

    /**
     * @OA\Get(
     *   path="/list_dictionary/{referential}",
     *   tags={"List dictionary"},
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
     *   summary="Return list dictionary",
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
            return ListDictionary::where('vocabulary_id', $referential)
                ->whereRaw('? BETWEEN start_date AND IFNULL(end_date, CURDATE() + INTERVAL 1000 YEAR)', $dateValidity)
                ->get();
        } else {
            return ListDictionary::where('vocabulary_id', $referential)->get();
        }
    }

    /**
     * @OA\Put(
     *   path="/list_dictionary/{list_dictionary}",
     *   tags={"List dictionary"},
     *   @OA\Parameter(
     *         name="list_dictionary",
     *         in="path",
     *         description="List dictionay id",
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
     *                 example={ "description": "description", "start_date": "2020-03-01", "end_date": "2020-02-02" },
     *             )
     *         )
     *     ),
     *   summary="Return list dictionary",
     *   @OA\Response(response=200, description="successful operation")
     * )
     * @param Request $request
     * @param ListDictionary $listDictionary
     * @return JsonResponse
     */
    public function update(Request $request, ListDictionary $listDictionary)
    {
        $listDictionary->update($request->all());

        return response()->json($listDictionary, 200);
    }
}
