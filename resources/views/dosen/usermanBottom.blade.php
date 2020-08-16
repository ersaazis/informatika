<script>
$(document).ready(function() {
    $("#cb_roles_id").change(function(){
        var selectedCountry = $(this).children("option:selected").val();
        if(selectedCountry == 2)
            $('#informasi_dosen').show();
        else
            $('#informasi_dosen').hide();
    });
});
</script>