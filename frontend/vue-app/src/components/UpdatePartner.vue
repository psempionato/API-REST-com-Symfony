<template>
    <div class="container mx-auto p-4">
      <h1 class="text-2xl font-bold mb-4">Atualizar Sócio</h1>
      <form @submit.prevent="updatePartner">
        <div class="mb-4">
          <label class="block text-sm font-medium text-gray-700">Name</label>
          <input
            v-model="partner.name"
            type="text"
            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
          />
        </div>
        <div class="mb-4">
          <label class="block text-sm font-medium text-gray-700">Cpf</label>
          <input
            v-model="partner.cpf"
            type="text"
            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
          />
        </div>
        <div>
          <button
            type="submit"
            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
          >
            Atualizar Sócio
          </button>
        </div>
      </form>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  import { useRoute, useRouter } from 'vue-router';
  import { ref, onMounted } from 'vue';
  
  export default {
    setup() {
      const route = useRoute();
      const router = useRouter();
      const partner = ref({
        name: '',
        cpf: ''
      });
  
      onMounted(async () => {
        const partnerId = route.params.id;
        try {
          const response = await axios.get(`http://localhost:8000/api/partners/${partnerId}`);
          partner.value = response.data.data;
        } catch (error) {
          console.error('Erro ao buscar dados do sócio', error);
        }
      });
  
      const updatePartner = async () => {
        const partnerId = route.params.id;
        try {
          await axios.put(`http://localhost:8000/api/partners/${partnerId}`, partner.value);
          router.push('/partners');
        } catch (error) {
          console.error('Erro ao atualizar sócio', error);
        }
      };
  
      return {
        partner,
        updatePartner
      };
    }
  };
  </script>
  
  <style scoped>
  </style>