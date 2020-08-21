<div class="modal fade" id="previewFile">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Preview Dokumen</h4>
        </div>
        <div class="modal-body">
            <iframe style="height:70vh; width:100%; border:none; margin:0; padding:0; overflow:hidden;" src="" id='frameDokumen'></iframe>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <a href="" id='downloadDokumen' type="button" class="btn btn-primary pull-left">Download</a>
        </div>
        </div>
    </div>
</div>
<script src="{{url('/cb_asset/js/bootstrap-toggle/bootstrap-toggle.min.js')}}"></script>
<script>
    $('.dokumensaya').change(function(e){
        var thisClass = this;
        var id = $(this).val();
        var url = "{{cb()->getAdminUrl('/cari_dokumen/dokumen/')}}/"+id+"/"+$(this).prop('checked');
        // console.log(url);
        $.get(url).fail(function(e) {
            alert( "Terdapat Ganguan Koneksi" );
        });
    });
    $('[data-toggle="toggle"]').bootstrapToggle({
        on: 'Ya',
        off: 'Bukan'
    });
    $('.preview').click(function(e){
        var href = $(this).attr('href');
        $('#frameDokumen').attr('src',"https://docs.google.com/viewerng/viewer?url="+href);
        $('#downloadDokumen').attr('href',href);
        $('#previewFile').modal('show');
        return false;
    });
</script>
