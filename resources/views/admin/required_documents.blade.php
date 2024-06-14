@extends('layouts.master.admin_template.master')

@push('css')

@endpush

@section('content')
<style>
    #users_table{
        font-size:x-small;
    }
    table td {
    vertical-align: middle !important;
}  
</style>

<section id="listing">
    <div class="contain-fluid">
        <ul class="crumbs">
            <li><a href="{{url('admin/dashboard')}}">Dashboard</a></li>
            <li>Required Documents</li>
        </ul>
        
        <div class="card_row flex_row" >
            <div class="col">
                <div class="card_blk">
                    <div class="icon" id="total_active"></div>
                    <strong>
                        Active
                    </strong>
                </div>
            </div>
            <div class="col">
                <div class="card_blk">
                    <div class="icon" id="total_inactive"></div>
                    <strong>Inactive</strong>
                </div>
            </div>
            <div class="col">
                <div class="card_blk">
                    <div class="icon" id="total_count"></div>
                    <strong>Total</strong>
                </div>
            </div>
            <div class="col">
                <div class="card_blk" id="add_document_btn">
                    <div class="icon" >
                    <img src="http://127.0.0.1:8000/assets/images/icon-plus.svg" alt="">
                    </div>
                   
                    <strong>Add New</strong>
                </div>
            </div>
            {{--<div class="col">
                <div class="card_blk">
                    
                </div>
            </div>
            <div class="col">
               <div class="card_blk" id="">
                    
                </div>
            </div>--}}
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
                            <th>Document Name</th>
                            <th>Description</th>
                            <th width="40" data-center>Status</th>
                            <th width="40" data-center>Action</th>
                           
                        </tr>
                    </thead>
                    <tbody id="documentListing_html">

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- delete modal start  -->
    <div class="popup sm" id="confirm_popup">
        <div class="table_dv">
            <div class="table_cell">
                <div class="contain">
                    <div class="_inner">
                        <div class="form_row row">
                            <div class="col-sm-12 col-12" style="text-align: center;">
                                <h5>Are you sure you want to delete this record...!!!</h5>
                            </div>
                            <div class="col-sm-12 col-12" style="display: grid; place-items: center;">
                                <div class="btn_blk">
                                    <a href="javascript:;" class="site_btn sm close_confirm" style="background: #ff0505;">No</a>
                                    <a href="javascript:;" class="site_btn sm delete_document_confirmed" data-id="">Yes</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- delete modal end  -->
<!-- Add Document Modal Start -->
<div class="popup sm" id="add_document_popup">
    <div class="table_dv">
        <div class="table_cell">
            <div class="contain">
                <div class="_inner">
                    <div class="form_row row">
                        <button type="button" class="x_btn" id="close_add_modal_btn_default"></button>
                        <div class="col-sm-12 col-12" style="text-align: center;">
                            <h5>Add New Document</h5>
                        </div>
                        <form id="add_document_form">
                            <div class="col-sm-12 col-12">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" id="name" name="name">
                                </div>
                            </div>
                            <div class="col-sm-12 col-12">
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                                </div>
                            </div>
                            
                            <div class="col-sm-12 col-12" style="display: grid; place-items: center;">
                                <div class="btn_blk">
                                    <button type="button" class="site_btn sm btn" style="background:red" id="close_add_modal_btn" >Close</button>
                                    <button type="button" class="site_btn sm " id="save_new_document" onclick="savenewdocument()">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Add Document Modal End -->

<!-- edit Document Modal Start -->
<div class="popup sm" id="edit_document_popup">
    <div class="table_dv">
        <div class="table_cell">
            <div class="contain">
                <div class="_inner">
                    <div class="form_row row">
                        <button type="button" class="x_btn"></button>
                        <div class="col-sm-12 col-12" style="text-align: center;">
                            <h5>Edit Document</h5>
                        </div>
                        <form id="edit_document_form">
                            <input type="hidden" name="document_id_edit" id="document_id_edit">
                            <div class="col-sm-12 col-12">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" id="name_edit" name="name_edit">
                                </div>
                            </div>
                            <div class="col-sm-12 col-12">
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea class="form-control" id="description_edit" name="description_edit" rows="3"></textarea>
                                </div>
                            </div>
                            
                            <div class="col-sm-12 col-12" style="display: grid; place-items: center;">
                                <div class="btn_blk">
                                    <button type="submit" class="site_btn sm " id="update_document" >Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- edit Document Modal End -->


</section>



@endsection

@push('script')
    
<script src="{{ asset('assets_admin/customjs/script_required_documents.js') }}"></script>
    
@endpush
