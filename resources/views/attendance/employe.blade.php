@extends('layouts.app')
@section('title', __('product.variations'))

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>Employé Liste
        <!-- <small>@lang('lang_v1.manage_product_variations')</small> -->
    </h1>
    <!-- <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
        <li class="active">Here</li>
    </ol> -->
</section>

<!-- Main content -->
<section class="content">
    @component('components.widget', ['class' => 'box-primary', 'title' => "Today Attendance"])
        @slot('tool')
            <!-- <div class="box-tools">
                <button type="button" class="btn btn-block btn-primary btn-modal" 
                data-href="{{action('VariationTemplateController@create')}}" 
                data-container=".variation_modal">
                <i class="fa fa-plus"></i> @lang('messages.add')</button>
            </div> -->
        @endslot
        <div class="table-responsive">
            <table class="table table-bordered table-striped" id="variation_table">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Face Id</th>
                        <th>Password</th>
                        <th>Status</th>
                    </tr>
                </thead>
                @if(!empty($employe))
                    @foreach($employe as $emp)
                        <tr>
                        
                            <td>{{$emp->name}}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="4" class="text-center">
                            -
                        </td>
                    </tr>
                @endif
            </table>
        </div>
    @endcomponent

    <div class="modal fade variation_modal" tabindex="-1" role="dialog" 
    	aria-labelledby="gridSystemModalLabel">
    </div>

</section>
<!-- /.content -->

@endsection
