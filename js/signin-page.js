$(document).ready(function () {
    $('#armazenar').click(function () {
        event.preventDefault();

        var _nome = $("#nome").val();
        var _sobrenome = $("#sobrenome").val();
        var _nascimento = $("#nascimento").val();
        var _senha = $("#senha").val();
        var _acesso = $("#acesso").val();

        $.ajax({
            method: "POST",
            url: "./backend/signin.php",
            data: {
                nome: _nome,
                sobrenome: _sobrenome,
                nascimento: _nascimento,
                senha: _senha,
                acesso: _acesso,
            }
        }).done(function (response) {
            if (response === "sucesso") {
                $('#successModal').modal('show');
                $('#nome').val('');
                $('#sobrenome').val('');
                $('#nascimento').val('');
                $('#senha').val('');
                $('#acesso').val('');
            } else {
                $('#errorModal').modal('show');
            }
        }).fail(function (xhr, status, error) {
            $('#errorModal').modal('show');
        });
    }
    )
})