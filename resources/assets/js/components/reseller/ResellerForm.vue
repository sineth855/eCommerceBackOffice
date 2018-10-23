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
                  <!--<v-layout row wrap>-->
                  <v-tabs text-and-icons>
                    <v-tab href="#tab-1">
                      <v-icon>home</v-icon> &nbsp; General
                    </v-tab>

                    <v-tab href="#tab-2">
                      <v-icon>person</v-icon> &nbsp; Credential Account
                    </v-tab>

                    <!--Tab 1-->
                    <v-tab-item id="tab-1">
                      <v-spacer></v-spacer>

                      <v-layout row>
                        <v-flex xs3>
                          <v-subheader>Assign To Store *</v-subheader>
                        </v-flex>
                        <v-flex xs6>
                          <v-select
                            :items="store"
                            v-model="formData.store_id"
                            label="Assign To Store"
                            auto
                            required
                            item-text="name"
                            item-value="id"
                            v-validate="'required'"
                            data-vv-name="Assign To Store"     
                            :error-messages="errors.collect('Assign To Store')"  
                          ></v-select>
                        </v-flex>
                      </v-layout>

                      <v-layout row>
                        <v-flex xs3>
                          <v-subheader>Store Name *</v-subheader>
                        </v-flex>
                        <v-flex xs6>
                          <v-text-field
                            label="Store Name"
                            name="name"
                            placeholder="Store Name"
                            v-model="formData.store_name"
                            v-validate="'required'"
                            data-vv-name="store name"     
                            :error-messages="errors.collect('store name')"  
                            required
                          ></v-text-field>
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
                            v-model="formData.telephone_1"
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
                          <v-subheader>Country *</v-subheader>
                        </v-flex>
                        <v-flex xs6>
                          <v-text-field
                            label="Country"
                            name="name"
                            placeholder="Country"
                            v-model="formData.country"
                            v-validate="'required'"
                            data-vv-name="country"     
                            :error-messages="errors.collect('country')"  
                            required
                          ></v-text-field>
                        </v-flex>
                      </v-layout>

                      <v-layout row>
                        <v-flex xs3>
                          <v-subheader>City *</v-subheader>
                        </v-flex>
                        <v-flex xs6>
                          <v-text-field
                            label="City"
                            name="name"
                            placeholder="City"
                            v-model="formData.city"
                            v-validate="'required'"
                            data-vv-name="city"     
                            :error-messages="errors.collect('city')"  
                            required
                          ></v-text-field>
                        </v-flex>
                      </v-layout>

                      <v-layout row>
                        <v-flex xs3>
                          <v-subheader>Province *</v-subheader>
                        </v-flex>
                        <v-flex xs6>
                          <v-text-field
                            label="Province"
                            name="name"
                            placeholder="Province"
                            v-model="formData.province"
                            v-validate="'required'"
                            data-vv-name="province"     
                            :error-messages="errors.collect('province')"  
                            required
                          ></v-text-field>
                        </v-flex>
                      </v-layout>

                      <v-layout row>
                        <v-flex xs3>
                          <v-subheader>Postal Code *</v-subheader>
                        </v-flex>
                        <v-flex xs6>
                          <v-text-field
                            label="Postal Code"
                            name="name"
                            placeholder="Postal Code"
                            v-model="formData.code"
                            v-validate="'required'"
                            data-vv-name="postal code"     
                            :error-messages="errors.collect('postal code')"  
                            required
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
                            v-model="formData.address_1"
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
                    </v-tab-item><!--#End Tab 1-->

                    <!--tab-2-->
                    <v-tab-item id="tab-2">
                      <v-spacer></v-spacer>
                      <v-layout row>
                        <v-flex xs3>
                          <v-subheader>Username *</v-subheader>
                        </v-flex>
                        <v-flex xs6>
                          <v-text-field
                            label="Username"
                            name="name"
                            placeholder="Username"
                            v-model="formData.username"
                            v-validate="'required'"
                            data-vv-name="username"     
                            :error-messages="errors.collect('username')"  
                            required
                          ></v-text-field>
                        </v-flex>
                      </v-layout>

                      <v-layout row>
                        <v-flex xs3>
                          <v-subheader>Password</v-subheader>
                        </v-flex>
                        <v-flex xs6>
                          <v-text-field
                            autocomplete="off"
                            :type="showpassword ? 'text' : 'password'"
                            label="Password"
                            name="name"
                            placeholder="Password"
                            v-model="password"
                          ></v-text-field>
                        </v-flex>
                      </v-layout>
                      <input type="hidden" v-model="formData.password"/>
                      <v-layout row>
                        <v-flex xs3>
                          <v-subheader>Confirm Password</v-subheader>
                        </v-flex>
                        <v-flex xs6>
                          <v-text-field
                            autocomplete="off"
                            :type="showpassword ? 'text' : 'password'"
                            label="Confirm Password"
                            placeholder="Confirm Password"
                            v-model="confirm_password"
                          ></v-text-field>
                        </v-flex>
                      </v-layout>
                    </v-tab-item><!--#End tab-2-->
                  </v-tabs><!--#End Tab-->
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
  import {createData,editData,updateData} from '~/api/reseller/reseller'
  import {fetchStoreList} from '~/api/system/store'
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
        showpassword: false,
        parent_name:'Resellers',
        child_name:'Resellers Form',
        routeName:'Resellers List',
        valid: true,
        notifyStatus: '',
        message: '',
        flash: Flash.state,
        store: [],
        password: '',
        confirm_password: '',
        formData: {
          store_id: 0,
          store_name: '',
          firstname: '',
          lastname: '',
          website: '',
          email: '',
          username: '',
          password: '',
          telephone_1: '',
          fax: '',
          country: '',
          city: '',
          province: '',
          code: '',
          address_1: '',
          status: 0
        }
      };
    },
    computed: {
    }, 
    created() {
      this.getStore()
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
            let data = {'id':response['data'][x]['store_id'],'name':response['data'][x]['name']}
            this.store.push(data)
          }
        })
      },
      getData() {
        editData(this.id).then(response => {
          // fetch all form data
          this.formData.username = response['data']['user']['username']
          this.formData.store_id = response['data']['reseller']['store_id']
          this.formData.store_name = response['data']['reseller']['store_name']
          this.formData.firstname = response['data']['reseller']['firstname']
          this.formData.lastname = response['data']['reseller']['lastname']
          this.formData.website = response['data']['reseller']['website']
          this.formData.email = response['data']['reseller']['email']
          this.formData.telephone_1 = response['data']['reseller']['telephone_1']
          this.formData.fax = response['data']['reseller']['fax']
          this.formData.address_1 = response['data']['reseller']['address_1']
          this.formData.country = response['data']['reseller']['country']
          this.formData.city = response['data']['reseller']['city']
          this.formData.province = response['data']['reseller']['province']
          this.formData.code = response['data']['reseller']['code']
          this.formData.status = response['data']['reseller']['status']
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
          this.notifyStatus = 'error'
          this.message = 'All fields are required!'
          return false
        }

        if(this.password!=''){
          if(this.password != this.confirm_password){
            this.notifyStatus = 'error'
            this.message = 'Password is not matched!'
            return false
          }
        }
          // If has props edit data
          if(this.id){
            if(this.password !=''){
              this.formData.password = this.password
            }else{
              this.formData.password = ''
            }
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
            if(this.password == ''){
              this.password = ''
              this.notifyStatus = 'error'
              this.message = 'Password is required!'
              return false
            }
            this.formData.password = this.password
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
          this.notifyStatus = 'error'
          this.message = 'Error while trying to process!'
        });
        
      }
    }
  };
</script>