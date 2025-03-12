<template>
    <div class="flex flex-col min-h-screen bg-gray-100">
      <Sidebar>
        <!-- Área de Importação -->
        <div class="mt-8 p-8">
          <input type="file" @change="handleFileUpload" accept=".csv" class="border p-2 rounded">

          <!-- Tabela -->
          <div class="mt-6 overflow-x-auto">
            <table class="w-full border-collapse bg-white shadow-md">
              <thead class="bg-gray-300">
                <tr>
                  <th class="p-2 border">Ordem</th>
                  <th class="p-2 border">Nº Paciente</th>
                  <th class="p-2 border">Data</th>
                  <th class="p-2 border">Tipo de Teste</th>
                  <th class="p-2 border">Resultado</th>
                  <th class="p-2 border">Início</th>
                  <th class="p-2 border">Paciente</th>
                  <th class="p-2 border">Sexo</th>
                  <th class="p-2 border">Usuário</th>
                  <th class="p-2 border">Finalização</th>
                  <th class="p-2 border">Ação</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(dado, index) in dados" :key="index">
                  <td class="p-2 border">{{ dado.ordem }}</td>
                  <td class="p-2 border">{{ dado.numeroPaciente }}</td>
                  <td class="p-2 border">{{ dado.data }}</td>
                  <td class="p-2 border">{{ dado.tipoTeste }}</td>
                  <td class="p-2 border">{{ dado.resultado }}</td>
                  <td class="p-2 border">{{ dado.inicioTeste }}</td>
                  <td class="p-2 border">{{ dado.paciente }}</td>
                  <td class="p-2 border">{{ dado.sexo }}</td>
                  <td class="p-2 border">{{ dado.usuario }}</td>
                  <td class="p-2 border">{{ dado.finalizacao }}</td>
                  <td class="p-2 border flex space-x-2">
                    <button @click="viewData(dado)" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                      Visualizar
                    </button>
                    <button @click="saveData(dado)" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                      Salvar
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </Sidebar>

      <!-- Modal Laudo -->
      <div v-if="showLaudo" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 z-50">
        <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-4xl" id="laudo-printable">
          <h2 class="text-2xl font-bold mb-4 text-center">Laudo Médico</h2>
          <div class="page-content">
            <p><strong>Ordem:</strong> {{ selectedData.ordem }}</p>
            <p><strong>Nº Paciente:</strong> {{ selectedData.numeroPaciente }}</p>
            <p><strong>Data:</strong> {{ selectedData.data }}</p>
            <p><strong>Tipo de Teste:</strong> {{ selectedData.tipoTeste }}</p>
            <p><strong>Resultado:</strong> {{ selectedData.resultado }}</p>
            <p><strong>Início do Teste:</strong> {{ selectedData.inicioTeste }}</p>
            <p><strong>Paciente:</strong> {{ selectedData.paciente }}</p>
            <p><strong>Sexo:</strong> {{ selectedData.sexo }}</p>
            <p><strong>Usuário:</strong> {{ selectedData.usuario }}</p>
            <p><strong>Finalização:</strong> {{ selectedData.finalizacao }}</p>
          </div>
          <div class="mt-6 text-center">
            <button @click="showLaudo = false" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 print-buttons">Fechar</button>
            <button @click="printPage" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 ml-2 print-buttons">Imprimir</button>
          </div>
        </div>
      </div>
    </div>
  </template>

  <script>
  import Sidebar from './Sidebar.vue';
  import axios from 'axios';

  export default {
    data() {
      return {
        dados: [],
        selectedData: {},
        showLaudo: false,
      };
    },
    components: {
      Sidebar,
    },
    methods: {
      handleFileUpload(event) {
        const file = event.target.files[0];
        if (file) {
          this.readCsv(file);
        }
      },
      readCsv(file) {
        const reader = new FileReader();
        reader.onload = (e) => {
          const content = e.target.result;
          this.processCsv(content);
        };
        reader.readAsText(file);
      },
      processCsv(content) {
        const rows = content.trim().split("\n").map(row => row.split(/[,\t]+/));
        this.dados = rows.map(row => {
          const ordem = row[0]?.trim();
          const numeroPaciente = row[1]?.trim();
          const data = row[2]?.trim().slice(0, -4); // Remove os últimos 4 dígitos da data
          const tipoTeste = row[3]?.trim();
          const resultado = row[4]?.trim();
          const inicioTeste = row[5]?.trim();
          const paciente = row[6]?.trim();
          const sexo = row[7]?.trim();
          const usuario = row[8]?.trim();
          const finalizacao = row[9]?.trim()?.replace(/"/g, "");

          // Verificação simples para garantir que campos obrigatórios não estejam vazios
          if (!numeroPaciente || !data || !tipoTeste || !resultado) {
            alert('Alguns campos obrigatórios estão faltando!');
            return null;  // Não adiciona o dado à lista se estiver faltando algo
          }

          return {
            ordem, numeroPaciente, data, tipoTeste, resultado, inicioTeste, paciente, sexo, usuario, finalizacao
          };
        }).filter(dado => dado !== null); // Filtra dados inválidos
      },
      viewData(dado) {
        this.selectedData = dado;
        this.showLaudo = true; // Exibe o modal
      },
      saveData(dado) {
    if (!dado.numeroPaciente || !dado.data || !dado.tipoTeste || !dado.resultado) {
        alert('Por favor, preencha todos os campos obrigatórios.');
        return;
    }

    // Removendo aspas extras do campo "ordem" e formatando a data
    const requestData = {
    ordem: String(dado.ordem).replace(/["']/g, ''), // Remove aspas extras
    numero_paciente: String(dado.numeroPaciente),
    data: dado.data.replace(/(\d{4})(\d{2})(\d{2})/, '$1-$2-$3'), // Alterado para 'data'
    tipo_teste: dado.tipoTeste,
    resultado: dado.resultado,
    inicio_teste: dado.inicioTeste || null,
    paciente: dado.paciente || null,
    sexo: dado.sexo || null,
    usuario: dado.usuario || null,
    finalizacao: dado.finalizacao || null,
};


    console.log('Enviando dados para o backend:', requestData);

    axios.post('/exame', requestData)
        .then(response => {
            console.log('Dados salvos:', response.data);
            alert("Exame salvo com sucesso!");
        })
        .catch(error => {
            console.error('Erro ao salvar os dados:', error);
            if (error.response) {
        console.error('Resposta do backend:', error.response.data);
        alert("Erro ao salvar os dados: " + JSON.stringify(error.response.data));
    }
});

}


,
      printPage() {
        const buttons = document.querySelectorAll('.print-buttons');
        buttons.forEach(button => button.style.display = 'none');

        const content = document.getElementById('laudo-printable').innerHTML;
        const printWindow = window.open('', '', 'height=600,width=800');
        printWindow.document.write('<html><head><title>Laudo Médico</title></head><body>');
        printWindow.document.write(content);
        printWindow.document.write('</body></html>');
        printWindow.document.close();
        printWindow.print();

        setTimeout(() => {
          buttons.forEach(button => button.style.display = 'inline-block');
        }, 1000);
      }
    }
  };
  </script>

  <style scoped>
  .page-content {
    line-height: 1.6;
    font-size: 16px;
    margin-bottom: 20px;
  }
  .page-content p {
    margin-bottom: 10px;
  }
  .fixed {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
  }
  .bg-gray-900 {
    background-color: rgba(0, 0, 0, 0.8);
  }
  .print-buttons {
    display: inline-block;
  }
  @media print {
    .print-buttons {
      display: none;
    }
  }
  </style>
