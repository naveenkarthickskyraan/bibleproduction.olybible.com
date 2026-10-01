<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use DB;
use App\Models\Lang;

class SupportController extends Controller
{
    // Method to get books based on the selected version
    public function getBooks(Request $request)
    {
        // Validate the version_id
        $versionId = $request->input('version_id');
        $bookId = $request->input('book_id');
        
        if($versionId && $bookId){
            if($request->status == 1){
                $totalChapCount = Book::where('id', $bookId)
                    ->where('version_id', $versionId)
                    ->pluck('total_chap_count')
                    ->first();
        
                // Generate chapter options
                $chapters = [];
                if ($totalChapCount) {
                    for ($i = 1; $i <= $totalChapCount; $i++) {
                        $chapters[] = [
                            'id' => $i, // Assuming chapter IDs are 1, 2, 3,..., total chapters
                            'chapter_number' => "Chapter ".$i,
                        ];
                    }
                }
                
                return response()->json($chapters);
            }
            $totalChapCount = Book::where('id', $bookId)
                ->where('version_id', $versionId)
                ->pluck('total_chap_count')
                ->first();
    
            // Generate chapter options
            $chapters = [];
            if ($totalChapCount) {
                for ($i = 0; $i < $totalChapCount; $i++) {
                    $chapters[] = [
                        'id' => $i, // Assuming chapter IDs are 1, 2, 3,..., total chapters
                        'chapter_number' => "Chapter ".$i + 1,
                    ];
                }
            }
            
    
            return response()->json($chapters);
        }
        
        if ($versionId) {
            // Fetch books related to the version_id
            $books = Book::where('version_id', $versionId)->get(); // Adjust model if needed
    
            // Return the data as JSON response
            return response()->json($books);
        }

    }
    
    // Method to get books based on the selected version
    public function getChapters(Request $request)
    {
        $versionId = $request->input('version_id');
        $bookId = $request->input('book_id');
    
        // Fetch chapters (if book and version are passed)
        if ($versionId && $bookId) {
            $book = Book::select('total_chap_count')
                        ->where('id', $bookId)
                        ->where('version_id', $versionId)
                        ->first();
    
            if (!$book) return response()->json([]);
    
            $existingChapters = BibleChapterImage::where('version_id', $versionId)
                ->where('book_id', $bookId)
                ->where('deleted_at', 0)
                ->pluck('chapter_id')
                ->toArray();
    
            $chapters = collect(range(1, $book->total_chap_count))
                        ->reject(fn($i) => in_array($i, $existingChapters))
                        ->map(fn($i) => ['id' => $i, 'chapter_number' => "Chapter $i"])
                        ->values();
    
            return response()->json($chapters);
        }
    
        // Fetch books based on version ID
        if ($versionId) {
            // Subquery to get completed book IDs
            $completedBooksSubquery = DB::table('bible_chapter_images as bci')
                ->join('books as b', 'b.id', '=', 'bci.book_id')
                ->select('bci.book_id')
                ->where('bci.version_id', $versionId)
                ->where('bci.deleted_at', 0)
                ->groupBy('bci.book_id', 'b.total_chap_count')
                ->havingRaw('COUNT(DISTINCT bci.chapter_id) >= b.total_chap_count');
    
            // Use whereNotIn with subquery
            $books = Book::select('id', 'title')
                        ->where('version_id', $versionId)
                        ->whereNotIn('id', $completedBooksSubquery)
                        ->orderBy('id', 'asc')
                        ->get();
    
            return response()->json($books);
        }
    
        return response()->json([]);
    }

    public function GetAudioType(Request $request)
    {
        $data = array();
        $gettt = Lang::where('id', $request->languageid)->get();
        $data['result'] = $gettt;
        return response()->json($data);
    }
}
