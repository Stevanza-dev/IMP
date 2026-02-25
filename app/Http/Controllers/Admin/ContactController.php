<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contacts = Contact::all();
        return view('admin.contacts.index', compact('contacts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.contacts.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'phone' => 'required|string',
        ]);
        Contact::create($data);
        return redirect()->route('contacts.index')->with('success', 'Kontak berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contact $contact)
    {
        return view('admin.contacts.form', compact('contact'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Contact $contact)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'phone' => 'required|string',
        ]);
        $contact->update($data);
        return redirect()->route('contacts.index')->with('success', 'Kontak berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contact $contact)
    {
        // $contact->delete();
        return back()->with('success', 'Fungsi hapus dinonaktifkan.');
    }
}
