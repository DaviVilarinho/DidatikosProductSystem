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
  }
}
</script>
