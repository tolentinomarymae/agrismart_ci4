<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CropRotationModel;
use App\Models\VIewFieldsModel;
use App\Models\JobsModel;
use App\Models\HarvestModel;
use App\Models\FertilizersModel;

class DashboardController extends BaseController
{
    private $field;
    private $jobs;
    private $harvest;
    private $planting;
    private $worker;
    private $variety;
    private $fertilizers;
    private $equipment;
    private $prof;

    public function __construct()
    {
        $this->field = new \App\Models\VIewFieldsModel();
        $this->jobs = new \App\Models\JobsModel();
        $this->harvest = new \App\Models\HarvestModel();
        $this->planting = new \App\Models\PlantingModel();
        $this->worker = new \App\Models\WorkerModel();
        $this->variety = new \App\Models\VarietyModel();
        $this->fertilizers = new \App\Models\FertilizersModel();
        $this->equipment = new \App\Models\EquipmentModel();
        $this->prof = new \App\Models\FarmelProfileModel();
    }

    //dashboard

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
        $totalRevenueThisYear = $resultRevenue->getRow()->totalRevenueThisYear;

        // Count of binhi
        $totalVarieties = $this->variety
            ->selectSum('quantity', 'totalVarieties')
            ->where('user_id', $userId)
            ->get();
        $totalBinhiCount = $totalVarieties->getRow()->totalVarieties;

        // Total money spent from jobs table
        $resultMoneySpent = $this->jobs
            ->selectSum('total_money_spent', 'totalMoneySpent')
            ->where('user_id', $userId)
            ->get();
        $totalMoneySpent = $resultMoneySpent->getRow()->totalMoneySpent;
        // Monthly revenue data
        $monthlyRevenue = $this->harvest
            ->select('YEAR(harvest_date) as year, MONTH(harvest_date) as month, SUM(total_revenue) as totalRevenue')
            ->where('user_id', $userId)
            ->groupBy('YEAR(harvest_date), MONTH(harvest_date)')
            ->findAll();

        // Extracting labels and data for the chart
        $monthlyLabels = array_map(function ($item) {
            return date('F Y', strtotime($item['year'] . '-' . $item['month'] . '-01'));
        }, $monthlyRevenue);

        $monthlyData = array_column($monthlyRevenue, 'totalRevenue');


        $harvestData = $this->harvest->where('user_id', $userId)->findAll();
        $revenueData = $this->harvest->where('user_id', $userId)->findAll();
        $workerData = $this->worker->where('user_id', $userId)->findAll();

        $data = [
            'totalHarvestQuantity' => $totalHarvestQuantity,
            'totalRevenueThisYear' => $totalRevenueThisYear,
            'harvest' => $harvestData,
            'totalBinhiCount' => $totalBinhiCount,
            'totalMoneySpent' => $totalMoneySpent,
            'worker' => $workerData,
            'monthlyLabels' => $monthlyLabels,
            'monthlyData' => $monthlyData,
        ];

        return view('userfolder/dashboard', $data);
    }

    // fields
    public function viewfields()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/sign_ins');
        }
        $userId = session()->get('farmer_id');

        $data = [
            'field' => $this->field->where('user_id', $userId)->findAll()
        ];
        return view('userfolder/viewfields', $data);
    }
    public function addnewfield()
    {
        $userId = session()->get('farmer_id');
        $username = session()->get('farmer_name');

        $validation = $this->validate([
            'field_name' => 'required',
            'field_address' => 'required',
            'field_total_area' => 'required',
        ]);

        if (!$validation) {
            return view('userfolder/viewfields', ['validation' => $this->validator]);
        }

        $this->field->save([
            'field_name' => $this->request->getPost('field_name'),
            'field_owner' => $this->request->getPost('field_owner'),
            'field_address' => $this->request->getPost('field_address'),
            'field_total_area' => $this->request->getPost('field_total_area'),
            'user_id' => $userId,
            'farmer_name' => $username,

        ]);

        return redirect()->to('/viewfields')->with('success', 'Field added successfully');
    }

    public function edit($field_id)
    {
        $model = new VIewFieldsModel();
        $field = $model->find($field_id);

        return view('field', ['field' => $field]);
    }
    public function update()
    {
        $model = new VIewFieldsModel();

        $field_id = $this->request->getPost('field_id');

        $dataToUpdate = [
            'field_name' => $this->request->getPost('field_name'),
            'field_owner' => $this->request->getPost('field_owner'),
            'field_address' => $this->request->getPost('field_address'),
            'field_total_area' => $this->request->getPost('field_total_area'),
        ];

        $model->update($field_id, $dataToUpdate);

        return redirect()->to('/viewfields')->with('success', 'Field updated successfully');
    }
    public function deleteProduct($field_id)
    {
        $model = new VIewFieldsModel();

        $field = $model->find($field_id);

        if ($field) {
            $model->delete($field_id);

            return redirect()->to('/viewfields')->with('success', 'field deleted successfully');
        } else {
            return redirect()->to('/viewfields')->with('error', 'field not found');
        }
    }

    //crop planting
    public function cropplanting()
    {
        $userId = session()->get('farmer_id');
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/sign_ins');
        } else {
            $data = [
                'planting' => $this->planting->where('user_id', $userId)->findAll()
            ];
            return view('userfolder/cropplanting', $data);
        }
    }
    public function addnewplanting()
    {
        $userId = session()->get('farmer_id');
        $username = session()->get('farmer_name');

        $validation = $this->validate([
            'field_name' => 'required',
            'crop_variety' => 'required',
        ]);

        if (!$validation) {
            return view('userfolder/viewfields', ['validation' => $this->validator]);
        }

        $this->planting->save([
            'field_id' => $this->request->getPost('field_id'),
            'field_name' => $this->request->getPost('field_name'),
            'crop_variety' => $this->request->getPost('crop_variety'),
            'planting_date' => $this->request->getPost('planting_date'),
            'season' => $this->request->getPost('season'),
            'start_date' => $this->request->getPost('start_date'),
            'end_date' => $this->request->getPost('end_date'),
            'notes' => $this->request->getPost('notes'),
            'user_id' => $userId,
            'farmer_name' => $username,
        ]);

        return redirect()->to('/cropplanting')->with('success', 'Field added successfully');
    }

    public function editplanting($planting_id)
    {
        $planting = $this->planting->find($planting_id);

        return view('planting', ['planting' => $planting]);
    }
    public function updateplanting()
    {

        $planting_id = $this->request->getPost('planting_id');

        $dataToUpdate = [
            'field_name' => $this->request->getPost('field_name'),
            'crop_variety' => $this->request->getPost('crop_variety'),
            'planting_date' => $this->request->getPost('planting_date'),
            'season' => $this->request->getPost('season'),
            'start_date' => $this->request->getPost('start_date'),
            'end_date' => $this->request->getPost('end_date'),
            'notes' => $this->request->getPost('notes'),
        ];

        // Update the product in the database using the update() method
        $this->planting->update($planting_id, $dataToUpdate);

        // Redirect back to the product list or a success page
        return redirect()->to('/cropplanting')->with('success', 'Field updated successfully');
    }
    public function deleteplanting($planting_id)
    {

        $planting = $this->planting->find($planting_id);

        if ($planting) {
            $this->planting->delete($planting_id);
            return redirect()->to('/cropplanting')->with('success', 'field deleted successfully');
        } else {
            return redirect()->to('/cropplanting')->with('error', 'field not found');
        }
    }

    //jobs

    public function jobs()
    {
        $userId = session()->get('farmer_id');
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/sign_ins');
        } else {
            $data = [
                'jobs' => $this->jobs->where('user_id', $userId)->findAll()
            ];
            return view('userfolder/jobs', $data);
        }
    }
    public function addnewjob()
    {
        $userId = session()->get('farmer_id');
        $username = session()->get('farmer_name');

        $validation = $this->validate([
            'job_name' => 'required',
            'field_name' => 'required',
            'finished_date' => 'required',
            'worker_name' => 'required',
            'total_money_spent' => 'required',
            'notes' => 'required',
        ]);

        if (!$validation) {
            return view('userfolder/jobs', ['validation' => $this->validator]);
        }

        $this->jobs->save([
            'job_name' => $this->request->getPost('job_name'),
            'field_id' => $this->request->getPost('field_id'),
            'field_name' => $this->request->getPost('field_name'),
            'finished_date' => $this->request->getPost('finished_date'),
            'worker_name' => $this->request->getPost('worker_name'),
            'total_money_spent' => $this->request->getPost('total_money_spent'),
            'notes' => $this->request->getPost('notes'),
            'user_id' => $userId,
            'farmer_name' => $username,

        ]);

        return redirect()->to('/jobs')->with('success', 'Job added successfully');
    }


    public function editjob($job_id)
    {
        $model = new JobsModel();
        $jobs = $model->find($job_id);

        return view('jobs', ['jobs' => $jobs]);
    }
    public function updatejob()
    {
        $model = new JobsModel();

        $job_id = $this->request->getPost('job_id');

        $dataToUpdate = [
            'job_name' => $this->request->getPost('job_name'),
            'field_name' => $this->request->getPost('field_name'),
            'finished_date' => $this->request->getPost('finished_date'),
            'worker_name' => $this->request->getPost('worker_name'),
            'total_money_spent' => $this->request->getPost('total_money_spent'),
            'notes' => $this->request->getPost('notes'),
        ];

        $model->update($job_id, $dataToUpdate);

        return redirect()->to('/jobs')->with('success', 'Job updated successfully');
    }
    public function deleteJob($job_id)
    {
        $model = new JobsModel();

        $jobs = $model->find($job_id);

        if ($jobs) {
            $model->delete($job_id);
            return redirect()->to('/jobs')->with('success', 'jobs deleted successfully');
        } else {
            return redirect()->to('/jobs')->with('error', 'jobs not found');
        }
    }

    //harvest

    public function harvest()
    {
        $userId = session()->get('farmer_id');
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/sign_ins');
        }
        $data = [
            'harvest' => $this->harvest->where('user_id', $userId)->findAll()
        ];
        return view('userfolder/harvest', $data);
    }
    public function addnewharvest()
    {
        $userId = session()->get('farmer_id');

        $validation = $this->validate([
            'field_name' => 'required',
            'variety_name' => 'required',
            'harvest_quantity' => 'required',
            'total_revenue' => 'required',
            'harvest_date' => 'required',
            'notes' => 'required',

        ]);

        if (!$validation) {
            return view('userfolder/harvest', ['validation' => $this->validator]);
        }

        $this->harvest->save([
            'field_id' => $this->request->getPost('field_id'),
            'field_name' => $this->request->getPost('field_name'),
            'variety_name' => $this->request->getPost('variety_name'),
            'harvest_quantity' => $this->request->getPost('harvest_quantity'),
            'total_revenue' => $this->request->getPost('total_revenue'),
            'harvest_date' => $this->request->getPost('harvest_date'),
            'notes' => $this->request->getPost('notes'),
            'user_id' => $userId,

        ]);

        return redirect()->to('/harvest')->with('success', 'Harvest added successfully');
    }


    public function editharvest($harvest_id)
    {
        $model = new HarvestModel();
        $harvest = $model->find($harvest_id);

        return view('harvest', ['harvest' => $harvest]);
    }
    public function updateharvest()
    {
        $model = new HarvestModel();

        $harvest_id = $this->request->getPost('harvest_id');

        $dataToUpdate = [
            'field_name' => $this->request->getPost('field_name'),
            'variety_name' => $this->request->getPost('variety_name'),
            'harvest_quantity' => $this->request->getPost('harvest_quantity'),
            'total_revenue' => $this->request->getPost('total_revenue'),
            'harvest_date' => $this->request->getPost('harvest_date'),
            'notes' => $this->request->getPost('notes'),
        ];

        $model->update($harvest_id, $dataToUpdate);

        return redirect()->to('/harvest')->with('success', 'Harvest updated successfully');
    }
    public function deleteHarvest($harvest_id)
    {
        $model = new HarvestModel();

        $jobs = $model->find($harvest_id);

        if ($jobs) {
            $model->delete($harvest_id);

            return redirect()->to('/harvest')->with('success', 'Harvest deleted successfully');
        } else {
            return redirect()->to('/harvest')->with('error', 'harvest not found');
        }
    }
    // worker
    public function worker()
    {
        $userId = session()->get('farmer_id');
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/sign_ins');
        } else {
            $data = [
                'worker' => $this->worker->where('user_id', $userId)->findAll()
            ];
            return view('userfolder/worker', $data);
        }
    }
    public function addnewworker()
    {
        $userId = session()->get('farmer_id');

        $validation = $this->validate([
            'worker_name' => 'required',
            'salaryperday' => 'required',
        ]);

        if (!$validation) {
            return view('userfolder/worker', ['validation' => $this->validator]);
        }

        $this->worker->save([
            'worker_name' => $this->request->getPost('worker_name'),
            'salaryperday' => $this->request->getPost('salaryperday'),
            'user_id' => $userId,
        ]);

        return redirect()->to('/workers')->with('success', 'Harvest added successfully');
    }

    public function editworker($worker_id)
    {
        $worker = $this->worker->find($worker_id);

        return view('worker', ['worker' => $worker]);
    }
    public function updateworker()
    {
        $worker_id = $this->request->getPost('worker_id');

        $dataToUpdate = [
            'worker_name' => $this->request->getPost('worker_name'),
            'salaryperday' => $this->request->getPost('salaryperday'),
        ];

        $this->worker->update($worker_id, $dataToUpdate);

        return redirect()->to('/workers')->with('success', 'Harvest updated successfully');
    }
    public function deleteworker($worker_id)
    {
        $worker = $this->worker->find($worker_id);

        if ($worker) {
            $this->worker->delete($worker_id);

            return redirect()->to('/workers')->with('success', 'Harvest deleted successfully');
        } else {
            return redirect()->to('/worker')->with('error', 'harvest not found');
        }
    }
    public function cropvariety()
    {
        $userId = session()->get('farmer_id');
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/sign_ins');
        } else {
            $data = [
                'variety' => $this->variety->where('user_id', $userId)->findAll()
            ];
            return view('userfolder/cropvariety', $data);
        }
    }
    public function addnewvariety()
    {
        $userId = session()->get('farmer_id');
        $validation = $this->validate([
            'barangay' => 'required',
            'equipment' => 'required',
            'variety_name' => 'required',
            'quantity' => 'required',
            'date_bought' => 'required',
            'notes' => 'required',
        ]);

        if (!$validation) {
            return view('userfolder/cropvariety', ['validation' => $this->validator]);
        }

        $this->variety->save([
            'barangay' => $this->request->getPost('barangay'),
            'equipment' => $this->request->getPost('equipment'),
            'variety_name' => $this->request->getPost('variety_name'),
            'variety_price' => $this->request->getPost('variety_price'),
            'quantity' => $this->request->getPost('quantity'),
            'date_bought' => $this->request->getPost('date_bought'),
            'notes' => $this->request->getPost('notes'),
            'user_id' => $userId,
        ]);

        return redirect()->to('/cropvariety')->with('success', 'Variety added successfully');
    }
    public function fertilizers()
    {
        $userId = session()->get('farmer_id');
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/sign_ins');
        } else {
            $data = [
                'fertilizers' => $this->fertilizers->where('user_id', $userId)->findAll()
            ];
            return view('userfolder/fertilizers', $data);
        }
    }
    public function addnewfertilizers()
    {
        $userId = session()->get('farmer_id');
        $validation = $this->validate([
            'fertilizer_name' => 'required',
            'quantity' => 'required',
            'date_bought' => 'required',
            'notes' => 'required',
        ]);

        if (!$validation) {
            return view('userfolder/ertilizers', ['validation' => $this->validator]);
        }

        $this->fertilizers->save([
            'fertilizer_name' => $this->request->getPost('fertilizer_name'),
            'price' => $this->request->getPost('price'),
            'quantity' => $this->request->getPost('quantity'),
            'date_bought' => $this->request->getPost('date_bought'),
            'notes' => $this->request->getPost('notes'),
            'user_id' => $userId,
        ]);

        return redirect()->to('/fertilizers')->with('success', 'fertilizer added successfully');
    }

    public function equipment()
    {
        $userId = session()->get('farmer_id');
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/sign_ins');
        } else {
            $data = [
                'equipment' => $this->equipment->where('user_id', $userId)->findAll()
            ];
            return view('userfolder/equipment', $data);
        }
    }
    public function addnewequipment()
    {
        $userId = session()->get('farmer_id');
        $validation = $this->validate([
            'equipment_name' => 'required',
            'date_bought' => 'required',
        ]);

        if (!$validation) {
            return view('userfolder/equipment', ['validation' => $this->validator]);
        }

        $this->equipment->save([
            'equipment_name' => $this->request->getPost('equipment_name'),
            'date_bought' => $this->request->getPost('date_bought'),
            'user_id' => $userId,
        ]);

        return redirect()->to('/equipment')->with('success', 'equipment added successfully');
    }

    public function addprofile()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/signinadmin');
        }
        $userId = session()->get('farmer_id');
        $prof = $this->prof->where('user_id', $userId)->findAll();
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
        $totalRevenueThisYear = $resultRevenue->getRow()->totalRevenueThisYear;

        // Count of binhi
        $totalVarieties = $this->variety
            ->selectSum('quantity', 'totalVarieties')
            ->where('user_id', $userId)
            ->get();
        $totalBinhiCount = $totalVarieties->getRow()->totalVarieties;

        // Total money spent from jobs table
        $resultMoneySpent = $this->jobs
            ->selectSum('total_money_spent', 'totalMoneySpent')
            ->where('user_id', $userId)
            ->get();
        $totalMoneySpent = $resultMoneySpent->getRow()->totalMoneySpent;

        $harvestData = $this->harvest->where('user_id', $userId)->findAll();
        $revenueData = $this->harvest->where('user_id', $userId)->findAll();
        $workerData = $this->worker->where('user_id', $userId)->findAll();


        $data = [
            'prof' => $prof,
            'totalHarvestQuantity' => $totalHarvestQuantity,
            'totalRevenueThisYear' => $totalRevenueThisYear,
            'harvest' => $harvestData,
            'totalBinhiCount' => $totalBinhiCount,
            'totalMoneySpent' => $totalMoneySpent,
            'worker' => $workerData,
            'field' => $this->field->where('user_id', $userId)->findAll()
        ];
        return view('userfolder/addprofile', $data);
    }
    public function addfarmerprofile()
    {
        $userId = session()->get('farmer_id');

        $validation = $this->validate([
            'fullname' => 'required',
            'idnumber' => 'required',
            'address' => 'required',
            'contactnumber' => 'required',
            'birthday' => 'required',
            'profile_picture' => 'uploaded[profile_picture]|max_size[profile_picture,1024]|is_image[profile_picture]',
        ]);

        if (!$validation) {
            return view('userfolder/addprofile', ['validation' => $this->validator]);
        }

        $profilePicture = $this->request->getFile('profile_picture');
        $newName = $profilePicture->getRandomName();
        $profilePicture->move(ROOTPATH . 'public/uploads/profile_pictures/', $newName);

        $this->prof->save([
            'user_id' => $userId,
            'fullname' => $this->request->getPost('fullname'),
            'idnumber' => $this->request->getPost('idnumber'),
            'address' => $this->request->getPost('address'),
            'contactnumber' => $this->request->getPost('contactnumber'),
            'birthday' => $this->request->getPost('birthday'),
            'profile_picture' => 'uploads/profile_pictures/' . $newName,
        ]);

        $prof = $this->prof->where('user_id', $userId)->findAll();

        $this->prof = $prof;
        $session = session();
        $session->set('prof', $prof);

        return redirect()->to('/addprofile')->with('success', 'Profile added successfully');
    }
    public function adminfields()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/signinadmin');
        }

        $data = [
            'field' => $this->field->findAll()
        ];
        return view('adminfolder/fields', $data);
    }
    public function admincropplanting()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/signinadmin');
        }

        $data = [
            'planting' => $this->planting->findAll()
        ];
        return view('adminfolder/croprotation', $data);
    }
    public function adminharvest()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/signinadmin');
        }

        $data = [
            'harvest' => $this->harvest->findAll()
        ];
        return view('adminfolder/harvest', $data);
    }
    public function map()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/signinadmin');
        }

        $barangays = ['Santiago', 'Kalinisan',  'Mabini', 'Adrialuna', 'Antipolo', 'Apitong', 'Arangin', 'Aurora', 'Bacungan', 'Bagong Buhay', 'Bancuro', 'Barcenaga', 'Bayani', 'Buhangin', 'Concepcion', 'Dao', 'Del Pilar', 'Estrella', 'Evangelista', 'Gamao', 'General Esco', 'Herrera', 'Inarawan', 'Laguna', 'Mabini', 'Andres Ilagan', 'Mahabang Parang', 'Malaya', 'Malinao', 'Malvar', 'Masagana', 'Masaguing', 'Melgar A', 'Melgar B', 'Metolza', 'Montelago', 'Montemayor', 'Motoderazo', 'Mulawin', 'Nag-Iba I', 'Nag-Iba II', 'Pagkakaisa', 'Paniquian', 'Pinagsabangan I', 'Pinagsabangan II', 'Pinahan', 'Poblacion I (Barangay I)', 'Poblacion II (Barangay II)', 'Poblacion III (Barangay III)', 'Sampaguita', 'San Agustin I', 'San Agustin II', 'San Andres', 'San Antonio', 'San Carlos', 'San Isidro', 'San Jose', 'San Luis', 'San Nicolas', 'San Pedro', 'Santa Isabel', 'Santa Maria', 'Santiago', 'Santo Nino', 'Tagumpay', 'Tigkan', 'Melgar B', 'Santa Cruz', 'Balite', 'Banuton', 'Caburo', 'Magtibay', 'Paitan'];
        $varietyData = [];

        foreach ($barangays as $barangay) {
            $varietyData[$barangay] = $this->variety
                ->select('variety_name')
                ->where('barangay', $barangay)
                ->findAll();
        }

        return view('adminfolder/map', ['varietyData' => $varietyData]);
    }
    public function farmermap()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/sign_ins');
        }

        $barangays = ['Santiago', 'Kalinisan',  'Mabini', 'Adrialuna', 'Antipolo', 'Apitong', 'Arangin', 'Aurora', 'Bacungan', 'Bagong Buhay', 'Bancuro', 'Barcenaga', 'Bayani', 'Buhangin', 'Concepcion', 'Dao', 'Del Pilar', 'Estrella', 'Evangelista', 'Gamao', 'General Esco', 'Herrera', 'Inarawan', 'Laguna', 'Mabini', 'Andres Ilagan', 'Mahabang Parang', 'Malaya', 'Malinao', 'Malvar', 'Masagana', 'Masaguing', 'Melgar A', 'Melgar B', 'Metolza', 'Montelago', 'Montemayor', 'Motoderazo', 'Mulawin', 'Nag-Iba I', 'Nag-Iba II', 'Pagkakaisa', 'Paniquian', 'Pinagsabangan I', 'Pinagsabangan II', 'Pinahan', 'Poblacion I (Barangay I)', 'Poblacion II (Barangay II)', 'Poblacion III (Barangay III)', 'Sampaguita', 'San Agustin I', 'San Agustin II', 'San Andres', 'San Antonio', 'San Carlos', 'San Isidro', 'San Jose', 'San Luis', 'San Nicolas', 'San Pedro', 'Santa Isabel', 'Santa Maria', 'Santiago', 'Santo Nino', 'Tagumpay', 'Tigkan', 'Melgar B', 'Santa Cruz', 'Balite', 'Banuton', 'Caburo', 'Magtibay', 'Paitan'];
        $varietyData = [];

        foreach ($barangays as $barangay) {
            $varietyData[$barangay] = $this->variety
                ->select('variety_name')
                ->where('barangay', $barangay)
                ->findAll();
        }

        return view('userfolder/map', ['varietyData' => $varietyData]);
    }
}
