<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
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

    //store listing data from store
    public function store(Request $request)
    {

        $formFieldsValidation = $request->validate([
            'title' => 'required',
            'company' => ['required', Rule::unique('listings', 'company')],
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags' => 'required',
            'salary' => 'string|nullable',
            'deadline' => 'string|nullable|date|after_or_equal:today', // Ensuring the date is today or in the future
            'description' => 'required',
            'requirements' => 'required'
        ]);

        // Check if the user's email is verified
        if (!auth()->user()->email_verified_at) {
            return redirect('/')->with('message', 'Account is not verified!');
        }

        // Handle file upload
        if ($request->hasFile('logo')) {
            $uploadedFileUrl = cloudinary()->upload($request->file('logo')->getRealPath())->getSecurePath();
            $formFieldsValidation['logo'] = $uploadedFileUrl;
        }

        $formFieldsValidation['user_id'] = auth()->id();

        // Check if the user is an admin or super-admin
        if (in_array(auth()->user()->role, ['admin', 'super-admin'])) {
            $formFieldsValidation['is_verified'] = true;
        }

        //create the datas into the listing model
        Listing::create($formFieldsValidation);

        // Session::flash('message', 'job created successfully');
        return redirect('/')->with('message', 'Post await admin approval!');
    }

    //Show edit form
    public function edit(Listing $listing)
    {
        return view('listings.edit', ['listing' => $listing]);
    }

    //update editted form
    public function update(Request $request, Listing $listing)
    {
        // Ensure logged in user is the owner before they could perform update operation
        if ($listing->user_id != auth()->id()) {
            abort(403, 'Unauthorized Action');
        }

        try {
            // Validate the form fields
            $formFieldsValidation = $request->validate([
                'title' => 'required',
                'company' => 'required',
                'location' => 'required',
                'website' => 'required',
                'email' => ['required', 'email'],
                'tags' => 'required',
                'salary' => 'string|nullable',
                'deadline' => 'string|nullable',
                'description' => 'required',
                'requirements' => 'required'
            ]);

            // Handle file upload
            if ($request->hasFile('logo')) {
                $uploadedFileUrl = Cloudinary::upload($request->file('logo')->getRealPath())->getSecurePath();
                $formFieldsValidation['logo'] = $uploadedFileUrl;
                Log::info('Logo uploaded URL:', ['logo' => $uploadedFileUrl]);
            }

            // Update the listing
            $listing->update($formFieldsValidation);

            Log::info('Listing updated successfully:', $listing->toArray());

            // Redirect with a success message
            return back()->with('message', 'Post updated!');
        } catch (\Exception $e) {
            // Log any exceptions that occur
            Log::error('Error updating listing:', ['message' => $e->getMessage()]);
            return back()->with('error', 'There was an error updating the post.');
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
        //making sure logged in user is the owner before they could perform delete operation
        if ($listing->user_id != auth()->id()) {
            abort(403, 'Unauthorized Action');
        }

        $listing->delete();
        return redirect('/')->with('message', 'Listing deleted Successfully!');
    }

    //Manage Listins
    public function manageListing()
    {
        return view('listings.manage', ['listings' => auth()->user()->listings()->get()]);
    }

    //Approve Listing
    public function approveListing(Listing $listing)
    {
        if (in_array(auth()->user()->role, ['admin', 'super-admin'])) {
            $listing->is_verified = true;
            $listing->save();
            return back()->with('message', 'Post approved successfully');
        }
    }
}
