<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ItemRequest;
use App\Item;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Item::query()->latest();

            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('image', function ($row) {
                    $url = asset('storage/' . $row->image);
                    return '<img src="' . $url . '" width="150" class="img-fluid rounded">';
                })
                ->addColumn('action', function ($row) {
                    $editUrl = route('items.edit', $row->id);

                    $btn = '<div class="list-icons">
                                <a href="' . $editUrl . '" class="list-icons-item text-primary-600" title="Edit"><i class="icon-pencil7"></i></a>
                                <a href="javascript:void(0)" data-id="' . $row->id . '" class="list-icons-item text-danger-600 ml-2 delete-item" title="Hapus"><i class="icon-trash"></i></a>
                            </div>';
                    return $btn;
                })
                ->rawColumns(['image', 'action'])
                ->make(true);
        }

        return view('items.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('items.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ItemRequest $request)
    {
        $item = new Item();
        $item->name = $request->name;
        $item->stock = $request->stock;
        $item->price = $request->price;
        $item->description = $request->description;
        if ($request->file('image')) {
            $imagepath = $request->file('image')->store('images', 'public');
            $item->image = $imagepath;
        }
        $item->save();
        return redirect()->route('items.index')->with('success', 'Item created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return void
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $Item = Item::findOrFail($id);
        return view('items.edit', compact('Item'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ItemRequest $request, $id)
    {
        $Item = Item::findOrFail($id);

        // Update data teks
        $Item->name = $request->name;
        $Item->stock = $request->stock;
        $Item->price = $request->price;
        $Item->description = $request->description;

        // Logika Ganti Foto
        if ($request->hasFile('image')) {
            // Hapus foto lama jika ada
            if ($Item->image && \Storage::disk('public')->exists($Item->image)) {
                \Storage::disk('public')->delete($Item->image);
            }

            // Simpan foto baru
            $imagepath = $request->file('image')->store('images', 'public');
            $Item->image = $imagepath;
        }

        $Item->save();

        return redirect()->route('items.index')->with('success', 'Item updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $Item = Item::findOrFail($id);
        \Storage::disk('public')->delete($Item->image);
        $Item->delete();

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Item deleted successfully'
            ]);
        }
        return redirect()->route('items.index')->with('success', 'Item deleted successfully');
    }
}
