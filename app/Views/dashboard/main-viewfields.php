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
                                            <button type="button" class="btn btn-primary" onclick="openEditFieldModal(
                                            <?= $fie['field_id']; ?>,
                                            '<?= $fie['field_name']; ?>',
                                            '<?= $fie['field_owner']; ?>',
                                            '<?= $fie['field_address']; ?>',
                                            '<?= $fie['field_total_area']; ?>',
                                            )">Edit</button>
                                            <button type="button" class="btn btn-danger" onclick="deleteProduct(<?= $fie['field_id']; ?>)">Delete</button>
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