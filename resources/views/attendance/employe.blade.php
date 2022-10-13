







@extends('layouts.app')
@section('title', 'Gestion des employée')

@section('content')
<section class="content-header">
    <h1>Gestion des employée</h1>
</section>
<!-- Main content -->
<section class="content">

    @component('components.widget', ['class' => 'box-primary', 'title' => 'Toutes les appareils'])
    @can('roles.view')

    @if (count($employe)>0)
    <table class="table table-bordered table-striped" id="devices_table">
        <thead>
            <tr>
                <th>firstName</th>
                <th>lastName</th>
                <th>Face Id</th>
                <th>Status</th>
                <th>@lang( 'messages.action' )</th>
            </tr>
        </thead>
    </table>
    @else
    <div class="alert alert-info">
        <a class="close" data-dismiss="alert" href="#">×</a>
        Nous n'avons pas trouvé d'employé.
    </div>
    @endif

    @endcan
    @endcomponent

</section>
@stop
@section('javascript')
<script type="text/javascript">
    //Roles table
    $(document).ready(function() {
        var devices_table = $('#devices_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '/employe',
            buttons: [],
            columnDefs: [{
                "targets": 1,
                "orderable": false,
                "searchable": false
            }]
        });
        $(document).on('click', 'button.delete_device_button', function() {
            swal({
                title: LANG.sure,
                text: "This device will be deleted.",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    var href = $(this).data('href');
                    var data = $(this).serialize();

                    $.ajax({
                        method: "DELETE",
                        url: href,
                        dataType: "json",
                        data: data,
                        success: function(result) {
                            if (result.success == true) {
                                toastr.success(result.msg);
                                devices_table.ajax.reload();
                            } else {
                                toastr.error(result.msg);
                            }
                        }
                    });
                }
            });
        });
    });
</script>
@endsection