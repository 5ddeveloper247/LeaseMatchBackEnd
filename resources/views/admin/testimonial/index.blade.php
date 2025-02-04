@extends('layouts.master.admin_template.master')

@push('css')
@endpush

@section('content')
<style>
    #users_table {
        font-size: x-small;
    }

    /* Center the image and reduce its size by half */
    #preview.preview-edit {
        display: flex;
        justify-content: start;
        /* Horizontally center the image */
        align-items: center;
        /* Vertically center the image */
        height: 50px;
        /* Set a fixed height for the preview area */
    }

    .preview-img-edit {
        /* Reduce width to 50% */
        max-width: 15%;
        max-height: 15%;
        /* Reduce height to 50% */
        object-fit: contain;
        /* Keep aspect ratio of the image */
        /* Optional: Rounded corners for the image */
    }

    .preview-img {
        width: 100px !important;
        border-radius: 4px
    }

    @media (max-width: 768px) {
        #listing .card_row>.col {

            height: 30vh;
        }
    }
</style>

<section id="listing">
    <div class="contain-fluid">
        <ul class="crumbs">
            <li><a href="{{url('admin/dashboard')}}">Dashboard</a></li>
            <li>Testimonial</li>
        </ul>
        <!-- <div class="card_row flex_row" style="justify-content:end"> -->
        <div class="card_row flex_row container d-flex justify-content-center align-items-center">

            <div class="col">
                <div class="card_blk">
                    <div class="icon" id="total"></div>
                    <strong>Total</strong>
                </div>
            </div>


            <div class="col">
                <div class="card_blk">
                    <div class="icon" id="active"></div>
                    <strong>
                        Active
                    </strong>
                </div>
            </div>


            <div class="col">
                <div class="card_blk">
                    <div class="icon" id="inactive"></div>
                    <strong>Inactive</strong>
                </div>
            </div>


            <div class="col">
                <div class="card_blk" id="add_user_btn">
                    <div class="icon">
                        <img src="{{asset('assets/images/icon-plus.svg')}}" alt="">
                    </div>
                    <strong>
                        Add Testimonial
                    </strong>
                </div>
            </div>

        </div>
        <div class="top_head mt-5">
            <h4>Testimonial</h4>
            <div class="form_blk">
                <input type="text" name="" id="searchInListing" class="text_box" placeholder="Search here">
                <button type="button"><img src="{{asset('assets/images/icon-search.svg')}}" alt=""></button>
            </div>
        </div>


        <div class="blk">
            <div class="tbl_blk tableFixHead">
                <table id="users_table" class="table table-responsive">
                    <thead>
                        <tr>
                            <th width="10">#</th>
                            <th width="40">Title</th>
                            <th width="40">Name</th>
                            <th width="40">description</th>
                            <th width="40">Address</th>
                            <th width="40">Rating</th>
                            <th width="40">Created Date</th>
                            <th width="40" data-center>Status</th>
                            <th width="40" data-center>Action</th>
                        </tr>
                    </thead>
                    <tbody id="users_table_body">


                    </tbody>
                </table>
            </div>
        </div>

    </div>
</section>


<div class="popup lg" data-popup="edit-data-popup" id="edit-data-popup">
    <div class="table_dv">
        <div class="table_cell">
            <div class="contain">
                <div class="_inner editor_blk">
                    <button type="button" class="x_btn" id="close_update_modal_default_btn"></button>
                    <div id="Inspection" class="tab-pane fade active in">

                        <form id="edit_user_form">
                            <input type="hidden" name="edit_id" id="edit_id">
                            @csrf
                            <fieldset>
                                <div class="blk">
                                    <h5 class="color">Testimonial</h5>
                                    <div class="form_row row">
                                        <div class="col-xs-12">
                                            <div class="form_blk">
                                                <h6>Title<sup>*</sup></h6>
                                                <input type="text" name="title_edit" id="title_edit" class="text_box"
                                                    placeholder="eg: John" maxlength="50">
                                            </div>
                                        </div>
                                        <div class="col-xs-12">
                                            <div class="form_blk">
                                                <h6>Name<sup>*</sup></h6>
                                                <input type="text" name="name_edit" id="name_edit" class="text_box"
                                                    placeholder="eg: John" maxlength="50">
                                            </div>
                                        </div>

                                        <div class="col-xs-12">
                                            <div class="form_blk">
                                                <h6>Description</h6>
                                                <textarea type="text" name="description_edit" id="description_edit"
                                                    class="text_box" placeholder="eg: John Wick"
                                                    maxlength="500"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-xs-12">
                                            <div class="form_blk">
                                                <h6>Address</h6>
                                                <textarea type="text" name="address_edit" id="address_edit"
                                                    class="text_box" placeholder="eg: John Wick"
                                                    maxlength="500"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-xs-12">
                                            <div class="form_blk">
                                                <h6>Rating</h6>
                                                <input type="number" name="rating_edit" id="rating_edit"
                                                    class="text_box" placeholder="" />
                                            </div>
                                        </div>


                                        <div class="btn_blk form_btn text-center">
                                            <button type="button" class="site_btn long"
                                                style="background-color: red !important;" id="uploadImage-edit">Upload
                                                Image</button>
                                            <input type="file" name="profile_edit" id="profile-img-edit"
                                                style="display: none" accept="image/*">
                                        </div>
                                        <div class="col-sm-12 mb-2">
                                            <div id="preview-edit" class="preview-edit"></div>
                                        </div>

                                    </div>
                                    <div class="form-check form-switch mt-2" style="margin-top:5px;">
                                        <input class="form-check-input m-2" name="status_edit" id="status_edit"
                                            type="checkbox" role="switch">
                                        <label class="form-check-label" for="flexSwitchCheckChecked">Status</label>
                                    </div>
                                    <div class="btn_blk form_btn text-center">
                                        <button type="button" class="site_btn long"
                                            style="background-color:red !important;"
                                            id="closeupdatedmodalbtn">Close</button>
                                        <button type="button" class="site_btn long saveuser_btn"
                                            id="edituser_btn">Update</button>
                                    </div>
                            </fieldset>


                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- modal to add user start  -->
<div class="popup lg" id="add-user-popup">
    <div class="table_dv" style="overflow-y: hidden;">
        <div class="table_cell">
            <div class="contain">
                <div class="_inner editor_blk" style="overflow-y: auto; scrollbar-width: none; height: 90vh">
                    <button type="button" class="x_btn" id="close_add_modal_btn"></button>
                    <div id="Inspection" class="tab-pane fade active in">

                        <form id="add_user_form">

                            <fieldset>
                                <div class="blk">
                                    <h5 class="color">Testimonial</h5>
                                    <div class="form_row row">
                                        <div class="col-xs-12">
                                            <div class="form_blk">
                                                <h6>Title<sup>*</sup></h6>
                                                <input type="text" name="title" id="title" class="text_box"
                                                    placeholder="eg: John" maxlength="50">
                                            </div>
                                        </div>
                                        <div class="col-xs-12">
                                            <div class="form_blk">
                                                <h6>Name<sup>*</sup></h6>
                                                <input type="text" name="name" id="name" class="text_box"
                                                    placeholder="eg: John" maxlength="50">
                                            </div>
                                        </div>

                                        <div class="col-xs-12">
                                            <div class="form_blk">
                                                <h6>Description</h6>
                                                <textarea type="text" name="description" id="description"
                                                    class="text_box" placeholder="eg: John Wick"
                                                    maxlength="500"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-xs-12">
                                            <div class="form_blk">
                                                <h6>Address</h6>
                                                <textarea type="text" name="address" id="address" class="text_box"
                                                    placeholder="eg: John Wick" maxlength="500"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-xs-12">
                                            <div class="form_blk">
                                                <h6>Rating</h6>
                                                <input type="number" name="rating" id="rating" class="text_box"
                                                    placeholder="" />
                                            </div>
                                        </div>


                                        <div class="btn_blk form_btn text-center">
                                            <button type="button" class="site_btn long"
                                                style="background-color: red !important;" id="uploadImage">Upload
                                                Image</button>
                                            <br>
                                            <input type="file" name="profile" id="profile-img" style="display: none"
                                                accept="image/*">
                                        </div>
                                        <div class="col-sm-12">
                                            <div id="preview" class="preview"></div>
                                        </div>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" role="switch" id="status"
                                                name="status">
                                            <label class="form-check-label" for="flexSwitchCheckChecked">
                                                Status</label>
                                        </div>

                                    </div>

                                    <div class="btn_blk form_btn text-center">
                                        <button type="button" class="site_btn long"
                                            style="background-color:red !important;"
                                            id="closeaddmodalbtn">Close</button>
                                        <button type="button" class="site_btn long saveuser_btn"
                                            id="saveuser_btn">Save</button>
                                    </div>
                            </fieldset>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- modal to add user end  -->


<!-- delete modal start  -->
<div class="popup sm" data-popup="delete-data-popup" id="delete_modal">
    <div class="table_dv">
        <div class="table_cell">
            <div class="contain">
                <div class="_inner editor_blk">
                    <button type="button" class="hidden x_btn clode_delete_modal_default_btn"></button>
                    <h3 class="text-center">Are You Sure to Delete?</h3>
                    <!-- <p>Are You Sure to Delete?</p> -->
                    <div class="text-center row">
                        <button type="button" class="btn bg-danger rounded-pill" id="close_delete_modal_btn">No</button>
                        <button type="button" class="btn bg-primary rounded-pill" id="delete_confirmed_btn"
                            data-id="">Yes</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- delete modal end  -->








@endsection

@push('script')

<script src="{{ asset('assets_admin/customjs/script_testimonial.js') }}"></script>
<script>
    // for add user
    document.getElementById('uploadImage').addEventListener('click', function() {
    // Trigger the hidden file input when the button is clicked
    document.getElementById('profile-img').click();
});


 // for edit user
    document.getElementById('uploadImage-edit').addEventListener('click', function() {
    // Trigger the hidden file input when the button is clicked
    document.getElementById('profile-img-edit').click();
});

document.getElementById('profile-img').addEventListener('change', function(event) {
    const file = event.target.files[0]; // Get the selected file
    const previewDiv = document.getElementById('preview');

    // Clear previous preview
    previewDiv.innerHTML = '';

    if (file) {
        const reader = new FileReader(); // Create a FileReader object to read the image

        reader.onload = function(e) {
            // Create an image element and set the source to the file's data URL
            const img = document.createElement('img');
            img.src = e.target.result;
            img.alt = 'Image Preview';
            img.classList.add('preview-img'); // Add a class to control styling

            // Append the image to the preview div
            previewDiv.appendChild(img);
        };

        // Read the file as a data URL
        reader.readAsDataURL(file);
    } else {
        previewDiv.textContent = 'No image selected'; // Fallback message if no file is chosen
    }
});
document.getElementById('profile-img-edit').addEventListener('change', function(event) {
    const file = event.target.files[0]; // Get the selected file
    const previewDiv = document.getElementById('preview-edit');

    // Clear previous preview
    previewDiv.innerHTML = '';

    if (file) {
        const reader = new FileReader(); // Create a FileReader object to read the image

        reader.onload = function(e) {
            // Create an image element and set the source to the file's data URL
            const img = document.createElement('img');
            img.src = e.target.result;
            img.alt = 'Image Preview';
            img.classList.add('preview-img-edit'); // Add a class to control styling

            // Append the image to the preview div
            previewDiv.appendChild(img);
        };

        // Read the file as a data URL
        reader.readAsDataURL(file);
    } else {
        previewDiv.textContent = 'No image selected'; // Fallback message if no file is chosen
    }
});

</script>


<script>
    $('#phone_number').on('input', function () {
    // Remove all non-numeric characters
    this.value = this.value.replace(/[^0-9]/g, '');
});

$('#phone_number_edit').on('input', function () {
    // Remove all non-numeric characters
    this.value = this.value.replace(/[^0-9]/g, '');

});

</script>
@endpush
