<template>
    <div id="app" class="min-h-screen flex items-center justify-center bg-gray-100">
      <div class="max-w-md w-full space-y-8 p-10 bg-white rounded-lg shadow-md">
        <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
          Faça login para continuar
        </h2>
        <form @submit.prevent="login">
          <div class="rounded-md shadow-sm -space-y-px">
            <div>
              <label for="email-address" class="sr-only">Email</label>
              <input v-model="email" id="email-address" name="email" type="email" autocomplete="email" required
                class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                placeholder="Email">
            </div>
            <div style="margin-top:10px;">
              <label for="password" class="sr-only">Senha</label>
              <input v-model="password" id="password" name="password" type="password" autocomplete="current-password" required
                class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                placeholder="Senha">
            </div>
          </div>
  
          <div class="flex items-center justify-between mt-6">
            <div class="text-sm content-end">
              <router-link to="/register" class="font-medium text-indigo-600 hover:text-indigo-500">
                Não possui um login? Cadastre-se
              </router-link>
              <router-view></router-view>
            </div>
          </div>
  
          <div class="mt-3">
            <button type="submit"
              class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
              Login
            </button>
          </div>
        </form>
      </div>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  import { useToast } from 'vue-toastification';    

  export default {
    name: 'UserLogin',
    data() {
      return {
        email: '',
        password: ''
      };
    },
    methods: {
      async login() {
        const toast = useToast();
        try {
            await axios.post('http://localhost:8000/api/login', {
                email: this.email,
                password: this.password
            });
            this.$router.push('/companies');
        } catch (error) {
            toast.error('Usuário ou senha inválido.');
        }
      }
    }
  };
  </script>
  
  <style>
  </style>