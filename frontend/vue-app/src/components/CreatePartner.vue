<template>
    <div class="bg-gray-100 flex items-center justify-center min-h-screen p-6">
        <div id="app" class="max-w-4xl w-full bg-white p-6 rounded-lg shadow-md">
            <h1 class="text-3xl font-bold text-gray-800 mb-6">Cadastrar Novo Sócio</h1>

            <form @submit.prevent="create">
            <div class="mb-4">
                <label for="razaoSocial" class="block text-gray-700 text-sm font-semibold mb-2">Nome</label>
                <input type="text" id="razaoSocial" v-model="partner.name" class="w-full p-3 border border-gray-300 rounded-lg" required>
            </div>

            <div class="mb-4">
                <label for="nomeFantasia" class="block text-gray-700 text-sm font-semibold mb-2">Cpf</label>
                <input type="text" id="nomeFantasia" v-model="partner.cpf" class="w-full p-3 border border-gray-300 rounded-lg" required>
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
import { ref } from 'vue';

export default {

  name: 'CreatePartner',
  setup() {
    const partner = ref({
      name: '',
      cpf: '',
    });
    const toast = useToast();

    const create = () => {
        try {
            axios.post('http://localhost:8000/api/partners', {
                name: partner.value.name,
                cpf: partner.value.cpf
            });
            toast.success("Sócio cadastrado com sucesso!");
            this.$router.push('/companies');
        } catch (error) {
            toast.error("Falha ao cadastrar sócio!");
        }
    };

    return {
      partner,
      create
    };
  }
};
</script>

<style>

</style>