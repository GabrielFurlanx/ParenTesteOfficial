<template>
    <div class="container">
      <!-- Conteúdo principal -->
      <div id="page-content-wrapper" class="content-wrapper">
        <!-- Navbar -->
        <div class="navbar">
          <button id="menu-toggle" class="btn">
            <i class="fas fa-bars"></i>
          </button>
          <span class="navbar-text">Bem-vindo ao Sistema</span>
        </div>

        <!-- Conteúdo da página -->
        <div class="center-container">
          <div class="table-container">
            <table>
              <thead>
                <tr>
                  <th rowspan="2">Nome</th>
                  <th colspan="2">Criança</th>
                  <th colspan="2">Investigado</th>
                  <th rowspan="2">Índice</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(row, index) in rows" :key="index">
      <td>{{ names[index] }}</td>
      <td><input type="number" v-model.number="row.input1" class="input-alelo" /></td>
      <td><input type="number" v-model.number="row.input2" class="input-alelo" /></td>
      <td><input type="number" v-model.number="row.input3" class="input-alelo" /></td>
      <td><input type="number" v-model.number="row.input4" class="input-alelo" /></td>
      <td class="index-value">{{ calculateIndex(row) }}</td>
    </tr>
              </tbody>
            </table>
            <p><strong>IP Acumulado:</strong> {{ ipAcumulado }}</p>
            <p><strong>PP %:</strong> {{ ppPercentage }}%</p>

            <!-- Botão para abrir o modal -->
            <button class="btn-modal" @click="showModal = true">Ver Tabela Detalhada</button>
            <button class="btn-save" @click="salvarDados">Salvar Exame</button>
          </div>
        </div>
      </div>

      <!-- Modal -->
      <div v-if="showModal" class="modal">
        <div class="modal-content large-modal">
          <span class="close" @click="showModal = false">&times;</span>
          <h3>Tabela Detalhada</h3>

          <div class="table-wrapper">
            <table class="detailed-table">
              <thead>
                <tr>
                  <th rowspan="2">Nome</th>
                  <th colspan="2">Criança</th>
                  <th colspan="2">Invesgado</th>
                  <th rowspan="2">Índice</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(row, index) in rows" :key="index">
                  <td>{{ names[index] }}</td>
                  <td>{{ row.input1 || '0' }}</td>
                  <td>{{ row.input2 || '0' }}</td>
                  <td>{{ row.input3 || '0' }}</td>
                  <td>{{ row.input4 || '0' }}</td>
                  <td class="index-value">{{ formatIndex(calculateIndex(row)) }}</td>
                </tr>
              </tbody>
            </table>
          </div>

          <div class="modal-actions">
  <button class="btn-print" @click="imprimirModal">Imprimir Tabela</button>
  <button class="btn-close" @click="showModal = false">Fechar</button>
</div>
        </div>
      </div>


    </div>
    <Sidebar />
  </template>

<script>
import Sidebar from './Sidebar.vue';
import axios from 'axios';

export default {
  components: {
    Sidebar,
  },
  data() {
    return {
      showModal: false,
      names: [
        "D8S1179", "D21S11", "D7S820", "CSF1PO", "D3S1358",
        "TH01", "D13S317", "D16S539", "D2S1338", "D19S433",
        "VWA", "TPOX", "D18S51", "D5S818", "FGA"
      ],
      rows: Array.from({ length: 15 }, () => ({
        input1: null,
        input2: null,
        input3: null,
        input4: null,
      })),
      dadosExame: {
        data: new Date().toLocaleDateString('pt-BR'),
        filho: {
          nome: '',
          certidao: '',
          mae: '',
          maeRG: '',
          maeCPF: ''
        },
        investigado: {
          nome: '',
          rg: '',
          cpf: ''
        }
      },
      salvando: false // Novo estado adicionado
    };
  },
  mounted() {
    // Carrega dados da tabela se existirem
    const savedData = localStorage.getItem('dadosTabela');
    if (savedData) {
      this.rows = JSON.parse(savedData);
    }

    // Carrega dados do exame de paternidade
    const dadosPaternidade = localStorage.getItem('dadosPaternidade');
    if (dadosPaternidade) {
      const parsedData = JSON.parse(dadosPaternidade);
      this.dadosExame = {
        data: parsedData.dataExame ? new Date(parsedData.dataExame).toLocaleDateString('pt-BR') : new Date().toLocaleDateString('pt-BR'),
        filho: {
          nome: parsedData.crianca.nome || 'Não informado',
          certidao: parsedData.crianca.certidao || 'Não informado',
          mae: parsedData.crianca.maeNome || 'Não informado',
          maeRG: parsedData.crianca.maeRg || 'Não informado',
          maeCPF: parsedData.crianca.maeCpf || 'Não informado'
        },
        investigado: {
          nome: parsedData.investigado.nome || 'Não informado',
          rg: parsedData.investigado.rg || 'Não informado',
          cpf: parsedData.investigado.cpf || 'Não informado'
        }
      };
    }
  },
  computed: {
    ipAcumulado() {
      return this.rows
        .map(row => this.calculateIndex(row))
        .filter(value => typeof value === "number")
        .reduce((acc, value) => acc + value, 0)
        .toFixed(6);
    },
    ppPercentage() {
      let ip = parseFloat(this.ipAcumulado);
      return ((ip / (ip + 1)) * 100).toFixed(6);
    }
  },
  methods: {
    async salvarDados() {
      if (this.salvando) return;
      this.salvando = true;

      try {
        const dadosParaEnviar = {
          nome_crianca: this.dadosExame.filho.nome,
          certidao_crianca: this.dadosExame.filho.certidao,
          rg_crianca: this.dadosExame.filho.rg,
          cpf_crianca: this.dadosExame.filho.cpf,
          nome_mae: this.dadosExame.filho.mae,
          rg_mae: this.dadosExame.filho.maeRG,
          cpf_mae: this.dadosExame.filho.maeCPF,
          nome_investigado: this.dadosExame.investigado.nome,
          rg_investigado: this.dadosExame.investigado.rg,
          cpf_investigado: this.dadosExame.investigado.cpf,
          data_exame: this.dadosExame.data,
          ip_acumulado: this.ipAcumulado,
          probabilidade_paternidade: this.ppPercentage,
          marcadores: this.names.map((name, index) => ({
            nome: name,
            crianca_alelo1: this.rows[index].input1,
            crianca_alelo2: this.rows[index].input2,
            investigado_alelo1: this.rows[index].input3,
            investigado_alelo2: this.rows[index].input4,
            indice: this.calculateIndex(this.rows[index])
          }))
        };

        const response = await axios.post('/paternidade', dadosParaEnviar, {
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json'
      }
    });

    if (response.data.success) {
      alert('Dados salvos com sucesso!');
    }
  } catch (error) {
    console.error('Erro detalhado:', error.response);
    alert(`Erro ao salvar: ${error.response?.data?.message || error.message}`);
  }

    },

    calculateIndex(row) {
      if (!row.input1 || !row.input2 || !row.input3 || !row.input4) return 0;

      let probAC = row.input1 === row.input3 ? 0.5 : 0;
      let probAD = row.input2 === row.input4 ? 0.5 : 0;
      let probBC = row.input1 === row.input4 ? 0.5 : 0;
      let probBD = row.input2 === row.input3 ? 0.5 : 0;
      let homozigoto1 = row.input1 === row.input2 ? 1 : 0;
      let homozigoto2 = row.input3 === row.input4 ? 1 : 0;

      let soma1 = probAC + probAD;
      let soma2 = probBC + probBD;
      let soma3 = soma1 + soma2;
      let exclusao = soma3 > 0 ? 1 : 0;
      let somaFinal = homozigoto1 + homozigoto2 + soma1 + soma2;

      let compSoma1 = soma1 > 0 ? row.input1 : row.input2;
      let compSoma2 = soma2 > 0 ? row.input2 : '-';

      let transportar1 = 0;
      if (somaFinal === 0.5) transportar1 = 1 / (4 * compSoma1);
      else if (somaFinal === 1.5) transportar1 = 1 / (2 * compSoma1);
      else if (somaFinal === 2) transportar1 = 1 / (2 * compSoma1);
      else if (somaFinal === 3.5) transportar1 = 1 / compSoma1;
      else if (somaFinal === 1) transportar1 = (compSoma1 + compSoma2) / (4 * compSoma1 * compSoma2);

      let transportar2 = exclusao > 0 ? transportar1 : 0;
      return typeof transportar2 === "number" ? transportar2 : 0;
    },
    formatIndex(value) {
      if (value === 0) return '0';
      return parseFloat(value.toFixed(8));
    },
    imprimirModal() {
      const tabela = document.querySelector('.detailed-table').cloneNode(true);

      const rows = tabela.querySelectorAll('tbody tr');
      this.rows.forEach((row, index) => {
        const cells = rows[index].querySelectorAll('td');
        cells[1].textContent = row.input1 || '0';
        cells[2].textContent = row.input2 || '0';
        cells[3].textContent = row.input3 || '0';
        cells[4].textContent = row.input4 || '0';
        cells[5].textContent = this.formatIndex(this.calculateIndex(row));
      });

      const printContainer = document.createElement('div');
      printContainer.innerHTML = `
        <div style="font-family: Arial; margin-bottom: 30px;">
          <h3 style="text-align: center; margin-bottom: 25px;">
            LAUDO DE EXAME DE PATERNIDADE
          </h3>

          <p style="text-align: justify; line-height: 1.6;">
            Em ${this.dadosExame.data}, compareceram ao Instituto de Criminalística do Paraná,
            <strong>${this.dadosExame.filho.nome}</strong> (filho), com registro em Certidão de Nascimento ${this.dadosExame.filho.certidao},
            filho de <strong>${this.dadosExame.filho.mae}</strong> (mãe), portadora de RG ${this.dadosExame.filho.maeRG},
            CPF ${this.dadosExame.filho.maeCPF}, e o investigado <strong>${this.dadosExame.investigado.nome}</strong>,
            portador de RG ${this.dadosExame.investigado.rg}, CPF ${this.dadosExame.investigado.cpf},
            onde, após prévia anuência das partes interessadas mediante assinatura de Termo de Autorização
            para Coleta de Material Biológico, foram submetidos à coleta de amostra biológica (sangue).
          </p>
        </div>

        <h4 style="text-align: center; margin: 25px 0 15px 0; font-family: Arial;">
          RESULTADOS DOS EXAMES
        </h4>
      `;

      printContainer.appendChild(tabela);

      const footerText = `
        <div style="margin-top: 40px; font-family: Arial; font-size: 13px; line-height: 1.6;">
          <h4 style="text-align: center; margin-bottom: 15px; text-decoration: underline;">
            CONCLUSÃO
          </h4>
          <p style="text-align: justify; text-indent: 40px; margin-bottom: 20px;">
            Devido às correspondências alélicas observadas e ao Índice de Paternidade Combinado alcançado
            (${this.ipAcumulado}), conclui-se pela presença de vínculo genético de paternidade entre o
            investigado e o filho, com uma Probabilidade de Paternidade maior que ${this.ppPercentage}%.
          </p>
          <p style="text-align: right; margin-top: 30px;">
            Londrina, ${new Date().toLocaleDateString('pt-BR', {day: 'numeric', month: 'long', year: 'numeric'})}.
          </p>
        </div>

        <div style="margin-top: 50px; font-family: Arial; font-size: 11px; text-align: center; border-top: 1px solid #ccc; padding-top: 10px;">
          <p>Este laudo técnico foi gerado automaticamente pelo sistema.</p>
          <p>Laboratório de Genética - Responsável Técnico: Dr. Genetista Silva - CRBM 1234</p>
        </div>
      `;
      printContainer.innerHTML += footerText;

      const printStyles = `
        <style>
          body { font-family: Arial; margin: 25px; }
          table { width: 100%; border-collapse: collapse; margin: 15px 0 25px 0; }
          th, td { border: 1px solid #ddd; padding: 8px; text-align: center; }
          th { background-color: #f2f2f2 !important; -webkit-print-color-adjust: exact; }
          .index-value { font-family: monospace; }
          @page {
            size: A4;
            margin: 2cm;
            @bottom-center {
              content: "Página " counter(page);
              font-family: Arial;
              font-size: 10px;
            }
          }
        </style>
      `;

      const printWindow = window.open('', '_blank');
      printWindow.document.write(`
        <!DOCTYPE html>
        <html>
        <head>
          <title>Laudo de Exame de Paternidade</title>
          <meta charset="UTF-8">
          ${printStyles}
        </head>
        <body>
          ${printContainer.innerHTML}
          <script>
            setTimeout(function() {
              window.print();
              window.close();
            }, 500);
          <\/script>
        </body>
        </html>
      `);
      printWindow.document.close();
    }
  }
};
</script>
<style scoped>
.container {
  display: flex;
  min-height: 100vh;
}

.content-wrapper {
  flex-grow: 1;
  display: flex;
  flex-direction: column;
  align-items: center;
}

.center-container {
  display: flex;
  justify-content: center;
  align-items: flex-start;
  width: 100%;
  margin-top: 50px;
}

.table-container {
  border: 1px solid #ccc;
  padding: 16px;
  border-radius: 8px;
  background-color: #f9f9f9;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: flex-start;
  width: 100%;
  max-width: 900px;
  overflow-x: auto;
}

table {
  width: 100%;
  border-collapse: collapse;
  table-layout: fixed;
}

th, td {
  padding: 10px;
  text-align: center;
  border: 1px solid #ddd;
  width: 16%;
}

input {
  width: 100%;
  box-sizing: border-box;
  height: 30px;
  text-align: center;
  font-size: 16px;
}

.btn-modal {
  margin-top: 20px;
  padding: 10px 20px;
  background-color: #4CAF50;
  color: white;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  transition: background-color 0.3s;
}

.btn-modal:hover {
  background-color: #45a049;
}

/* Estilos do Modal */
.modal {
  display: flex;
  position: fixed;
  z-index: 1000;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0,0,0,0.5);
  justify-content: center;
  align-items: center;
  backdrop-filter: blur(3px);
}

.modal-content {
  background-color: #fff;
  padding: 30px;
  border-radius: 10px;
  box-shadow: 0 5px 15px rgba(0,0,0,0.3);
  width: 90%;
  max-width: 1000px;
  max-height: 85vh;
  overflow-y: auto;
  position: relative;
  display: flex;
  flex-direction: column;
}

.close {
  position: absolute;
  right: 20px;
  top: 20px;
  font-size: 28px;
  color: #aaa;
  cursor: pointer;
  transition: color 0.3s;
}

.close:hover {
  color: #333;
}

h3 {
  text-align: center;
  margin-bottom: 25px;
  color: #333;
  font-size: 24px;
}

.table-wrapper {
  overflow-x: auto;
  margin-bottom: 20px;
  flex-grow: 1;
}

.detailed-table {
  width: 100%;
  border-collapse: collapse;
  font-size: 14px;
  margin-bottom: 20px;
}

.detailed-table th {
  background-color: #f5f5f5;
  position: sticky;
  top: 0;
  font-weight: 600;
  padding: 12px 15px;
}

.detailed-table td {
  padding: 12px 15px;
  border: 1px solid #e0e0e0;
}

.detailed-table th,
.detailed-table td {
  text-align: center;
}

.index-value {
  font-family: 'Courier New', monospace;
  white-space: nowrap;
}

/* Área de botões ajustada */
.modal-actions {
  display: flex;
  justify-content: center;
  gap: 15px;
  margin-top: auto;
  padding-top: 20px;
  border-top: 1px solid #eee;
}

.btn-print {
  padding: 8px 20px;
  background-color: #4CAF50;
  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  font-size: 14px;
  min-width: 120px;
}

.btn-close {
  padding: 8px 20px;
  background-color: #f44336;
  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  font-size: 14px;
  min-width: 120px;
}

.btn-print:hover {
  background-color: #45a049;
}

.btn-close:hover {
  background-color: #d32f2f;
}

/* Responsividade */
@media screen and (max-width: 768px) {
  .modal-content {
    width: 95%;
    padding: 20px;
  }

  .detailed-table th,
  .detailed-table td {
    padding: 8px 10px;
    font-size: 13px;
  }

  .modal-actions {
    flex-direction: column;
    gap: 10px;
  }

  .btn-print,
  .btn-close {
    width: 100%;
    min-width: auto;
  }

  .close {
    right: 15px;
    top: 15px;
    font-size: 24px;
  }

  h3 {
    font-size: 20px;
    margin-bottom: 15px;
  }
}

@media print {
  .modal-actions,
  .close {
    display: none;
  }
}

.action-buttons {
  display: flex;
  gap: 15px;
  margin-top: 20px;
  justify-content: center;
}

.btn-save {
  padding: 10px 20px;
  background-color: #2196F3;
  color: white;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  transition: background-color 0.3s;
  font-size: 16px;
}

.btn-save:hover {
  background-color: #0b7dda;
}

.btn-save:disabled {
  background-color: #cccccc;
  cursor: not-allowed;
}
</style>
