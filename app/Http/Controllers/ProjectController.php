<?php

namespace App\Http\Controllers;

use App\Project;
use App\Order;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Menampilkan semua project.
     */
    public function index()
    {
        $projects = Project::with('order.customer', 'order.service')
            ->latest()
            ->get();

        return view('projects.index', compact('projects'));
    }

    /**
     * Menampilkan form tambah project.
     */
    public function create()
    {
        $orders = Order::with('customer', 'service')
            ->whereDoesntHave('project')
            ->latest()
            ->get();

        return view('projects.create', compact('orders'));
    }

    /**
     * Menyimpan project baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'project_name' => 'required|string|max:100',
            'start_date' => 'nullable|date',
            'deadline' => 'nullable|date|after_or_equal:start_date',
            'progress' => 'nullable|integer|min:0|max:100',
            'status' => 'nullable|in:not_started,process,revision,completed',
        ]);

        $order = Order::findOrFail($request->order_id);

        if ($order->project()->exists()) {
            return back()
                ->withInput()
                ->withErrors([
                    'order_id' => 'Order ini sudah memiliki project.'
                ]);
        }

        $progress = $request->progress ?? 0;
        $status = $request->status ?? 'not_started';

        Project::create([
            'order_id' => $request->order_id,
            'project_name' => $request->project_name,
            'start_date' => $request->start_date,
            'deadline' => $request->deadline,
            'progress' => $progress,
            'status' => $status,
        ]);

        return redirect()
            ->route('projects.index')
            ->with('success', 'Project berhasil dibuat.');
    }

    /**
     * Menampilkan detail project.
     */
    public function show(Project $project)
    {
        $project->load('order.customer', 'order.service');

        return view('projects.show', compact('project'));
    }

    /**
     * Menampilkan form edit project.
     */
    
    public function edit(Project $project)
    {
        $orders = Order::with('customer', 'service')
            ->whereDoesntHave('project')
            ->orWhere('id', $project->order_id)
            ->latest()
            ->get();

        return view('projects.edit', compact('project', 'orders'));
    }


    /**
     * Mengupdate project.
     */
    public function update(Request $request, Project $project)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'project_name' => 'required|string|max:100',
            'start_date' => 'nullable|date',
            'deadline' => 'nullable|date|after_or_equal:start_date',
            'progress' => 'nullable|integer|min:0|max:100',
            'status' => 'required|in:not_started,process,revision,completed',
        ]);

        $progress = $request->progress ?? 0;

        $project->update([
            'order_id' => $request->order_id,
            'project_name' => $request->project_name,
            'start_date' => $request->start_date,
            'deadline' => $request->deadline,
            'progress' => $progress,
            'status' => $request->status,
        ]);

        return redirect()
            ->route('projects.index')
            ->with('success', 'Project berhasil diperbarui.');
    }

    /**
     * Menghapus project.
     */
    public function destroy(Project $project)
    {
        $project->delete();

        return redirect()
            ->route('projects.index')
            ->with('success', 'Project berhasil dihapus.');
    }
}