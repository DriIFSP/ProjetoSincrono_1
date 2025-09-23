<?php
// Inclui a conexão com o banco de dados
include 'conecta.inc';

// Diretório para salvar imagens
$dir = "img/";

// -------------------------------
// VERIFICA SE O FORMULÁRIO FOI ENVIADO CORRETAMENTE - o isset confere se os dados foram passados
// -------------------------------
if (isset($_POST['func'], $_POST['valor'], $_POST['segmento'], $_FILES['foto'])) {

    // Recebe os valores do formulário
    $nome = $_POST['func'];
    $valor = $_POST['valor'];
    $segmento = $_POST['segmento'];
    $arquivo = $_FILES['foto'];
    $foto = $_FILES['foto']['name'];

    // -------------------------------
    // VALIDAÇÃO BÁSICA DOS CAMPOS
    // -------------------------------
    if ($nome == "" || $valor == "" || $foto == "" || $segmento == "") {
        echo "<script>
            alert('Preencha todos os campos');
            history.back();
        </script>";
        exit;
    }

    // -------------------------------
    // CONVERTENDO VALOR PARA NÚMERO
    // -------------------------------
    // Garante que valores como "1.500,50" ou "1500.50" sejam convertidos corretamente
    $valor = floatval(str_replace(',', '.', $valor));

    // -------------------------------
    // CÁLCULO DO BÔNUS
    // -------------------------------
    if($valor < 500.00)
        $bonus = $valor * 0.01;        // 1% de bônus
    elseif($valor < 1001.00)
        $bonus = $valor * 0.05;        // 5% de bônus
    elseif($valor < 3001.00)
        $bonus = $valor * 0.10;        // 10% de bônus
    else
        $bonus = $valor * 0.15;        // 15% de bônus

    // -------------------------------
    // CAPTURANDO MÊS E ANO ATUAL
    // -------------------------------
    $data = new DateTime();
    $ano = $data->format("Y");   // Ano atual
    $mes = $data->format("n");   // Mês atual (1-12)

    // -------------------------------
    // VERIFICA DUPLICIDADE NO BANCO
    // -------------------------------
    $resul = mysqli_query($con, "SELECT * FROM tbfuncmes WHERE nome='$nome' AND segmento='$segmento' AND mes='$mes' AND ano='$ano'")
        or die ("Erro na consulta ao banco");

    $total = mysqli_num_rows($resul);

    if($total < 1) {
        // -------------------------------
        // UPLOAD DA IMAGEM
        // -------------------------------
        $ext = pathinfo($foto, PATHINFO_EXTENSION);                     // Pega extensão do arquivo
        $novo_nome = $nome . "_" . date("Ymd_His") . "." . $ext;       // Gera nome único
        $destino = $dir . $novo_nome;                                   // Caminho final

        if (move_uploaded_file($arquivo["tmp_name"], $destino)) {
            echo "<script>alert('Foto transferida com sucesso!');</script>";
        } else {
            echo "<script>
                alert('Erro ao carregar o arquivo');
                history.back();
            </script>";
            exit; // Encerra execução se falhar upload
        }

        // -------------------------------
        // INSERÇÃO NO BANCO
        // -------------------------------
        $sql = "INSERT INTO tbfuncmes (nome, vrvenda, vrbonus, caminhoimg, segmento, mes, ano)
                VALUES ('$nome', '$valor', '$bonus', '$destino', '$segmento', '$mes', '$ano')";
        mysqli_query($con, $sql) or die ("Erro ao incluir no banco");

        // -------------------------------
        // FEEDBACK AO USUÁRIO
        // -------------------------------
        echo "<script>
            alert('Venda do Funcionário incluída com sucesso neste Mês, Ano e Segmento!');
            history.back();
        </script>";

    } else {
        // Já existe registro
        echo "<script>
            alert('Já foi cadastrado as vendas deste funcionário para este segmento, mês e ano');
            history.back();
        </script>";
    }

    // -------------------------------
    // FECHANDO A CONEXÃO COM O BANCO
    // -------------------------------
    mysqli_close($con);

} else {
    // Formulário não enviado corretamente
    echo "<script>
        alert('Formulário não enviado corretamente');
        history.back();
    </script>";
    exit;
}
?>
