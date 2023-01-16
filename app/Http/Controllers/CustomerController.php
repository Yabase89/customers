<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use DB;

class CustomerController extends Controller
{
    public function __construct()
	{  
		if(Session::get('login_id') > 0)
		{  
			return redirect('/dashboard');
		} else { 
            return redirect('/');
        }
	}
    public function index()
	{   
        if(Session::get('login_id') > 0)
		{  
			return redirect('/dashboard');
		} 
        return view('index');
    }
    public function signin(Request $request)
    {
        $validatedata = $request->validate(
            [
                'username' => 'required|email',
                'password' => 'required'
            ]
        );
        $getUserID =  DB::table('admin')->where('email', $request->username)->where('password', md5($request->password))->where('status', '1')->first();
        $id = isset($getUserID) ? $getUserID->id: 0;
        if ($id > 0) {
            Session::put('login_id', $id);	
            Session::put('login_name', $getUserID->name);
            return redirect('/dashboard');
        } else {
            Session::flash('message','Username and password are mismatch');
            Session::flash('class','error');
            return back(); 
        }
        
    }
    public function dashboard()
    {   
        if(Session::get('login_id') > 0)
		{  
            $customers = DB::table('customer_list')->where('is_delete', '0')->orderby('id','desc')->paginate(10);
	      	return view('dashboard',compact('customers'));
		} else {
            return redirect('/');
        }
        
    }
    public function customerform()
    {
        if(Session::get('login_id') > 0)
		{  
            $gender_data = DB::table('gender')->where('status', '1')->orderby('id','asc')->get();
            $address_types = DB::table('addresstype')->where('status', '1')->orderby('id','asc')->get();
            $page_type = "Add";
			return view('customer',compact('gender_data','address_types','page_type'));
		} 
        return redirect('/');
    }
    public function getaddresstypes()
    {  
        $address_types = DB::table('addresstype')->where('status', '1')->orderby('id','asc')->get();
        $data = array();
        $address_html = '';
        foreach($address_types as $add) {
            $address_html .= '<option value="'.$add->id.'">'.$add->address_type.'</option>';
        }
        $data['address_types'] = $address_html;
        return $data;
    }
    public function customersave(Request $request)
    {   
        $validatedata = $request->validate(
            [
                'first_name' => 'required',
                'last_name' => 'required',
                'gender' => 'required',
                'mobile_number' => 'required|numeric|digits:10',
                'email' => 'required|email',
                'address_type.*' => 'required',
                'street_address.*' => 'required',
                'city.*' => 'required',
                'state.*' => 'required',
                'postcode.*' => 'required|numeric|digits:4',
                'primary.*' => 'required|in:1'
            ]
        );
        if ($request->primary == '') {
            Session::flash('message','Please select any one primary address');
            Session::flash('class','error');
            return back(); 
        }
        $first_name = $request->first_name;
        $last_name = $request->last_name;
        $gender = $request->gender;
        $mobile_number = $request->mobile_number;
        $email = $request->email;
        $primary_add = $request->primary;
        $total_address = $request->total_address;
        $main_data =  array('first_name'=>$first_name,'last_name'=>$last_name,'gender'=>$gender,'mobile_number'=>$mobile_number,'email'=>$email,'is_delete'=>0,'created_at'=>date('Y-m-d H:i:s'));
        $check_customer =  DB::table('customer_list')->where('email', $email)->where('is_delete', '0')->first();
        $customer_id = isset($check_customer) ? $check_customer->id: 0;
        if ($customer_id == 0) {
            $check_customer_mobile =  DB::table('customer_list')->where('mobile_number', $mobile_number)->where('is_delete', '0')->first();
            $customer_id = isset($check_customer_mobile) ? $check_customer_mobile->id: 0;
            if ($customer_id == 0) {
                $customer_save= DB::table('customer_list')->insert($main_data); 
                $customer_id = DB::getPdo()->lastInsertId();
                for ($i=0; $i < $total_address; $i++) { 
                    $address_type = $request->address_type[$i];
                    $street_address = $request->street_address[$i];
                    $city = $request->city[$i];
                    $state = $request->state[$i];
                    $postcode = $request->postcode[$i];
                    $address_type = $request->address_type[$i];
                    $is_primary = ($primary_add == $i) ? '1' : '0' ;
                    $address_data =  array('customer_id' => $customer_id,'address_type'=>$address_type,'street_address'=>$street_address,'city'=>$city,'state'=>$state,'postcode'=>$postcode,'is_primary'=>$is_primary,'created_at'=>date('Y-m-d H:i:s'));
                    DB::table('customer_address')->insert($address_data); 
                }
                Session::flash('message','Customer created successfully');
                Session::flash('class','success');
                return redirect('/dashboard');
            } else {
                Session::flash('message','Mobile number already exist');
                Session::flash('class','error');
                return back();
            }
            
        } else {
            Session::flash('message','Email ID already exist');
            Session::flash('class','error');
            return back();  
        }
        
    }
    public function editcustomer($id)
    {
        
        if(Session::get('login_id') > 0)
		{  
            $customer =  DB::table('customer_list')->where('id', $id)->where('is_delete', '0')->first();
            $customer_address =  DB::table('customer_address')->where('customer_id', $customer->id)->get();
            $gender_data = DB::table('gender')->where('status', '1')->orderby('id','asc')->get();
            $address_types = DB::table('addresstype')->where('status', '1')->orderby('id','asc')->get();
            $page_type = "Edit";
			return view('customer_edit',compact('gender_data','address_types','page_type','customer','customer_address','id'));
		} 
        return redirect('/');
    }
    public function customerupdate(Request $request)
    {
        $validatedata = $request->validate(
            [
                'first_name' => 'required',
                'last_name' => 'required',
                'gender' => 'required',
                'mobile_number' => 'required|numeric|digits:10',
                'email' => 'required|email',
                'address_type.*' => 'required',
                'street_address.*' => 'required',
                'city.*' => 'required',
                'state.*' => 'required',
                'postcode.*' => 'required|numeric|digits:4',
                'primary.*' => 'required|in:1'
            ]
        );
        if ($request->primary == '') {
            Session::flash('message','Please select any one primary address');
            Session::flash('class','error');
            return back(); 
        }
        $id = $request->customer_edit_id;
        $first_name = $request->first_name;
        $last_name = $request->last_name;
        $gender = $request->gender;
        $mobile_number = $request->mobile_number;
        $email = $request->email;
        $primary_add = $request->primary;
        $total_address = $request->total_address;
        $main_data =  array('first_name'=>$first_name,'last_name'=>$last_name,'gender'=>$gender,'mobile_number'=>$mobile_number,'email'=>$email,'is_delete'=>0,'updated_at'=>date('Y-m-d H:i:s'));
        $check_customer =  DB::table('customer_list')->where('email', $email)->where('is_delete', '0')->where('id', '!=', $id)->first();
        $customer_id = isset($check_customer) ? $check_customer->id: 0;
        if ($customer_id == 0) {
            $check_customer_mobile =  DB::table('customer_list')->where('mobile_number', $mobile_number)->where('is_delete', '0')->where('id', '!=', $id)->first();
            $customer_id = isset($check_customer_mobile) ? $check_customer_mobile->id: 0;
            if ($customer_id == 0) {
                $customer_update= DB::table('customer_list')->where('id', $id)->update($main_data); 
                for ($i=0; $i < $total_address; $i++) { 
                    $address_id = (isset($request->address_id[$i]))?$request->address_id[$i]:0;
                    $address_type = $request->address_type[$i];
                    $street_address = $request->street_address[$i];
                    $city = $request->city[$i];
                    $state = $request->state[$i];
                    $postcode = $request->postcode[$i];
                    $address_type = $request->address_type[$i];
                    $is_primary = ($primary_add == $i) ? '1' : '0' ;
                    $address_data =  array('customer_id' => $id,'address_type'=>$address_type,'street_address'=>$street_address,'city'=>$city,'state'=>$state,'postcode'=>$postcode,'is_primary'=>$is_primary);
                    if ($address_id > 0) {
                        $address_data['updated_at'] = date("Y-m-d H:i:s");
                        DB::table('customer_address')->where('id', $address_id)->update($address_data); 
                    } else {
                        $address_data['created_at'] = date("Y-m-d H:i:s");
                        DB::table('customer_address')->insert($address_data); 
                    }
                    
                    
                }
                Session::flash('message','Customer details updated successfully');
                Session::flash('class','success');
                return redirect('/dashboard');
            } else {
                Session::flash('message','Mobile number already exist');
                Session::flash('class','error');
                return back();
            }
            
        } else {
            Session::flash('message','Email ID already exist');
            Session::flash('class','error');
            return back();  
        }
        
    }
    public function customerdelete($id)
    {
        if(Session::get('login_id') > 0)
		{  
            $value = array('is_delete'=>1,'deleted_at'=>date('Y-m-d H:i:s'));
            DB::table('customer_list')->where('id', $id)->update($value); 
            Session::flash('message','Customer deleted successfully');
            Session::flash('class','success');
            return 'success';
		} else {
            return 'fail';
        }
    }
    public function logout()
    {
        session()->forget('login_id');
		session()->forget('login_firstname');
		session()->forget('login_lastname');
		session()->forget('login_type');
		return redirect('/');
    }
}
