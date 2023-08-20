<template>
  <main class="container">
    <div id="containerlogin"> 
      <div  v-if='error' class="alert alert-warning" role="alert">
        {{mensagem}}
      </div>
      <form @submit.prevent="register">

        <h3>{{title}}</h3>

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

        <button type="submit"  class="btn btn-primary btn-block mb-4">{{descriptionbtn}}</button>

      </form>
    </div> 
  </main>
</template>

<script>
import {ref, computed, defineComponent, onMounted} from 'vue';
import { useRouter } from 'vue-router';
import { useStore } from "@/store";
import {
  LIST_CATEGORIES_ACTION, 
  SAVE_CLIENT_MUTATION, 
  UPDATE_CLIENT_ACTION
} from '@/store/mutation-types'
import {mask} from 'vue-the-mask'
import ClientDataService from "@/services/ClientDataService"

export default defineComponent({
  name: "formulario",
  directives: {mask},
  props: {
    id: {
      type: String,
    },
  },
  setup(props) {

    const name = ref("");
    const cpf = ref("");
    const email = ref("");
    const category = ref("");
    const error = ref(false);
    const router = useRouter();
    const mensagem = ref(' Houve um erro no cadastro tente novamente mais tarde.')
    const title = ref('Cadastro de Cliente')
    const descriptionbtn = ref('Cadastrar')
    const store = useStore()

    store.dispatch(LIST_CATEGORIES_ACTION);

    if (props.id) {
      title.value = "Editar Cliente";
      descriptionbtn.value = "Salvar";
      
        ClientDataService.get(props.id).then(function(client){
          name.value = client.data.data?.name || "";
          cpf.value = client.data.data?.cpf || "";
          email.value = client.data.data?.email || "";
          category.value = client.data.data?.category || "";
        });
      
    }

    const register = async function register(){

      let data = {
          "name":name.value,
          "cpf": cpf.value.replace(/\D/g, ''),
          "email":email.value,
          "category": category.value
      }

      if (props.id) {
        store.dispatch(UPDATE_CLIENT_ACTION,{id:props.id,"data":data})
          .then(() => router.push("/clientes"),
          errorRequest  
        );
      } else {
        store.dispatch(SAVE_CLIENT_MUTATION, data)
          .then(() => router.push("/clientes"),
          errorRequest  
        );
      }
    }

    const errorRequest = function (responseError) {
      error.value = true;
      mensagem.value = responseError.response.data.message;
    }

    return {
        categories: computed(() => store.state.b.categories),
        clients: computed(() => store.state.a.clients),
        mensagem,
        name,
        cpf,
        email,
        category,
        error,
        title,
        descriptionbtn,
        register
    }
  }
});

</script>

