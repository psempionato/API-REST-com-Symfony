<template>
    <div class="bg-gray-100 flex items-center justify-center min-h-screen p-6">
        <div id="app" class="max-w-4xl w-full bg-white p-6 rounded-lg shadow-md">
            <h1 class="text-3xl font-bold text-gray-800 mb-6">Cadastrar Nova Empresa</h1>

            <form @submit.prevent="create">
            <div class="mb-4">
                <label for="razaoSocial" class="block text-gray-700 text-sm font-semibold mb-2">Razão Social</label>
                <input type="text" id="razaoSocial" v-model="company.legal_name" class="w-full p-3 border border-gray-300 rounded-lg" required>
            </div>

            <div class="mb-4">
                <label for="nomeFantasia" class="block text-gray-700 text-sm font-semibold mb-2">Nome Fantasia</label>
                <input type="text" id="nomeFantasia" v-model="company.trade_name" class="w-full p-3 border border-gray-300 rounded-lg" required>
            </div>

            <div class="mb-4">
                <label for="cnpj" class="block text-gray-700 text-sm font-semibold mb-2">CNPJ</label>
                <input type="text" id="cnpj" v-model="company.cnpj" class="w-full p-3 border border-gray-300 rounded-lg" required>
            </div>

            <div class="mb-4">
                <label for="endereco" class="block text-gray-700 text-sm font-semibold mb-2">Endereço</label>
                <input type="text" id="endereco" v-model="company.address" class="w-full p-3 border border-gray-300 rounded-lg" required>
            </div>

            <div class="mb-4">
                <label for="telefone" class="block text-gray-700 text-sm font-semibold mb-2">Telefone</label>
                <input type="tel" id="telefone" v-model="company.phone" class="w-full p-3 border border-gray-300 rounded-lg" required>
            </div>

            <div class="mb-4">
                <label for="email" class="block text-gray-700 text-sm font-semibold mb-2">E-mail</label>
                <input type="email" id="email" v-model="company.email" class="w-full p-3 border border-gray-300 rounded-lg" required>
            </div>

            <div class="mb-4">
                <label for="socios" class="block text-gray-700 text-sm font-semibold mb-2">Sócios</label>
                <select id="socios" v-model="company.partner" class="w-full p-3 border border-gray-300 rounded-lg" required>
                <option value="" disabled>Selecione um sócio</option>
                <option v-for="partner in partners" :key="partner.id" :value="partner.id">{{ partner.name }}</option>
                </select>
            </div>
            <div class="">
                <div class="flex justify-left">
                    <router-link to="/companies" class="flex justify-left bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400">
                    Voltar
                    </router-link>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400">
                    Cadastrar
                    </button>
                </div>
            </div>
            </form>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import { useToast } from 'vue-toastification';
import { ref, onMounted } from 'vue';

export default {

  name: 'UserLogin',
  setup() {
    const company = ref({
      legal_name: '',
      trade_name: '',
      cnpj: '',
      address: '',
      phone: '',
      email: '',
      partner: ''
    });

    const partners = ref([]);
    const toast = useToast();

    const fetchPartners = async () => {
      try {
        const response = await axios.get('http://localhost:8000/api/partners');
        partners.value = response.data.data;
      } catch (error) {
        toast.error("Erro ao carregar a lista de sócios")
      }
    };

    onMounted(() => {
      fetchPartners();
    });

    const create = () => {
        try {
            axios.post('http://localhost:8000/api/companies', {
                legal_name: company.value.legal_name,
                trade_name: company.value.trade_name,
                cnpj: company.value.cnpj,
                address: company.value.address,
                phone: company.value.phone,
                email: company.value.email,
                partner: company.value.partner
            });
            toast.success("Empresa cadastrada com sucesso!");
            this.$router.push('/companies');
        } catch (error) {
            toast.error("Falha ao cadastrar empresa!");
        }
    };

    return {
      company,
      partners,
      create
    };
  }
};
</script>

<style>

</style>