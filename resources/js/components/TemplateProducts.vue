<template>
    <form action="" @submit.prevent="save">
        
        <div class="form-group row">

         <div v-for="(product, index) in form.products" class="mr-12">
             <div class="col-md-2 col-form-label">
                 products
             </div>


             <div class="col-md">
                 <div class="row">
                     <div class="col-md">
                         <select v:model="form.products[index].id" class="form-control">
                             <option label="Label"></option>
                             <option v-for="product in products" :value="product.id">{{ product.name }}</option>

                         </select>

<div v-if="errors[`products.${index}.id`] "  class="fv-plugins-message-container">

             <div data-field="email" data-validator="notEmpty" class="fv-help-block">{{ errors[`products.${index}.id`][0] }}</div>
             </div>
                     </div>
                     <div class="form-group mr-2">

                         <input class="form-control" v-model="form.products[index].quantity" type="numeric" placeholder="quantity" />
<div v-if="errors[`products.${index}.quantity`] "  class="fv-plugins-message-container">

             <div data-field="email" data-validator="notEmpty" class="fv-help-block">{{ errors[`products.${index}.quantity`][0] }}</div>
             </div>
                     </div>
                     <div class="form-group">

                         <input class="form-control price" v-model="form.products[index].price" type="numeric" placeholder="price" />
<div v-if="errors[`products.${index}.price`] "  class="fv-plugins-message-container">

             <div data-field="email" data-validator="notEmpty" class="fv-help-block">{{ errors[`products.${index}.price`][0] }}</div>
             </div>
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

        <div class="d-flex justify-content-between mt-12">

            <button class=" btn btn-secondary" @click.prevent="addProduct">Add Product</button>
                        <button type="submit" class="btn btn-primary" @click.prevent="save">Create Product Template</button>

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
            products: {
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
                // console.log(`temlpates/${this.template.id}/products`);
                axios.post(`temlpates/${this.template.id}/products`, this.form, {
                    headers: {
                        Authorization: 'Bearer ' + this.auth_token
                    }
                }).then(res => {
                    // window.location = '/templates'
                }).catch(err => {
                this.errors = err.response.data.errors;

                    console.log(err.response.data.errors)
                    // set errors array
                })
            },
            removeProduct(index) {
                this.form.products.splice(index, 1)
            },
            addProduct() {
                this.form.products.push(
                    {id: null, price: null, quantity: null}
                )
            }
        }
    }
</script>