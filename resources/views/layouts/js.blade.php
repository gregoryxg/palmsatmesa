<script src="{{ asset('js/jquery-3.4.1.js') }}"></script>
<script>window.jQuery || document.write('<script src="{{ asset('js/bootstrap.bundle.js') }}"><\/script>')</script>
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
<script src="{{asset('js/moment.js')}}"></script>
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