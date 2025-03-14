<template>
    <div class="container">
      <!-- Sidebar -->


      <!-- Conteúdo principal -->
      <div id="page-content-wrapper">
        <!-- Navbar -->
        <div class="navbar">
          <button id="menu-toggle" class="btn">
            <i class="fas fa-bars"></i>
          </button>
          <span class="navbar-text">Bem-vindo ao Sistema</span>
        </div>

        <!-- Conteúdo da página -->
        <div class="content">
          <div class="center-container">
            <div class="table-container">
              <h2>Minha Tabela</h2>
              <table>
                <thead>
                  <tr>
                    <th rowspan="2">Nome</th>
                    <th colspan="2">Criança</th>
                    <th colspan="2">Filho</th>
                    <th rowspan="2">Resultado</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(row, index) in rows" :key="index">
                    <td>{{ names[index] }}</td>
                    <td><input type="number" v-model.number="row.input1" /></td>
                    <td><input type="number" v-model.number="row.input2" /></td>
                    <td><input type="number" v-model.number="row.input3" /></td>
                    <td><input type="number" v-model.number="row.input4" /></td>
                    <td>{{ calculateResult(row) }}</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>

    <Sidebar />
  </template>

  <script>
  import Sidebar from './Sidebar.vue';

  export default {
    components: {
      Sidebar,
    },
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
        return row.input1 + row.input2 + row.input3 + row.input4;
      },
    },
  };
  </script>

  <style scoped>
  .container {
    display: flex;
    min-height: 100vh;
  }

  /* Sidebar (ajuste conforme o seu componente Sidebar.vue) */
  .sidebar {
    width: 250px;
    background-color: #2c3e50;
    color: white;
  }

  #page-content-wrapper {
    flex-grow: 1;
    display: flex;
    flex-direction: column;
  }

  .navbar {
    padding: 10px;
    background-color: #f8f9fa;
    border-bottom: 1px solid #ddd;
  }

  .content {
    flex-grow: 1;
    padding: 16px;
    display: flex;
    justify-content: center;
    align-items: center;
  }

  .center-container {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%;
  }

  .table-container {
    border: 1px solid #ccc;
    padding: 16px;
    border-radius: 8px;
    width: 100%;
    max-width: 800px;
    background-color: #f9f9f9;
    overflow-x: auto;
  }

  table {
    width: 100%;
    border-collapse: collapse;
  }

  th, td {
    padding: 16px 20px;
    text-align: center;
    border: 1px solid #ddd;
  }

  th {
    background-color: #4CAF50;
    color: white;
  }

  td {
    background-color: #f9f9f9;
  }

  input {
    width: 100%;
    padding: 8px;
    margin: 4px 0;
    box-sizing: border-box;
    border: 1px solid #ddd;
    border-radius: 4px;
    text-align: center;
  }

  input:focus {
    outline-color: #4CAF50;
  }

  tr:hover {
    background-color: #f1f1f1;
  }
  </style>
