<template>
  <div class="form mini-form">
    <h1 v-if="isEdition">Editando Produto</h1>
    <h1 v-else>Novo Produto</h1>
    <div v-if="isEdition" class="form-group row mt-3">
      <label for="cod" class="col-sm-2 col-form-label">Cod: {{ idSearch }}</label>
      <div class="col-sm-10">
        <input type="text" readonly class="form-control-plaintext" v-model="product.cod">
      </div>
    </div>
    <div class="form-group mt-3">
      <label for="nome">Nome do Produto</label>
      <input type="text" class="form-control" v-model="product.nome" placeholder="Nome" />
    </div>
    <div class="form-group mt-3">
      <label for="valor">Valor do Produto</label>
      <input type="number" step="any" class="form-control" v-model="product.valor" placeholder="R$ 00.00">
    </div>
    <div class="form-group mt-3">
      <label for="estoque">Estoque do Produto</label>
      <input type="number" class="form-control" v-model="product.estoque" placeholder="2" />
    </div>
    <div class="form-group mt-3">
      <label for="cidade">Cidade</label>
      <select class="form-control city-selection" v-model="product.cidade_id">
        <option v-for="(id, nome) in citiesIdByNome" :value="id" :key="id">{{ nome }}</option>
      </select>
    </div>
    <button @click="submitForm" type="submit" class="btn btn-primary mt-3" style="align-items: right;">Enviar</button>
  </div>
</template>

<script>
import axios from 'axios';
export default {
  props: {
    product: {
      required: false,
      default: () => ({
        cod: undefined,
        nome: undefined,
        valor: undefined,
        estoque: undefined,
        cidade_id: undefined
      })
    },
    isEdition: {
      type: Boolean,
      required: true,
    },
    citiesIdByNome: {
      type: Object,
      required: false,
      default: () => JSON.parse(localStorage.getItem('citiesIdByNome'))
    },
    idSearch: {
      type: Number,
      required: false
    }
  },
  created() {
    if (this.idSearch !== undefined && this.isEditing) {
      axios.get(`${this.PRODUCT_API_ROUTE}/${this.idSearch}`)
        .then(response => {
          this.product = response.data;
        }).catch(error => {
          this.errors = error?.response?.data?.errors ?? 'Erro Inesperado';
        });
    }
  },
  methods: {
    submitForm() {
      this.product.cidade_id = parseInt(this.product.cidade_id);
      this.product.estoque = parseInt(this.product.estoque);
      this.product.valor = parseFloat(this.product.valor);
      if (this.isEditing) {
        axios.put(`${this.PRODUCT_API_ROUTE}/${this.product.cod}`, this.product).then(response => {
          console.log(JSON.stringify(response));
        }).catch(error => {
          console.log(JSON.stringify(error));
        });
      } else {
        axios({
          method: 'post',
          url: this.PRODUCT_API_ROUTE,
          data: this.product,
        }).then(response => {
          console.log('response' + JSON.stringify(response));
        }).catch(error => {
          console.log('error' + JSON.stringify(error));
        });
      }
    }
  }
};
</script>