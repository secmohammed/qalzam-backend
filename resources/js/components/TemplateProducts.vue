<template>
    <form action="" @submit.prevent="save">
        
     <div class="form-group row">
         <div v-for="(product, index) in form.products">

             <div class="col-md-2 col-form-label">
                 products
             </div>

             <div class="col-md">
                 <div class="row">
                     <div class="col-md">
                         <select v:model="form.products[index].id" class="form-control kt_select2_products ">
                             <option label="Label"></option>
                             <option v-for="procutsVariation in productVariations" :value="procutsVariation.id">{{ procutsVariation.name }}</option>

                         </select>

                     </div>
                     <div class="form-group mr-2">

                         <input class="form-control " v-model="form.products[index].quantity" type="numeric" placeholder="quantity" />

                     </div>
                     <div class="form-group">

                         <input class="form-control price " v-model="form.products[index].price" type="numeric" placeholder="price" />

                     </div>
                     <div class="col-md-auto">

                         <button class="btn btn-sm btn-danger land_phones-delete-button" onclick="confirm('Are you sure?') || event.stopImmediatePropagation();" @click="removeProduct(index)">
                             <i class="fa fa-trash-alt"></i>
                         </button>
                     </div>
                 </div>

             </div>
         </div>
     </div>

   <div class="d-flex justify-content-end mt-5">
        <button class=" btn btn-secondary " @click.prevent="addProduct">Add Product</button>
        <button type="submit"></button>
        </div>
        
    </form>
</template>
<script>
    export default {
        props: {
            action: {
                required: true,
                type: String,
            },

            template: {
                required: true,
                type: Object
            },
            auth_token: {
                required: true,
                type: String
            }
        },
        data() {
            return {
                errors: [],
                form: {
                    products: [
                        {id: null, price: null, quantity: null}
                    ],
                }
            }
        },
        mounted() {
        },
        methods: {
            save() {
                axios.post(`temlpates/${this.template.id}/products`, this.form, {
                    headers: {
                        Authorization: 'Bearer ' + this.auth_token
                    }
                }).then(res => {
                    // window.location = '/templates'
                }).catch(err => {
                    // console.log(err.response.data.errors)
                    //set errors array
                })
            },
            addProduct() {
                this.form.products.push(
                    {id: null, price: null, quantity: null}
                )
            }
        }
    }
</script>