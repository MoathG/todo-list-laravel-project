<?php

namespace App\Http\Controllers;

use App\todo;

use Illuminate\Http\Request;

class TodosController extends Controller
{
    public function index() {

        // fetch all data from database
        //display them in the todos.index page

        $todos = Todo::all();

        return view('todos.index')->with('todos', $todos);
    }

    public function show($todoId) {
        
        // $todo = Todo::find($todoId);

        return view('todos.show')->with('todo', Todo::find($todoId));

    }

    public function create() {
        
        return view('todos.create');

    }

    public function store() {

        // dd(request()->all());

        $this->validate(request(), [
            'name' => 'required|min:6|max:20',
            'descriotion' => 'required'
        ]);

        $data = request()->all();

        $todo = new Todo();
        $todo->name = $data['name'];
        $todo->descriotion = $data['descriotion'];
        $todo->completed = false;

        $todo->save();

        session()->flash('success', 'Todo Created successfully');

        return redirect('/todos');

    }

    public function edit($todoId) {

        $todo = Todo::find($todoId);

        return view('todos.edit')->with('todo', $todo);
    }

    public function update(Todo $todo) {

        $this->validate(request(), [
            'name' => 'required|min:6|max:20',
            'descriotion' => 'required'
        ]);

        $data = request()->all();

        // $todo = Todo::find($todoId);

        $todo->name = $data['name'];
        $todo->descriotion = $data['descriotion'];

        $todo->save();

        session()->flash('success', 'Todo Updated successfully');

        return redirect('/todos');

    }

    public function destroy(Todo $todo) {
        
        // $todo = Todo::find($todoId);
        //we can write the function find without write it like we can se in the parameter upside

        $todo->delete();

        session()->flash('success', 'Todo Deleted successfully');

        return redirect('/todos');

    }

    public function complete(Todo $todo) {

        $todo->completed = true;

        $todo->save();

        session()->flash('success', 'Todo Completed successfully');

        return redirect('/todos');

    }
}
