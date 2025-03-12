<template>
    <div v-if="show" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
      <div class="bg-white rounded-lg shadow-lg w-11/12 max-w-2xl">

        <!-- Cabeçalho -->
        <div class="flex justify-between items-center p-4 border-b">
          <h2 class="text-xl font-semibold">{{ title }}</h2>
          <button @click="$emit('close')" class="text-gray-500 hover:text-gray-700">
            ✖
          </button>
        </div>

        <!-- Corpo do Modal -->
        <div class="p-4">
          <slot></slot>
        </div>

        <!-- Rodapé -->
        <div class="flex justify-end p-4 border-t">
          <button @click="$emit('close')" class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500">
            Fechar
          </button>
        </div>

      </div>
    </div>
  </template>

  <script>
  export default {
    props: {
      show: Boolean,
      title: String
    }
  };
  </script>
