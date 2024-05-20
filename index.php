<?php
session_start();
include_once 'config.php';

if ($conn->connect_error) {
    die("Conexão com o banco de dados falhou: " . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projeto | CRUD, PHP e JS</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

</head>
<body>
    <div class="container">
        <h2>Formulario com CRUD - Victor&Adrielle</h2>

        <form id="myForm">
            <input type="hidden" id="id" name="id">
            <div class="form-group">
                <label for="nome" class="labelInput">Nome Completo:</label>
                <input type="text" id="name" name="nome" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="data_nascimento" class="labelInput">Data de Nascimento:</label>
                <input type="date" id="age" name="data_nascimento" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="endereco" class="labelInput">Endereço:</label>
                <input type="text" id="address" name="endereco" class="form-control" placeholder="Rua..." required>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="cidade" class="labelInput">Cidade:</label>
                    <input type="text" id="city" name="cidade" class="form-control" required>
                </div>
                <div class="form-group col-md-4">
                    <label for="estado">Estado:</label>
                    <select id="state" name="estado" class="form-control" required>
                        <option selected>Selecione um estado</option>
                        <option value="AC">AC</option>
                        <option value="AL">AL</option>
                        <option value="AP">AP</option>
                        <option value="AM">AM</option>
                        <option value="BA">BA</option>
                        <option value="CE">CE</option>
                        <option value="DF">DF</option>
                        <option value="ES">ES</option>
                        <option value="GO">GO</option>
                        <option value="MA">MA</option>
                        <option value="MT">MT</option>
                        <option value="MS">MS</option>
                        <option value="MG">MG</option>
                        <option value="PA">PA</option>
                        <option value="PB">PB</option>
                        <option value="PR">PR</option>
                        <option value="PE">PE</option>
                        <option value="PI">PI</option>
                        <option value="RJ">RJ</option>
                        <option value="RN">RN</option>
                        <option value="RS">RS</option>
                        <option value="RO">RO</option>
                        <option value="RR">RR</option>
                        <option value="SC">SC</option>
                        <option value="SP">SP</option>
                        <option value="SE">SE</option>
                        <option value="TO">TO</option>
                    </select>
                </div>
            <div class="container">
                <button id="btn-submit" type="submit" name="submit" class="btn btn-primary">Adicionar</button>
            </div>
            
        </form>

        <div class="container">
            <div class="row">
                <h2>Usuários Cadastrados</h2>
            </div>

            <?php 
                $sql = "SELECT * FROM formulario";
                $result = $conn->query($sql);
                if ($result && $result->num_rows>0):
            ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>Nome</th>
                        <th>Data de Nascimento</th>
                        <th>Endereço</th>
                        <th>Cidade</th>
                        <th>Estado</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        while ($row = $result->fetch_assoc()):
                    ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['nome']; ?></td>
                        <td><?php echo date('d/m/Y', strtotime($row['dt_nascimento'])); ?></td>
                        <td><?php echo $row['endereco']; ?></td>
                        <td><?php echo $row['cidade']; ?></td>
                        <td><?php echo $row['estado']; ?></td>
                        <td>
                            <button type="button" data-id="<?php echo $row['id']; ?>" class="btn btn-sm btn-warning get-btn">Editar</button>
                            <button type="button" data-id="<?php echo $row['id']; ?>" class="btn btn-sm btn-danger delete-btn">Excluir</button>
                        </td>
                    </tr>
                    <?php
                        endwhile;
                    ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
        


    <script>

        let data = [];

        $('.get-btn').click(function() {
            var id = $(this).data('id');
            
            
            $.ajax({
                url: 'getById.php',
                type: 'GET',
                data: { id: id },
                success: function(data) {
                    var obj = JSON.parse(data);
                    $('#id').val(obj.id);
                    $('#name').val(obj.nome);
                    $('#age').val(obj.dt_nascimento);
                    $('#address').val(obj.endereco);
                    $('#city').val(obj.cidade);
                    $('#state').val(obj.estado);   
                    $('#btn-submit').text('Atualizar');
            
                }
            });
        });

        $('.delete-btn').click(function() {
            var id = $(this).data('id');

            $.ajax({
                url: 'deleteUser.php',
                type: 'POST',
                data: { id: id },
                success: function(response) {
                    alert('Registro deletado com sucesso')
                    location.reload();
                },
                error: function(xhr, status, error) {
                    alert('Erro ao deletar o registro')
                }
            });
        });

        $('form').submit(function(event) {
            event.preventDefault();
            submitForm();
        });
        
        function submitForm() {
            var id = $('#id').val();
            var nome = $('#name').val();
            var data_nascimento = $('#age').val();
            var endereco = $('#address').val();
            var cidade = $('#city').val();
            var estado = $('#state').val();

            var payload = {
            nome: nome,
            data_nascimento: data_nascimento,
            endereco: endereco,
            cidade: cidade,
            estado: estado
            };

            if (id) {
            payload.id = id;
            $.ajax({
                url: 'updateUser.php',
                type: 'POST',
                data: payload,
                success: function(response) {
                    alert('Registro atualizado com sucesso')
                    location.reload();
                },
                error: function(xhr, status, error) {
                    alert('Erro ao atualizar o registro')
                }
            });
            } else {
            $.ajax({
                url: 'createUser.php',
                type: 'POST',
                data: payload,
                success: function(response) {
                    alert('Registro criado com sucesso')
                    location.reload();
                },
                error: function(xhr, status, error) {
                    alert('Erro ao criar o registro')
                }
            });
            }
        }     
    </script>


</body>
</html>
