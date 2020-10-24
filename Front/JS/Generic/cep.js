//TRAZER CIDADES E ESTADOS API IBGE
var optionsUf = '';
        $.get({
            url: 'https://servicodados.ibge.gov.br/api/v1/localidades/estados',
            success: function(res){
                // optionsUf = '<option>Selecione o estado</option>';
                for(i = 0; i < res.length; i++) {
                    optionsUf += '<option value="'+res[i].id+'">'+res[i].nome+'</option>';
                }
                $('#estado').html(optionsUf);
            }
        });

        $('#estado').change(function () {
            console.log('entrou')
            var cidades = '';
            var categoria = '{{ \Request::segment(1) }}';
            $.ajax({
                url: 'https://servicodados.ibge.gov.br/api/v1/localidades/estados/'+$(this).val()+'/municipios',
                data: {
                    categoria: categoria,
                    _token: '{{ @csrf_token() }}',
                    estado_id: $(this).val(),
                    pais_id: $('select[name="pais_id"]').val()

                },
                method: 'POST',
                type: 'json',
                success: function (res) {
                    console.log(res)

                    // cidades = '<option>Selecione a cidade</option>';
                    for (i = 0; i < res.length; i++) {
                        cidades += '<option value="' + res[i].nome + '">' + res[i].nome + '</option>';
                    }
                    $('#cidade').html(cidades);
                }
            });
        });
