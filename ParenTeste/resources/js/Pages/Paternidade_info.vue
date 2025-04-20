<template>
    <div class="container">
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
                  <label for="certidaoCrianca">Certidão de Nascimento</label>
                  <input v-model="crianca.certidao" type="text" id="certidaoCrianca" required />
                </div>

                <div class="input-group">
                  <label for="cpfCrianca">CPF</label>
                  <input v-model="crianca.cpf" type="text" id="cpfCrianca" v-mask="'###.###.###-##'" required />
                </div>

                <h2 class="form-title">Dados da Mãe</h2>

                <div class="input-group">
                  <label for="nomeMae">Nome Completo</label>
                  <input v-model="crianca.maeNome" type="text" id="nomeMae" required />
                </div>

                <div class="input-group">
                  <label for="rgMae">RG</label>
                  <input v-model="crianca.maeRg" type="text" id="rgMae" required />
                </div>

                <div class="input-group">
                  <label for="cpfMae">CPF</label>
                  <input v-model="crianca.maeCpf" type="text" id="cpfMae" v-mask="'###.###.###-##'" required />
                </div>

                <h2 class="form-title">Dados do Investigado</h2>

                <div class="input-group">
                  <label for="nomeInvestigado">Nome Completo</label>
                  <input v-model="investigado.nome" type="text" id="nomeInvestigado" required />
                </div>

                <div class="input-group">
                  <label for="rgInvestigado">RG</label>
                  <input v-model="investigado.rg" type="text" id="rgInvestigado" required />
                </div>

                <div class="input-group">
                  <label for="cpfInvestigado">CPF</label>
                  <input v-model="investigado.cpf" type="text" id="cpfInvestigado" v-mask="'###.###.###-##'" required />
                </div>

                <div class="input-group">
                  <label for="dataExame">Data do Exame</label>
                  <input v-model="dataExame" type="date" id="dataExame" required />
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
  import { Inertia } from '@inertiajs/inertia';
  import Sidebar from './Sidebar.vue';
  import { mask } from 'vue-the-mask';

  export default {
    directives: { mask },
    components: {
      Sidebar
    },
    data() {
      return {
        dataExame: new Date().toISOString().substr(0, 10), // Data atual como padrão
        crianca: {
          nome: '',
          certidao: '',
          cpf: '',
          maeNome: '',
          maeRg: '',
          maeCpf: ''
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
  // Remove caracteres especiais dos CPFs
  this.crianca.cpf = this.crianca.cpf.replace(/[^\d]+/g, '');  // Remove tudo que não for número
  this.crianca.maeCpf = this.crianca.maeCpf.replace(/[^\d]+/g, '');
  this.investigado.cpf = this.investigado.cpf.replace(/[^\d]+/g, '');

  const dadosPaternidade = {
    dataExame: this.dataExame,
    crianca: this.crianca,
    investigado: this.investigado
  };

  console.log(dadosPaternidade); // Verifique os dados antes de enviar

  // Salva os dados no localStorage
  localStorage.setItem('dadosPaternidade', JSON.stringify(dadosPaternidade));

  // Envia para a próxima página
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
    display: flex;
    align-items: center;
  }

  .navbar-text {
    margin-left: 15px;
    font-size: 1.2rem;
  }

  .content {
    flex-grow: 1;
    padding: 20px;
    display: flex;
    justify-content: center;
    align-items: flex-start;
    overflow-y: auto;
  }

  .center-container {
    display: flex;
    justify-content: center;
    width: 100%;
  }

  .form-container {
    background-color: #fff;
    padding: 25px;
    border-radius: 8px;
    width: 100%;
    max-width: 600px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
  }

  .form-title {
    font-size: 1.3rem;
    font-weight: bold;
    margin: 20px 0 15px 0;
    color: #2c3e50;
    border-bottom: 1px solid #eee;
    padding-bottom: 8px;
  }

  .input-group {
    margin-bottom: 15px;
  }

  .input-group label {
    display: block;
    font-size: 0.95rem;
    font-weight: 500;
    margin-bottom: 6px;
    color: #555;
  }

  .input-group input {
    width: 100%;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 1rem;
    transition: border-color 0.3s;
  }

  .input-group input:focus {
    border-color: #4CAF50;
    outline: none;
  }

  .input-group input[type="date"] {
    padding: 9px;
  }

  .submit-btn {
    width: 100%;
    padding: 12px;
    background-color: #4CAF50;
    color: white;
    border: none;
    border-radius: 4px;
    font-size: 1rem;
    font-weight: 500;
    cursor: pointer;
    transition: background-color 0.3s;
    margin-top: 20px;
  }

  .submit-btn:hover {
    background-color: #45a049;
  }

  /* Responsividade */
  @media (max-width: 768px) {
    .form-container {
      padding: 15px;
    }

    .form-title {
      font-size: 1.2rem;
    }

    .input-group input {
      padding: 8px;
    }
  }
  </style>
