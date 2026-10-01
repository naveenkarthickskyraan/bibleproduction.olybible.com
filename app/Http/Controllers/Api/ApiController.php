<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BaseVerse;
use App\Models\Dictionary\DictionaryInfo;
use App\Models\Dictionary\AppInfo;
use App\Models\Dictionary\TemplateInfo;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

class ApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function check(Request $request)
    {
        $key = $request->_key;
        if($key == 'ijklmn')
        {
            $value = 'poyVeWVAWoGXuKZxeCgQYlaYdOvUxCoQKczaj36T';
            return view('admin.api.api_route_list')->with('key', $value);
        }
        abort(404);
    }

    // public function get_dictionary_words_api(Request $request)
    // {
    //     try {
    //         // Validation rules
    //         $validator = Validator::make($request->all(), [
    //             'app_id' => 'required',
    //             'book_num'       => 'required',
    //             'chapter_num'    => 'required',
    //         ]);

    //         // If validation fails, return error response
    //         if ($validator->fails()) {
    //             return response()->json([
    //                 'result'  => '0',
    //                 'data'    => [],
    //                 'message' => $validator->errors()->first()
    //             ]);
    //         }

    //         // Fetch validated data
    //         $app_id = $request->input('app_id', null);
    //         $book_num = $request->input('book_num');
    //         $chapter_num = $request->input('chapter_num');
    //         $app_version_id = (int) "";
    //         if($app_id){
    //             $AppInfo = AppInfo::whereId($app_id)->first();
    //             if($AppInfo != null || !empty($$AppInfo)){
    //                 $getTemplateId = AppInfo::whereId($app_id)->first()->temp_id;
    //                 $TemplateInfo = TemplateInfo::whereId($getTemplateId)->first() ?? "";
    //                 $app_version_id = $TemplateInfo->version_id ?? "";
    //             }else{
    //                 return response()->json([
    //                     'result' => '0',
    //                     'data' => $resArr ?? [],
    //                     'message' => 'No data found'
    //                 ]);
    //             }
    //         } else {
    //             return response()->json([
    //                 'result' => '0',
    //                 'data' => $resArr ?? [],
    //                 'message' => 'No data found'
    //             ]);
    //         }
            
    //         // Example fetch logic (adjust as per your actual requirement)
    //         $words = BaseVerse::forVersion($app_version_id)
    //             ->whereDeletedAt(0)
    //             ->where('book_num', $book_num)
    //             ->where('chapter_num', $chapter_num)
    //             ->get('word_ids')->pluck('word_ids')->toArray();

    //         // Process the word_ids array
    //         $finalWordIds = [];

    //         foreach ($words as $wordString) {
    //             if (!empty($wordString)) {
    //                 $ids = explode(',', $wordString); // split by comma
    //                 $finalWordIds = array_merge($finalWordIds, $ids); // merge into final array
    //             }
    //         }

    //         // Remove empty values and duplicates
    //         $finalWordIds = array_unique(array_filter($finalWordIds));

    //         // Re-index array keys if needed (optional)
    //         $finalWordIds = array_values($finalWordIds);

    //         if(count($finalWordIds) > 0 ){
    //             $words = DictionaryInfo::whereIn('id',$finalWordIds)->where('deleted_at',0)->get();
    //             $resArr = [];
    //             if ($words->isNotEmpty()) {
    //                 foreach ($words as $key => $value) {
    //                     # code...
    //                     $temp =[];
    //                     $temp['word'] = $value->word ?? "";
    //                     $temp['description'] = $value->description ?? "";
    //                     $temp['version_id'] = $value->version_id ?? "";
    //                     array_push($resArr,$temp);
    //                 }
    //                 return response()->json([
    //                     'result' => '1',
    //                     'data' => $resArr,
    //                     'message' => 'success'
    //                 ]);

    //             }

    //         } 
            
    //         return response()->json([
    //             'result' => '0',
    //             'data' => $resArr ?? [],
    //             'message' => 'No data found'
    //         ]);

    //     } catch (\Exception $e) {
    //         Log::error('Error in get_dictionary_words_api: ' . $e->getMessage());
    //         return response()->json(['result' => '0', 'data' => [], 'message' =>  $e->getMessage()]);
    //     }
    // }

    public function get_dictionary_words_api(Request $request)
    {
        try {
            // Validation rules
            $validator = Validator::make($request->all(), [
                'app_id'       => 'required',
                'book_num'     => 'required',
                'chapter_num'  => 'required',
            ]);

            // If validation fails, return error response
            if ($validator->fails()) {
                return response()->json([
                    'result'  => '0',
                    'data'    => [],
                    'message' => $validator->errors()->first()
                ]);
            }

            $app_id = $request->input('app_id');
            $book_num = $request->input('book_num');
            $chapter_num = $request->input('chapter_num');

            // Cache key generation based on parameters
            $cacheKey = "dictionary_words_{$app_id}_{$book_num}_{$chapter_num}";

            // Try fetching from cache, if not exist, compute and cache it
            $response = Cache::remember($cacheKey, 1, function () use ($app_id, $book_num, $chapter_num) {
                $app_version_id = "";

                $AppInfo = AppInfo::find($app_id);
                if (!$AppInfo) {
                    return [
                        'result'  => '0',
                        'data'    => [],
                        'message' => 'No data found'
                    ];
                }

                $getTemplateId = $AppInfo->temp_id;
                $TemplateInfo = TemplateInfo::find($getTemplateId);
                $app_version_id = $TemplateInfo->version_id ?? "";

                // Fetch word_ids from BaseVerse
                $words = BaseVerse::forVersion($app_version_id)
                    ->whereDeletedAt(0)
                    ->where('book_num', $book_num)
                    ->where('chapter_num', $chapter_num)
                    ->pluck('word_ids')
                    ->toArray();

                // Process word_ids into array
                $finalWordIds = collect($words)
                    ->filter()
                    ->flatMap(function ($wordString) {
                        return explode(',', $wordString);
                    })
                    ->filter()
                    ->unique()
                    ->values()
                    ->toArray();

                if (empty($finalWordIds)) {
                    return [
                        'result'  => '0',
                        'data'    => [],
                        'message' => 'No data found'
                    ];
                }

                // Fetch dictionary words
                $dictionaryWords = DictionaryInfo::whereIn('id', $finalWordIds)
                    ->where('deleted_at', 0)
                    ->get()
                    ->unique('word')      // 🔴 restrict duplicate words
                    ->values();           // 🔴 reset array index

                if ($dictionaryWords->isEmpty()) {
                    return [
                        'result'  => '0',
                        'data'    => [],
                        'message' => 'No data found'
                    ];
                }

                // Prepare response data
                $resArr = $dictionaryWords->map(function ($word) {
                    return [
                        'id'        => $word->id ?? "",
                        'word'        => $word->word ?? "",
                        'description' => $word->description ?? "",
                        'version_id'  => $word->version_id ?? ""
                    ];
                })->toArray();

                return [
                    'result'  => '1',
                    'data'    => $resArr,
                    'message' => 'success'
                ];
            });

            // Return cached or computed response
            return response()->json($response);

        } catch (\Exception $e) {
            Log::error('Error in get_dictionary_words_api: ' . $e->getMessage());
            return response()->json([
                'result'  => '0',
                'data'    => [],
                'message' => $e->getMessage()
            ]);
        }
    }


}
