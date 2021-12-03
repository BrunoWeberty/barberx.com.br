<link rel="stylesheet" href="{{ asset('/assets/css/dataTables.bootstrap4.css') }}">
<link rel="stylesheet" href="{{ asset('/assets/css/responsive.bootstrap4.css') }}">
<script src="{{ asset('/assets/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('/assets/js/dataTables.bootstrap4.js') }}"></script>
<script src="{{ asset('/assets/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('/assets/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('/assets/js/demo.datatable-init.js') }}"></script>

<script>
    function exibeLoad(){
        if(confirm('Deseja realmente excluir?')){
            $('#loader').fadeIn('fast');
        }else{
            return false;
        }
    }
</script>