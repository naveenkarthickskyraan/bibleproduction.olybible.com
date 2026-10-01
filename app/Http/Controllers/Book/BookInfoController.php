<?php

namespace App\Http\Controllers\Book;


use App\Models\Book;
use App\Models\Version;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Lang;
use App\Helpers\LogActivity;
use DataTables;
use App\Rules\ExistsInMysql2;

class BookInfoController extends Controller
{
    public function show(Request $request)
    {
        if (!has_permission('book_menu', 'read')) {
            abort(403);
        }
        if (!has_module_access('book_menu')) {
            abort(403);
        }

        $book_infos = Book::where('deleted_at',0);

        if($request->ajax()) {
            return DataTables::of($book_infos)
                ->addColumn('title', function ($item) {
                    return '<div id="'.$item->id.'">'.htmlspecialchars($item->title).'</div>';
                })
                ->addColumn('book_num', function ($item) {
                     return $item->book_num;
                })
                ->addColumn('short_title', function ($item) {
                    return $item->short_title ? $item->short_title : 'N/A';
                })
                ->addColumn('total_chap_count', function ($item) {
                    return $item->total_chap_count;
                })
                ->addColumn('version_id', function ($item) {
                    return $item->version_id != null ? $item->version->version_name : "";
                })
                ->addColumn('created_at', function ($item) {
                    $date                    = $item->created_at->addHours(5)->addMinutes(30);
                    return '<div class="date-info">
                                <span class="fw-semibold">'.$date->format('D d, M Y').'</span><br>
                                <span class="text-muted">'.$date->format('h:i A').'</span>
                            </div>';
                })
                ->addColumn('status', function ($item) {
                    return $item->is_active  == '0' ? 
                        '<span class="badge bg-success"><i class="bi bi-check-circle me-1"></i> Active</span>' : 
                        '<span class="badge bg-danger"><i class="bi bi-exclamation-octagon me-1"></i> Inactive</span>';
                })
                ->addColumn('action', function ($items) {
                    $editUrl                 = url("admin/edit_book/".$items->id);
                    $deleteUrl               = url("admin/delete_book/".$items->id);
                    $editDisable             = !has_permission('book_menu', 'update') == true ? "disabled":"";
                    $deleteDisable             = !has_permission('book_menu', 'delete') == true ? "disabled":"";

                    return '<div class="btn-group">
                                <form action="'.$editUrl.'" method="POST">'.csrf_field().'
                                    <button  type="submit" class="btn btn-icon btn-circle btn-sm btn-outline-primary '.$editDisable.'" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Edit App" style="background: #7367EF !important;border-color:#7367EFcf;color:#ffffff !important;"><i class="fa fa-edit"></i></button>
                                </form>
                                <form  id="form_submit_'.$items->id.'"   action="'.$deleteUrl.'" method="POST" style="padding-left:5px;">'.csrf_field().'
                                    <input id="disable_'.$items->id.'" type="hidden" name="ad_app_type"  class="form-control" />
                                    <button  type="button" class="btn btn-icon btn-circle btn-sm btn-outline-danger '.$deleteDisable.'"  onclick="return validateform('.$items->id.')"  data-bs-toggle="tooltip" data-bs-placement="top" title="Delete App" style="background: #EE4B2B;border-color:#EE4B2B;color:#ffffff !important"><i class="fa fa-trash-can-arrow-up"></i></button>
                                </form>
                            </div>';
                })
                ->addColumn('status_update', function ($items) {
                    $statusUpdateUrl = url('admin/book_status_update');
                    $statusText = $items->is_active == '0' ? 'Enable' : 'Disable';
                    $statusValue = $items->is_active == '0' ? '0' : '1';
                    $statusDisable             = !has_permission('book_menu', 'status') == true ? "disabled":"";
                    if($statusValue == 1)
                    {
                        return '<center><form action="'.$statusUpdateUrl.'" method="POST">'.
                                csrf_field().
                                '<input type="hidden" name="book_id" value="'.$items->id.'">'.
                                ($items->is_active == '0' ? '<input type="hidden" name="status" value="0">' : '<input type="hidden" name="status" value="1">').
                                '<button type="submit" data-toggle="tooltip" data-original-title="'.$statusText.'" id="status_btn" name="status_btn" title="" class="btn_status btn btn-success btn-sm '.($items->is_active == '0' ? 'enable ' : '').''.$statusDisable.'" style="background: #ffad46!important;border-color: #ffad46!important;color: #fff!important;">
                                    <i class="fa fa-solid fa-circle"></i>
                                </button>
                            </form></center>';
                    }else{

                        return '<center><form action="'.$statusUpdateUrl.'" target="_top" method="POST">'.
                                    csrf_field().
                                    '<input type="hidden" name="book_id" value="'.$items->id.'">'.
                                    ($items->is_active == '0' ? '<input type="hidden" name="status" value="0">' : '<input type="hidden" name="status" value="1">').
                                    '<button type="submit" data-toggle="tooltip" data-original-title="'.$statusText.'" id="status_btn" name="status_btn" title="" class="btn_status btn btn-success btn-sm '.($items->is_active == '0' ? 'enable ' : '').''.$statusDisable.'" >
                                        <i class="fa fa-solid fa-circle"></i>
                                    </button>
                                </form></center>';
                    }
                })
                ->rawColumns(['version_id','title','short_title','total_chap_count','book_num', 'created_at', 'status', 'action', 'status_update'])
                ->filter(function ($query) use ($request) {
                    if ($request->has('search') && $keyword = $request->get('search')['value']) {
                        $query->where(function($q) use ($keyword) {
                            $q->where('book_num', 'like', "%{$keyword}%")
                            ->orWhere('title', 'like', "%{$keyword}%")
                            ->orWhere('short_title', 'like', "%{$keyword}%")
                            ->orWhere('total_chap_count', 'like', "%{$keyword}%")
                            ->orWhere('meta_keyword', 'like', "%{$keyword}%")
                            ->orWhere('meta_description', 'like', "%{$keyword}%")
                            ->orWhereDate('created_at', 'like', "%{$keyword}%")
                            ->orWhereIn('version_id', function($subQuery) use ($keyword) {
                                $subQuery->select('id')
                                        ->from(\DB::connection('mysql2')->table('versions'))
                                        ->where('version_name', 'like', "%{$keyword}%");
                            });
                        });
                    }
                })
                ->make(true);
        }

        return view('admin.version.book.book_list');

    }

    function Add_list()
    {
        if (!has_permission('book_menu', 'create')) {
            abort(403);
        }
        if (!has_module_access('book_menu')) {
            abort(403);
        }
        LogActivity::addToLog();
        
        $lang = Lang::all();

        $bookList = Book::where('title', '!=', '')
                ->select(\DB::raw('MAX(version_id) as version_id'), 'version_id', \DB::raw('COUNT(*) as sub_category_count'))
                ->groupBy('version_id')
                ->orderBy('sub_category_count', 'desc')
                ->pluck('version_id');

        $versions = Version::orderBy('id','desc')->whereNotIn('id', $bookList)->get();
        return view('admin.version.book.add_book', compact('lang','versions'));

    }

    public function active(Request $request)
    {
        if (!has_permission('book_menu', 'status')) {
            abort(403);
        }

        if (!has_module_access('book_menu')) {
            abort(403);
        }

        LogActivity::addToLog();

        $cat_id = $request->book_id;
        $status = $request->status;
        if($status == 0)
        {
            $app_active = Book::find($cat_id);
            $app_active->is_active ='1';
            $app_active->save();
            return back()->with('message','Word Disabled Successfully');
        }
        if($status == 1)
        {
            $app_active = Book::find($cat_id);
            $app_active->is_active ='0';
            $app_active->save();
            return back()->with('message','Word Enabled Successfully');
        }
    }

    public function store(Request $request)
    {
        if (!has_permission('book_menu', 'create')) {
            abort(403);
        }
        if (!has_module_access('book_menu')) {
            abort(403);
        }
        
        // Validate the request
        $validated = $request->validate([
            'version_id' => ['required', new ExistsInMysql2('versions', 'id')],
            'metadescription' => 'nullable|string|max:160',
            'metakeywords' => 'nullable|string|max:255',
            'books' => 'required|array|min:1',
            'books.*.book_num' => 'required|string|max:50',
            'books.*.title' => 'required|string|max:255',
            'books.*.short_title' => 'required|string|max:50',
            'books.*.total_chap_count' => 'required|integer|min:1',
        ]);

        // Start database transaction
        \DB::connection('mysql2')->beginTransaction();

        try {
            // Process each book
            foreach ($request->books as $bookData) {
                $book = new Book();
                $book->version_id = $request->version_id;
                $book->book_num = $bookData['book_num'];
                $book->title = $bookData['title'];
                $book->short_title = $bookData['short_title'];
                $book->total_chap_count = $bookData['total_chap_count'];
                $book->meta_description = $request->metadescription;
                $book->meta_keyword = $request->metakeywords;
                $book->save();
            }

            // Commit transaction
            \DB::connection('mysql2')->commit();

            return back()->with('message', 'Books added successfully!');
        } catch (\Exception $e) {
            // Rollback transaction on error
            \DB::connection('mysql2')->rollBack();
            return back()->withInput()->with('error', 'Error saving books: ' . $e->getMessage());
        }
    }

    public function delete(Request $request, $id)
    {
        if (!has_permission('book_menu', 'delete')) {
            abort(403);
        }
        if (!has_module_access('book_menu')) {
            abort(403);
        }

        LogActivity::addToLog();

        $Q1 = Book::find($id);
        $Q1->deleted_at = '1';
        $Q1->save();
        return back()->with('message','Delete Record Successfully');

    }

    public function EditCategory($id)
    {
        if (!has_permission('book_menu', 'update')) {
            abort(403);
        }
        if (!has_module_access('book_menu')) {
            abort(403);
        }

        $book = Book::findOrFail($id);
       
        $lang = Lang::all();

        $bookList = Book::where('title', '!=', '')
                ->select(\DB::raw('MAX(version_id) as version_id'), 'version_id', \DB::raw('COUNT(*) as sub_category_count'))
                ->groupBy('version_id')
                ->orderBy('sub_category_count', 'desc')
                ->pluck('version_id');

        $versions = Version::orderBy('id','desc')->whereIn('id', $bookList)->get();

        return view('admin.version.book.edit_book_list', compact('book','lang','versions'));

    }

    public function EditCatList(Request $request, $id)
    {
        if (!has_permission('book_menu', 'update')) {
            abort(403);
        }
        if (!has_module_access('book_menu')) {
            abort(403);
        }

        // Validate the request
        $validated = $request->validate([
            'version_id' => ['required', new ExistsInMysql2('versions', 'id')],
            'metadescription' => 'nullable|string|max:160',
            'metakeywords' => 'nullable|string|max:255',
            'book_num' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'short_title' => 'required|string|max:255',
            'total_chap_count' => 'required|string|max:255',
        ]);

        // Start database transaction
        \DB::connection('mysql2')->beginTransaction();

        try {
            // Process each book
            $book = Book::findOrFail($id);
            $book->version_id = $request->version_id;
            $book->book_num = $request->book_num;
            $book->title = $request->title;
            $book->short_title = $request->short_title;
            $book->total_chap_count = $request->total_chap_count;
            $book->meta_description = $request->metadescription;
            $book->meta_keyword = $request->metakeywords;
            $book->save();

            // Commit transaction
            \DB::connection('mysql2')->commit();

            return redirect()->to(url('admin/book_list') . '#' . $book->id)
                    ->with('message', 'Book Edited successfully!');
        } catch (\Exception $e) {
            // Rollback transaction on error
            \DB::connection('mysql2')->rollBack();
            return back()->withInput()->with('error', 'Error saving books: ' . $e->getMessage());
        }

    }

}
