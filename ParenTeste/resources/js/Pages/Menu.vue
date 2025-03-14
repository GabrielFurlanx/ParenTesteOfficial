<template>
    <div class="d-flex" id="wrapper">
      <!-- Sidebar -->
      <div class="border-right" id="sidebar-wrapper">
        <div class="sidebar-heading"></div>
        <div class="list-group list-group-flush">
          <!-- Link para voltar ao Menu -->
          <a href="/" class="list-group-item list-group-item-action">
            <i class="fas fa-home"></i> Menu
          </a>

          <!-- Teste de Paternidade -->
          <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" @click.prevent="toggleSubmenu('testePaternidadeSubmenu')">
            Teste de Paternidade
            <i :class="activeSubmenu === 'testePaternidadeSubmenu' ? 'fas fa-chevron-down' : 'fas fa-chevron-right'" class="arrow-icon"></i>
          </a>
          <div class="submenu" :class="{ 'open': activeSubmenu === 'testePaternidadeSubmenu' }">
            <a href="/calculo" class="list-group-item list-group-item-action submenu-item">Novo Teste</a>
            <a href="#" class="list-group-item list-group-item-action submenu-item">Histórico de Laudos</a>
          </div>

          <!-- Exame de Sangue -->
          <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" @click.prevent="toggleSubmenu('exameSangueSubmenu')">
            Exame de Sangue
            <i :class="activeSubmenu === 'exameSangueSubmenu' ? 'fas fa-chevron-down' : 'fas fa-chevron-right'" class="arrow-icon"></i>
          </a>
          <div class="submenu" :class="{ 'open': activeSubmenu === 'exameSangueSubmenu' }">
            <a href="#" class="list-group-item list-group-item-action submenu-item" @click.prevent="goToExame">Histórico de Laudo</a>
          </div>

          <!-- Cadastro e Logout -->
          <a href="/cadastro" class="list-group-item list-group-item-action">Cadastrar</a>
          <a href="#" @click.prevent="logout" class="list-group-item list-group-item-action">Sair</a>
        </div>
      </div>

      <!-- Conteúdo Principal -->
      <div id="page-content-wrapper">
        <nav class="navbar navbar-expand-lg navbar-light border-bottom">
          <button class="btn btn-primary" id="menu-toggle">
            <i class="fas fa-bars"></i>
          </button>
          <div class="ml-auto d-flex align-items-center">
            <i class="fas fa-user user-icon"></i>
            <span class="navbar-text">Usuário</span>
          </div>
        </nav>

        <!-- Container Geral -->
        <div class="container-fluid main-content">
          <div class="content-left">
            <h1 class="mt-4">ParenTeste</h1>
            <p>Bem-vindo à página inicial do ParenTeste</p>
          </div>

          <!-- Formulário de Agendamento no Canto Direito -->
          <div class="agendamento-container">
            <h3>Agendar Consulta</h3>
            <form @submit.prevent="agendarConsulta">
              <div class="form-group">
                <label for="nome">Nome do Paciente</label>
                <input type="text" id="nome" v-model="nomePaciente" class="form-control" required>
              </div>

              <div class="form-group">
                <label for="telefone">Telefone</label>
                <input type="text" id="telefone" v-model="telefone" class="form-control" required>
              </div>

              <div class="form-group">
                <label for="email">E-mail</label>
                <input type="email" id="email" v-model="email" class="form-control" required>
              </div>

              <div class="form-group">
                <label for="data">Data da Consulta</label>
                <input type="date" id="data" v-model="dataConsulta" class="form-control" :min="minDate" required>

              </div>

              <div class="form-group">
                <label for="hora">Hora da Consulta</label>
                <input type="time" id="hora" v-model="horaConsulta" class="form-control" required>
              </div>

              <button type="submit" class="btn btn-success">Agendar</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </template>

<script>
import { Inertia } from '@inertiajs/inertia';

export default {
  name: 'Menu',
  data() {
    return {
      activeSubmenu: null, // Controla os submenus
      nomePaciente: "",
      telefone: "",
      email: "",
      dataConsulta: "",
      horaConsulta: "",
      minDate: "", // Data mínima para o calendário
      successMessage: this.$page.props.successMessage || '', // Mensagem de sucesso do controlador
    };
  },
  methods: {

    exibirAlerta() {
      alert('Este é um alerta de teste!');
    },

    toggleSubmenu(submenu) {
      this.activeSubmenu = this.activeSubmenu === submenu ? null : submenu;
    },
    logout() {
      Inertia.post('/logout', {}, {
        onSuccess: () => {
          window.location.href = '/login';
        }
      });
    },
    goToExame() {
      Inertia.get('/exame');
    },
    agendarConsulta() {
  Inertia.post('/agendar-consulta', {
    nome_paciente: this.nomePaciente,
    telefone: this.telefone,
    email: this.email,
    data_consulta: this.dataConsulta,
    hora_consulta: this.horaConsulta,
  }, {
    onSuccess: () => {
      alert('Consulta agendada com sucesso!'); // Mostra o alerta
      this.successMessage = 'Consulta agendada com sucesso!';
    },
    onError: (errors) => {
      alert(errors.data_consulta ? errors.data_consulta[0] : 'Erro ao agendar.');
    }
  });
},
  },
  mounted() {
    // Define a data mínima para o campo de data
    this.minDate = new Date().toISOString().split('T')[0]; // Formato YYYY-MM-DD

    // Ajusta o comportamento do menu
    document.getElementById('menu-toggle').addEventListener('click', function(e) {
      e.preventDefault();
      document.getElementById('wrapper').classList.toggle('toggled');
    });
  }
}
</script>

  <style scoped>
  @import url('https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css');
  @import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css');
  @import '../../css/styles_inicio.css';

  /* Sidebar */
  .submenu {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.3s ease, padding 0.3s ease;
    padding: 0 1rem;
  }

  .submenu.open {
    max-height: 200px;
    padding: 0.5rem 1rem;
  }

  /* Layout principal */
  .main-content {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    padding: 20px;
  }

  /* Conteúdo esquerdo (Texto principal) */
  .content-left {
    flex: 1;
  }

  /* Agendamento no canto direito */
  .agendamento-container {
    background-color: #f8f9fa;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    width: 300px;
    position: absolute;
    right: 20px;
    top: 150px;
  }

  .agendamento-container h3 {
    margin-bottom: 15px;
  }

  .agendamento-container .form-group {
    margin-bottom: 10px;
  }
  </style>
