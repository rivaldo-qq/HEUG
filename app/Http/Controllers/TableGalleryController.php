<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\ProductGallery;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ProductGalleryRequest;
use App\Http\Requests\TableGalleryRequest;
use App\Models\Table;
use App\Models\TableGallery;
use Yajra\DataTables\Facades\DataTables;

class TableGalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Table $table)
    {
        if (request()->ajax()) {
            $query = TableGallery::where('tables_id', $table->id);

            return DataTables::of($query)
                ->addColumn('action', function ($item) {
                    return '
                        <form class="inline-block" action="' . route('dashboard.table-gallery.destroy', $item->id) . '" method="POST">
                        <button class="border border-red-500 bg-red-500 text-white rounded-md px-2 py-1 m-2 transition duration-500 ease select-none hover:bg-red-600 focus:outline-none focus:shadow-outline" >
                            Hapus
                        </button>
                            ' . method_field('delete') . csrf_field() . '
                        </form>';
                })
                ->editColumn('url', function ($item) {
                    return '<img style="max-width: 150px;" src="'. Storage::url($item->url) .'"/>';
                })
                ->editColumn('is_featured', function ($item) {
                    return $item->is_featured ? 'Yes' : 'No';
                })
                ->rawColumns(['action', 'url'])
                ->make();
        }

        return view('pages.dashboard.table-gallery.index', compact('table'));
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Table $table)
    {
        return view('pages.dashboard.table-gallery.create', compact('table'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TableGalleryRequest $request, Table $table)
    {
        $files = $request->file('files');

        if($request->hasFile('files'))
        {
            foreach ($files as $file) {
                $path = $file->store('public/gallery');

                TableGallery::create([
                    'tables_id' => $table->id,
                    'url' => $path
                ]);
            }
        }

        return redirect()->route('dashboard.table.table-gallery.index', $table->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProductGallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function show(TableGallery $gallery)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProductGallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductGallery $gallery)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProductGallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function update(TableGalleryRequest $request, TableGallery $gallery)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductGallery  $productGallery
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = TableGallery::findOrFail($id);
        $item->delete();

        return redirect()->route('dashboard.table.index');
    }
}
