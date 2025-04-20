<template>
    <div id="wrapper" :class="{ 'toggled': sidebarOpen }">
      <!-- Sidebar -->
      <div id="sidebar-wrapper">
        <div class="list-group list-group-flush">
            <a href="/" class="list-group-item list-group-item-action">
            <i class="fas fa-home"></i> Menu
            </a>
          <!-- Item do menu Teste de Paternidade com submenu -->
          <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" @click.prevent="toggleSubmenu('testePaternidadeSubmenu')">
            Teste de Paternidade
            <i :class="activeSubmenu === 'testePaternidadeSubmenu' ? 'fas fa-chevron-down' : 'fas fa-chevron-right'" class="arrow-icon"></i>
          </a>
          <div class="submenu" :class="{ 'open': activeSubmenu === 'testePaternidadeSubmenu' }">
            <a href="/paternidade-info" class="list-group-item list-group-item-action submenu-item">Novo Teste</a>
            <a href="/historico-paternidade" class="list-group-item list-group-item-action submenu-item">Histórico de Laudos</a>
          </div>

          <!-- Item do menu Exame de Sangue com submenu -->
          <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" @click.prevent="toggleSubmenu('exameSangueSubmenu')">
            Exame de Sangue
            <i :class="activeSubmenu === 'exameSangueSubmenu' ? 'fas fa-chevron-down' : 'fas fa-chevron-right'" class="arrow-icon"></i>
          </a>
          <div class="submenu" :class="{ 'open': activeSubmenu === 'exameSangueSubmenu' }">
            <a href="/exame" class="list-group-item list-group-item-action submenu-item">Histórico de Laudo</a>
          </div>

          <!-- Link para Cadastrar -->
          <a href="/cadastro" class="list-group-item list-group-item-action">Cadastrar</a>

          <!-- Botão de Logout -->
          <a href="#" @click.prevent="logout" class="list-group-item list-group-item-action">Sair</a>
        </div>
      </div>

      <!-- Page Content -->
      <div id="page-content-wrapper">
        <!-- Navbar -->
        <div class="navbar">
          <button @click="toggleSidebar" id="menu-toggle" class="btn">
            <i class="fas fa-bars"></i>
          </button>
          <span class="navbar-text">Bem-vindo ao Sistema</span>
        </div>

        <!-- Conteúdo da página -->
        <div class="content">
          <slot></slot>
        </div>
      </div>
    </div>
  </template>

  <script>
  export default {
    data() {
      return {
        sidebarOpen: false,
        activeSubmenu: null,
      };
    },
    methods: {
      toggleSidebar() {
        this.sidebarOpen = !this.sidebarOpen;
      },
      toggleSubmenu(submenu) {

        this.activeSubmenu = this.activeSubmenu === submenu ? null : submenu;
      },
      goToExame() {

        console.log("Redirecionando para Histórico de Laudo");
      },
      logout() {

        console.log("Logout");
      },
    },
  };
  </script>

  <style scoped>
  /* Wrapper */
  #wrapper {
    display: flex;
    width: 100%;
    height: 100vh;
    position: relative;
  }

  /* Sidebar */
  #sidebar-wrapper {
    width: 250px;
    margin-left: -250px;
    background-color: gray;
    transition: margin 0.3s ease;
    padding-top: 0px;
    position: fixed;
    top: 60px;
    left: 0;
    height: calc(100vh - 60px);
    z-index: 1050;
  }

  #wrapper.toggled #sidebar-wrapper {
    margin-left: 0;
  }

  /* Página de Conteúdo */
  #page-content-wrapper {
    flex: 1;
    padding: 20px;
    padding-top: 60px;
    margin-left: 0;
    transition: margin-left 0.3s ease;
  }

  /* Navbar */
  .navbar {
    background-color: #ff8103;
    margin-bottom: 0;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    z-index: 1000;
    height: 60px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0 10px;
  }

  #menu-toggle {
    background-color: transparent;
    border: none;
    color: white;
    font-size: 1.5rem;
  }

  .navbar-text {
    font-size: 18px;
    color: white;
    margin-left: 5px;
  }

  /* Estilo para os itens do menu da sidebar */
  #sidebar-wrapper .list-group-item {
    background-color: gray;
    color: white;
    border: none;
    border-bottom: 1px solid white;
  }

  #sidebar-wrapper .list-group-item:last-child {
    border-bottom: none;
  }

  #sidebar-wrapper .list-group-item:hover {
    background-color: darkgray;
  }

  .submenu {
    display: none;
    background-color: #555;
  }

  .submenu.open {
    display: block;
  }

  .submenu-item {
    padding-left: 30px;
  }

  .arrow-icon {
    font-size: 1.2rem;
  }

  @media (max-width: 767px) {
    #sidebar-wrapper {
      width: 100%;
      margin-left: -100%;
    }

    #wrapper.toggled #sidebar-wrapper {
      margin-left: 0;
      width: 250px;
    }

    #page-content-wrapper {
      padding-left: 0;
      padding-right: 0;
    }

    .navbar-text {
      font-size: 16px;
    }
  }
  </style>
