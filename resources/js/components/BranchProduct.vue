<template>
<div class="">
    <div v-for="(product, index) in form.products">
        <div class="form-group row">
            <div class="col-md-2 col-form-label">
                product
            </div>

            <div class="col-md">
                <div class="row">
                    <div class="col-md">

                        <multiselect :searchable="true" v-model="productsValue[index]" @select="(data)=> { productSelected(data,index)}" track-by="id" label="name" :options="products"></multiselect>

                        <div v-if="errors[`products.${index}.id`] " class="fv-plugins-message-container">

                            <div data-field="email" data-validator="notEmpty" class="fv-help-block">{{ errors[`products.${index}.id`][0] }}</div>
                        </div>
                    </div>

                    <div class="form-group mr-2">

                        <input class="form-control " v-model="form.products[index].price" type="numeric" placeholder="price" />
                        <div v-if="errors[`products.${index}.price`] " class="fv-plugins-message-container">

                            <div data-field="email" data-validator="notEmpty" class="fv-help-block">{{ errors[`products.${index}.price`][0] }}</div>
                        </div>
                    </div>

                    <div class="col-md-auto">

                        <button class="btn btn-sm btn-danger land_phones-delete-button" onclick="confirm('Are you sure?') || event.stopImmediatePropagation();" @click.prevent="removeProduct(index)">
                            <i class="fa fa-trash-alt"></i>
                        </button>
                    </div>
                </div>

            </div>
        </div>

    </div>

    <div class="form-group  d-flex justify-content-end mt-5">

        <button class="btn btn-secondary" @click.prevent="addProduct">
            Add product
        </button>

    </div>
    <div class="form-group row">
        <label class="col-form-label text-right col-lg-2 col-sm-12">branch</label>
        <div class="col-lg-10 col-md-9 col-sm-12">

            <multiselect :searchable="true" v-model="branchesValue" track-by="id" label="name" :options="branches"></multiselect>
            <div v-if="errors['branch_id'] " class="fv-plugins-message-container">

                <div data-field="email" data-validator="notEmpty" class="fv-help-block">{{ errors["branch_id"][0] }}</div>
            </div>

        </div>
    </div>
<div class=" d-flex justify-content-center ">
    
    <button class="btn btn-secondary" v-if="action === 'create'" @click.prevent="save" :disabled="!isCreateOrderButtonDisabled">
        Create branch product
    </button>
          <button class="btn btn-secondary" v-if="action === 'edit'" @click.prevent="save" :disabled="!isCreateOrderButtonDisabled">
                edit branch product
            </button>
</div>
</div>
</template>

<script>
import Multiselect from 'vue-multiselect'

export default {
    components: {
        Multiselect
    },
    props: {
      
        branch: {
            required: false,
            type: Object,
        },
        branch_value: {
            required: false,

        },
     
        action: {
            required: true,
            type: String,
        },
        auth_token: {
            required: true,
            type: String,
        },
        action: {
            required: true,
            type: String,
        },
    },

    data() {
        return {
            productsValue: [],
            branchesValue: {},
            errors: [],
            products:[],
            branches:[],
            form: {
                products: [{
                    id: null,
                    price: null
                }],
            },

        }
    },
    computed: {
        isCreateOrderButtonDisabled() {
            return this.form.products.length && this.branchesValue.id
        },
    },
   async mounted() {
        
  const {data:{data:products}} =   await axios.get('/api/product_variations?per_page=10000000', {
                headers: {
                    Authorization: "Bearer " + this.auth_token,
                },
            });
  const {data:{data:branches}} =   await axios.get('/api/branches?per_page=10000000', {
                headers: {
                    Authorization: "Bearer " + this.auth_token,
                },
            });
            this.products =products;
            this.branches =branches;
if(this.branch_value)
{

    this.branchesValue = this.branch_value;
}

     if (this.action === 'edit') {
            this.branchesValue = this.branch;
 

            this.branch.products.forEach((product, index) => {
            // console.log("🚀 ~ file: OrderProduct.vue ~ line 267 ~ this.edit.products.forEach ~ product", product,products.length)

                this.productsValue[index] = product
               this.form.products[index].id = product.id

                this.form.products[index].price = product.pivot.price
                  if( index < this.branch.products.length-1) this.addProduct()

            });

        }
    },
    methods: {
        addProduct() {
            this.form.products.push({
                id: null,
                price: null
            })
        },
        removeProduct(index) {
            this.form.products.splice(index, 1)
        },
        productSelected(product, productIndex) {
            console.log("🚀 ~ file: OrderProduct.vue ~ line 295 ~ productSelected ~ var2", productIndex, product)
            this.form.products[productIndex].id = product.id
            console.log("🚀 ~ file: OrderProduct.vue ~ line 295 ~ productSelected ~ var2", this.form.products)

        },
        save() {

if(this.action === 'edit')
{
    console.log(this.form,'form')
    axios.put(`/api/branch_products/${this.branchesValue.id}/update`, this.form, {
                headers: {
                    Authorization: "Bearer " + this.auth_token,
                },
            }).then((res) => {

                window.location = `/${this.$dashboardPrefix}/branches/${this.branchesValue.id}`
            }).catch((err) => {
                // console.log("🚀 ~ file: OrderProduct.vue ~ line 257 ~ save ~ err.response.data.errors", err.response.data.errors, err.response)
                this.errors = err.response.data.errors;

            });
}

            axios.post(`/api/branch_products/${this.branchesValue.id}`, this.form, {
                headers: {
                    Authorization: "Bearer " + this.auth_token,
                },
            }).then((res) => {

                window.location = `/${this.$dashboardPrefix}/branches/${this.branchesValue.id}`
            }).catch((err) => {
                // console.log("🚀 ~ file: OrderProduct.vue ~ line 257 ~ save ~ err.response.data.errors", err.response.data.errors, err.response)
                this.errors = err.response.data.errors;

            });
        },
       
    },
}
</script>

<style lang="">

</style>
