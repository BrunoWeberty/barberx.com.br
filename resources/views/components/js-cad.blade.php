<link rel="stylesheet" href="{{ asset('assets/css/chosen.min.css') }}">
<script src="{{ asset('assets/js/jquery.maskedinput.js') }}"></script>
<script src="{{ asset('assets/js/jquery.validate.min.js') }}"></script>
<script src="{{ asset('assets/js/chosen.jquery.min.js') }}"></script>
<script>
    jQuery(document).ready(function () {
        jQuery(".standardSelect").chosen({
            disable_search_threshold: 10,
            no_results_text: "Ops, sem nenhum resultado!",
            width: "100%"
        });
    });

    function voltarPag() {
        window.history.back();
    }
    
    $(function () {

        $("#cpf").mask("999.999.999-99");
        $('#telefone').mask("(9?9) 999999999").ready(function (event) {
            var target, phone, element;
            target = (event.currentTarget) ? event.currentTarget : event.srcElement;
            phone = (/\D/g, '');//tirando todos caracteres
            element = $(target);
            //element.unmask();   // ver sobre isso depois
            if (phone.length > 10) {
                element.mask("(9?9) 999999999");
            } else {
                element.mask("(9?9) 9999999999");
            }
        });
        $("#formulario").validate({
            errorClass: "is-invalid",
            validClass: "is-valid",
            errorPlacement: function (error, element) {
                error.appendTo(element.parent("td").next("td"));//retirando o label para erro
            },
            rules: {
                name: {
                    minlength: 3,
                    maxlength: 70
                }
            },
            messages: {
                name: {required: ""}
            }
        });
        $("#payment-button").click(function(){
            //exclusivo apenas para produtos
            if ($('#categoria').val() == ''){
                alert('É necessário selecionar a Categoria do Produto!');
                return false;
            }
            if ($('#marca').val() == ''){
                alert('É necessário selecionar a Marca do Produto!');
                return false;
            }
            if ($("#formulario").valid()) { //Verifica se o formulário está válido, ai sim exibe loader.
                $('#loader').fadeIn('fast');
            }
        });

    });
</script>
