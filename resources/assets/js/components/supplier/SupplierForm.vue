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
                      <v-subheader>Store *</v-subheader>
                    </v-flex>
                    <v-flex xs6>
                      <v-combobox
                        :items="stores"
                        v-model="formData.store"
                        tags
                        chips
                        multiple=""
                        label="Store"
                        class="input-group--focused"
                        item-text="name"
                        v-validate="'required'"
                        data-vv-name="store"     
                        :error-messages="errors.collect('store')"  
                        required
                      ></v-combobox>
                    </v-flex>
                  </v-layout>

                  <v-layout row>
                    <v-flex xs3>
                      <v-subheader>First Name *</v-subheader>
                    </v-flex>
                    <v-flex xs6>
                      <v-text-field
                        label="First Name"
                        name="name"
                        placeholder="First Name"
                        v-model="formData.firstname"
                        v-validate="'required'"
                        data-vv-name="first name"     
                        :error-messages="errors.collect('first name')"  
                        required
                      ></v-text-field>
                    </v-flex>
                  </v-layout>

                  <v-layout row>
                    <v-flex xs3>
                      <v-subheader>Last Name *</v-subheader>
                    </v-flex>
                    <v-flex xs6>
                      <v-text-field
                        label="Last Name"
                        name="name"
                        placeholder="Last Name"
                        v-model="formData.lastname"
                        v-validate="'required'"
                        data-vv-name="last name"     
                        :error-messages="errors.collect('last name')"  
                        required
                      ></v-text-field>
                    </v-flex>
                  </v-layout>

                  <v-layout row>
                    <v-flex xs3>
                      <v-subheader>Website</v-subheader>
                    </v-flex>
                    <v-flex xs6>
                      <v-text-field
                        label="Website"
                        name="name"
                        placeholder="Website"
                        v-model="formData.website"
                      ></v-text-field>
                    </v-flex>
                  </v-layout>

                  <v-layout row>
                    <v-flex xs3>
                      <v-subheader>Email *</v-subheader>
                    </v-flex>
                    <v-flex xs6>
                      <v-text-field
                        label="Email"
                        type="email"
                        name="name"
                        placeholder="Email"
                        v-model="formData.email"
                        v-validate="'required'"
                        data-vv-name="email"     
                        :error-messages="errors.collect('email')"  
                        required
                      ></v-text-field>
                    </v-flex>
                  </v-layout>

                  <v-layout row>
                    <v-flex xs3>
                      <v-subheader>Telephone *</v-subheader>
                    </v-flex>
                    <v-flex xs6>
                      <v-text-field
                        label="Telephone"
                        name="name"
                        placeholder="Telephone"
                        v-model="formData.telephone"
                        v-validate="'required'"
                        data-vv-name="telephone"     
                        :error-messages="errors.collect('telephone')"  
                        required
                      ></v-text-field>
                    </v-flex>
                  </v-layout>

                  <v-layout row>
                    <v-flex xs3>
                      <v-subheader>Fax</v-subheader>
                    </v-flex>
                    <v-flex xs6>
                      <v-text-field
                        label="Fax"
                        name="name"
                        placeholder="Fax"
                        v-model="formData.fax"
                      ></v-text-field>
                    </v-flex>
                  </v-layout>

                  <v-layout row>
                    <v-flex xs3>
                      <v-subheader>Address</v-subheader>
                    </v-flex>
                    <v-flex xs6>
                      <v-textarea outline
                        label="address"
                        name="address"
                        placeholder="address"
                        v-model="formData.address"
                        data-vv-name="address"
                      ></v-textarea outline>
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
                          label="Active"
                          :value="1"
                        ></v-radio>
                        <v-radio
                          :key="0"
                          label="Inactive"
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
  import {createData,editData,updateData} from '~/api/supplier/supplier';
  import Message from '~/components/common/Message';
  import {fetchStoreList} from '~/api/system/store';
  import BreadCrumb from '~/components/common/BreadCrumb';
  import VWidget from '~/components/VWidget';
  import Flash from '~/services/flash';
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
        stores: [],
        parent_name:'Suppliers',
        child_name:'Suppliers Form',
        routeName:'Suppliers',
        valid: true,
        notifyStatus: '',
        message: '',
        flash: Flash.state,
        formData: {
          store: [],
          firstname: '',
          lastname: '',
          website: '',
          email: '',
          telephone: '',
          fax: '',
          address: '',
          status: 1
        }
      };
    },
    computed: {
    }, 
    created() {
      this.getStore();
      if(this.id){
        Flash.setLoading(true)
        this.getData();
      }
    },
    methods: {
      backList(){
        this.$router.push({name:this.routeName})
      },
      getStore(){
        fetchStoreList().then(response => {
          // this.datatable = response
          for(let x=0 ; x <= response['data'].length-1 ; x++){
            let data = {'store_id':response['data'][x]['store_id'],'name':response['data'][x]['name']};
            this.stores.push(data);
          }
        })
      },
      getData() {
        editData(this.id).then(response => {
          // fetch all form data
          this.formData.store = response['data']['store'];
          this.formData.firstname = response['data']['firstname']
          this.formData.lastname = response['data']['lastname']
          this.formData.website = response['data']['website']
          this.formData.email = response['data']['email']
          this.formData.telephone = response['data']['telephone']
          this.formData.fax = response['data']['fax']
          this.formData.address = response['data']['address']
          this.formData.status = response['data']['status']
          Flash.setLoading(false)
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