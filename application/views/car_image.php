<!DOCTYPE html>
<html lang="en">

<head>
    <title></title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="shortcut icon" type="" href="#">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" referrerpolicy="no-referrer"></script>
</head>

<body>
    <h1 class="mt-3 text-center">Image CRUD with Ajax in Codeigniter</h1>
    <button type="button" class="btn btn-dark modalbtn float-end my-4 me-5" data-bs-toggle="modal" data-bs-target="#imageModal">Add Image</button>

    <table class="table table-hover table-bordered text-center">
        <tr>
            <th>Image</th>
            <th>Action</th>
        </tr>
        <?php
        foreach ($images as $values) { ?>
            <tr>
                <td><img src="<?php echo base_url('images/') . $values->image; ?> ?>" class="img-fluid mt-3" style="width: 80px; height: 80px; border-radius: 50%;" alt="product image"></td>
                <td>
                    <button class="btn btn-primary" onclick="editModal('<?php echo  $values->image_id ?>')">Edit</button> |
                    <button class="btn btn-danger" onclick="delete_image('<?php echo  $values->image_id ?>')">Delete</button>
                </td>
            </tr>
        <?php }
        ?>
    </table>


    <!-- tooltips and popovers modal -->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="exampleModalPopoversLabel" aria-modal="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="image-title" id="image-title" style="margin: 0px !important;">Add Image</h5>
                    <a href="javascript: void(0)" class="btn-close" data-bs-dismiss="modal"></a>
                </div>
                <!-- ........ model start ........  -->
                <div class="modal-body">
                    <form id="submit">
                        <div class="mb-3">
                            <input type="hidden" name="id" id="editID">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="">Image</label>
                            <input type="file" class="form-control" id="file" name="file">
                        </div>

                        <input type="hidden" class="form-control" id="old_file" name="old_file">

                        <div>
                            <div class="row d-flex justify-content-between">
                                <div class="col-6">
                                    <button onclick="client_erase_data()" type="reset" class="btn btn-danger w-100" id="clear">Clear</button>
                                </div>
                                <div class="col-6">
                                    <button class="btn btn-success w-100" id="btnsave">Upload</button>
                                    <button class="btn btn-success w-100" id="btnupdate">Update</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- ........ model end ........ -->
            </div>
        </div>
    </div>

    <!-- javascript ================================== -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>

    <script>
        // Data Insert
        $(".modalbtn").click(function() {
            $("#btnupdate").hide();
            $("#btnsave").show();
            $("#image-title").html('Upload Image');
            client_erase_data();
        });


        $(document).ready(function() {
            $("#submit").submit(function(event) {
                event.preventDefault();
                $('#imageModal').modal('hide');
                $.ajax({
                    url: "<?= base_url("index.php/CarModel/image_upload") ?>",
                    type: "POST",
                    data: new FormData(this),
                    processData: false,
                    contentType: false,
                    cache: false,
                    async: false,
                    success: function(response) {
                        windows.location.reload();
                        client_erase_data();
                    }
                });
            });
        });





        // Data edit=======================================================
        function editModal(image_id) {
            $("#btnupdate").show();
            $("#btnsave").hide();
            $("#image-title").html('Edit Image');
            $("#imageModal").modal('show');

            $.ajax({
                url: "<?php echo base_url('index.php/CarModel/edit_image/') ?>" + image_id,
                type: "post",
                data: {
                    image_id: image_id
                },
                success: function(data) {
                    var data = JSON.parse(data);
                    $('#editID').val(data.image_id);
                    $('#old_file').val(data.image);
                }
            });
        }

        $("#btnupdate").click(function(event) {
            event.preventDefault();
            $("#imageModal").modal('hide');
            var image_id = $("#editID").val();
            var editFormData = new FormData($('#submit')[0]);

            $.ajax({
                url: "<?= base_url('index.php/CarModel/update_image/') ?>" + image_id,
                type: "POST",
                data: editFormData,
                processData: false,
                contentType: false,
                success: function(dataResult) {

                }
            });
        });

        // Data Delete=======================================================
        function delete_image(image_id) {
            $.ajax({
                url: "<?= base_url('index.php/CarModel/delete_image/') ?>" + image_id,
                type: "POST",
                success: function(dataResult) {

                }
            });
        }

        // Our Created Function========================================== //

        function client_erase_data() {
            $('#editID').val('');
            $('#file').val('');
        }
    </script>
</body>

</html>