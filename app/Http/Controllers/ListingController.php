<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
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
            'description' => 'required'
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
        return redirect('/')->with('message', 'job created successfully!');
    }

    //Show edit form
    public function edit(Listing $listing)
    {
        return view('listings.edit', ['listing' => $listing]);
    }

    //update editted form
    public function update(Request $request, Listing $listing)
    {

        //making sure logged in user is the owner before they could perform update operation
        if ($listing->user_id != auth()->id()) {
            abort(403, 'Unauthorized Action');

            // Session::flash('message', 'job created successfully');
            // return back()->with('message', 'job updated successfully!');
        }

        $formFieldsValidation = $request->validate([
            'title' => 'required',
            'company' => 'required',
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags' => 'required',
            'description' => 'required'
        ]);

        // Handle file upload
        if ($request->hasFile('logo')) {
            $uploadedFileUrl = Cloudinary::upload($request->file('logo')->getRealPath())->getSecurePath();
            $formFieldsValidation['logo'] = $uploadedFileUrl;
        }

        $listing->update($formFieldsValidation);

        // Session::flash('message', 'job created successfully');
        return back()->with('message', 'job updated successfully!');
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
}
