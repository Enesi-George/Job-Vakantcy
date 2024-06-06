<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use App\Jobs\HandleFileUpload;
use App\Jobs\UploadImgLogoJob;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\ListingRequest;
use App\Http\Requests\EditListingRequest;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class ListingController extends Controller
{

    //Show all listings
    // public function index(){
    //     return view('listings.index', [
    //         'listings' => Listing::latest()->filter(request(['tag', 'search']))->get()
    //     ]);
    // }

    //implementing pagination(E.G SimplePaginate())
    public function index()
    {
        return view('listings.index', [
            'listings' => Listing::latest()->filter(request(['tag', 'search']))->paginate(6)
        ]);
    }



    //Show Create Form
    public function create()
    {
        return view('listings.create');
    }

    public function store(ListingRequest $request)
    {
        try {
            // Get the validated data as an array
            $formFieldsValidation = $request->ListingDTO()->toArray();

            // Check if the user's email is verified
            if (!auth()->user()->email_verified_at) {
                return redirect('/')->with('message', 'Account is not verified!');
            }

            $formFieldsValidation['user_id'] = auth()->id();

            // Check if the user is an admin or super-admin
            if (in_array(auth()->user()->role, ['admin', 'super-admin'])) {
                $formFieldsValidation['is_verified'] = true;
            }

            // Create the data into the listing model
            $listing = Listing::create($formFieldsValidation);

            // Handle file upload by dispatching a job
            if ($request->hasFile('logo')) {
                $logo = $request->file('logo');
                $filePath = $logo->store('temp/' . uniqid(), 'local'); // Save the file to a temporary location
                Log::info(['Controller: ' => $filePath]);
                UploadImgLogoJob::dispatch($filePath, auth()->id(), true); // Indicate it's a user ID
            }

            return redirect('/')->with('message', 'Post await admin approval!');
        } catch (\Exception $e) {
            Log::error('Create post Error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return redirect('/')->with('error', 'Error while creating post. Please contact the administrative.');
        }
    }

    //Show edit form
    public function edit(Listing $listing)
    {
        return view('listings.edit', ['listing' => $listing]);
    }

    //update editted form
    public function update(EditListingRequest $request, Listing $listing)
    {
        // Ensure the logged-in user is the owner before they can perform the update operation
        if ($listing->user_id != auth()->id()) {
            abort(403, 'Unauthorized Action');
        }

        try {
            // Get the validated data as an array
            $formFieldsValidation = $request->ListingDTO()->toArray();

            // Update the listing with the validated data
            $listing->update($formFieldsValidation);

            // Handle file upload by dispatching a job
            if ($request->hasFile('logo')) {
                $logo = $request->file('logo');
                $filePath = $logo->store('temp/' . uniqid(), 'local'); // Save the file to a temporary location
                Log::info(['Controller: ' => $filePath]);
                UploadImgLogoJob::dispatch($filePath, $listing->id, false); // Indicate it's a listing ID
            }

            Log::info('Listing updated successfully:', $listing->toArray());

            // Redirect with a success message
            return back()->with('message', 'Post updated!');
        } catch (\Exception $e) {
            Log::error('Edit post error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return back()->with('error', 'Error while editing post. Please contact the administrative.');
        }
    }


    //show single Listing
    public function show(Listing $listing)
    {
        return view('listings.show', [
            'listing' => $listing
        ]);
    }
    //delete single listing
    public function destroy(Listing $listing)
    {
        try {
            //making sure logged in user is the owner before they could perform delete operation
            if ($listing->user_id != auth()->id()) {
                abort(403, 'Unauthorized Action');
            }

            $listing->delete();
            return redirect('/')->with('message', 'Listing deleted Successfully!');
        } catch (\Exception $e) {
            Log::error('delete post error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return redirect('/')->with('error', 'Error while deleting post. Please contact the administrative.');
        }
    }

    //Manage Listins
    public function manageListing()
    {
        /** @var User $user */
        $user = auth()->user();
        return view('listings.manage', ['listings' => $user->listings()->get()]);
    }
}
