<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;

class NoteController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    return response()->json(['notes' => Note::paginate()]);
  }

  public function show(Note $note)
  {

    return response()->json(['note' => $note]);
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    $data = $request->validate([
      'title' => 'required|string',
      'body' => 'required|string|max:3000'
    ]);

    $note = Note::create(array_merge($data, [
      'user_id' => auth()->id(),
    ]));

    return response()->json(['message' => 'note succesfully added', 'note' => $note]);
  }


  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, Note $note)
  {
    abort_if($note->user_id !== auth()->id(), 401, "You can not edit another user's notes");

    $data = $request->validate([
      'title' => 'string',
      'body' => 'string|max:3000'
    ]);

    $note->update($data);

    return response()->json(['message' => 'note succesfully updated', 'note' => $note]);
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Note $note)
  {
    abort_if($note->user_id !== auth()->id(), 401, "You can not delete another user's note");

    $note->delete();

    return response()->json(['message' => 'note succesfully deleted']);
  }
}
