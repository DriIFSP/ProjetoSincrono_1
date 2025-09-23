<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cadastro de Funcionário</title>
  <link rel="icon" type="image/x-icon" href="../assets/favicon.ico">
  <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="css/estilo.css">
</head>

<body>
  <div class="container py-4">

    <!-- Botão de voltar -->
    <a href="../index.html" class="btn btn-secondary mb-3">Voltar</a>

    <h2 class="mb-4">Cadastro Síncrono</h2>

    <form method="POST" id="form1" name="form1" action="cadastrafuncionario.php" enctype="multipart/form-data">

      <div class="row">

        <!-- Coluna da imagem -->
        <div class="col-lg-5 text-center mb-4">
          <img src="img/moldura.png" id="preview" alt="Pré-visualização" class="img-fluid rounded mb-3" width="60%">
          <input type="file" id="foto" name="foto" accept=".png,.jpg" class="form-control" onchange="previewImagem(this)" required>
        </div>

        <!-- Coluna dos campos -->
        <div class="col-lg-7">

          <!-- Seleção de Funcionário -->
          <div class="form-group mb-3">
            <label for="func"><b>Escolha o Funcionário:</b></label>
            <select id="func" name="func" class="form-control w-50" required>
              <option value="" selected disabled>--- Selecione ---</option>
              <option value="Ana Andrade">Ana Andrade</option>
              <option value="Bruna Costa">Bruna Costa</option>
              <option value="Carlos Montreal">Carlos Montreal</option>
              <option value="João Freitas">João Freitas</option>
              <option value="Paulo Santos">Paulo Santos</option>
              <option value="Rita Passaros">Rita Passaros</option>
            </select>
          </div>

          <!-- Valor de Vendas -->
          <div class="form-group mb-3">
            <label for="valor"><b>Digite o valor de Vendas do Mês:</b></label>
            <input type="text" id="valor" name="valor" class="form-control w-25" placeholder="Valor Vendas"
              onkeypress="mascara(this, moeda)" maxlength="10" required>
          </div>

          <!-- Seleção de Segmento -->
          <div class="form-group mb-3">
            <label for="segmento"><b>Escolha o Segmento:</b></label>
            <select id="segmento" name="segmento" class="form-control w-50" required>
              <option value="" selected disabled>--- Selecione ---</option>
              <option value="Automóveis">Automóveis</option>
              <option value="Imóveis">Imóveis</option>
              <option value="Seguro Residencial">Seguro Residencial</option>
              <option value="Seguro Automóvel">Seguro Automóvel</option>
            </select>
          </div>

          <!-- Botão de envio -->
          <button type="submit" class="btn btn-primary btn-xl" onclick="validarFormulario(event)">Cadastrar</button>
        </div>
      </div>
    </form>
  </div>

  <!-- Scripts no final -->
  <script>
    // Preview da imagem
    function previewImagem(campo) {
      if (campo.files && campo.files[0]) {
        const reader = new FileReader();
        reader.onload = function (e) {
          document.getElementById("preview").src = e.target.result;
        };
        reader.readAsDataURL(campo.files[0]);
      }
    }

    // Validação do formulário
    function validarFormulario(e) {
      e.preventDefault(); // evita envio automático

      const form = document.getElementById("form1");
      const func = document.getElementById("func").value;
      const segmento = document.getElementById("segmento").value;
      const valor = document.getElementById("valor").value;
      const foto = document.getElementById("foto").value;

      if (func === "") {
        alert("Escolha um Funcionário");
        document.getElementById("func").focus();
        return;
      }
      if (segmento === "") {
        alert("Escolha um Segmento");
        document.getElementById("segmento").focus();
        return;
      }
      if (valor === "") {
        alert("Digite o valor");
        document.getElementById("valor").focus();
        return;
      }
      if (foto === "") {
        alert("É obrigatório anexar uma foto!");
        return;
      }

      form.submit();
    }

    // Máscara de moeda
    function mascara(o, f) {
      v_obj = o;
      v_fun = f;
      setTimeout("execmascara()", 1);
    }

    function execmascara() {
      v_obj.value = v_fun(v_obj.value);
    }

    function moeda(v) {
      v = v.replace(/\D/g, ""); // permite apenas números
      v = v.replace(/(\d{1})(\d{1,2})$/, "$1.$2"); // vírgula antes dos 2 últimos dígitos
      return v;
    }
  </script>
</body>
</html>