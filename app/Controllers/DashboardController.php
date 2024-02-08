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
    }

    //fields


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

        // Validate the form data
        $validation = $this->validate([
            'field_name' => 'required',
            'field_address' => 'required',
            'field_total_area' => 'required',
        ]);

        if (!$validation) {
            // Validation failed, return to the form with errors
            return view('userfolder/viewfields', ['validation' => $this->validator]);
        }

        // If validation passes, insert the data into the database
        $this->field->save([
            'field_name' => $this->request->getPost('field_name'),
            'field_owner' => $this->request->getPost('field_owner'),
            'field_address' => $this->request->getPost('field_address'),
            'field_total_area' => $this->request->getPost('field_total_area'),
            'user_id' => $userId,
            'farmer_name' => $username,

        ]);

        // Redirect to a success page or display a success message
        return redirect()->to('/viewfields')->with('success', 'Field added successfully');
    }

    public function edit($field_id)
    {
        // Load the product to be edited from the database
        $model = new VIewFieldsModel();
        $field = $model->find($field_id);

        // Load the edit view with the product data
        return view('field', ['field' => $field]);
    }
    public function update()
    {
        // Handle the form submission to update the product
        $model = new VIewFieldsModel();

        // Retrieve the field_id from the form input
        $field_id = $this->request->getPost('field_id');

        // Define the data to be updated
        $dataToUpdate = [
            'field_name' => $this->request->getPost('field_name'),
            'field_owner' => $this->request->getPost('field_owner'),
            'field_address' => $this->request->getPost('field_address'),
            'field_total_area' => $this->request->getPost('field_total_area'),
        ];

        // Update the product in the database using the update() method
        $model->update($field_id, $dataToUpdate);

        // Redirect back to the product list or a success page
        return redirect()->to('/viewfields')->with('success', 'Field updated successfully');
    }
    public function deleteProduct($field_id)
    {
        // Load the model
        $model = new VIewFieldsModel();

        // Check if the product with the given field_ID exists
        $field = $model->find($field_id);

        if ($field) {
            // Delete the field from the database
            $model->delete($field_id);

            // Redirect back to the field list with a success message
            return redirect()->to('/viewfields')->with('success', 'field deleted successfully');
        } else {
            // Redirect back to the field list with an error message if the field doesn't exist
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
            // Validation failed, return to the form with errors
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

        // Define the data to be updated
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
            'equipment_use' => 'required',
            'quantity_use' => 'required',
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
            'equipment_use' => $this->request->getPost('equipment_use'),
            'quantity_use' => $this->request->getPost('quantity_use'),
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

        // Define the data to be updated
        $dataToUpdate = [
            'job_name' => $this->request->getPost('job_name'),
            'field_name' => $this->request->getPost('field_name'),
            'finished_date' => $this->request->getPost('finished_date'),
            'worker_name' => $this->request->getPost('worker_name'),
            'equipment_use' => $this->request->getPost('equipment_use'),
            'quantity_use' => $this->request->getPost('quantity_use'),
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

        // Redirect to a success page or display a success message
        return redirect()->to('/harvest')->with('success', 'Harvest added successfully');
    }


    public function editharvest($harvest_id)
    {
        // Load the product to be edited from the database
        $model = new HarvestModel();
        $harvest = $model->find($harvest_id);

        // Load the edit view with the product data
        return view('harvest', ['harvest' => $harvest]);
    }
    public function updateharvest()
    {
        // Handle the form submission to update the product
        $model = new HarvestModel();

        // Retrieve the field_id from the form input
        $harvest_id = $this->request->getPost('harvest_id');

        // Define the data to be updated
        $dataToUpdate = [
            'field_name' => $this->request->getPost('field_name'),
            'variety_name' => $this->request->getPost('variety_name'),
            'harvest_quantity' => $this->request->getPost('harvest_quantity'),
            'total_revenue' => $this->request->getPost('total_revenue'),
            'harvest_date' => $this->request->getPost('harvest_date'),
            'notes' => $this->request->getPost('notes'),
        ];

        // Update the product in the database using the update() method
        $model->update($harvest_id, $dataToUpdate);

        // Redirect back to the product list or a success page
        return redirect()->to('/harvest')->with('success', 'Harvest updated successfully');
    }
    public function deleteHarvest($harvest_id)
    {
        // Load the model
        $model = new HarvestModel();

        // Check if the product with the given field_ID exists
        $jobs = $model->find($harvest_id);

        if ($jobs) {
            // Delete the jobs from the database
            $model->delete($harvest_id);

            // Redirect back to the jobs list with a success message
            return redirect()->to('/harvest')->with('success', 'Harvest deleted successfully');
        } else {
            // Redirect back to the jobs list with an error message if the jobs doesn't exist
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
            'variety_name' => 'required',
            'quantity' => 'required',
            'date_bought' => 'required',
            'notes' => 'required',
        ]);

        if (!$validation) {
            return view('userfolder/cropvariety', ['validation' => $this->validator]);
        }

        $this->variety->save([
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
            'notes' => 'required',
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
    public function adminfields()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/sign_ins');
        }


        $data = [
            'field' => $this->field->findAll()
        ];
        return view('adminfolder/fields', $data);
    }
}
