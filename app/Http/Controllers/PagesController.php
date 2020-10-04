<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use DB;
use App\Hospital;
use App\Doctor;
use App\User;
use App\Appointment;
use Session;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Hash;

class PagesController extends Controller
{
    public function index()
    {
        return view('pages.home')->with('title', 'Find Doctors');
    }

    public function profile()
    {
        return view('pages.profile')->with('title', 'Find Doctors');
    }

    public function registerOption()
    {
        return view('pages.registerOption')->with('title', 'Find Doctors');
    }
    

    public function doctors()
    {
        $result = DB::select('select * from doctors');
        return view('pages.doctors')->with('data', $result)->with('title', 'Doctors');
    }


    public function nearbyHospitals()
    {
        $result = DB::select('select * from hospitals');
        return view('pages.nearbyHospitals')->with('result', $result)->with('title', 'Hospitals');
    }


    public function hospital(Request $request)
    {
        
        $id = $request->query('id');
        $result = DB::select('select * from hospitals where id='.$id);
        return view('pages.nearbyHospitals')->with('result', $result)->with('title', 'Hospitals');
    }

    public function hospitals()
    {
        $result = DB::select('select * from hospitals');
        return view('pages.hospitals')->with('result', $result)->with('title', 'Hospitals');
    }

    public function hospitalForm()
    {
        return view('admin.hospitalForm')->with('title', 'Hospitals');
    }

    public function createHospital(Request $request)
    {
       
        $data = $request->all();

        $validator = Validator::make($data, [
            'name' => ['required', 'string'],
            'category' => ['required', 'string'],
            'contact' => ['required', 'string'],
            'lat' => ['required', 'numeric'],
            'lng' => ['required', 'numeric']
        ]);
          
        if ($validator->fails()) {
            return redirect('hospital/create')
                ->withErrors($validator)
                ->withInput();
        }

        try{
            $hospital = new Hospital;
            $hospital->name = $request->input('name');
            $hospital->category = $request->input('category');
            $hospital->contact = $request->input('contact');
            $hospital->lat = (float) $request->input('lat');
            $hospital->lng = (float) $request->input('lng');
            $hospital->save();
        }
        catch(Exception $e){
            Session::flash('message', "operation failed")->with('title', 'Hospitals');
            return redirect('hospital/create');
        }
        Session::flash('message', "Inserted");
        return redirect('hospital/create')->with('message', 'Inserted')->with('title', 'Hospitals');
    }


    public function doctorForm()
    {
        $result = DB::select('select * from hospitals');
        return view('pages.doctorForm')->with('result', $result)->with('title', 'Doctors');
    }

    public function createDoctor(Request $request)
    {

        $data = $request->all();

        $validator = Validator::make($data, [
            'name' => ['required', 'string'],
            'title' => ['required', 'string'],
            'specialities' => ['required', 'string'],
            'v_hour' => ['required', 'string'],
            'v_day' => ['required', 'string'],
            'hospital_id' => ['required', 'numeric']
        ]);



        if ($validator->fails()) {
            return redirect('doctor/register')
                ->withErrors($validator)
                ->withInput();
        }

        try{
            $doctor = new Doctor;
            $doctor->name = $request->input('name');
            $doctor->email = $request->input('email');
            $doctor->title = $request->input('title');
            $doctor->specialities = $request->input('specialities');
            $doctor->v_hour = $request->input('v_hour');
            $doctor->v_day = $request->input('v_day');
            $doctor->hospital_id = (int) $request->input('hospital_id');

            $doctor->save();
        }
        catch(Exception $e){
            Session::flash('message', "operation failed");
            return redirect('doctor/register')->with('title', 'Doctors');
        }
        Session::flash('message', "Registerd");

        User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'is_doctor' => 1,
            'password' => Hash::make($request->input('password'))
        ]);

        return redirect('/');
    }

    public function findDoctors(Request $request)
    {
        $specialities = $request->input('specialities');
        $result = DB::select("select * from doctors where specialities='".$specialities."'");
        return view('pages.doctors')->with('data', $result)->with('title', "Dcotors");
    }


    public function about()
    {
        return view('pages.aboutUs')->with('title', 'About Us');
    }

    public function appointment(Request $request)
    {
        
        $id = $request->query('id');
        return view('pages.appointment')->with('id', $id)->with('title', 'Appointments');
    }

    public function createAppointment(Request $request)
    {
        
        $data = $request->all();

        $validator = Validator::make($data, [
            'details' => ['required', 'string'],
        ]);



        if ($validator->fails()) {
            return redirect('/doctor/appointment')
                ->withErrors($validator)
                ->withInput();
        }

        try{
            $appointment = new Appointment;
            $appointment->details = $request->input('details');
            $appointment->date = date('Y-m-d');
            $appointment->doctors_id = (int) $request->input('doctor_id');
            $appointment->user_id = Auth::user()->id;
            $appointment->save();
        }
        catch(Exception $e){
            Session::flash('message', "operation failed");
            return redirect('doctor/appoinment')->with('title', 'Appointment');
        }
        Session::flash('message', "Successfull");

        return redirect('/doctors');
    }
}
