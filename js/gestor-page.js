$(document).ready(function () {

    // função para criar os cards com base nos dados do banco
    function carregarAtividade() {
        $.ajax({
            method: "GET",
            url: "./backend/crud/get_atividades.php",
            dataType: "json",
            success: function (response) {
                if (response.length > 0) {
                    response.forEach(function (atividades) {

                        let atv_titulo = atividades.ATV_TITULO;
                        let atv_descricao = atividades.ATV_DESCRICAO;
                        let atv_criacao = atividades.ATV_DT_CRIACAO;
                        let atv_status = atividades.ATV_STATUS;
                        let atv_conclusao = atividades.ATV_DT_CONC;
                        let atv_id = atividades.ATV_ID;

                        var conclusaoDate = new Date(atv_conclusao);
                        var today = new Date();

                        var conclusaoClass = '';
                        if (conclusaoDate < today) {
                            conclusaoClass = 'conclusao-passada';
                        }
                        else {
                            conclusaoClass = 'conclusao-outra';
                        }

                        if (atv_status == 0) {

                            var cardHTML = "<div class='col-md-4 mb-4 cartao' style='padding-top: 10px'>" +
                                "<div class='card h-100 d-flex flex-column' style='border-radius: 10px;'>" +
                                "<div class='card-header text-center' style='background-color: #0A2647; border-radius: 10px 10px 0px 0px;'>" +
                                "<h4 class='m-0' style='color: aliceblue; padding: 5px;'>" + atv_titulo + "</h4>" +
                                "</div>" +
                                "<div class='card-body flex-grow-1'>" +
                                "<p style='color: rgba(0, 0, 0, 0.466); margin: 0px; font-size: 12px'>Criado em: " + formatarData(atv_criacao) + "</p>" +
                                "<p class='card-text' style='padding-top: 10px; font-size: 18px'>" + atv_descricao + "</p>" +
                                "<p style='font-size: 14px; text-align: right;' class='" + conclusaoClass + "'>Conclusão: " + formatarData(atv_conclusao) + "</p>" +
                                "</div>" +
                                "<div class='card-footer text-center' style='padding-top: 10px; background-color: transparent; border-top: none;'>" +
                                "<button class='btn btn-danger deletar' data-id='" + atv_id + "' style='margin-right: 10px;'><i class='ri-close-circle-fill'></i></button>" +
                                "<button class='btn btn-success concluido' data-id='" + atv_id + "' style='margin-right: 10px;'><i class='ri-checkbox-circle-fill'></i></button>" +
                                "<button class='btn btn-primary editar' data-id='" + atv_id + "'><i class='ri-edit-circle-fill'></i></button>" +
                                "</div>" +
                                "</div>" +
                                "</div>";

                            $("#atividades").append(cardHTML);
                        }
                    });

                    response.forEach(function (atividades) {
                        let atv_titulo = atividades.ATV_TITULO;
                        let atv_descricao = atividades.ATV_DESCRICAO;
                        let atv_criacao = atividades.ATV_DT_CRIACAO;
                        let atv_status = atividades.ATV_STATUS;
                        let atv_id = atividades.ATV_ID;
                        if (atv_status == 1) {

                            var cardHTML = "<div class='col-md-4 mb-4 cartao' style='padding-top: 10px'>" +
                                "<div class='card h-100 d-flex flex-column' style='border-radius: 10px;'>" +
                                "<div class='card-header text-center' style='background-color: #A8DEC0; border-radius: 10px 10px 0px 0px;'>" +
                                "<h4 class='m-0' style='color: #1D392A; padding: 5px;'>" + atv_titulo + "</h4>" +
                                "</div>" +
                                "<div class='card-body flex-grow-1'>" +
                                "<p style='color: rgba(0, 0, 0, 0.466); margin: 0px'>Criado em: " + atv_criacao + "</p>" +
                                "<p class='card-text' style='padding-top: 10px'>" + atv_descricao + "</p>" +
                                "</div>" +
                                "<div class='card-footer text-center' style='padding-top: 5px; background-color: transparent; border-top: none;'>" +
                                "<button class='btn btn-danger deletar' data-id='" + atv_id + "' style='margin-right: 10px;'><i class='ri-close-circle-fill'></i></button>" +
                                "</div>" +
                                "</div>" +
                                "</div>" +
                                "</div>";

                            $("#atividades").append(cardHTML);
                        }
                    });

                } else {
                    console.log("Não há atividades disponível")
                }
            },
            error: function (xhr, status, error) {
                console.error("Erro ao carregar as atividades: ", error);
            }
        })
    }

    carregarAtividade();

    // Função para formatar a data no formato brasileiro (dia/mês/ano)
    function formatarData(data) {
        var partes = data.split('-');
        return partes[2] + '/' + partes[1] + '/' + partes[0];
    }

    //clicar no botão de créditos
    $("#creditos").click(function () {
        $("#creditosModal").modal('show');
    });

    //clicar no botão de adicionar nova atividade
    $("#adicionar").click(function () {
        $("#atividadesModal").modal('show');
    });

    $('#atividadesModal').on('show.bs.modal', function () {
        var today = new Date().toISOString().split('T')[0];
        $('#criacao').val(today);
    });

    //clicar no botão de criar nova atividade
    $("#btn-criar").click(function () {
        event.preventDefault();

        var _titulo = $("#titulo").val();
        var _descricao = $("#descricao").val();
        var _criacao = $("#criacao").val();
        var _conclusao = $("#conclusao").val();

        $.ajax({
            method: "POST",
            url: "./backend/atividade.php",
            data: {
                titulo: _titulo,
                descricao: _descricao,
                criacao: _criacao,
                conclusao: _conclusao
            }
        }).done(function (response) {
            if (response === "sucesso") {
                $('#successModal').modal('show');
                $('#atividades').empty();
                carregarAtividade();

                //LIMPAR OS CAMPOS QUANDO SE CRIA UMA ATIVIDADE NOVA
                $('#titulo').val('');
                $('#descricao').val('');
                $('#criacao').val('');
                $('#conclusao').val('');
            } else {
                $('#errorModal').modal('show');
            }
        }).fail(function (xhr, status, error) {
            $('#errorModal').modal('show');
        })
    });

    // clicar no botão de cancelar ao criar um novo card
    $(document).on('click', '#btn-cancelar', function () {
        $('#titulo').val('');
        $('#descricao').val('');
        $('#criacao').val('');
        $('#conclusao').val('');
    });

    //para deletar os cards
    $(document).on('click', '.deletar', function () {
        var idAtividade = $(this).data('id');
        var $button = $(this);

        $.ajax({
            method: "POST",
            url: "./backend/crud/remove_atividades.php",
            data: { id: idAtividade },
            success: function (response) {
                $('#removeModal').modal('show');
                $('#atividades').empty();
                carregarAtividade();
            },
            error: function (xhr, status, error) {
                console.error("Erro ao excluir a atividade: ", error);
            }
        })
    });

    var idAtividade;

    //para atualizar os cards
    $(document).on('click', '.editar', function () {
        // Armazena o ID da atividade em uma variável
        idAtividade = $(this).data('id');
        console.log("ID da atividade: " + idAtividade);

        $.ajax({
            method: "GET",
            url: "./backend/id_atividade.php",
            data: {
                id: idAtividade
            },
            dataType: "json",
            success: function (response) {
                $("#titulo-novo").val(response.ATV_TITULO);
                $("#descricao-novo").val(response.ATV_DESCRICAO);
                $("#conclusao-novo").val(response.ATV_DT_CONC);
            },
            error: function (xhr, status, error) {
                console.error("Erro ao obter os detalhes da atividade: ", error)
            }
        });

        $('#editarModal').modal('show');
    });

    $('#btn-atualizar').click(function () {
        event.preventDefault();

        var _tituloNovo = $("#titulo-novo").val();
        var _descricaoNovo = $("#descricao-novo").val();
        var _conclusaoNovo = $("#conclusao-novo").val();

        $.ajax({
            method: "POST",
            url: "./backend/crud/update_atividades.php",
            data: {
                tituloNovo: _tituloNovo,
                descricaoNovo: _descricaoNovo,
                conclusaoNovo: _conclusaoNovo,
                id: idAtividade
            },
        }).done(function (response) {
            if (response.includes("sucesso")) {
                $('#successModal').modal('show');
                $('#atividades').empty();
                carregarAtividade();
            } else {
                $('#errorModal').modal('show');
            }
        }).fail(function (xhr, status, error) {
            $('#errorModal').modal('show');
        });
    });

    //para concluir os cards
    $(document).on('click', '.concluido', function () {
        var idAtividade = $(this).data('id');
        console.log("ID da atividade: " + idAtividade);

        var card = $(this).closest('.cartao');

        $.ajax({
            method: "POST",
            url: "./backend/concluir_atividade.php",
            data: { id: idAtividade },
            success: function (response) {
                if (response === "sucesso") {
                    console.log("status trocado");
                    card.remove();
                    $('#atividades').empty();
                    carregarAtividade();
                }
            },
            error: function (xhr, status, error) {
                console.error("Erro ao excluir a atividade: ", error);
            }
        });
    });


})