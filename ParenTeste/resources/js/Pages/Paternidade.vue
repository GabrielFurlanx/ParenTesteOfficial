<template>
    <div class="table-container">
      <h2>Minha Tabela</h2>
      <table>
        <thead>
          <tr>
            <th>Nome</th>
            <th>Input 1</th>
            <th>Input 2</th>
            <th>Input 3</th>
            <th>Input 4</th>
            <th>Resultado</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(row, index) in rows" :key="index">
            <td>{{ names[index] }}</td> <!-- Usar nomes fixos -->
            <td><input type="number" v-model.number="row.input1" /></td>
            <td><input type="number" v-model.number="row.input2" /></td>
            <td><input type="number" v-model.number="row.input3" /></td>
            <td><input type="number" v-model.number="row.input4" /></td>
            <td>{{ calculateResult(row) }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </template>

  <script>
  export default {
    data() {
      return {
        names: [
          "D8S1179", "D21S11", "D7S820", "CSF1PO", "D3S1358",
          "TH01", "D13S317", "D16S539", "D2S1338", "D19S433",
          "VWA", "TP0X", "D18S51", "D5818", "FGA"
        ],
        rows: Array.from({ length: 15 }, () => ({
          input1: 0,
          input2: 0,
          input3: 0,
          input4: 0,
        })),
      };
    },
    methods: {
      calculateResult(row) {
        return row.input1 + row.input2 + row.input3 + row.input4; // Altere a lógica conforme necessário
      },
    },
  };
  </script>

  <style>
  .table-container {
    border: 1px solid #ccc; /* Borda do contêiner */
    padding: 16px; /* Espaçamento interno */
    border-radius: 8px; /* Cantos arredondados */
    max-width: 800px; /* Largura máxima do bloco */
    margin: auto; /* Centralizar o bloco na tela */
    background-color: #f9f9f9; /* Cor de fundo */
    overflow-x: auto; /* Adiciona rolagem horizontal se necessário */
  }

  table {
    width: 100%; /* A tabela ocupa 100% da largura do contêiner */
    border-collapse: collapse; /* Colapsa bordas da tabela */
  }

  th, td {
    padding: 8px;
    text-align: center;
  }

  input {
    width: 100%; /* Os inputs ocupam 100% da largura da célula */
    box-sizing: border-box; /* Inclui padding e borda na largura total */
  }
  </style>
