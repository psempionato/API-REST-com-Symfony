<template>
    <div class="container mx-auto p-4">
      <h1 class="text-2xl font-bold mb-4">Atualizar Empresa</h1>
      <form @submit.prevent="updateCompany">
        <div class="mb-4">
          <label class="block text-sm font-medium text-gray-700">Razão Social</label>
          <input
            v-model="company.legal_name"
            type="text"
            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
          />
        </div>
        <div class="mb-4">
          <label class="block text-sm font-medium text-gray-700">Nome Fantasia</label>
          <input
            v-model="company.trade_name"
            type="text"
            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
          />
        </div>
        <div class="mb-4">
          <label class="block text-sm font-medium text-gray-700">CNPJ</label>
          <input
            v-model="company.cnpj"
            type="text"
            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
          />
        </div>
        <div class="mb-4">
          <label class="block text-sm font-medium text-gray-700">Endereço</label>
          <input
            v-model="company.address"
            type="text"
            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
          />
        </div>
        <div class="mb-4">
          <label class="block text-sm font-medium text-gray-700">Telefone</label>
          <input
            v-model="company.phone"
            type="text"
            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
          />
        </div>
        <div class="mb-4">
          <label class="block text-sm font-medium text-gray-700">Email</label>
          <input
            v-model="company.email"
            type="email"
            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
          />
        </div>
        <div>
          <button
            type="submit"
            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
          >
            Atualizar Empresa
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
      const company = ref({
        legal_name: '',
        trade_name: '',
        cnpj: '',
        address: '',
        phone: '',
        email: ''
      });
  
      onMounted(async () => {
        const companyId = route.params.id;
        try {
          const response = await axios.get(`http://localhost:8000/api/companies/${companyId}`);
          company.value = response.data.data;
        } catch (error) {
          console.error('Erro ao buscar dados da empresa', error);
        }
      });
  
      const updateCompany = async () => {
        const companyId = route.params.id;
        try {
          await axios.put(`http://localhost:8000/api/companies/${companyId}`, company.value);
          router.push('/companies');
        } catch (error) {
          console.error('Erro ao atualizar empresa', error);
        }
      };
  
      return {
        company,
        updateCompany
      };
    }
  };
  </script>
  
  <style scoped>
  </style>