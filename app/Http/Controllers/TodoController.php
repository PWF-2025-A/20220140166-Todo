<?php

namespace App\Http\Controllers;
use App\Models\Todo;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    public function index()
    {
        // $todos = Todo::all();
       // $todos = Todo::where('user_id', Auth::id()) ->get();
        //dd($todos);
        //return view('todo.index');
    
         $todos = Todo::with('category') 
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        $todosCompleted = Todo::where('user_id', auth::user()->id)
         ->where('is_complete', true)
         ->count();
         
         return view('todo.index', compact('todos', 'todosCompleted'));
     }
 
     public function store(Request $request)
     {
         $request->validate([
             'title' => 'required|string|max:25',
             'category_id' => 'required|exists:categories,id'
         ]);
 
         $todo = Todo::create([
             'title' => ucfirst($request->title),
             'category_id' => $request->category_id,
             'user_id' => Auth::id(),
             'is_complete' => false,
         ]);
 
         return redirect()->route('todo.index')->with('success', 'Todo created successfully.');
     }

    public function create()
    {
        $categories = Category::all();
        return view('todo.create',  compact('categories'));
    }

    public function edit(Todo $todo)
     {
         if (auth::user()->id == $todo->user_id) {
             $categories = Category::all();
             return view('todo.edit', compact('todo', 'categories'));
         } else {
             // abort(403);
             // abort(403, 'Not authorized');
             return redirect()->route('todo.index')->with('danger', 'You are not authorized to edit this todo!');
         }
     }

     public function update(Request $request, Todo $todo)
     {
         $request->validate([
             'title' => 'required|max:255',
             'category_id' => 'required|exists:categories,id',

         ]);
     
         // Practical
         // $todo->title = $request->title;
         // $todo->save();
     
         // Eloquent Way - Readable
         $todo->update([
             'title' => ucfirst($request->title),
             'category_id' => $request->category_id,
         ]);
     
         return redirect()->route('todo.index')->with('success', 'Todo updated successfully!');
     }
    
     public function complete(Todo $todo)
     {
         if (auth::user()->id == $todo->user_id) {
             $todo->update([
                 'is_complete' => true,
             ]);
             return redirect()->route('todo.index')->with('success', 'Todo completed successfully!');
         } else {
             return redirect()->route('todo.index')->with('danger', 'You are not authorized to complete this todo!');
         }
     }
 
     public function uncomplete(Todo $todo)
     {
         if (auth::user()->id == $todo->user_id) {
             $todo->update([
                 'is_complete' => false,
             ]);
             return redirect()->route('todo.index')->with('success', 'Todo uncompleted successfully!');
         } else {
             return redirect()->route('todo.index')->with('danger', 'You are not authorized to uncomplete this todo!');
         }
     }
 
     public function destroy(Todo $todo)
     {
         if (auth::user()->id == $todo->user_id) {
             $todo->delete();
             return redirect()->route('todo.index')->with('success', 'Todo deleted successfully!');
         } else {
             return redirect()->route('todo.index')->with('danger', 'You are not authorized to delete this todo!');
         }
     }
 
     public function destroyCompleted()
     {
         // get all todos for current user where is_completed is true
         $todosCompleted = Todo::where('user_id', auth::user()->id)
             ->where('is_complete', true)
             ->get();
 
         foreach ($todosCompleted as $todo) {
             $todo->delete();
         }
 
         // dd($todosCompleted);
         return redirect()->route('todo.index')->with('success', 'All completed todos deleted successfully!');
     }
    
}
