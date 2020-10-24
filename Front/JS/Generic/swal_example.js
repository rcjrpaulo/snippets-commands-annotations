// refresh the page
swal("Proposta distratada com sucesso!!", {
    icon: "success",
})
    .then(() => location.reload())

//swal alerting
swal({icon: "error", dangerMode: true, text: 'Valor atual não pode ser zerado'})

//swal asking the user
swal({
    title: "Você tem certeza?",
    text: "Todos os valores de pré itbi desse empreendimento serão resetados",
    icon: "error",
    buttons: {
        cancel: "Cancelar",
        confirm: "Confirmar",
    },
    dangerMode: true,
})
    .then((confirmouAcao) => {
        if (confirmouAcao) {
            let id_empreend = self.torresNumeradas[0][0][0].id_empreend

            let data = {
                id_empreend: id_empreend
            }

            $.ajax({
                url: self.urlResetar,
                type: 'POST',
                data: data,
                success: function (response) {
                    if(response.message == 'success') {
                        swal("Reset feito com sucesso !", {
                            icon: "success",
                        }).then(() => location.reload())
                    }
                }
            })

        } else {
            // if user denies
        }
    });