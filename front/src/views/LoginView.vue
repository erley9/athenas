<template>
  <main class="container">
    <div id="containerlogin"> 
      <div  v-if='error' class="alert alert-warning" role="alert">
        Houve um erro no login tente novamente.
      </div>
      <form @submit.prevent="login">
        <div class="form-outline mb-4">
          <input type="email" required v-model="email" id="inputEmailLogin" class="form-control" placeholder="Email" />
        </div>
          
        <div class="form-outline mb-4">
          <input type="password" required v-model="password" id="inputSenhaLogin" class="form-control" placeholder="Senha" />
        </div>

        <button type="submit"  class="btn btn-primary btn-block mb-4">Entrar</button>

        <div class="text-left">
          <p><RouterLink  class="nav-link"  to="/registro">Cadastrar</RouterLink></p>
        </div>
      </form>
    </div> 
  </main>
</template>

<script>
import {ref, defineComponent} from 'vue'
import AuthDataService from '../services/AuthDataService'
import { useRouter } from 'vue-router'
import { useStore } from "@/store"
import { 
    LIST_CATEGORIES_ACTION,
    LIST_CLIENTS_ACTION
} from '@/store/mutation-types'

export default defineComponent({
  name:"login",
  setup (){
    const email = ref("")
    const password = ref("")
    const error = ref(false)
    const router = useRouter()
    const store = useStore()

    const login  = async function (){
      try{
        const {data} = await AuthDataService.login({
          "email":email.value,
          "password":password.value
        });

        if (data.status) {
          localStorage.setItem('accesstoken', data.token);
          store.dispatch(LIST_CATEGORIES_ACTION);
          store.dispatch(LIST_CLIENTS_ACTION, 1);
          router.push("/clientes");
        }
        
      }catch(responseError) {
        error.value = true;
        setInterval(function(){
          error.value = false;
        }, 4000);
      }
    }

    return {
      email,
      password,
      login,
      error
    }
  }
})
</script>
