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
          <span class="navbar-text">Cadastro de Paternidade</span>
        </div>

        <!-- Formulário de Cadastro de Paternidade -->
        <div class="content">
          <div class="center-container">
            <div class="form-container">
              <form @submit.prevent="salvarDadosTemporarios">
                <h2 class="form-title">Dados da Criança</h2>

                <div class="input-group">
                  <label for="nomeCrianca">Nome da Criança</label>
                  <input v-model="crianca.nome" type="text" id="nomeCrianca" required />
                </div>

                <div class="input-group">
                  <label for="cpfCrianca">CPF</label>
                  <input v-model="crianca.cpf" type="text" id="cpfCrianca" required />
                </div>

                <h2 class="form-title">Dados do Investigado</h2>

                <div class="input-group">
                  <label for="nomeInvestigado">Nome do Investigado</label>
                  <input v-model="investigado.nome" type="text" id="nomeInvestigado" required />
                </div>

                <div class="input-group">
                  <label for="rgInvestigado">RG</label>
                  <input v-model="investigado.rg" type="text" id="rgInvestigado" required />
                </div>

                <div class="input-group">
                  <label for="cpfInvestigado">CPF</label>
                  <input v-model="investigado.cpf" type="text" id="cpfInvestigado" required />
                </div>

                <button
                  type="button"
                  @click="salvarDadosEAvancar"
                  class="submit-btn"
                >
                  Salvar e Ir para Cálculo
                </button>
              </form>
              <Sidebar />
            </div>
          </div>
        </div>
      </div>
    </div>
  </template>

  <script>
  import { Inertia } from '@inertiajs/inertia'; // Importando o Inertia
  import Sidebar from './Sidebar.vue'; // Componente Sidebar

  export default {
    components: {
      Sidebar
    },
    data() {
      return {
        crianca: {
          nome: '',
          cpf: ''
        },
        investigado: {
          nome: '',
          rg: '',
          cpf: ''
        }
      };
    },
    methods: {
      salvarDadosEAvancar() {
        // Preparando os dados para envio para a próxima tela
        const dadosPaternidade = {
          crianca: this.crianca,
          investigado: this.investigado
        };

        // Salva os dados no localStorage
        localStorage.setItem('dadosPaternidade', JSON.stringify(dadosPaternidade));

        // Usando Inertia para redirecionar para a página de cálculo
        Inertia.visit('/calculo');
      }
    }
  };
  </script>

  <style scoped>
  .container {
    display: flex;
    min-height: 100vh;
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

  .form-container {
    background-color: #fff;
    padding: 16px;
    border-radius: 8px;
    width: 100%;
    max-width: 500px; /* Define a largura máxima do formulário */
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  }

  .form-title {
    font-size: 1.5rem;
    font-weight: bold;
    margin-bottom: 16px;
    text-align: center;
  }

  .input-group {
    margin-bottom: 12px;
  }

  .input-group label {
    font-size: 0.9rem;
    font-weight: 500;
    margin-bottom: 6px;
  }

  .input-group input {
    width: 100%;
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 1rem;
  }

  .submit-btn {
    width: 100%;
    padding: 10px;
    background-color: #4CAF50;
    color: white;
    border: none;
    border-radius: 5px;
    font-size: 1rem;
    cursor: pointer;
    transition: background-color 0.3s;
  }

  .submit-btn:hover {
    background-color: #45a049;
  }
  </style>
