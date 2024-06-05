@extends('layouts.master.admin_template.master')

@push('css')
@endpush

@section('content')
<style>
    #users_table{
        font-size:x-small;
    }
</style>

<section id="listing">
    <div class="contain-fluid">
        <ul class="crumbs">
            <li><a href="{{url('admin/dashboard')}}">Dashboard</a></li>
            <li>Admin Users</li>
        </ul>
        <!-- <div class="card_row flex_row" style="justify-content:end"> -->
        <div class="card_row flex_row" >
            
            
            <div class="col">
                <div class="card_blk">
                    <div class="icon" id="active_users"></div>
                    <strong>
                        Active
                    </strong>
                </div>
            </div>
            <div class="col">
                <div class="card_blk">
                    <div class="icon" id="inactive_users"></div>
                    <strong>Inactive</strong>
                </div>
            </div>
            <div class="col">
                <div class="card_blk" id="">
                    <div class="icon"></div>
                    <strong>
                        
                    </strong>
                </div>
            </div>
            <div class="col">
                <div class="card_blk">
                    <div class="icon" id="total_users"></div>
                    <strong>Total</strong>
                </div>
            </div>
            <div class="col">
                <div class="card_blk" id="add_user_btn">
                    <div class="icon">
                        <img src="{{asset('assets/images/icon-plus.svg')}}" alt="">
                    </div>
                    <strong>
                        Add Sub-Admin
                    </strong>
                </div>
            </div>
        </div>
        <div class="br"></div>
        <div class="top_head">
            
           
        </div>
        <div class="blk">
            <div class="tbl_blk">
                <table id="users_table" class="table table-responsive">
                    <thead>
                        <tr>
                            <th width="10">#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th width="40">Contact</th>
                            <th width="40" >Created Date</th>
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
                       
                        <form  method="POST" id="edit_user_form">
                            <input type="hidden" name="user_id" id="user_id">
                            @csrf
                            <fieldset>
                                <div class="blk">
                                    <h5 class="color">Edit Admin User</h5>
                                    <div class="form_row row">
                                        <div class="col-xs-6">
                                            <div class="form_blk">
                                                <h6>First Name<sup>*</sup></h6>
                                                <input type="text" name="first_name_edit" id="first_name_edit" class="text_box" placeholder="eg: John Wick" maxlength="50">
                                            </div>
                                        </div>
                                        <div class="col-xs-6">
                                            <div class="form_blk">
                                                <h6>Middle Name</h6>
                                                <input type="text" name="middle_name_edit" id="middle_name_edit" class="text_box" placeholder="eg: John Wick" maxlength="50">
                                            </div>
                                        </div>
                                        <div class="col-xs-6">
                                            <div class="form_blk">
                                                <h6>Last Name</h6>
                                                <input type="text" name="last_name_edit" id="last_name_edit" class="text_box" placeholder="eg: John Wick" maxlength="50">
                                            </div>
                                        </div>
                                        <div class="col-xs-6">
                                            <div class="form_blk">
                                                <h6>Contact Number</h6>
                                                <input type="number" name="phone_number_edit" id="phone_number_edit" class="text_box" placeholder="eg: +92300 0000 000"maxlength="15">
                                            </div>
                                        </div>
                                        <div class="col-xs-12">
                                            <div class="form_blk">
                                                <h6>Email<sup>*</sup></h6>
                                                <p id="email_edit" class="text_box">
                                            </div>
                                        </div>

                                        <?php 
                                            $menu = getAllMenu();
                                        ?>
                                        <div class="col-sm-12"><h5 class="color">Menu Controls:</h5></div>
                                        @if(count($menu) > 0)
                                            @foreach($menu as $value)
                                                <div class="col-sm-3">
                                                    <div class="form_blk">
                                                        <div class="lbl_btn">
                                                            <input type="checkbox" name="menu_control[]" id="menu_chk_{{$value->id}}" class="menu-control-chk" value="{{$value->id}}">
                                                            <label for="menu_chk_{{$value->id}}">{{$value->name}}</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                   
                                <div class="btn_blk form_btn text-center">
                                  
                                    <button type="submit" class="site_btn long saveuser_btn" id="edituser_btn">Update</button>
                                    <button type="button" class="site_btn long"  style="background-color:red !important;"id="closeupdatedmodalbtn">Close</button>
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
    <div class="table_dv">
        <div class="table_cell">
            <div class="contain">
                <div class="_inner editor_blk">
                    <button type="button" class="x_btn" id="close_add_modal_btn"></button>
                    <div id="Inspection" class="tab-pane fade active in">
                       
                        <form  method="POST" id="add_user_form">
                            
                            <fieldset>
                                <div class="blk">
                                    <h5 class="color">Add Sub-Admin</h5>
                                    <div class="form_row row">
                                        <div class="col-xs-6">
                                            <div class="form_blk">
                                                <h6>First Name<sup>*</sup></h6>
                                                <input type="text" name="first_name" id="first_name" class="text_box" placeholder="eg: John Wick" maxlength="50">
                                            </div>
                                        </div>
                                        <div class="col-xs-6">
                                            <div class="form_blk">
                                                <h6>Middle Name</h6>
                                                <input type="text" name="middle_name" id="middle_name" class="text_box" placeholder="eg: John Wick" maxlength="50">
                                            </div>
                                        </div>
                                        <div class="col-xs-6">
                                            <div class="form_blk">
                                                <h6>Last Name</h6>
                                                <input type="text" name="last_name" id="last_name" class="text_box" placeholder="eg: John Wick" maxlength="50">
                                            </div>
                                        </div>
                                        <div class="col-xs-6">
                                            <div class="form_blk">
                                                <h6>Contact Number</h6>
                                                <input type="number" name="phone_number" id="phone_number" class="text_box" placeholder="eg: +92300 0000 000"maxlength="15">
                                            </div>
                                        </div>
                                        <div class="col-xs-12">
                                            <div class="form_blk">
                                                <h6>Email<sup>*</sup></h6>
                                                <input type="text" name="email" id="email" class="text_box" placeholder="eg: someone@example.com" maxlength="50">
                                            </div>
                                        </div>

                                        <?php 
                                            $menu = getAllMenu();
                                        ?>
                                        <div class="col-sm-12"><h5 class="color">Menu Controls:</h5></div>
                                        @if(count($menu) > 0)
                                            @foreach($menu as $value)
                                                <div class="col-sm-3">
                                                    <div class="form_blk">
                                                        <div class="lbl_btn">
                                                            <input type="checkbox" name="menu_control[]" id="menu_chk_{{$value->id}}" value="{{$value->id}}">
                                                            <label for="menu_chk_{{$value->id}}">{{$value->name}}</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                        
                                    </div>
                                   
                                <div class="btn_blk form_btn text-center">
                                  
                                    <button type="submit" class="site_btn long saveuser_btn" id="saveuser_btn">Save</button>
                                    <button type="button" class="site_btn long"  style="background-color:red !important;"id="closeaddmodalbtn">Close</button>
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
                    <button type="button" class="btn bg-danger rounded-pill" id="close_delete_modal_btn" >No</button>
                    <button type="button" class="btn bg-primary rounded-pill" id="delete_confirmed_btn" data-id="">Yes</button>
                    
                    <!-- <button type="button" class="btn btn-danger ">Delete</button> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- delete modal end  -->








@endsection

@push('script')
    
<script src="{{ asset('assets_admin/customjs/script_adminusers.js') }}"></script>
    
@endpush
