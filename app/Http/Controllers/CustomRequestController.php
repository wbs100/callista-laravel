<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CustomRequest;
use App\Models\Product;
use App\Models\User;
use App\Models\UserOrder;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;

class CustomRequestController extends Controller
{
    /**
     * Show the custom request form
     */
    public function index()
    {
        return view('public-site.customize');
    }

    /**
     * Store a new custom request
     */
    public function store(Request $request)
    {
        try {
            // Validate the request
            $validated = $request->validate([
                'fullName' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'phone' => 'required|string|max:20',
                'furnitureType' => 'required|string|max:255',
                'dimensions' => 'nullable|string|max:255',
                'materials' => 'nullable|string|max:255',
                'designDescription' => 'required|string|max:2000',
                'referenceImages.*' => 'nullable|image|mimes:jpeg,jpg,png|max:10240', // 10MB max per image
                'budget' => 'nullable|string'
            ]);

            // Handle file uploads
            $imagePaths = [];
            
            // Check if files are uploaded
            if ($request->hasFile('referenceImages')) {
                // Create directory if it doesn't exist
                $uploadDir = public_path('uploads/custom-reqs');
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }

                $files = $request->file('referenceImages');
                
                // Handle array of files
                if (is_array($files)) {
                    foreach ($files as $index => $image) {
                        if ($image && $image->isValid()) {
                            // Generate unique filename
                            $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                            
                            // Move file to directory
                            if ($image->move($uploadDir, $filename)) {
                                $imagePaths[] = 'uploads/custom-reqs/' . $filename;
                            }
                        }
                    }
                } else {
                    // Handle single file
                    if ($files && $files->isValid()) {
                        $filename = time() . '_' . uniqid() . '.' . $files->getClientOriginalExtension();
                        if ($files->move($uploadDir, $filename)) {
                            $imagePaths[] = 'uploads/custom-reqs/' . $filename;
                        }
                    }
                }
            }

            // Create the custom request
            $customRequest = CustomRequest::create([
                'full_name' => $validated['fullName'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'furniture_type' => $validated['furnitureType'],
                'dimensions' => $validated['dimensions'],
                'materials' => $validated['materials'],
                'design_description' => $validated['designDescription'],
                'reference_images' => $imagePaths,
                'budget' => $validated['budget'],
                'status' => 'pending'
            ]);

            // Return success response
            return response()->json([
                'success' => true,
                'message' => 'Your custom furniture request has been submitted successfully! We will contact you within 24-48 hours.',
                'requestId' => $customRequest->id
            ]);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Please check your form data.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error('Custom Request Error: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while submitting your request. Please try again.',
                'error' => config('app.debug') ? $e->getMessage() : 'Internal server error'
            ], 500);
        }
    }

    /**
     * Get all custom requests for admin
     */
    public function adminIndex(Request $request)
    {
        // Ensure only admins can access
        if (auth()->user()->role !== 'admin') {
            return redirect()->route('dashboard')->with('error', 'Access denied. Admin privileges required.');
        }

        $query = CustomRequest::query();
        
        // Filter by status if provided
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        // Search by name or email
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('full_name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%')
                  ->orWhere('furniture_type', 'like', '%' . $request->search . '%');
            });
        }

        $customRequests = $query->orderBy('created_at', 'desc')->paginate(10);
        $customRequests->appends($request->query());

        $users = User::orderBy('created_at', 'desc')->paginate(10);
        $products = Product::all();
        $orders = UserOrder::all();

        return view('admin-dashboard.custom-requests', compact('customRequests', 'users', 'products', 'orders'));
    }

    /**
     * Show a specific custom request
     */
    public function show($id)
    {
        // Ensure only admins can access
        if (auth()->user()->role !== 'admin') {
            return redirect()->route('dashboard')->with('error', 'Access denied. Admin privileges required.');
        }

        $customRequest = CustomRequest::findOrFail($id);
        return view('admin-dashboard.custom-request-details', compact('customRequest'));
    }

    /**
     * Update a custom request (admin only)
     */
    public function update(Request $request, $id)
    {
        // Ensure only admins can access
        if (auth()->user()->role !== 'admin') {
            return response()->json(['error' => 'Access denied'], 403);
        }

        try {
            $customRequest = CustomRequest::findOrFail($id);
            
            $validated = $request->validate([
                'status' => 'required|in:pending,reviewing,quoted,approved,in_progress,completed,cancelled',
                'admin_notes' => 'nullable|string|max:2000',
                'quoted_price' => 'nullable|numeric|min:0'
            ]);

            $customRequest->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Custom request updated successfully!',
                'customRequest' => $customRequest
            ]);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating the request.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete a custom request (admin only)
     */
    public function destroy($id)
    {
        // Ensure only admins can access
        if (auth()->user()->role !== 'admin') {
            return response()->json(['error' => 'Access denied'], 403);
        }

        try {
            $customRequest = CustomRequest::findOrFail($id);
            
            // Delete associated images
            if ($customRequest->reference_images) {
                foreach ($customRequest->reference_images as $imagePath) {
                    $fullPath = public_path($imagePath);
                    if (file_exists($fullPath)) {
                        unlink($fullPath);
                    }
                }
            }
            
            $customRequest->delete();

            return response()->json([
                'success' => true,
                'message' => 'Custom request deleted successfully!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while deleting the request.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
