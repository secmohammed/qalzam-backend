<template>
    <form action="" @submit.prevent="save">
        

       <div v-for="(product, index) in form.products">
            <div class="form-group row">
                <div class="col-md-1 col-form-label">
                    product
                </div>

                    <div class="row col-sm-11">
                        <div class="col-sm-6">
                           
                <multiselect :searchable="true" v-model="productsValue[index]" @select="(data)=> { productSelected(data,index)}" track-by="id" label="name" :options="products"></multiselect>

                            
                            <div v-if="errors[`products.${index}.id`] " class="fv-plugins-message-container">

                                <div data-field="email" data-validator="notEmpty" class="fv-help-block">{{ errors[`products.${index}.id`][0] }}</div>
                            </div>
                        </div>

                        <div class="form-group mr-2">

                            <input class="form-control " v-model="form.products[index].quantity" type="numeric" placeholder="quantity" />
                            <div v-if="errors[`products.${index}.quantity`] " class="fv-plugins-message-container">

                                <div data-field="email" data-validator="notEmpty" class="fv-help-block">{{ errors[`products.${index}.quantity`][0] }}</div>
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
                     <!-- <div class="col-md-auto">

                         <button class="btn btn-sm btn-danger land_phones-delete-button" onclick="confirm('Are you sure?') || event.stopImmediatePropagation();" @click="removeProduct(index)">
                             <i class="fa fa-trash-alt"></i>
                         </button>
                     </div>
                 </div> -->

             </div>
         </div>

        <div class="d-flex justify-content-between mt-12">

            <button class=" btn btn-secondary" @click.prevent="addProduct">Add Product</button>
                        <button type="submit" class="btn btn-primary" @click.prevent="save">Create Product Template</button>

        </div>
    </form>
</template>
<script>
 import Multiselect from 'vue-multiselect'

    export default {
        components:{
        Multiselect

        },
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
                type: Array
            },
            auth_token: {
                required: true,
                type: String
            }
        },
        data() {
            return {
                errors: [],
            productsValue: [],

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
                axios.post(`/api/templates/${this.template.id}/products`, this.form, {
                    headers: {
                        Authorization: 'Bearer ' + this.auth_token
                    }
                }).then(res => {
                    window.location = `/${this.$dashboardPrefix}/templates/${this.template.id}`
                }).catch(err => {
                    this.errors = err.response.data?.errors || [];
                })
            },
            removeProduct(index) {
                this.form.products.splice(index, 1)
            },
             productSelected(product,productIndex) {
                console.log("🚀 ~ file: OrderProduct.vue ~ line 295 ~ productSelected ~ var2", productIndex,product)
                this.form.products[productIndex].id=product.id
                console.log("🚀 ~ file: OrderProduct.vue ~ line 295 ~ productSelected ~ var2",this.form.products)

                },
            addProduct() {
                this.form.products.push(
                    {id: null, price: null, quantity: null}
                )
            }
        }
    }
</script>