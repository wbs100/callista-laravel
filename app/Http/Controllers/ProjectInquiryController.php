<?php
namespace App\Http\Controllers;

use App\Models\ProjectInquiry;
use Illuminate\Http\Request;

class ProjectInquiryController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'firstName' => 'required|string|max:100',
            'lastName' => 'required|string|max:100',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:30',
            'projectType' => 'required|string|max:100',
            'budget' => 'nullable|string|max:100',
            'timeline' => 'nullable|string|max:100',
            'location' => 'nullable|string|max:255',
            'projectDescription' => 'required|string',
            'inspiration' => 'nullable|string|max:100',
            'newsletter' => 'nullable|boolean',
        ]);
        $validated['newsletter'] = $request->has('newsletter');
        ProjectInquiry::create($validated);
        return response()->json(['message' => 'Your inquiry has been submitted. We will contact you soon.']);
    }
}
