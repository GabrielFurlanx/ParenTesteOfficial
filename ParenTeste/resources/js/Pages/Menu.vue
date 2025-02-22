<template>
    <div class="d-flex" id="wrapper">
      <div class="border-right" id="sidebar-wrapper">
        <div class="sidebar-heading"></div>
        <div class="list-group list-group-flush">
          <!-- Item do menu Teste de Paternidade com submenu -->
          <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" @click.prevent="toggleSubmenu('testePaternidadeSubmenu')">
            Teste de Paternidade
            <i :class="activeSubmenu === 'testePaternidadeSubmenu' ? 'fas fa-chevron-down' : 'fas fa-chevron-right'" class="arrow-icon"></i>
          </a>
          <div class="submenu" :class="{ 'open': activeSubmenu === 'testePaternidadeSubmenu' }">
            <a href="/calculo" class="list-group-item list-group-item-action submenu-item">Novo Teste</a>
            <a href="#" class="list-group-item list-group-item-action submenu-item">Histórico de Laudos</a>
          </div>

          <!-- Item do menu Exame de Sangue com submenu -->
          <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" @click.prevent="toggleSubmenu('exameSangueSubmenu')">
            Exame de Sangue
            <i :class="activeSubmenu === 'exameSangueSubmenu' ? 'fas fa-chevron-down' : 'fas fa-chevron-right'" class="arrow-icon"></i>
          </a>
          <div class="submenu" :class="{ 'open': activeSubmenu === 'exameSangueSubmenu' }">
            <a href="#" class="list-group-item list-group-item-action submenu-item" @click.prevent="goToExame">Histórico de Laudo</a>
          </div>

          <!-- Link para Cadastrar -->
          <a href="/cadastro" class="list-group-item list-group-item-action">Cadastrar</a>

          <!-- Botão de Logout -->
          <a href="#" @click.prevent="logout" class="list-group-item list-group-item-action">Sair</a>
        </div>
      </div>

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
        <img src="/UniFil-Logo-Fundo.jfif" alt="Logo da UniFil" style="width: 200px; height: 50px; float: right;">
        <div class="container-fluid">
          <h1 class="mt-4">ParenTeste</h1>
          <p>Bem-vindo à página inicial do ParenTeste</p>
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
      activeSubmenu: null, // Estado para controlar qual submenu está ativo
    };
  },
  methods: {
    toggleSubmenu(submenu) {
      // Alterna entre abrir e fechar o submenu
      this.activeSubmenu = this.activeSubmenu === submenu ? null : submenu;
    },
    logout() {
      Inertia.post('/logout', {}, {
        onSuccess: () => {
          window.location.href = '/login'; // Redireciona para a página de login após o logout
        }
      });
    },
    goToExame() {
      Inertia.get('/exame'); // Redireciona para a página de Exame.vue
    }
  },
  mounted() {
    // Inicializa o menu toggle
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

.submenu {
  max-height: 0;
  overflow: hidden;
  transition: max-height 0.3s ease, padding 0.3s ease; /* Efeito de transição */
  padding: 0 1rem; /* Para manter algum espaço interno */
}

.submenu.open {
  max-height: 200px; /* Ajuste este valor conforme necessário */
  padding: 0.5rem 1rem; /* Espaçamento quando aberto */
}
</style>

