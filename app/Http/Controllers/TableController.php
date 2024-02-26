<?php

namespace App\Http\Controllers;

use App\Models\Table;
use Illuminate\Support\Str;
use App\Http\Requests\TableGalleryRequest;
use App\Http\Requests\TableRequest;
use App\Models\Transaction;
use Yajra\DataTables\Facades\DataTables;

class TableController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $query = Table::query();

            return DataTables::of($query)
                ->addColumn('action', function ($item) {
                    return '
                        <a class="inline-block border border-red-500 bg-red-500 text-white rounded-md px-2 py-1 m-2 transition duration-500 ease select-none hover:bg-red-600 focus:outline-none focus:shadow-outline"
                            href=" ' . route('dashboard.table.table-gallery.index', $item->id) . ' ">
                            Gallery
                        </a>
                        <a class="inline-block border border-red-500 bg-red-500 text-white rounded-md px-2 py-1 m-2 transition duration-500 ease select-none hover:bg-red-600 focus:outline-none focus:shadow-outline" 
                            href=" ' . route('dashboard.table.edit', $item->id) . ' ">
                            Edit
                        </a>
                        <form class="inline-block" action=" ' . route('dashboard.table.destroy', $item->id) . ' " method="POST">
                        <button class="border border-red-500 bg-red-500 text-white rounded-md px-2 py-1 m-2 transition duration-500 ease select-none hover:bg-red-600 focus:outline-none focus:shadow-outline" >
                            Hapus
                        </button>
                            ' . method_field('delete') . csrf_field() . '
                        </form>';
                })
                ->editColumn('price', function ($item) {
                    return number_format($item->price);
                })
                ->rawColumns(['action'])
                ->make();
        }

        return view('pages.dashboard.table.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.dashboard.table.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(TableRequest $request)
    {
        $data = $request->all();

        $data['slug'] = Str::slug($request->name);

        Table::create($data);

        return redirect()->route('dashboard.table.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function show(Table $table)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function edit(Table $table)
    {
        return view('pages.dashboard.table.edit', [
            'item' => $table
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(TableRequest $request, Table $table)
    {
        $data = $request->all();

        $data['slug'] = Str::slug($request->name);


        $table->update($data);

        return redirect()->route('dashboard.table.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Table $table)
    {
        $table->delete();

        return redirect()->route('dashboard.table.index');
    }
}
