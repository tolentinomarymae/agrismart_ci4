<?php

namespace App\Controllers;
use App\Models\RegisterModel;
use App\Controllers\BaseController;

class LoginController extends BaseController
{
   
    
    public function dashboards()
    {if(!session()->get('isLoggedIn')){
        return redirect()->to('/sign_ins');
    }
    else{
        
        return view ('userfolder/dashboard');
    }
    }
    public function register()
    {

        helper(['form']);

        $rules = [
            'farmer_name' => 'required|min_length[1]|max_length[100]',
            'idnumber' => 'required|min_length[1]|max_length[100]|is_unique[user.idnumber]',
            'password' => 'required|min_length[8]|max_length[100]',
            'repeat_password' => 'matches[password]'

        ];

        if ($this->validate($rules)) {
            $registermodel = new RegisterModel();

            $data = [
                'farmer_name' => $this->request->getVar('farmer_name'),
                'idnumber' => $this->request->getVar('idnumber'),
                'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
                'repeat_password' => password_hash($this->request->getVar('repeat_password'), PASSWORD_DEFAULT),
                'usertype' => $this->request->getVar('usertype')
            ];

            dd($registermodel);

            dd($registermodel->save($data));

            return redirect()->to('/sign_ins');

        } else {
            $data['validation'] = $this->validator;
            return view('signin-signup/register', $data);
        }
    }
    public function loginauth(){
        $session = session();
        $registermodel = new RegisterModel();
        $farmer_name = $this->request->getVar('farmer_name');
        $password = $this->request->getVar('password');


        $data = $registermodel->where('farmer_name', $farmer_name)->first();

        if($data){
            $pass = $data['password'];
            $authenticatePassword = password_verify($password, $pass);

            if ($authenticatePassword){
                $ses_data = [
                    'farmer_id' => $data['farmer_id'],
                    'farmer_name'=> $data['farmer_name'],
                    'isLoggedIn' => TRUE,
                    'usertype' => $data['usertype'],

                ];

                $session->set($ses_data);

                if($data['usertype'] === 'admin'){
                    return redirect()->to('/admindashboard');
                } 
                else if($data['usertype'] === 'farmer'){
                    return redirect()->to('/dashboards');
                }
            }else{
                $session->setFlashdata('msg', 'Name or Password is incorrect.');

                return redirect()->to('/sign_ins');
            }
        }
    }
    public function login(){
        session()->remove(['farmer_id', 'farmer_name', 'idnumber', 'isLoggedIn', 'usertype']);
        helper(['form']);
        return view('signin-signup/login');
    }
    public function registerview(){
        helper(['form']);
        $data=[];
        return view('signin-signup/register', $data);
    }
    public function admindashboard(){
        if(!session()->get('isLoggedIn')){
            return redirect()->to('/sign_ins');
        }
        else{
            
            return view('adminfolder/dashboard');
        }
    }
     public function croprotation()
    {
        if(!session()->get('isLoggedIn')){
            return redirect()->to('/sign_ins');
        }
        else{
            
            return view ('userfolder/croprotation');
        }
    }
    public function jobs()
    {
        if(!session()->get('isLoggedIn')){
            return redirect()->to('/sign_ins');
        }
        else{
            
            return view ('userfolder/jobs');
        }
    }
}
