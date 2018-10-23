<template>
  <div id="page-text-fields">
    <v-form ref="form" v-model="valid" lazy-validation @submit.prevent="onSubmit">
      <!--Bread Camp for form -->
      <bread-crumb
        :routeName="routeName"
        :parent_name="parent_name"
        :child_name="child_name">
      </bread-crumb>
      <!--#End Bread Camp for form -->

      <v-container grid-list-xl fluid>
        <!--toast message-->
        <message
          ref="child"
          :notifyStatus="notifyStatus"
          :message="message" > 
        ></message>
        <!--#End toast message-->
        <v-layout row wrap>
          <v-flex sm12>
            <v-widget :title="child_name" >
              <div slot="widget-content">
                <v-container>

                  <v-layout row>
                    <v-flex xs3>
                      <v-subheader>Author *</v-subheader>
                    </v-flex>
                    <v-flex xs6>
                      <v-text-field
                        label="Author"
                        name="name"
                        placeholder="Author"
                        v-model="formData.author"
                        v-validate="'required'"
                        data-vv-name="author"     
                        :error-messages="errors.collect('author')"  
                        required
                      ></v-text-field>
                    </v-flex>
                  </v-layout>

                  <v-layout row>
                    <v-flex xs3>
                      <v-subheader>Product *</v-subheader>
                    </v-flex>
                      <v-flex xs6>
                        <v-select
                          :items="product"
                          v-model="formData.product_id"
                          label="Product"
                          autocomplete
                          single-line
                          required
                          item-text="name"
                          item-value="id"
                          v-validate="'required'"
                          data-vv-name="Product"     
                          :error-messages="errors.collect('Product')"  
                        ></v-select>
                        <v-flex xs6>
                    </v-flex>
                    </v-flex>
                  </v-layout>

                  <v-layout row>
                    <v-flex xs3>
                      <v-subheader>Description</v-subheader>
                    </v-flex>
                    <v-flex xs6>
                      <v-textarea outline
                        label="Description"
                        name="name"
                        placeholder="Description"
                        v-model="formData.text"
                        data-vv-name="Description"
                      ></v-textarea outline>
                    </v-flex>
                  </v-layout>

                  <v-layout row>
                    <v-flex xs3>
                      <v-subheader>Rating *</v-subheader>
                    </v-flex>
                    <v-flex xs6>
                      <v-radio-group v-model="formData.rating" row>
                        <v-radio
                          :key="1"
                          label="Rate 1"
                          :value="1"
                        ></v-radio>
                        <v-radio
                          :key="2"
                          label="Rate 2"
                          :value="2"
                        ></v-radio>

                        <v-radio
                          :key="3"
                          label="Rate 3"
                          :value="3"
                        ></v-radio>
                        <v-radio
                          :key="4"
                          label="Rate 4"
                          :value="4"
                        ></v-radio>
                        <v-radio
                          :key="5"
                          label="Rate 5"
                          :value="5"
                        ></v-radio>
                      </v-radio-group>
                    </v-flex>
                  </v-layout>

                  <v-layout row>
                    <v-flex xs3>
                      <v-subheader>Status *</v-subheader>
                    </v-flex>
                    <v-flex xs6>
                      <v-radio-group v-model="formData.status" row>
                        <v-radio
                          :key="1"
                          label="Enable"
                          :value="1"
                        ></v-radio>
                        <v-radio
                          :key="0"
                          label="Disable"
                          :value="0"
                        ></v-radio>
                      </v-radio-group>
                    </v-flex>
                  </v-layout>
         
                </v-container>
              </div>
            </v-widget>
          </v-flex>
        </v-layout>
      </v-container>
    </v-form>

  </div>
</template>

<script>
  import {createData,editData,updateData} from '~/api/catalog/review'
  import Countries  from '~/api/country';
  import {fetchProductList} from '~/api/catalog/product'
  import Message from '~/components/common/Message'
  import BreadCrumb from '~/components/common/BreadCrumb'
  import VWidget from '~/components/VWidget';
  import Flash from '~/services/flash'
  export default {
    props:['id'],
    $_veeValidate: {
      validator: 'new'
    },
    components: {
      VWidget,
      Message,
      BreadCrumb
    },
    data () {
      return {
        parent_name:'Review',
        child_name:'Review Form',
        routeName:'Review',
        valid: true,
        notifyStatus: '',
        message: '',
        flash: Flash.state,
        product: [],
        formData: {
          product_id: '',
          customer_id: 0,
          author: 'Author',
          text: '',
          rating: 3,
          status: 0
        },
        attributeGroup: [],
      };
    },
    computed: {
    }, 
    created() {
      if(this.id){
        Flash.setLoading(true)
        this.getData();
      }
      this.getAllProduct()
    },
    methods: {
      backList(){
        this.$router.push({name:this.routeName})
      },
      getData() {
        editData(this.id).then(response => {
          console.log("data",response['data'])
          // fetch all form data
          this.formData.product_id = response['data']['product_id']
          this.formData.author = response['data']['author']
          this.formData.rating = response['data']['rating']
          this.formData.text = response['data']['text']
          this.formData.status = response['data']['status']
          Flash.setLoading(false)
        })
      },
      getAllProduct() {
        fetchProductList().then(response => {
          // this.datatable = response
          for(let x=0 ; x <= response['data'].length-1 ; x++){
            let data = {'id':response['data'][x]['product_id'],'name':response['data'][x]['product_name']}
            this.product.push(data)
          }
        })
      },
      clear () {
        this.formData = {};
        this.$validator.reset();
      },
      onSubmit () {
        this.$validator.validateAll().then((result) => {
        if(!result){
          this.notifyStatus = 'error';
          this.message = 'All fields are required!';
          return false;
        }
          // If has props edit data
          if(this.id){
            updateData(this.formData,this.id).then(response => {
              if(response.success == true){
                this.notifyStatus = 'success'
                this.message = response.message
              }else{
                this.notifyStatus = 'error'
                this.message = response.message
              }
            }).catch(e => {
                this.notifyStatus = 'error'
                this.message = 'Error while trying to update data!'
            })
          }else{        
            createData(this.formData).then(response => {
              if(response.success == true){
                this.notifyStatus = 'success'
                this.message = response.message
                this.clear()
              }else{
                this.notifyStatus = 'error'
                this.message = response.message
              }
            }).catch(e => {
                this.notifyStatus = 'error'
                this.message = 'Error while trying to create data!'
            })
          }
        }).catch(() => {
        });
        
      }
    }
  };
</script>