<div class="main_content_iner ">
    <div class="container-fluid p-3">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="QA_section">
                    <div class="white_box_tittle list_header">
                        <h4 style="color:#88c431">Mga Bukid</h4>
                        <div class=" box_right d-flex lms_block">
                            <div class="serach_field_2">
                                <div class="search_inner">
                                    <form Active="#">
                                        <div class="search_field">
                                            <input type="text" placeholder="Search content here...">
                                        </div>
                                        <button type="submit"> <i class="ti-search"></i> </button>
                                    </form>
                                </div>
                            </div>
                            <div class="add_button ms-2">
                                <a href="#" data-bs-toggle="modal" data-bs-target="#addfieldmodal" class="btn_1">Add New</a>
                            </div>
                        </div>
                    </div>

                    <div class="QA_table mb_30">
                        <table class="table lms_table_active">
                            <thead>
                                <tr>
                                    <th scope="col">Pangalan ng Bukid</th>
                                    <th scope="col">May-ari ng Lupa</th>
                                    <th scope="col">Address ng Bukid</th>
                                    <th scope="col">Kabuuang Sukat</th>
                                    <th scope="col">Aksyon</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($field as $fie) : ?>
                                    <tr>
                                        <td><?= $fie['field_name'] ?></td>
                                        <td><?= $fie['field_owner'] ?></td>
                                        <td><?= $fie['field_address'] ?></td>
                                        <td><?= $fie['field_total_area'] ?></td>
                                        <td>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background-color: #88c431; border: none;">
                                                    Actions
                                                </button>
                                                <div class="dropdown-menu">
                                                    <button type="button" class="dropdown-item" onclick="openEditFieldModal(
                                                        <?= $fie['field_id']; ?>,
                                                        '<?= $fie['field_name']; ?>',
                                                        '<?= $fie['field_owner']; ?>',
                                                        '<?= $fie['field_address']; ?>',
                                                        '<?= $fie['field_total_area']; ?>',
                                                        )">Edit</button>
                                                    <button type="button" class="dropdown-item" onclick="deleteProduct(<?= $fie['field_id']; ?>)">Delete</button>
                                                    <button type="button" class="dropdown-item" onclick="openAddPlantingModal('<?= $fie['field_name']; ?>')">Add New Planting Details</button>
                                                    <button type="button" class="dropdown-item" onclick="openAddJobModal('<?= $fie['field_name']; ?>')">Add New Job</button>
                                                    <button type="button" class="dropdown-item" onclick="openAddHarvestModal('<?= $fie['field_name']; ?>')">Add New Harvest</button>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Field Modal -->
<div class="modal fade" id="addfieldmodal" role="dialog" aria-labelledby="addfieldmodalLabel" aria-hidden="true">
    <br>
    <div class="modal-dialog modal-dialog-centered" style="z-index: 10000;">

        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addfieldmodalLabel">Add New Field</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="/addfield" method="post">
                    <div class="mb-3">
                        <label for="field_name" class="form-label">Pangalan ng Bukid</label>
                        <input type="text" name="field_name" id="field_name" placeholder="Pangalan ng Bukid" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="field_owner" class="form-label">Pangalang ng May-ari</label>
                        <input type="text" name="field_owner" id="field_owner" placeholder="Kung hindi sarili ng lupang binubukid, ilagay ang pangalan ng may-ari" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="field_address" class="form-label">Address ng Bukid</label>
                        <input type="text" name="field_address" id="field_address" placeholder="Address ng Bukid" class=" form-control">
                    </div>
                    <div class="mb-3">
                        <label for="field_total_area" class="form-label">Kabuuang Sukat</label>
                        <input type="text" name="field_total_area" id="field_total_area" placeholder="Ilagay kung ilang Hectares." class="form-control">
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>


<!-- Add Planting Details Modal -->
<div class="modal fade" id="addplantingmodal" role="dialog" aria-labelledby="addplantingmodalLabel" aria-hidden="true">
    <br>
    <div class="modal-dialog modal-dialog-centered" style="z-index: 10000;">

        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addplantingmodalLabel">Add New Crop Planting Details</h5>
            </div>
            <div class="modal-body">
                <form action="/addplanting" method="post">
                    <div class="mb-3">
                        <label for="field_name" class="form-label">Pangalan ng Bukid</label>
                        <input type="text" name="field_name" id="field_name_add" placeholder="Pangalan ng Bukid" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="crop_variety" class="form-label">Pangalang ng Variety</label>
                        <input type="text" name="crop_variety" id="crop_variety" placeholder="Pangalan ng Variety" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="planting_date" class="form-label">Araw ng Pagtatanim</label>
                        <input type="date" name="planting_date" id="planting_date" class=" form-control">
                    </div>
                    <div class="mb-3">
                        <label for="season" class="form-label">Season</label>
                        <select name="season" id="season" class="form-select">
                            <option value="Dry Season">Dry Season(December to May)</option>
                            <option value="Wet Season">Wet Season (June to November)</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="start_date" class="form-label">Simula ng Pagtatanim</label>
                        <input type="date" name="start_date" id="start_date" class=" form-control">
                    </div>
                    <div class="mb-3">
                        <label for="end_date" class="form-label">Araw ng Ani</label>
                        <input type="date" name="end_date" id="end_date" class=" form-control">
                    </div>
                    <div class="mb-3">
                        <label for="notes" class="form-label">Araw ng Pagtatanim</label>
                        <textarea name="notes" id="notes" class=" form-control"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>


<!-- Add Job Modal -->
<div class="modal fade" id="addjobmodal" role="dialog" aria-labelledby="addjobmodalLabel" aria-hidden="true">
    <br>
    <div class="modal-dialog modal-dialog-centered" style="z-index: 10000;">

        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addjobmodalLabel">Add New Job</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="/addjob" method="post">
                    <div class="mb-3">
                        <label for="job_name" class="form-label">Trabaho</label>
                        <select name="job_name" id="job_name" class="form-select">
                            <option value="Gamas">Gamas</option>
                            <option value="Lipat Tanim">Lipat Tanim</option>
                            <option value="Spray">Spray</option>
                            <option value="Fertilize">Fertilize</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="field_name" class="form-label">Pangalan ng Bukid</label>
                        <input type="text" name="field_name" id="field_nameadd" placeholder="Pangalan ng Bukid" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="finished_date" class="form-label">Araw</label>
                        <input type="date" name="finished_date" id="finished_date" class=" form-control">
                    </div>
                    <div class="mb-3">
                        <label for="worker_name" class="form-label">Pangalang ng Magtatrabaho</label>
                        <input type="text" name="worker_name" id="worker_name" placeholder="Pangalan ng Magtatrabaho" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="equipment_use" class="form-label">Kagamitan</label>
                        <input type="text" name="equipment_use" id="equipment_use" placeholder="Kagamitan" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="quantity_use" class="form-label">Bilang ng Ginamit</label>
                        <input type="text" name="quantity_use" id="quantity_use" placeholder="Bilang ng Ginamit" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="total_money_spent" class="form-label">Total na Nagastos</label>
                        <input type="text" name="total_money_spent" id="total_money_spent" placeholder="Total na Nagastos" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="notes" class="form-label">Notes</label>
                        <input type="text" name="notes" id="notes" placeholder="Notes" class="form-control">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>


<!-- Add Harvest Modal -->
<div class="modal fade" id="addharvestmodal" role="dialog" aria-labelledby="addharvestmodalLabel" aria-hidden="true">
    <br>
    <div class="modal-dialog modal-dialog-centered" style="z-index: 10000;">

        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addharvestmodalLabel">Add New Harvest</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="/addharvest" method="post">
                    <div class="mb-3">
                        <label for="field_name" class="form-label">Pangalan ng Bukid</label>
                        <input type="text" name="field_name" id="field_name_harvest" placeholder="Pangalan ng Bukid" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="variety_name" class="form-label">Pangalan ng Variety</label>
                        <input type="text" name="variety_name" id="variety_name" placeholder="Pangalan ng Variety" class=" form-control">
                    </div>
                    <div class="mb-3">
                        <label for="harvest_quantity" class="form-label">Dami ng Naani</label>
                        <input type="text" name="harvest_quantity" id="harvest_quantity" placeholder="Dami ng Naani" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="total_revenue" class="form-label">Kabuuang Kita</label>
                        <input type="text" name="total_revenue" id="total_revenue" placeholder="Kabuuang Kita" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="harvest_date" class="form-label">Araw ng Ani</label>
                        <input type="date" name="harvest_date" id="harvest_date" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="notes" class="form-label">Notes</label>
                        <input type="text" name="notes" id="notes" placeholder="Notes" class="form-control">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>


<!-- edit_product_modal.php -->

<div class="modal fade" id="editfieldmodal" tabindex="-1" aria-labelledby="editfieldmodalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editfieldmodalLabel">Edit Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="/viewfields/update" method="post">
                    <input type="hidden" name="field_id" id="editfield_id">
                    <div class="mb-3">
                        <label for="editfield_name" class="form-label">Pangalan ng Bukid</label>
                        <input type="text" name="field_name" id="editfield_name" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="editfield_owner" class="form-label">May-ari ng Bukid</label>
                        <input type="text" name="field_owner" id="editfield_owner" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="editfield_address" class="form-label">Address ng Bukid</label>
                        <input type="text" name="field_address" id="editfield_address" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="editfield_total_area" class="form-label">Kabuuang Sukat</label>
                        <input type="text" name="field_total_area" id="editfield_total_area" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>