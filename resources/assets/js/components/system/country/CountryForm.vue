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
                      <v-subheader>Country Name *</v-subheader>
                    </v-flex>
                    <v-flex xs6>
                      <v-text-field
                        label="Country Name"
                        name="name"
                        placeholder="Country Name"
                        v-model="formData.name"
                        v-validate="'required'"
                        data-vv-name="Country Name"     
                        :error-messages="errors.collect('Country Name')"  
                        required
                      ></v-text-field>
                    </v-flex>
                  </v-layout>

                  <v-layout row>
                    <v-flex xs3>
                      <v-subheader>ISO Code 2 *</v-subheader>
                    </v-flex>
                    <v-flex xs6>
                      <v-text-field
                        label="ISO Code 2"
                        name="name"
                        placeholder="ISO Code 2"
                        v-model="formData.iso_code_2"
                        v-validate="'required'"
                        data-vv-name="ISO Code 2"     
                        :error-messages="errors.collect('ISO Code 2')"  
                        required
                      ></v-text-field>
                    </v-flex>
                  </v-layout>

                  <v-layout row>
                    <v-flex xs3>
                      <v-subheader>ISO Code 3 *</v-subheader>
                    </v-flex>
                    <v-flex xs6>
                      <v-text-field
                        label="ISO Code 3"
                        name="name"
                        placeholder="ISO Code 3"
                        v-model="formData.iso_code_3"
                        v-validate="'required'"
                        data-vv-name="ISO Code 3"     
                        :error-messages="errors.collect('ISO Code 3')"  
                        required
                      ></v-text-field>
                    </v-flex>
                  </v-layout>

                  <v-layout row>
                    <v-flex xs3>
                      <v-subheader>Address Format *</v-subheader>
                    </v-flex>
                    <v-flex xs6>
                      <v-text-field
                        label="Address Format"
                        name="name"
                        placeholder="Address Format"
                        v-model="formData.address_format"
                        v-validate="'required'"
                        data-vv-name="Address Format"     
                        :error-messages="errors.collect('Address Format')"  
                        required
                      ></v-text-field>
                    </v-flex>
                  </v-layout>

                  <v-layout row>
                    <v-flex xs3>
                      <v-subheader>Postcode *</v-subheader>
                    </v-flex>
                    <v-flex xs6>
                      <v-text-field
                        label="Postcode"
                        name="name"
                        placeholder="Postcode"
                        v-model="formData.postcode_required"
                        v-validate="'required'"
                        data-vv-name="Postcode"     
                        :error-messages="errors.collect('Postcode')"  
                        required
                      ></v-text-field>
                    </v-flex>
                  </v-layout>
                  
                  <v-layout row>
                    <v-flex xs3>
                      <v-subheader>Free Shipping</v-subheader>
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
  import {createData,editData,updateData} from '~/api/system/country'
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
        parent_name:'Country',
        child_name:'Country Form',
        routeName:'Country',
        valid: true,
        notifyStatus: '',
        message: '',
        flash: Flash.state,
        formData: {
          name: '',
          iso_code_2: '',
          iso_code_3: '',
          address_format: '',
          postcode_r: '',
          status: 1
        }
      };
    },
    computed: {
    }, 
    created() {
      if(this.id){
        Flash.setLoading(true)
        this.getData();
      }
    },
    methods: {
      backList(){
        this.$router.push({name:this.routeName})
      },
      getData() {
        editData(this.id).then(response => {
          // fetch all form data
          this.formData.name = response['data']['name']
          this.formData.iso_code_2 = response['data']['iso_code_2']
          this.formData.iso_code_3 = response['data']['iso_code_3']
          this.formData.address_format = response['data']['address_format']
          this.formData.postcode_required = response['data']['postcode_required']
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