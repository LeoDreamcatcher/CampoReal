<?php
session_start();

class Aluno {
    // atributos da classe aluno, com matricula protegida e dados privados
    private $nome;
    protected $matricula;
    private $curso;

    public function __construct($nome, $matricula, $curso) {
        $this->nome = $nome;
        $this->matricula = $matricula;
        $this->curso = $curso;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getMatricula() {
        return $this->matricula;
    }

    public function getCurso() {
        return $this->curso;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function setCurso($curso) {
        $this->curso = $curso;
    }
}

class CadastroAlunos {
    //array privado
    private $alunos = [];

    //funções para adição, exlusão e edição de alunos, utilizando os "sets" dos atributos.
    public function cadastrarAluno(Aluno $aluno) {
        $this->alunos[$aluno->getMatricula()] = $aluno;
    }

    public function listarAlunos() {
        return $this->alunos;
    }

    public function editarAluno($matricula, $nome, $curso) {
        if (isset($this->alunos[$matricula])) {
            $this->alunos[$matricula]->setNome($nome);
            $this->alunos[$matricula]->setCurso($curso);
        }
    }

    public function excluirAluno($matricula) {
        if (isset($this->alunos[$matricula])) {
            unset($this->alunos[$matricula]);
        }
    }
}

// Verifica se os dados do formulário foram submetidos
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_SESSION['cadastro'])) {
        $_SESSION['cadastro'] = new CadastroAlunos();
    }

    // Verifica qual botão foi clicado
    if (isset($_POST["submit_cadastro"])) {
        $nome = $_POST["nome"];
        $matricula = $_POST["matricula"];
        $curso = $_POST["curso"];

        $aluno = new Aluno($nome, $matricula, $curso);

        // Cadastra o aluno
        $_SESSION['cadastro']->cadastrarAluno($aluno);
    } elseif (isset($_POST["submit_edicao"])) {
        $matricula = $_POST["matricula_edit"];
        $nome = $_POST["nome_edit"];
        $curso = $_POST["curso_edit"];

        // Edita o aluno
        $_SESSION['cadastro']->editarAluno($matricula, $nome, $curso);
    } elseif (isset($_POST["submit_exclusao"])) {
        $matricula = $_POST["matricula_excluir"];

        // Exclui o aluno
        $_SESSION['cadastro']->excluirAluno($matricula);
    }
}
?>

<!-- HTML para obtenção de infos do aluno no CRUD. -->
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Cadastro de Alunos</title>
</head>
<body>
    <h1>Cadastro de Alunos</h1>

    <h2>Cadastrar Aluno</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="nome">Nome:</label><br>
        <input type="text" id="nome" name="nome"><br>

        <label for="matricula">Matrícula:</label><br>
        <input type="text" id="matricula" name="matricula"><br>

        <label for="curso">Curso:</label><br>
        <input type="text" id="curso" name="curso"><br>

        <input type="submit" name="submit_cadastro" value="Cadastrar">
    </form>

    <h2>Editar Aluno</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="matricula_edit">Matrícula:</label><br>
        <input type="text" id="matricula_edit" name="matricula_edit"><br>

        <label for="nome_edit">Novo Nome:</label><br>
        <input type="text" id="nome_edit" name="nome_edit"><br>

        <label for="curso_edit">Novo Curso:</label><br>
        <input type="text" id="curso_edit" name="curso_edit"><br>

        <input type="submit" name="submit_edicao" value="Editar">
    </form>

    <h2>Excluir Aluno</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="matricula_excluir">Matrícula do Aluno a ser excluído:</label><br>
        <input type="text" id="matricula_excluir" name="matricula_excluir"><br>

        <input type="submit" name="submit_exclusao" value="Excluir">
    </form>

    <?php
    if (isset($_SESSION['cadastro']) && !empty($_SESSION['cadastro']->listarAlunos())) {
        echo "<h2>Alunos Cadastrados:</h2>";
        foreach ($_SESSION['cadastro']->listarAlunos() as $aluno) {
            echo "<p>Nome: " . $aluno->getNome() . "</p>";
            echo "<p>Matrícula: " . $aluno->getMatricula() . "</p>";
            echo "<p>Curso: " . $aluno->getCurso() . "</p>";
            echo "<hr>";
        }
    } else {
        echo "<p>Nenhum aluno cadastrado.</p>";
    }
    ?>
</body>
</html>
