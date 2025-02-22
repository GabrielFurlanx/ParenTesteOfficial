<template>
    <div class="flex flex-col min-h-screen bg-gray-100">
      <!-- Cabeçalho -->
      <header class="bg-orange-500 text-white p-4 flex justify-between items-center">
        <h1 class="text-lg font-semibold">Importar Exame</h1>
      </header>

      <!-- Área de Importação -->
      <div class="mt-8 p-8">
        <input type="file" @change="handleFileUpload" accept=".csv" class="border p-2 rounded">
        <button @click="processCsv" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 mt-2">
          Importar Arquivo
        </button>

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
                <th class="p-2 border"></th>
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
      <!-- Botões para Visualizar e Salvar -->
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
    </div>
  </template>

  <script>
  export default {
    data() {
      return {
        dados: [],
      };
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
  const rows = content.trim().split("\n").map(row => row.split(/[\t,]+/));

  console.log("Dados do CSV:", rows);

  this.dados = rows.map(row => ({
    ordem: row[0]?.trim() || "Não informado",
    numeroPaciente: row[1]?.trim() || "Não informado",
    data: row[2]?.trim() || "Não informado",
    tipoTeste: row[3]?.trim() || "Não informado",
    resultado: row[4]?.trim() || "Não informado",
    inicioTeste: row[5]?.trim() || "Não informado",
    paciente: row[6]?.trim() || "Não informado",
    sexo: row[7]?.trim() || "Não informado",
    usuario: row[8]?.trim() || "Não informado",
    finalizacao: row[9]?.trim()?.replace(/"/g, "") || "Não informado",
  }));

  console.log("Dados processados:", this.dados);
}

    }
  };
  </script>
