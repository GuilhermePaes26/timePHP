<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Jogador e Time</title>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <style>
        /* Reset básico */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f9;
            color: #333;
            padding: 20px;
        }

        h2 {
            text-align: center;
            color: rgb(71, 105, 255);
            margin-bottom: 20px;
        }

        .form-container {
            display: flex;
            justify-content: center;
            gap: 10px;
            flex-wrap: wrap;
            margin-bottom: 40px;
        }

        .form-card {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 15px;
            width: 100%;
            max-width: 450px;
            box-sizing: border-box;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        label {
            font-weight: bold;
            font-size: 14px;
            color: #555;
        }

        input[type="text"],
        input[type="number"],
        input[type="file"],
        select {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
            width: 100%;
            box-sizing: border-box;
        }

        input[type="submit"], input[type="button"] {
            background-color: rgb(71, 105, 255);
            color: white;
            border: none;
            padding: 8px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
        }

        input[type="submit"]:hover, input[type="button"]:hover {
            background-color: rgb(51, 85, 204);
        }

        /* Responsividade */
        @media (max-width: 768px) {
            .form-container {
                flex-direction: column;
                align-items: center;
            }
        }
    </style>
</head>
<body>

<h2>Cadastro Futebolístico</h2>

<!-- Mensagem de Sucesso -->
@if(session('success'))
    <div>{{ session('success') }}</div>
@endif

<!-- Formulário HTML -->
<div class="form-container">
    <div class="form-card">
        <h2>Cadastre um jogador</h2>
        <form id="cadastroJogadorForm" onsubmit="enviarFormulario(event)">
            @csrf
            <label for="nome_jogador">Nome do Jogador</label>
            <input type="text" id="nome_jogador" name="nome_jogador" required>

            <label for="idade_jogador">Idade do Jogador</label>
            <input type="number" id="idade_jogador" name="idade_jogador" required>

            <label for="imagem_jogador">Adicione uma imagem</label>
            <input type="file" id="imagem_jogador" name="imagem_jogador" accept="image/*" required>
            
            <label for="time_id">Selecione o time</label>
            <select id="time_id" name="time_id" required>
                <option value="">Selecione um time</option>
                <!-- As opções de time serão carregadas via JavaScript -->
            </select>

            <input type="submit" value="Cadastrar Jogador">
        </form>
    </div>
    <div class="form-card">
        <h2>Cadastre um time</h2>
        <form id="cadastroTimeForm" onsubmit="enviarFormularioTime(event)">
            @csrf
            <label for="nome_time">Nome do Time</label>
            <input type="text" id="nome_time" name="nome_time" required>

            <label for="titulo_time">Maior Título do Time</label>
            <input type="text" id="titulo_time" name="titulo_time" required>

            <label for="imagem_time">Adicione uma imagem</label>
            <input type="file" id="imagem_time" name="imagem_time" accept="image/*" required>

            <input type="submit" value="Cadastrar Time">
        </form>
    </div>
</div>

<script>
    // Função para carregar os times no campo select
    function carregarTimes() {
        axios.get('http://127.0.0.1:8000/api/times')
            .then(response => {
                const times = response.data;
                const select = document.getElementById('time_id');
                
                // Limpa as opções existentes
                select.innerHTML = '<option value="">Selecione um time</option>';

                // Preenche as opções com os times
                times.forEach(time => {
                    const option = document.createElement('option');
                    option.value = time.id;
                    option.textContent = time.nome;
                    select.appendChild(option);
                });
            })
            .catch(error => {
                console.error('Erro ao carregar os times:', error);
            });
    }

    // Carregar os times assim que a página for carregada
    window.onload = carregarTimes;

    function enviarFormulario(event) {
        event.preventDefault();

        let formData = new FormData();
        formData.append('nome', document.getElementById('nome_jogador').value);
        formData.append('idade', document.getElementById('idade_jogador').value);
        formData.append('imagem', document.getElementById('imagem_jogador').files[0]);
        formData.append('time_id', document.getElementById('time_id').value);

        axios.post('http://127.0.0.1:8000/api/jogadores', formData)
            .then(response => {
                alert('Cadastro de jogador realizado com sucesso!');
                document.getElementById('cadastroJogadorForm').reset();
            })
            .catch(error => {
                console.error(error);
                alert('Erro ao cadastrar jogador. Verifique os campos.');
            });
    }

    function enviarFormularioTime(event) {
        event.preventDefault();

        let formData = new FormData();
        formData.append('nome', document.getElementById('nome_time').value);
        formData.append('titulos', document.getElementById('titulo_time').value);
        formData.append('imagem', document.getElementById('imagem_time').files[0]);

        axios.post('http://127.0.0.1:8000/api/times', formData)
            .then(response => {
                alert('Cadastro de time realizado com sucesso!');
                document.getElementById('cadastroTimeForm').reset();
            })
            .catch(error => {
                console.error(error);
                alert('Erro ao cadastrar time. Verifique os campos.');
            });
    }
</script>

</body>
</html>
