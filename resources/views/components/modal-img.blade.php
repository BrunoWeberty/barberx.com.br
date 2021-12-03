<div class="modal fade" id="modalImg" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="mediumModalLabel">Imagem cadastrada</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <img id="imgModalLoad" src="" alt="" class="img-responsive img">
                {{-- <p></p> --}}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>
<script>
    function abreModalImg(imagem){
        $('#loader').fadeIn('fast');
        $('#imgModalLoad').attr('src',imagem);
        $('#loader').fadeOut('fast');
    }
</script>