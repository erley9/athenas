<template>
  <main class="container">
    <div class="card mt-3">
      <div class="card-header">
        Lista de Clientes
      </div>
      <div class="card-body">
        <nav aria-label="Page navigation example">
          <ul class="pagination">
            <li class="page-item" v-bind:class="pag.active ? 'disabled' : ''" v-for="pag in pagination"><a href="#" class="page-link" @click.prevent=listPaginate(pag.url)  v-html="pag.label"></a></li>
          </ul>
        </nav>

        <RouterLink  class="btn btn-success mt-1 mb-1"  to="/clientes/cadastro">Cadastrar</RouterLink>
        <table class="table table-dark table-striped">
          <thead>
            <tr>
              <th scope="col">ID</th>
              <th scope="col">Nome</th>
              <th scope="col">CPF</th>
              <th scope="col">Email</th>
              <th scope="col" class="text-center">Categoria</th>
              <th scope="col">Tipo</th>
              <th scope="col">Ações</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="client in clients" :key="client.id">
              <th scope="row">{{client.id}}</th>
              <td>{{client.name}}</td>
              <td>{{mascaraCpf(client.cpf)}}</td>
              <td>{{client.email}}</td>
              <td class="text-center">{{client.category}}</td>
              <td>{{client.classification}}</td>
              <td>
                <RouterLink  class="icone"  :to="'/clientes/editar/' + client.id"><font-awesome-icon :icon="['fas', 'fa-edit']"/></RouterLink>
                <RouterLink class="icone" to="#" @click="remove(client.id)"><font-awesome-icon :icon="['fas', 'fa-remove']" /></RouterLink>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </main>
</template>

<script>
import {ref, defineComponent, computed} from 'vue'
import { useRouter } from 'vue-router'
import { useRoute } from 'vue-router'
import { useStore } from "@/store"
import {LIST_CLIENTS_ACTION, REMOVE_CLIENT_ACTION} from '@/store/mutation-types'

export default defineComponent({
  name:"ListaCliente",
  setup() {
    const router = useRouter(); 
    const route = useRoute()
    const store = useStore()
    const error = ref(false);
    const mensagem = ref('');

    const page = ref(route.query.page ?? 1);
    store.dispatch(LIST_CLIENTS_ACTION, page.value);

    const remove = async function (id){
      store.dispatch(REMOVE_CLIENT_ACTION, id).then(
        function(response){
          store.dispatch(LIST_CLIENTS_ACTION, page.value);
        },
        function(responseError) {
          error.value = true;
          mensagem.value = responseError.response.data.message;
        }
      )
    }

    const mascaraCpf = function (valor) {
      return valor.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/g,"\$1.\$2.\$3\-\$4")
    }

    const listPaginate = function(url) {
      if (url) {        
        router.push("/clientes"+url)
        page.value = url.replace("?page=","");
        store.dispatch(LIST_CLIENTS_ACTION, page.value); 
      }
    }

    return {
      mascaraCpf,
      clients: computed(() => store.state.a.clients),
      pagination: computed(() => store.state.a.pagination),
      remove,
      listPaginate
    }
  }
})
</script>
