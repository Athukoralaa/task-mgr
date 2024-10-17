<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    /**
     * Display a listing of the tasks for the authenticated user.
     */
    public function index()
    {
        // Retrieve all tasks for the authenticated user, paginated (10 tasks per page)
        $tasks = auth()->user()->tasks()->paginate(5);

        // Return tasks in JSON format
        return response()->json($tasks);
        
    }

    /**
     * Store a newly created task in the database.
     */
    public function store(Request $request)
    {
        // Validate the incoming request
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:pending,completed',
        ]);

        // If validation fails, return an error response
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        // Create the task for the authenticated user
        $task = auth()->user()->tasks()->create([
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,
        ]);

        // Return the created task in JSON format
        return response()->json([
            'message' => 'Task created successfully',
            'task' => $task
        ], 201);
    }

    /**
     * Update the specified task in the database.
     */
    public function update(Request $request, Task $task)
    {
        // Check if the authenticated user is the owner of the task
        if ($task->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Validate the incoming request
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:pending,completed',
        ]);

        // If validation fails, return an error response
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        // Update the task with new data
        $task->update([
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,
        ]);

        // Return the updated task in JSON format
        return response()->json([
            'message' => 'Task updated successfully',
            'task' => $task
        ], 200);
    }

    /**
     * Remove the specified task from the database.
     */
    public function destroy(Task $task)
    {
        // Check if the authenticated user is the owner of the task
        if ($task->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Delete the task
        $task->delete();

        // Return a success message
        return response()->json([
            'message' => 'Task deleted successfully'
        ], 200);
    }

    public function toggleStatus(Task $task)
    {
        // Check if the authenticated user is the owner of the task
        if ($task->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Toggle the task status (pending -> completed or completed -> pending)
        $task->status = $task->status === 'pending' ? 'completed' : 'pending';
        $task->save();

        // Return a success message along with the updated task
        return response()->json([
            'message' => 'Task status updated successfully',
            'task' => $task
        ], 200);
    }
}
