<template>
    <div class="flex flex-col min-h-screen bg-gray-100">
      <Sidebar>
        <div class="mt-8 p-8">
          <div class="mt-6 overflow-x-auto">
            <table class="w-full border-collapse bg-white shadow-md">
              <thead class="bg-gray-300">
                <tr>
                  <th class="p-2 border">ID</th>
                  <th class="p-2 border">Nº Paciente</th>
                  <th class="p-2 border">Data</th>
                  <th class="p-2 border">Tipo de Teste</th>
                  <th class="p-2 border">Resultado</th>
                  <th class="p-2 border">Início</th>
                  <th class="p-2 border">Paciente</th>
                  <th class="p-2 border">Sexo</th>
                  <th class="p-2 border">Usuário</th>
                  <th class="p-2 border">Finalização</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(dado, index) in dados" :key="index">
                  <td class="p-2 border">{{ dado.id }}</td>
                  <td class="p-2 border">{{ dado.numero_paciente }}</td>
                  <td class="p-2 border">{{ dado.data }}</td>
                  <td class="p-2 border">{{ dado.tipo_teste }}</td>
                  <td class="p-2 border">{{ dado.resultado }}</td>
                  <td class="p-2 border">{{ dado.inicio_teste }}</td>
                  <td class="p-2 border">{{ dado.paciente }}</td>
                  <td class="p-2 border">{{ dado.sexo }}</td>
                  <td class="p-2 border">{{ dado.usuario }}</td>
                  <td class="p-2 border">{{ dado.finalizacao }}</td>
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
  </script>
