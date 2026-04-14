<?php
namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// Ensure you have imported the correct model
use App\Models\SoapTemplate; 

class TemplateController extends Controller
{
    public function index(Request $request)
    {
        $doctorId = Auth::id();
        $query = SoapTemplate::where('doctor_id', $doctorId);

        // Handle Search (Updated to match DB columns)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('template_name', 'LIKE', "%{$search}%")
                  ->orWhere('subjective_text', 'LIKE', "%{$search}%")
                  ->orWhere('objective_text', 'LIKE', "%{$search}%")
                  ->orWhere('assessment_text', 'LIKE', "%{$search}%")
                  ->orWhere('plan_text', 'LIKE', "%{$search}%");
            });
        }

        // Ordered by the correct column name
        $templates = $query->orderBy('template_name', 'asc')->paginate(6);

        return view('doctor.templates', compact('templates'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'template_name' => 'required|string|max:255',
        ]);

        SoapTemplate::create([
            'doctor_id' => Auth::id(),
            'template_name' => $request->template_name,
            'subjective_text' => $request->subjective_text,
            'objective_text' => $request->objective_text,
            'assessment_text' => $request->assessment_text,
            'plan_text' => $request->plan_text,
        ]);

        return back()->with('success', 'Macro template created successfully.');
    }

    public function update(Request $request, $id)
    {
        $template = SoapTemplate::where('doctor_id', Auth::id())->findOrFail($id);

        $request->validate([
            'template_name' => 'required|string|max:255',
        ]);

        $template->update($request->only([
            'template_name', 
            'subjective_text', 
            'objective_text', 
            'assessment_text', 
            'plan_text'
        ]));

        return back()->with('success', 'Macro template updated successfully.');
    }

    public function destroy($id)
    {
        $template = SoapTemplate::where('doctor_id', Auth::id())->findOrFail($id);
        $template->delete();

        return back()->with('success', 'Macro template deleted.');
    }
}