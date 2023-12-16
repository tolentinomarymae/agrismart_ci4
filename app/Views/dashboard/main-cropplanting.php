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
                                <a href="#" data-bs-toggle="modal" data-bs-target="#addplantingmodal" class="btn_1">Add New</a>
                            </div>
                        </div>
                    </div>

                    <div class="QA_table mb_30">
                        <table class="table lms_table_active">
                            <thead>
                                <tr>
                                    <th scope="col">Pangalan ng Bukid</th>
                                    <th scope="col">Pangalan ng Variety</th>
                                    <th scope="col">Araw ng Pagtatanim</th>
                                    <th scope="col">Season</th>
                                    <th scope="col">Simula ng Pagsasaka</th>
                                    <th scope="col">Ani</th>
                                    <th scope="col">Notes</th>
                                    <th scope="col">Aksyon</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($planting as $pla) : ?>
                                    <tr>
                                        <td><?= $pla['field_name'] ?></td>
                                        <td><?= $pla['crop_variety'] ?></td>
                                        <td><?= $pla['planting_date'] ?></td>
                                        <td><?= $pla['season'] ?></td>
                                        <td><?= $pla['start_date'] ?></td>
                                        <td><?= $pla['end_date'] ?></td>
                                        <td><?= $pla['notes'] ?></td>
                                        <td>
                                            <button type="button" class="btn btn-primary" onclick="openEditFieldModal(
                                            <?= $pla['planting_id']; ?>,
                                            '<?= $pla['field_name']; ?>',
                                            '<?= $pla['crop_variety']; ?>',
                                            '<?= $pla['planting_date']; ?>',
                                            '<?= $pla['season']; ?>',
                                            '<?= $pla['start_date']; ?>',
                                            '<?= $pla['end_date']; ?>',
                                            '<?= $pla['notes']; ?>',
                                            )">Edit</button>
                                            <button type="button" class="btn btn-danger" onclick="deleteProduct(<?= $pla['planting_id']; ?>)">Delete</button>
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

<!-- Add Product Modal -->
<div class="modal fade" id="addplantingmodal" role="dialog" aria-labelledby="addplantingmodalLabel" aria-hidden="true">
    <br>
    <div class="modal-dialog modal-dialog-centered" style="z-index: 10000;">

        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addfieldmodalLabel">Add New Crop Planting Details</h5>
            </div>
            <div class="modal-body">
                <form action="/addplanting" method="post">
                    <div class="mb-3">
                        <label for="field_name" class="form-label">Pangalan ng Bukid</label>
                        <input type="text" name="field_name" id="field_name" placeholder="Pangalan ng Bukid" class="form-control">
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
                        <select name="season" id="season" class=" form-control">
                            <option value="dry-season">Dry Season(December to May)</option>
                            <option value="wet-season">Wet Season (June to November)</option>
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
                    <input type="hidden" name="farmer_id" id="editfarmer_id">
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