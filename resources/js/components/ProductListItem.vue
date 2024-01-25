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
      <div class="col-sm">
        <p class="card-text">{{ product.estoque }} em {{ cities?.find(city => city.id ===
          product.cidade_id)?.nome ?? 'Localização Desconhecida' }} </p>
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
      default: () => ({
        nome: '',
        valor: 0,
        cidade_id: '',
        estoque: 0
      })
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
    cities: {
      type: Array,
      required: false,
      default: () => JSON.parse(localStorage.cities)
    }
  }
}
</script>
