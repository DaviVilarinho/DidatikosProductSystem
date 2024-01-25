<template>
  <div class="card">
    <div v-for="product in products" :key="product['cod']" class="card-body">
      <product-list-item :product="product"></product-list-item>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      products: []
    };
  },
  created() {
    this.products = [{
      cod: '1',
      nome: 'Produto 1',
      valor: 10.0,
      estoque: 11,
      cidade_id: '1'
    }, {
      cod: '2',
      nome: 'Produto 2',
      valor: 20.0,
      estoque: 22,
      cidade_id: '1'
    }, {
      cod: '4',
      nome: 'Produto 4 Que Acabou',
      valor: 20.0,
      estoque: 0,
      cidade_id: '1'
    }, {
      cod: '3',
      nome: 'Produto 3',
      valor: 30.0,
      estoque: 33,
      cidade_id: '1'
    }];
  }
}
</script>
