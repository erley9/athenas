<template>
  <main class="container">
    <div id="containerlogin"> 
      <div  v-if='error' class="alert alert-warning" role="alert">
        Houve um erro no cadastro tente novamente mais tarde.
      </div>
      <form @submit.prevent="cadastrar">

        <h3>Formulário de Cadastro</h3>

        <div class="form-outline mb-4">
          <input type="name" required v-model="name" id="inputNomeLogin" class="form-control" placeholder="Nome" />
        </div>

        <div class="form-outline mb-4">
          <input type="email" required v-model="email" id="inputEmailLogin" class="form-control" placeholder="Email" />
        </div>
          
        <div class="form-outline mb-4">
          <input type="password" required v-model="password" id="inputSenhaLogin" class="form-control" placeholder="Senha" />
        </div>

        <button type="submit"  class="btn btn-primary btn-block mb-4">Cadastrar</button>

      </form>
    </div> 
  </main>
</template>

<script setup>
import {ref} from 'vue';
import AuthDataService from '../services/AuthDataService';
import { useRouter } from 'vue-router';
const name = ref("");
const email = ref("");
const password = ref("");
const error = ref(false);
const router = useRouter();

async function cadastrar(){
  try{
    const {data} = await AuthDataService.register({
      "name":name.value,
      "email":email.value,
      "password": password.value
    });

    if (data.status) {
      localStorage.setItem('accesstoken', data.token);
      router.push("/clientes");
    } 
  } catch(responseError) {
    error.value = true;
    setInterval(function(){
      error.value = false;
    }, 4000);
  }
}
</script>
