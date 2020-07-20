<?php

namespace App\Http\Controllers;

use App\NoteBook;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;

class NoteBookController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax() || $request->isJson()) {
            return response()->json(NoteBook::userNotebooks(), 200);
        }

        return view('home');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('notebook.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(['title' => 'required|unique:note_books,title']);

        NoteBook::create([
            'title' => $request->title, 
            'user_id' => auth()->id()
        ]);

        return redirect()->route('notebook.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\NoteBook  $notebook
     * @return \Illuminate\Http\Response
     */
    public function show(NoteBook $notebook)
    {
        $notes = $notebook->notes()->get();

        return response()->json($notes, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\NoteBook  $noteBook
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, NoteBook $notebook)
    {
        $v = Validator::make($request->all(), ['title' => 'required']);

        if($v->fails()) return response()->json($v->errors()->all(), 422);

        $notebook->update([
            'user_id' => auth()->id(),
            'title' => $request->title
        ]);

        return response()->json(true, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\NoteBook  $noteBook
     * @return \Illuminate\Http\Response
     */
    public function destroy(NoteBook $notebook)
    {
        $notebook->delete();

        return response()->json(true, 200);
    }
}
