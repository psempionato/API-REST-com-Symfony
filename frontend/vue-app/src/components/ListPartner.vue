<template>
    <div class="p-6 max-full mx-auto">
      <h2 class="text-3xl font-bold text-gray-800 mb-6 border-b-2 border-gray-300 pb-2">Sócios</h2>
      <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-md">
        <thead class="bg-gray-100 border-b border-gray-200">
          <tr>
            <th class="py-2 px-4 text-left text-gray-600 font-semibold">Nomel</th>
            <th class="border-l-2 border-gray-300 py-2 px-4 text-left text-gray-600 font-semibold">CPF</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="item in items" :key="item.id" class="border-b border-gray-200">
            <td class="border-l-2 border-gray-300 py-2 px-4">{{ item.name }}</td>
            <td class="border-l-2 border-gray-300 py-2 px-4">{{ item.cpf }}</td>
            <td class="border-l-2 border-gray-300 py-2 px-4">
                <router-link :to="{ name: '/partner-update', params: { id: item.id } }" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600 ml-2">Atualizar</router-link>
              <button @click="detetePartner(item.id)" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 ml-2">Excluir</button>
            </td>
          </tr>
          <tr v-if="!items.length">
            <td colspan="8" class="py-2 px-4 text-center text-gray-500">Nenhum sócio.</td>
          </tr>
        </tbody>
      </table>
      <div class="flex justify-left mt-5">
        <div>
            <router-link to="/companies" class="flex justify-left bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400">
            Voltar
            </router-link>
        </div>
        </div>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  import { useToast } from 'vue-toastification';
  import { ref, onMounted } from 'vue';
  
  export default {
    setup() {
      const items = ref([]);
      const toast = useToast();
  
      onMounted(async () => {
        try {
          const response = await axios.get('http://localhost:8000/api/partners');
          items.value = response.data.data;
        } catch (error) {
          toast.error('Erro ao buscar sócios');
        }
      });
  
      const detetePartner = (id) => {
        try {
            axios.delete(`http://localhost:8000/api/partners/${id}`);
            toast.success("Sócio excluido com sucesso!");
            items.value = items.value.filter(partner => partner.id !== id);
        } catch (error) {
            toast.error("Falha ao excluir sócio!");
        }
      };
  
      return { 
        items,
        detetePartner
      };
    }
  };
  </script>
  
  <style>
  
  </style>
  