<template>
  <div class="p-6 max-full mx-auto">
    <h2 class="text-3xl font-bold text-gray-800 mb-6 border-b-2 border-gray-300 pb-2">Empresas</h2>
    <div style="height: 50px;"> 
      <router-link to="/companies/create" class="bg-green-500 text-white px-6 py-2 rounded hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-400">
        Cadastrar Nova Empresa
      </router-link>
      <router-link to="/partners/create" class="ml-5 bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400">
        Cadastrar Sócio
      </router-link>
      <router-link to="/partners" class="ml-5 bg-yellow-500 text-white px-6 py-2 rounded hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-400">
        Listar Sócios
      </router-link>
    </div>
    <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-md">
      <thead class="bg-gray-100 border-b border-gray-200">
        <tr>
          <th class="py-2 px-4 text-left text-gray-600 font-semibold">Razão Social</th>
          <th class="border-l-2 border-gray-300 py-2 px-4 text-left text-gray-600 font-semibold">Nome Fantasia</th>
          <th class="border-l-2 border-gray-300 py-2 px-4 text-left text-gray-600 font-semibold">CNPJ</th>
          <th class="border-l-2 border-gray-300 py-2 px-4 text-left text-gray-600 font-semibold">Endereço</th>
          <th class="border-l-2 border-gray-300 py-2 px-4 text-left text-gray-600 font-semibold">Telefone</th>
          <th class="border-l-2 border-gray-300 py-2 px-4 text-left text-gray-600 font-semibold">E-mail</th>
          <th class="border-l-2 border-gray-300 py-2 px-4 text-left text-gray-600 font-semibold">Ações</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="item in items" :key="item.id" class="border-b border-gray-200">
          <td class="py-2 px-4">{{ item.legal_name }}</td>
          <td class="border-l-2 border-gray-300 py-2 px-4">{{ item.trade_name }}</td>
          <td class="border-l-2 border-gray-300 py-2 px-4">{{ item.cnpj }}</td>
          <td class="border-l-2 border-gray-300 py-2 px-4">{{ item.address }}</td>
          <td class="border-l-2 border-gray-300 py-2 px-4">{{ item.phone }}</td>
          <td class="border-l-2 border-gray-300 py-2 px-4">{{ item.email }}</td>
          <td class="border-l-2 border-gray-300 py-2 px-4">
            <router-link :to="{ name: '/company-partners', params: { id: item.id } }" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Ver Sócios</router-link>
            <router-link :to="{ name: '/company-update', params: { id: item.id } }" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600 ml-2">Atualizar</router-link>
            <button @click="deteteCompany(item.id)" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 ml-2">Excluir</button>
          </td>
        </tr>
        <tr v-if="!items.length">
          <td colspan="8" class="py-2 px-4 text-center text-gray-500">Nenhuma empresa encontrada.</td>
        </tr>
      </tbody>
    </table>
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
        const response = await axios.get('http://localhost:8000/api/companies');
        items.value = response.data.data;
      } catch (error) {
        toast.error('Erro ao buscar empresas');
      }
    });

    const deteteCompany = (id) => {
      try {
          axios.delete(`http://localhost:8000/api/companies/${id}`);
          toast.success("Empresa excluida com sucesso!");
          items.value = items.value.filter(company => company.id !== id);
      } catch (error) {
          toast.error("Falha ao excluir empresa!");
      }
    };

    return { 
      items,
      deteteCompany
    };
  }
};
</script>

<style>

</style>
