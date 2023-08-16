<template>
  <main class="container">
    <div id="containerlogin"> 
      <div  v-if='error' class="alert alert-warning" role="alert">
        {{mensagem}}
      </div>
      <form @submit.prevent="register">

        <h3>Cadastro de Cliente</h3>

        <div class="form-outline mb-4">
          <input type="name" required v-model="name" id="inputNomeLogin" class="form-control" placeholder="Nome" />
        </div>

        <div class="form-outline mb-4">
          <input class="form-control" type="text" v-model="cpf" placeholder="CPF" v-mask="['#############', '###.###.###-##']">
        </div>

        <div class="form-outline mb-4">
          <input type="email" required v-model="email" id="inputEmailLogin" class="form-control" placeholder="Email" />
        </div>

        <div class="form-outline mb-4">
          <select name="category" v-model="category" id="inputCategory" class="form-control" placeholder="Selecione a categoria">
            <option value="">Selecione a categoria</option>
            <option :value="itemcategory.id"  v-for="itemcategory in categories" :key="itemcategory.id">{{itemcategory.name}}</option>
          </select>
        </div>

        <button type="submit"  class="btn btn-primary btn-block mb-4">Cadastrar</button>

      </form>
    </div> 
  </main>
</template>

<script setup>
import {ref, onMounted} from 'vue';
import ClientDataService from '../services/ClientDataService';
import CategoryDataService from '../services/CategoryDataService';
import { useRouter } from 'vue-router';

const name = ref("");
const cpf = ref("");
const email = ref("");
const category = ref("");
const categories = ref("");
const error = ref(false);
const router = useRouter();
const mensagem = ref(' Houve um erro no cadastro tente novamente mais tarde.');

onMounted(() => {

  const request = getCategories();

  request.then(function(response){

    categories.value = response.data.data.data;

  });

});

async function register(){

  try {
    const data = await ClientDataService.create({
      "name":name.value,
      "cpf": cpf.value.replace(/\D/g, ''),
      "email":email.value,
      "category": category.value
    });

    if (data.status) {
      router.push("/clientes");
    }

  } catch (responseError) {
      error.value = true;
      mensagem.value = responseError.response.data.message;
  }
}

async function getCategories() {
  return await CategoryDataService.getPaginate();
}
</script>

<script>
import {mask} from 'vue-the-mask'
export default {
  directives: {mask}
}
</script>
