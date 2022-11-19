@extends('layouts.default')
@section('title', __('faq.create_new_faq'))
@section('page-title', __('faq.create_new_faq'))

@section('content')

    <div class="row">
        <div class="col-12">
            <form class="" action="#" method="POST" id="add_faq_form">
                <div class="row">
                    <div class="col-sm-9 col-md-9 col-xl-9">
                        <div class="card m-b-30">
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-12">
                                        <label class="col-form-label" for="FAQ_Question">{{ __('faq.question') }}:</label>
                                        <input type="text" class="form-control" name="FAQ_Question" id="FAQ_Question"
                                            placeholder="{{ __('core.enter') . ' ' . __('faq.question') }}" required />
                                    </div>
                                    <div class="form-group ck-editor__editable_inlin col-12">
                                        <label class="col-form-label" for="area">{{ __('core.body') }}:</label>
                                        <textarea id="FAQ_Answer" name="FAQ_Answer" required></textarea>
                                        <label id="FAQ_Answer_error"></label>
                                    </div>
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-success waves-effect waves-light">
                                            <i class="fa fa-dot-circle-o"></i> {{ __('core.submit') }}
                                        </button>
                                        <button type="reset" class="btn btn-danger" onclick="RemoveTextAreaBody()">
                                            <i class="fa fa-ban"></i> {{ __('core.reset') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
@endsection



@section('js')
    @include('layouts.text_editor')

    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <script>
        function RemoveTextAreaBody() {
            $('.ck-content').empty();
        }
        $(document).ready(function() {
            var getUrl = window.location;
            var baseUrl = getUrl.protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[0];

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });



            //imprt classic editor initialization
            classicEditorAllFunctions();

            //create instance from the editor
            ClassicEditor
                .create(document.querySelector('#FAQ_Answer'), {

                    extraPlugins: [SimpleUploadAdapterPlugin]
                })
                .catch(error => {
                    console.error(error);
                });

            //------------validation for add faq------------
            $("#add_faq_form").validate({
                rules: {
                    "FAQ_Question": {
                        required: true,
                        maxlength: 250
                    },

                },
                messages: {
                    "FAQ_Question": {
                        required: "{{ __('customeValidation.FAQ_Question_Req') }}",
                        maxlength: "{{  __('customeValidation.FAQ_Question_Length')  }}"
                    },

                },
                submitHandler: function(form) { // for demo
                    addFaq();
                    return false;
                }
            });

            //------------add Faq------------
            function addFaq() {
                var bodyContent = $('#FAQ_Answer').val().trim();

                if (bodyContent == '') {
                    $('#FAQ_Answer_error').css('color', 'red').text("{{ __('customeValidation.body') }}");
                    return;
                } else {
                    var fd = new FormData();
                    fd.append('FAQ_Question', $('#FAQ_Question').val());
                    fd.append('FAQ_Answer', $('#FAQ_Answer').val());

                    $.ajax({
                        url: "{{ route('faq.store') }}",
                        type: "POST",
                        processData: false,
                        contentType: false,
                        data: fd,
                        beforeSend: function() {
                            showLoading("{{ __('core.loading') }}");
                        },
                        success: function(response) {
                            if (response.status) {
                                successAlert(response.message, "{{ __('core.success_done') }}",
                                    "{{ __('core.ok') }}", "this");
                            } else {
                                errorAlert(response.message, "{{ __('core.cancelled') }}");
                            }
                        },
                        error: function(err) {
                            var errors_msgs = err.responseJSON.errors;
                            var error_msg = '{{ __('errorMessages.something_went_wrong') }}';
                            if (errors_msgs.length != 0) {
                                for (const x in errors_msgs) {
                                    for (var i = 0; i < errors_msgs[x].length; i++) {
                                        error_msg += '<br>' + errors_msgs[x][i];
                                    }
                                }
                            }
                            errorAlert(error_msg, "{{ __('core.cancelled') }}");
                            return;
                        }
                    });
                }
            }


        });
    </script>
@endsection
