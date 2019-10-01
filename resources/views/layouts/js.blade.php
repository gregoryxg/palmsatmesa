<script src="{{ asset('js/jquery-3.4.1.js') }}"></script>
<script>window.jQuery || document.write('<script src="{{ asset('js/bootstrap.bundle.js') }}"><\/script>')</script>
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
<script src="{{asset('js/moment.js')}}"></script>
<script src="https://unpkg.com/vue"></script>
<script src="https://unpkg.com/vuejs-datepicker"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.3.4/jquery.inputmask.bundle.js"></script>

@yield('page_js')

<script>
    $(document).ready(function($) {
        $(".table-row").click(function() {
            window.document.location = $(this).data("href");
        });
    });
</script>

<script type="text/javascript">
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#profile_preview').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);


        }
    }
</script>
<script>
    // Add the following code if you want the name of the file appear on select
    $(".custom-file-input").on("change", function() {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });
</script>

<script>
    $(document).ready(function(){
        $('#mobile_phone').inputmask({"mask": "(###) ###-####"});
        $('#work_phone').inputmask({"mask": "(###) ###-####"});
        $('#home_phone').inputmask({"mask": "(###) ###-####"});
        $('#phone').inputmask({"mask": "(###) ###-####"});
    });
</script>
