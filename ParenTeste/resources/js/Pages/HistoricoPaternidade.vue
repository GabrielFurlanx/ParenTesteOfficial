<template>
    <div class="flex flex-col min-h-screen bg-gray-100">
      <Sidebar>
        <div class="mt-8 p-8">
          <div class="mt-6 overflow-x-auto">
            <table class="w-full border-collapse bg-white shadow-md">
              <thead class="bg-gray-300">
                <tr>
                  <th class="p-2 border">ID</th>
                  <th class="p-2 border">Nome da Mãe</th>
                  <th class="p-2 border">Nome do Investigado</th>
                  <th class="p-2 border">Nome da Criança</th>
                  <th class="p-2 border">Data do Exame</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(dado, index) in dados" :key="index">
                  <td class="p-2 border">{{ dado.id }}</td>
                  <td class="p-2 border">{{ dado.nome_mae }}</td>
                  <td class="p-2 border">{{ dado.nome_investigado }}</td>
                  <td class="p-2 border">{{ dado.nome_crianca }}</td>
                  <td class="p-2 border">{{ formatDateTime(dado.created_at) }}</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </Sidebar>
    </div>
  </template>

  <script setup>
  import Sidebar from './Sidebar.vue';
  import { defineProps } from 'vue';

  const props = defineProps({
    dados: Array
  });

  const formatDateTime = (dateString) => {
    if (!dateString) return '';

    const date = new Date(dateString);

    // Formato: ano/mês/dia horas:minutos
    const year = date.getFullYear();
    const month = (date.getMonth() + 1).toString().padStart(2, '0');
    const day = date.getDate().toString().padStart(2, '0');
    const hours = date.getHours().toString().padStart(2, '0');
    const minutes = date.getMinutes().toString().padStart(2, '0');

    return `${year}/${month}/${day} ${hours}:${minutes}`;
  };
  </script>
