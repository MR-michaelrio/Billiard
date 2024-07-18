<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use Carbon\Carbon;
class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $members = Member::all();
        return view('member.index',compact('members'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('member.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        // $request->validate([
        do {
            $id_member = 'M' . rand(1, 1000000000);
        } while (Member::where('id_member', $id_member)->exists());

        $mulai_member_date = Carbon::createFromFormat('Y-m-d', $request->mulai_member);
        $durasi = (int) $request->durasi;
        $akhir_member_date = (clone $mulai_member_date)->addMonths($durasi);
        $akhir_member = $akhir_member_date->format('Y-m-d');
    
        Member::create([
            'id_member' => $id_member,
            'nama' => $request->nama,
            'no_telp' => $request->no_telp,
            'alamat' => $request->alamat,
            'tanggal_lahir' => $request->tanggal_lahir,
            'mulai_member' => $mulai_member_date->format('Y-m-d'),
            'akhir_member' => $akhir_member, 
        ]);
    
        return redirect()->route('member.index');
        
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
    public function edit(string $id)
    {
        //
        $Member = Member::where('id_member',$id)->first();
        return view('member.edit',compact('Member'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $Member = Member::where('id_member', $id)->firstOrFail();

        $mulai_member_date = Carbon::createFromFormat('Y-m-d', $request->mulai_member);
        $durasi = (int) $request->durasi;
        $akhir_member_date = (clone $mulai_member_date)->addMonths($durasi);
        $akhir_member = $akhir_member_date->format('Y-m-d');

        $Member->update([
            'nama' => $request->nama,
            'no_telp' => $request->no_telp,
            'alamat' => $request->alamat,
            'tanggal_lahir' => $request->tanggal_lahir,
            'mulai_member' => $mulai_member_date->format('Y-m-d'),
            'akhir_member' => $akhir_member, 
        ]);
        return redirect()->route('member.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $Member = Member::where('id_member', $id)->get();

        $Member->each->delete();
        return redirect()->route('member.index');
    }
}
