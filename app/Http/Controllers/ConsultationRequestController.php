<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ConsultationRequest;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use App\Models\Product;
use App\Models\CustomRequest;
use App\Models\Order;
use App\Models\ProjectInquiry;

class ConsultationRequestController extends Controller
{
    /**
     * Store a new consultation request
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'firstName' => 'required|string|max:100',
                'lastName' => 'required|string|max:100',
                'email' => 'required|email|max:255',
                'phone' => 'required|string|max:20',
                'projectType' => 'required|string|max:50',
                'budget' => 'required|string|max:50',
                'preferredDate' => 'required|date',
                'projectDetails' => 'nullable|string|max:2000',
                'location' => 'required|string|max:255',
            ]);

            $consultation = ConsultationRequest::create([
                'first_name' => $validated['firstName'],
                'last_name' => $validated['lastName'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'project_type' => $validated['projectType'],
                'budget' => $validated['budget'],
                'preferred_date' => $validated['preferredDate'],
                'project_details' => $validated['projectDetails'] ?? null,
                'location' => $validated['location'],
                'status' => 'pending',
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Your consultation request has been submitted! We will contact you soon.'
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Please check your form data.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred. Please try again.',
                'error' => config('app.debug') ? $e->getMessage() : 'Internal server error'
            ], 500);
        }
    }

    public function index()
    {
        $users = User::all();
        $products = Product::all();
        $customRequests = CustomRequest::all();
        $projectInquiries = ProjectInquiry::all();
        $orders = Order::all();
        $consultationRequests = ConsultationRequest::orderBy('created_at', 'desc')->paginate(10);
        return view('admin-dashboard.consultation-requests', compact('consultationRequests', 'projectInquiries',  'users', 'products', 'customRequests', 'orders'));
    }
}
