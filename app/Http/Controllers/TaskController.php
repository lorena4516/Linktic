<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Task::query();

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }
    
        if ($request->has('due_date')) {
            $query->whereDate('due_date', $request->due_date);
        }
    
        return $query->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validar los datos de entrada
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|in:pending,in_progress,completed',
            'due_date' => 'required|date',
        ]);

        // Crear la tarea y devolverla
        return Task::create($validatedData);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Consultar por id
        return Task::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validar los datos de entrada
        $validatedData = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'status' => 'sometimes|required|in:pending,in_progress,completed',
            'due_date' => 'sometimes|required|date',
        ]);

        // Encontrar y actualizar la tarea
        $task = Task::findOrFail($id);
        $task->update($validatedData);

        // Devolver la tarea actualizada
        return $task;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Encontrar y eliminar la tarea
        $task = Task::findOrFail($id);
        $task->delete();

        // Devolver una respuesta sin contenido
        return response(null, 204);
    }

    public function filterByStatus(Request $request)
    {
        $this->validate($request, [
            'status' => 'required|in:pending,in_progress,completed',
        ]);

        return Task::where('status', $request->status)->get();
    }

    public function filterByDueDate(Request $request)
    {
        $this->validate($request, [
            'due_date' => 'required|date',
        ]);

        return Task::whereDate('due_date', $request->due_date)->get();
    }

}
