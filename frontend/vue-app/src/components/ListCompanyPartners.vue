<template>
    <div class="container mx-auto p-4">
      <h1 class="text-2xl font-bold mb-4">Detalhes da Empresa</h1>
      <div v-if="company">
        <div class="mb-4">
          <h2 class="text-xl font-semibold">Informações da Empresa</h2>
          <p><strong>Razão Social:</strong> {{ company.legal_name }}</p>
          <p><strong>Nome Fantasia:</strong> {{ company.trade_name }}</p>
          <p><strong>CNPJ:</strong> {{ company.cnpj }}</p>
          <p><strong>Endereço:</strong> {{ company.address }}</p>
          <p><strong>Telefone:</strong> {{ company.phone }}</p>
          <p><strong>Email:</strong> {{ company.email }}</p>
        </div>
  
        <div>
          <h2 class="text-xl font-semibold mb-2">Sócios</h2>
          <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-md">
            <thead class="bg-gray-100 border-b border-gray-200">
              <tr>
                <th class="border-l-2 border-gray-300 py-2 px-4 text-left text-gray-600 font-semibold">Nome</th>
                <th class="border-l-2 border-gray-300 py-2 px-4 text-left text-gray-600 font-semibold">Cpf</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="partner in company.partners" :key="partner.id">
                <td class="border-l-2 border-gray-300 py-2 px-4">{{ partner.name }}</td>
                <td class="border-l-2 border-gray-300 py-2 px-4">{{ partner.cpf }}</td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="flex justify-left mt-5">
            <div>
                <router-link to="/companies" class="flex justify-left bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400">
                Voltar
                </router-link>
            </div>
        </div>
      </div>
      <div v-else>
        <p>Carregando dados da empresa...</p>
      </div>
    </div> 
  </template>
  
  <script>
  import axios from 'axios';
  import { useRoute } from 'vue-router';
  import { ref, onMounted } from 'vue';
  
  export default {
    setup() {
      const route = useRoute();
      const company = ref(null);
      
      onMounted(async () => {
        const companyId = route.params.id;
        console.log(companyId);
        try {
          const response = await axios.get(`http://localhost:8000/api/companies/${companyId}`);
          company.value = response.data.data;
          console.log(company.value.legal_name);
        } catch (error) {
          console.error('Erro ao buscar sócios', error);
        }
      });
  
      return { 
        company
      };
    }
  };
  </script>
  
  <style>
  /* Adicione ou personalize os estilos Tailwind aqui, se necessário */
  </style>
  