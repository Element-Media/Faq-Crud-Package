@extends('layouts.default')
@section('title', __('faq.faq_list'))
@section('page-title', __('faq.faq_list'))
@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card m-b-30">
                <div class="card-body">
                    <table id="faqDatatable" class="col-12 table table-striped dt-responsive nowrap"
                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>{{ __('faq.question') }}</th>
                                <th width="5%">{{ __('core.action') }}</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        $(document).ready(function() {
            var getUrl = window.location;
            var baseUrl = getUrl.protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[0];

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            //----------------show page-------------------------
            var table = $('#faqDatatable').DataTable({
                "processing": true,
                "serverSide": true,
                lengthChange: false,
                dom: '<"row"<"col-sm-12 col-md-6"lB><"col-sm-12 col-md-6"f>><"row"rt><"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
                buttons: [{
                    text: "{{ __('faq.create_new_faq') }}",
                    className: 'btn btn-primary',
                    action: function() {
                        window.location = "{{ route('faq.create') }}";
                    },
                    init: function(api, node, config) {
                        $(node).removeClass('btn-secondary')
                    }
                }],
                "order": [],
                'ajax': {
                    'url': "{{ route('faq.list') }}",
                    'type': 'GET'
                },
                "columns": [

                    {
                        data: 'Faq_Question',
                        name: 'Faq_Question'
                    },
                    {
                        data: 'Faq_ID',
                        name: 'Faq_ID',
                        mRender: function(data, row, fulldata) {
                            return '<a href="{{ url('admin/faq/edit/') }}/' + data + '" data-id="' +
                                data +
                                '" class=" btn btn-primary btn-sm btn-delete" ><i class="far fa-edit"></i></a>' +
                                '<a href="#" data-id="' + data +
                                '" class="delete-faq btn btn-danger btn-sm btn-delete" ><i class="far fa-trash-alt"></i></a>';
                        }
                    },
                ]
            });

            //----------------End show page-------------------------

            //----------------Delete page-------------------------
            @include('admin.jsFunctions.delete_function', [
                'model' => 'faq',
                'table_id' => '#faqDatatable',
                'delete_button_class' => '.delete-faq',
            ])
            //--------------end delete page---------------------
        });
    </script>
@endsection
