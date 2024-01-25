<template>
  <form @submit.prevent="submitForm" class="form mini-form">
    <h1 v-if="isEdition">Editando Produto</h1>
    <h1 v-else>Novo Produto</h1>
    <div v-if="isEdition" class="form-group row mt-3">
      <label for="cod" class="col-sm-2 col-form-label">Cod</label>
      <div class="col-sm-10">
        <input type="text" id="cod" readonly class="form-control-plaintext" v-model="product.cod">
      </div>
    </div>
    <div class="form-group mt-3">
      <label for="nome">Nome do Produto</label>
      <input type="text" class="form-control" id="nome" v-model="product.nome" placeholder="Nome" />
    </div>
    <div class="form-group mt-3">
      <label for="valor">Valor do Produto</label>
      <input type="number" step="any" class="form-control" id="valor" v-model="product.valor" placeholder="R$ 00.00">
    </div>
    <div class="form-group mt-3">
      <label for="estoque">Estoque do Produto</label>
      <input type="number" class="form-control" id="estoque" v-model="product.estoque" placeholder="2" />
    </div>
    <div class="form-group mt-3">
      <label for="cidade">Cidade</label>
      <select class="form-control city-selection" id="cidade" v-model="product.cidade_id">
        <option v-for="(id, nome) in citiesIdByNome" :value="id" :key="id">{{ nome }}</option>
      </select>
    </div>
    <button type="submit" class="btn btn-primary mt-3" style="align-items: right;">Enviar</button>
  </form>
</template>

<script>
export default {
  props: {
    product: {
      required: false,
      default: () => ({
        cod: undefined,
        nome: undefined,
        valor: undefined,
        cidade_id: undefined,
        estoque: undefined
      })
    },
    isEdition: {
      type: Boolean,
      required: true,
    },
    errors: {
      required: false
    },
    isSuccessful: {
      required: false
    },
    citiesIdByNome: {
      type: JSON,
      required: false,
      default: () => JSON.parse(localStorage.getItem('citiesIdByNome'))
    },
    idSearch: {
      type: Number,
      required: false
    }
  },
  created() {
    if (this.idSearch && this.isEditing) {
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
      if (this.isEditing) {
        this.editProduct();
      } else {
        this.createProduct();
      }
    },
    createProduct() {
      axios.post(this.PRODUCT_API_ROUTE, this.product)
        .then(response => {
          this.errors = undefined;
          this.isSuccessful = true;
        }).catch(error => {
          this.errors = error?.response?.data?.errors ?? 'Erro Inesperado';
          this.isSuccessful = false;
        });
    },
    editProduct() {
      axios.put(`${this.PRODUCT_API_ROUTE}/${this.product.id}`, this.product)
        .then(response => {
          this.isSuccessful = true;
          this.errors = undefined;
        }).catch(error => {
          this.errors = error?.response?.data?.errors ?? 'Erro Inesperado';
          this.isSuccessful = false;
        });
    }
  }
};
</script>