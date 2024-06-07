@extends('layouts.master.admin_template.master')

@push('css')
@endpush

@section('content')
	
    <!-- Dashboard Section -->
    <section id="dash">
        <div class="contain-fluid">
            <p class="text-center">Error: {{@$error}}</p>
        </div>
    </section>
        

@endsection

@push('script')
    
    <!-- <script src="{{ asset('assets_admin/customjs/script_adminorders.js') }}"></script> -->
    
@endpush
