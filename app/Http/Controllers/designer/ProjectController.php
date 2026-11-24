<?php

namespace App\Http\Controllers\Designer;

use App\Http\Controllers\Controller;
use App\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    private function checkDesigner()
    {
        abort_unless(
            Auth::check() && Auth::user()->role == 'designer',
            403
        );
    }

    private function findDesignerProject($id)
    {
        return Project::with(['order.customer', 'order.service'])
            ->whereHas('order', function ($query) {
                $query->where('designer_id', Auth::id());
            })
            ->findOrFail($id);
    }

    // Daftar Project Designer
    public function index()
    {
        $this->checkDesigner();

        $projects = Project::with(['order.customer', 'order.service'])
            ->whereHas('order', function ($query) {
                $query->where('designer_id', Auth::id());
            })
            ->latest()
            ->paginate(10);

        return view('designer.projects.index', compact('projects'));
    }

    // Detail Project
    public function show($id)
    {
        $this->checkDesigner();

        $project = $this->findDesignerProject($id);

        return view('designer.projects.show', compact('project'));
    }

    // Update Progress dan Status
    public function update(Request $request, $id)
    {
        $this->checkDesigner();

        $project = $this->findDesignerProject($id);

        $validated = $request->validate([
            'progress' => 'required|integer|min:0|max:100',
            'status' => 'required|in:not_started,process,revision,completed',
        ]);

        if ($validated['progress'] == 100) {
            $validated['status'] = 'completed';
        }

        if ($validated['status'] == 'completed') {
            $validated['progress'] = 100;
        }

        $project->update([
            'progress' => $validated['progress'],
            'status' => $validated['status'],
        ]);

        return redirect()
            ->route('designer.projects.show', $project->id)
            ->with('success', 'Progress project berhasil diperbarui!');
    }
}