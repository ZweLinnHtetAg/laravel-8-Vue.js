<template>

  <div class="container my-5">
    <div class="row my-3 justify-content-end">
      <div class="col-4">
        <button class="btn btn-primary btn-lg" @click="create">
          <i class="fas fa-plus-circle mr-1"></i>
          Create
        </button>
      </div>
      <div class="col-4">
        <form v-on:submit.prevent="view">
          <div class="input-group">
            <input
              type="text"
              placeholder="Search"
              class="form-control"
              v-model="search"
            />
            <div class="input-group-append">
              <button type="submit" class="btn btn-primary">
                <i class="fas fa-search mr-1"></i> Search
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
    <div class="row">
      <div class="col-md-4">
        <div class="card">
          <h3 class="card-header">{{ isEditMode ? "Edit" : "Create" }}</h3>
          <div class="card-body">
            <form
              @submit.prevent="isEditMode ? update() : store()"
              @keydown="product.onKeydown($event)"
            >
              <alert-error :form="product" :message="message"></alert-error>
              <div class="form-group">
                <label for="">Name</label>
                <input
                  type="text"
                  v-model="product.name"
                  class="form-control"
                  :class="{ 'is-invalid': product.errors.has('name') }"
                />
                <has-error :form="product" field="name"></has-error>
              </div>
              <div class="form-group">
                <label for="">Price</label>
                <input
                  type="number"
                  v-model="product.price"
                  class="form-control"
                  :class="{ 'is-invalid': product.errors.has('name') }"
                />
                <has-error :form="product" field="price"></has-error>
              </div>
              <button
                class="btn btn-primary btn-block"
                type="submit"
                v-if="isEditMode"
              >
                <i class="fas fa-save mr-1"></i>
                Update
              </button>
              <button class="btn btn-primary btn-block" type="submit" v-else>
                <i class="fas fa-save mr-1"></i>
                Save
              </button>
            </form>
          </div>
        </div>
      </div>
      <div class="col-md-8">
        <table class="table">
          <thead>
            <tr>
              <th>Id</th>
              <th>Name</th>
              <th>Price</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="product in products.data" :key="product.id">
              <td>{{ product.id }}</td>
              <td>{{ product.name }}</td>
              <td>{{ product.price }}</td>
              <td>
                <button class="btn btn-success btn-sm" @click="edit(product)">
                  <i class="fas fa-pen mr-1"></i>
                  Edit
                </button>
                <button
                  class="btn btn-danger btn-sm"
                  @click="destroy(product.id)"
                >
                  <i class="fas fa-trash mr-1"></i>
                  Delete
                </button>
              </td>
            </tr>
          </tbody>
        </table>

        <pagination
          :data="products"
          @pagination-change-page="view"
        ></pagination>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "ProductComponent",
  data() {
    return {
      isLoading : false,
      search: "",
      message: "",
      isEditMode: false,
      products: {},
      product: new Form({
        id : "",
        name: "",
        price: "",
      }),
    };
  },
  methods: {
   
    view(page = 1) {
      let loader = this.$loading.show();
      this.$Progress.start();
      axios
        .get(`api/products?page=${page}&search=${this.search}`)
        .then((response) => {
          this.products = response.data;
          this.$Progress.finish()
          loader.hide()
        })
        .catch((error) => { console.log(error); this.$Progress.fail(); } );
    },

    create() {
      this.product.clear();
      this.isEditMode = false;
      this.product.reset();
    },

    store() {
      let loader = this.$loading.show();
      this.product
        .post("/api/products")
        .then((response) => {
          this.view();
          this.product.clear();
          this.product.reset();
          Toast.fire({
          icon: 'success',
          title: 'Successfully added new product'
          })
        loader.hide();
        })
        .catch((error) => {
          this.message = error.response.data.message;
        });
    },

    edit(product) {
      (this.isEditMode = true), 
      this.product.fill(product);
    },

    update() {
     this.$Progress.start();
     let loader = this.$loading.show();
     this.product.put(`/api/products/${this.product.id}`).then((response) => {
        this.isEditMode = false;
        this.view(), this.product.clear();
        this.product.reset();
        this.$Progress.finish();
         Toast.fire({
        icon: 'success',
        title: 'Successfully Updated'
        })
        loader.hide();
      });

    },
    destroy(productId) {
      this.$Progress.start();
      Swal.fire({
        title: 'Are you sure?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.isConfirmed) {

          axios.delete(`/api/products/${productId}`).then((response) => {
          this.view(),
              (this.product.clear());
              (this.product.reset());
          this.$Progress.finish();
          });
          
          Swal.fire(
            {
              title : 'Deleted!',
              text : 'Product has been deleted.',
              icon : 'success',
            }
          )
        }
      })
     
    },
  },
  created() {
    this.view();
  },
};
</script>

<style>
</style>