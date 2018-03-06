<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <form>
                    <div class="form-group">
                        <label>Product Name</label>
                        <input type="text" v-model="form.productName" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Quantity in Stock</label>
                        <input type="text" v-model="form.quantityInStock" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Price per Item</label>
                        <input type="text" v-model="form.pricePerItem" class="form-control">
                    </div>
                    <button type="submit" @click.prevent="storeProducts()" class="btn btn-primary">Submit</button>
                </form>
                <br>
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">Product</th>
                        <th scope="col">Qty in Stock</th>
                        <th scope="col">Price per Item</th>
                        <th scope="col">Date Added</th>
                        <th scope="col">Total Value</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="product in orderedProducts">
                        <td>{{ product.productName}}</td>
                        <td>{{ product.quantityInStock }}</td>
                        <td>{{ product.pricePerItem }}</td>
                        <td>{{ product.dateAdded }}</td>
                        <td>{{ product.totalValue }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</template>

<script>
    export default {
        data(){
          return{
              products:[],
              form: {
                  productName: '',
                  quantityInStock: '',
                  pricePerItem: '',
                  dateAdded: '',
                  totalValue: ''
              }
            }
        },
        mounted() {
            this.getProducts()
        },
        computed:{
            orderedProducts(){
                return _.orderBy(this.products,'dateAdded');
            }
        },
        methods:{
            getProducts(){
                axios.get('/products')
                    .then(response => {
                        this.products = response.data
                })
            },
            storeProducts(){
                this.form.dateAdded = new Date();
                this.form.totalValue = this.form.quantityInStock * this.form.pricePerItem;
                this.products.push(this.form);
                axios.post('/products',this.products)
                    .then(response => {
                        this.form.productName = '';
                        this.form.quantityInStock = '';
                        this.form.pricePerItem = '';
                        this.form.dateAdded = '';
                        this.form.totalValue = '';
                        this.getProducts();
                })
            }
        }
    }
</script>
