<div class="modal fade" id="modalExcluir" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="mediumModalLabel">Atenção</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Deseja realmente excluir este registro?</p>
            </div>
            <div class="modal-footer">
                <a onclick="showLoad();" id="linkExclusao" href="#" type="button" class="btn btn-danger" id="delete">Apagar Registo</a>
                <button type="button" data-dismiss="modal" class="btn btn-default">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<script>
    function abreModalExcluir(url){
        $('#linkExclusao').attr('href', url)
    }

    function showLoad(){
        $('#loader').fadeIn('fast');
    }
</script>