<?php

namespace App\Controllers;

use App\Models\RegisterModel;
use App\Controllers\BaseController;

class LoginController extends BaseController
{

    private $field;
    private $jobs;
    private $harvest;
    private $user;
    private $planting;
    private $worker;
    private $variety;

    public function __construct()
    {
        $this->field = new \App\Models\VIewFieldsModel();
        $this->jobs = new \App\Models\JobsModel();
        $this->harvest = new \App\Models\HarvestModel();
        $this->user = new \App\Models\RegisterModel();
        $this->planting = new \App\Models\PlantingModel();
        $this->worker = new \App\Models\WorkerModel();
        $this->variety = new \App\Models\VarietyModel();
    }
    public function dashboards()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/logins');
        }

        $userId = session()->get('farmer_id');

        $currentYear = date('Y');


        // total na naani
        $resultQuantity = $this->harvest
            ->selectSum('harvest_quantity', 'totalHarvestQuantity')
            ->where('user_id', $userId)
            ->get();
        $totalHarvestQuantity = $resultQuantity->getRow()->totalHarvestQuantity;


        // kita ngayong taon
        $resultRevenue = $this->harvest
            ->selectSum('total_revenue', 'totalRevenueThisYear')
            ->where('user_id', $userId)
            ->where('YEAR(harvest_date)', $currentYear)
            ->get();

        // Count of binhi
        $totalVarieties = $this->variety
            ->selectSum('quantity', 'totalVarieties')
            ->where('user_id', $userId)
            ->get();
        $totalBinhiCount = $totalVarieties->getRow()->totalVarieties;


        $totalRevenueThisYear = $resultRevenue->getRow()->totalRevenueThisYear;
        $harvestData = $this->harvest->where('user_id', $userId)->findAll();
        $revenueData = $this->harvest->where('user_id', $userId)->findAll();
        $workerData = $this->worker->where('user_id', $userId)->findAll();

        $data = [
            'totalHarvestQuantity' => $totalHarvestQuantity,
            'totalRevenueThisYear' => $totalRevenueThisYear,
            'harvest' => $harvestData,
            'totalBinhiCount' => $totalBinhiCount,
            'revenue' => $revenueData,
            'worker' => $workerData,

        ];

        return view('userfolder/dashboard', $data);
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
    public function loginauth()
    {
        $session = session();
        $registermodel = new RegisterModel();
        $farmer_name = $this->request->getVar('farmer_name');
        $password = $this->request->getVar('password');


        $data = $registermodel->where('farmer_name', $farmer_name)->first();

        if ($data) {
            $pass = $data['password'];
            $authenticatePassword = password_verify($password, $pass);

            if ($authenticatePassword) {
                $ses_data = [
                    'farmer_id' => $data['farmer_id'],
                    'farmer_name' => $data['farmer_name'],
                    'isLoggedIn' => TRUE,
                    'usertype' => $data['usertype'],

                ];

                $session->set($ses_data);

                if ($data['usertype'] === 'Admin') {
                    return redirect()->to('/admindashboard');
                } else if ($data['usertype'] === 'Farmer') {
                    return redirect()->to('/dashboards');
                }
            } else {
                $session->setFlashdata('msg', 'Name or Password is incorrect.');

                return redirect()->to('/sign_ins');
            }
        }
    }
    public function login()
    {
        session()->remove(['farmer_id', 'farmer_name', 'idnumber', 'isLoggedIn', 'usertype']);
        helper(['form']);
        return view('signin-signup/login');
    }
    public function registerview()
    {
        helper(['form']);
        $data = [];
        return view('signin-signup/register', $data);
    }
    public function admindashboard()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/sign_ins');
        } else {

            return view('adminfolder/dashboard');
        }
    }
}
