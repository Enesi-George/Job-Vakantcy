<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Listing;
use App\Jobs\UploadImgLogoJob;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\ListingRequest;
use Illuminate\Support\Facades\Storage;
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

            $formFieldsValidation = $request->validate([
                'title' => 'required',
                'company' => ['required'],
                'location' => 'required',
                'website' => 'required',
                'email' => ['required', 'email'],
                'tags' => 'required',
                'salary' => 'string|nullable',
                'deadline' => 'string|nullable|date|after_or_equal:today',
                'description' => 'required',
                'requirements' => 'required'
            ]);

            // Check if the user's email is verified
            if (!auth()->user()->email_verified_at) {
                return redirect('/listings/create')->with('error', 'Account is not verified!. Please verify to continue');
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
                // $filePath = $logo->store('temp/' . uniqid(), 'local'); // Save the file to a temporary location
                // Log::info(['Controller: ' => $filePath]);
                // UploadImgLogoJob::dispatch($filePath, auth()->id(), true); // Indicate it's a user ID

                // if (!Storage::exists($filePath)) {
                //     Log::error('File does not exist', ['filePath' => $filePath]);
                //     return;
                // }

                // $fileRealPath = Storage::path($filePath);
                $uploadedFileUrl = Cloudinary::upload($request->file('logo')->getRealPath())->getSecurePath();
                $formFieldsValidation['logo'] = $uploadedFileUrl;

                Log::info(['Job cloudinary url' => $uploadedFileUrl]);

                $identifier = auth()->id();
                $isUserId = true;


                // Update the listing with the logo URL
                $listing = $isUserId
                    ? Listing::where('user_id', $identifier)->latest()->first()
                    : Listing::find($identifier);

                if ($listing) {
                    $listing->logo = $uploadedFileUrl;
                    $listing->save();
                }

                // // Delete the temporary file
                // Storage::delete($filePath);
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
            return redirect("/listings/{$listing->id}")->with('message', 'Post updated!');
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

            $user = User::query()->where('id', $listing->user_id)->get();
            //making sure logged in user is the owner before they could perform delete operation
            if ($listing->user_id != auth()->id() && auth()->user() != in_array(auth()->user()->role, ['admin', 'super-admin'])) {
                abort(403, 'Unauthorized Action');
            }

            // if (auth()->user()->role != in_array(auth()->user()->role, ['admin', 'super-admin'])) {
            //     AdminDisapprovedListJob::dispatch($user);
            // }
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
