<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Project;
use App\Order;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    private function checkAdmin()
    {
        abort_unless(auth()->check() && auth()->user()->role == 'admin', 403);
    }

    // Menampilkan semua project
    public function index()
    {
        $this->checkAdmin();

        $projects = Project::with('order.customer', 'order.service')
            ->latest()
            ->get();

        return view('projects.index', compact('projects'));
    }

    // Form tambah project
    public function create()
    {
        $this->checkAdmin();

        $orders = Order::with('customer', 'service')
            ->whereDoesntHave('project')
            ->latest()
            ->get();

        return view('projects.create', compact('orders'));
    }

    // Menyimpan project
    public function store(Request $request)
    {
        $this->checkAdmin();

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

        Project::create([
            'order_id' => $request->order_id,
            'project_name' => $request->project_name,
            'start_date' => $request->start_date,
            'deadline' => $request->deadline,
            'progress' => $request->progress ?? 0,
            'status' => $request->status ?? 'not_started',
        ]);

        return redirect()
            ->route('projects.index')
            ->with('success', 'Project berhasil dibuat.');
    }

    // Detail project
    public function show(Project $project)
    {
        $this->checkAdmin();

        $project->load('order.customer', 'order.service');

        return view('projects.show', compact('project'));
    }

    // Form edit project
    public function edit(Project $project)
    {
        $this->checkAdmin();

        $orders = Order::with('customer', 'service')
            ->where(function ($query) use ($project) {
                $query->whereDoesntHave('project')
                    ->orWhere('id', $project->order_id);
            })
            ->latest()
            ->get();

        return view('projects.edit', compact('project', 'orders'));
    }

    // Update project
    public function update(Request $request, Project $project)
    {
        $this->checkAdmin();

        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'project_name' => 'required|string|max:100',
            'start_date' => 'nullable|date',
            'deadline' => 'nullable|date|after_or_equal:start_date',
            'progress' => 'nullable|integer|min:0|max:100',
            'status' => 'required|in:not_started,process,revision,completed',
        ]);

        $order = Order::findOrFail($request->order_id);

        if (
            $order->id != $project->order_id &&
            $order->project()->exists()
        ) {
            return back()
                ->withInput()
                ->withErrors([
                    'order_id' => 'Order ini sudah memiliki project lain.'
                ]);
        }

        $project->update([
            'order_id' => $request->order_id,
            'project_name' => $request->project_name,
            'start_date' => $request->start_date,
            'deadline' => $request->deadline,
            'progress' => $request->progress ?? 0,
            'status' => $request->status,
        ]);

        return redirect()
            ->route('projects.index')
            ->with('success', 'Project berhasil diperbarui.');
    }

    // Hapus project
    public function destroy(Project $project)
    {
        $this->checkAdmin();

        $project->delete();

        return redirect()
            ->route('projects.index')
            ->with('success', 'Project berhasil dihapus.');
    }
}