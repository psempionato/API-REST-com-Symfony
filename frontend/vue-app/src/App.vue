<template>
  <div id="app">
    <nav class="bg-gray-800 p-4">
      <div class="container mx-auto">
        <router-link to="/login" class="text-white px-4"></router-link>
        <router-link to="/register" class="text-white px-4"></router-link>
        <router-link to="/companies" class="text-white px-4"></router-link>
        <router-link to="/companies/create" class="text-white px-4"></router-link>
      </div>
    </nav>
    <router-view></router-view>
  </div>
</template>

<script>
export default {
  name: 'App',
};
</script>

<style>

</style>
