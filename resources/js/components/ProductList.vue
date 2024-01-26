<template>
  <div class="card">
    <div v-for="product in products" :key="product['cod']" class="card-body">
      <product-list-item :product="product"></product-list-item>
    </div>
    <div class="card-body" style="display: flex; justify-content: center; width: 50%; margin: auto;">
      <a href="/products-new" class="btn btn-primary">Novo Produto</a>
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
    axios.get("/api/products").then(response => {
      this.products = response.data;
    }).catch(error => {
      console.log(JSON.stringify(error));
    });
  }
}
</script>
