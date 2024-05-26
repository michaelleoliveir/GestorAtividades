$(document).ready(function () {

    $.ajax({
      method: "POST",
      url: "./backend/login.php",
      data: { operation: "load" },
    }).done(function (resposta) {
      var obj = $.parseJSON(resposta);

      if (obj.nome != "undefined") {
        $("#acesso").val(obj.acesso);
        $("#senha").val(obj.senha);
        $("#armazenar").toggle(false);
      } else {
        $("#armazenar").toggle(true);
      }
    })
  })

  $("#armazenar").click(function () {
    var acesso = $("#acesso").val();
    var senha = $("#senha").val();

    $.ajax({
      method: 'post',
      url: './backend/login.php',
      data: {
        operation: "login",
        acesso: acesso,
        senha: senha
      },
      beforeSend: function (xhr) {
        xhr.setRequestHeader(
          "Authorization",
          "Basic " + btoa(acesso + ":" + senha)
        );
      },
      error: function (xhr) {
        $('#errorModal').modal('show');
      },
    }).done(function (resposta) {
      var obj = $.parseJSON(resposta);

      if (obj.status == "logado") {
        window.location.href = "gestor-page.html";
      } else {
        window.location.href = "login-page.html";
      }
    })

  });