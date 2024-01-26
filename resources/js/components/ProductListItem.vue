<template>
  <div class="card-body">
    <div class="row">
      <div class="col-sm">
        <h5 class="card-title">{{ product.nome }} </h5>
      </div>
      <div class="col-sm">
        <p class="card-text">{{ Intl.NumberFormat(lang, {
          style: 'currency', currency:
            currency
        }, product).format(product.valor) }} </p>
      </div>
      <div v-if="product.estoque > 0" class="col-sm">
        <p class="card-text">{{ product.estoque }} em {{ citiesById[product?.cidade_id] ?? 'Local Indefinido' }} </p>
      </div>
      <div v-else class="col-sm">
        <span class="badge badge-warning">Indisponível em {{ citiesById[product?.cidade_id] ?? 'Local Indefinido'
        }}</span>
      </div>
      <div class="col-sm">
        <a :href="`/products/${product.cod}`" class="btn btn-primary">Editar</a>
      </div>
      <div class="col-sm">
        <button @click="deleteProduct" type="submit" class="btn btn-primary" style="align-items: right;">Deletar</button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    product: {
      type: Object,
      required: true,
    },
    lang: {
      type: String,
      required: false,
      default: 'pt-br'
    },
    currency: {
      type: String,
      required: false,
      default: 'BRL'
    },
    citiesById: {
      type: JSON,
      required: false,
      default: () => JSON.parse(localStorage.getItem('citiesById'))
    }
  },
  methods: {
    deleteProduct() {
      axios.delete(`/api/products/${this.product.cod}`)
        .then(response => {
          alert(`Produto ${this.product.nome} deletado com sucesso!`);
          window.location.reload();
        }).catch(error => {
          alert(`Erro ao deletar produto! ${error?.response?.data?.errors}`);
        });
    }
  }
}
</script>
