import { createRouter, createWebHistory } from 'vue-router';
import ListCompanies from '@/components/ListCompanies.vue';
import UserRegister from '@/components/UserRegister.vue';
import UserLogin from '@/components/UserLogin.vue';
import CreateCompany from '@/components/CreateCompany.vue';
import ListCompanyPartners from '@/components/ListCompanyPartners.vue';
import CreatePartner from '@/components/CreatePartner.vue';
import ListPartner from '@/components/ListPartner.vue';
import UpdateCompany from '@/components/UpdateCompany.vue';
import UpdatePartner from '@/components/UpdatePartner.vue';

const routes = [
  { path: '/login', component: UserLogin },
  { path: '/register', component: UserRegister },
  { path: '/companies', component: ListCompanies },
  { path: '/companies/create', component: CreateCompany },
  { path: '/company-partners/:id', name:'/company-partners', component: ListCompanyPartners },
  { path: '/partners/create', component: CreatePartner },
  { path: '/partners', component: ListPartner },
  { path: '/company-update/:id', name:'/company-update', component: UpdateCompany },
  { path: '/partner-update/:id', name:'/partner-update', component: UpdatePartner },
];

const router = createRouter({
  history: createWebHistory(),
  routes
});

export default router;
