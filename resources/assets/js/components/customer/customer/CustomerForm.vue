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
                      <v-icon>person</v-icon> &nbsp; Address
                    </v-tab>

                    <v-tab href="#tab-3">
                      <v-icon>person</v-icon> &nbsp; Credential Account
                    </v-tab>

                    <!--Tab 1-->
                    <v-tab-item id="tab-1">
                      <v-spacer>&nbsp;</v-spacer>

                      <v-layout row>
                        <v-flex xs3>
                          <v-subheader>Store *</v-subheader>
                        </v-flex>
                        <v-flex xs6>
                          <v-select
                            :items="store"
                            v-model="formData.store_id"
                            label="Store"
                            auto
                            item-text="name"
                            item-value="id"
                            v-validate="'required'"
                            data-vv-name="store"     
                            :error-messages="errors.collect('store')"  
                            required
                          ></v-select>
                        </v-flex>
                      </v-layout>

                      <v-layout row>
                        <v-flex xs3>
                          <v-subheader>Customer Group *</v-subheader>
                        </v-flex>
                        <v-flex xs6>
                          <v-select
                            :items="customerGroup"
                            v-model="formData.customer_group_id"
                            label="Customer Group"
                            auto
                            required
                            item-text="name"
                            item-value="id"
                            v-validate="'required'"
                            data-vv-name="customer group"     
                            :error-messages="errors.collect('customer group')"  
                          ></v-select>
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
                          <v-subheader>Newsletter *</v-subheader>
                        </v-flex>
                        <v-flex xs6>
                          <v-radio-group v-model="formData.newsletter" row>
                            <v-radio
                              :key="1"
                              label="Yes"
                              :value="1"
                            ></v-radio>
                            <v-radio
                              :key="0"
                              label="No"
                              :value="0"
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
                      <v-spacer>&nbsp;</v-spacer>
                      <div v-for="(data, key) in address" :key="key">
                          <v-layout row>
                            <v-flex xs3>
                              <v-subheader>First Name *</v-subheader>
                            </v-flex>
                            <v-flex xs6>
                              <v-text-field
                                label="First Name"
                                v-bind:value="data['firstname']"
                                name="firstname[]"
                                v-bind:class="'firstname'+ key"
                                :key="key"
                                placeholder="First Name"  
                                v-validate="'required'"
                                v-model="data.firstname"
                                data-vv-name="customer first name"
                                :error-messages="errors.collect('customer first name')"  
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
                                v-bind:value="data['lastname']"
                                name="lastname[]"
                                v-bind:class="'lastname'+ key"
                                placeholder="Last Name"
                                :key="key"
                                v-model="data.lastname"
                                v-validate="'required'"
                                data-vv-name="customer last name"     
                                :error-messages="errors.collect('customer last name')"  
                                required
                              ></v-text-field>
                            </v-flex>
                          </v-layout>

                          <v-layout row>
                            <v-flex xs3>
                              <v-subheader>Company *</v-subheader>
                            </v-flex>
                            <v-flex xs6>
                              <v-text-field
                                label="Company"
                                v-bind:value="data['company']"
                                name="company[]"
                                v-bind:class="'company'+ key"
                                placeholder="Company"
                                :key="key"
                                v-model="data.company"
                                v-validate="'required'"
                                data-vv-name="customer company"     
                                :error-messages="errors.collect('customer company')"  
                                required
                              ></v-text-field>
                            </v-flex>
                          </v-layout>
                          
                          <v-layout row>
                            <v-flex xs3>
                              <v-subheader>Country</v-subheader>
                            </v-flex>
                              <v-flex xs6>
                                <v-autocomplete
                                  :items="country"
                                  :key="key"
                                  v-bind:value="data['country']"
                                  label="Country"
                                  single-line
                                  autocomplete="off"
                                  name="country[]"
                                  v-bind:class="'country'+ key"
                                  item-text="name"
                                  item-value="id"
                                  v-model="data.country"
                                  v-validate="'required'"
                                  data-vv-name="customer country"     
                                  :error-messages="errors.collect('customer country')"  
                                  required
                                ></v-autocomplete>
                                <v-flex xs6>
                            </v-flex>
                            </v-flex>
                          </v-layout>

                          <v-layout row>
                            <v-flex xs3>
                              <v-subheader>Zone *</v-subheader>
                            </v-flex>
                              <v-flex xs6>
                                <v-autocomplete
                                  :items="zoneData"
                                  :key="key"
                                  v-bind:value="data['zone']"
                                  label="Zone"
                                  single-line
                                  autocomplete="off"
                                  name="zone[]"
                                  v-bind:class="'zone'+ key"
                                  item-text="name"
                                  item-value="id"
                                  v-model="data.zone"
                                  v-validate="'required'"
                                  data-vv-name="zone"     
                                  :error-messages="errors.collect('zone')"  
                                  required
                                ></v-autocomplete>
                                <v-flex xs6>
                            </v-flex>
                            </v-flex>
                          </v-layout>

                          <v-layout row>
                            <v-flex xs3>
                              <v-subheader>City *</v-subheader>
                            </v-flex>
                            <v-flex xs6>
                              <v-text-field
                                label="City"
                                name="city[]"
                                v-bind:value="data['city']"
                                placeholder="City"
                                :key="key"
                                v-bind:class="'city'+ key"
                                v-model="data.city"
                                v-validate="'required'"
                                data-vv-name="city"     
                                :error-messages="errors.collect('city')"  
                                required
                              ></v-text-field>
                            </v-flex>
                          </v-layout>

                          <v-layout row>
                            <v-flex xs3>
                              <v-subheader>Post Code *</v-subheader>
                            </v-flex>
                            <v-flex xs6>
                              <v-text-field
                                label="Post Code"
                                name="postcode[]"
                                v-bind:value="data['postcode']"
                                v-bind:class="'postcode'+ key"
                                placeholder="Post Code"
                                :key="key"
                                v-model="data.postcode"
                                v-validate="'required'"
                                data-vv-name="postcode"     
                                :error-messages="errors.collect('postcode')"  
                                required
                              ></v-text-field>
                            </v-flex>
                          </v-layout>

                          <v-layout row>
                            <v-flex xs3>
                              <v-subheader>Address 1 *</v-subheader>
                            </v-flex>
                            <v-flex xs6>
                              <v-textarea outline
                                label="Address 1"
                                name="address_1[]"
                                v-bind:value="data['address_1']"
                                placeholder="Address 1"
                                v-bind:class="'address_1'+ key"
                                :key="key"
                                v-model="data.address_1"
                                v-validate="'required'"
                                data-vv-name="address"     
                                :error-messages="errors.collect('address')"  
                                required
                              ></v-textarea outline>
                            </v-flex>
                          </v-layout>

                          <v-layout row>
                            <v-flex xs3>
                              <v-subheader> Address 2 *</v-subheader>
                            </v-flex>
                            <v-flex xs6>
                              <v-textarea outline
                                label="Address 2"
                                name="address_2[]"
                                v-bind:value="data['address_2']"
                                placeholder="Address 2"
                                v-bind:class="'address_2'+ key"
                                :key="key"
                                v-model="data.address_2"
                                v-validate="'required'"
                                data-vv-name="address 2"     
                                :error-messages="errors.collect('address 2')"  
                                required
                              ></v-textarea outline>
                            </v-flex>
                          </v-layout>

                          <v-layout row>
                            <v-flex sm3 lg3>
                              <v-btn small color="error" @click="removeAddress(key)" dark>Remove</v-btn>
                            </v-flex>
                          </v-layout>

                          <v-divider :key="key"></v-divider>
                          <v-spacer>&nbsp;</v-spacer>
                      </div>
                      <v-layout row>
                        <v-flex sm2 lg2>
                          &nbsp;
                        </v-flex>

                        <v-flex sm3 lg3>
                          &nbsp;
                        </v-flex>

                        <v-flex sm3 lg3>
                          <v-btn small color="primary" @click="addAddress()" dark>Add</v-btn>
                        </v-flex>
                      </v-layout>
                      
                    </v-tab-item><!--#End tab-2-->
                  

                    <!--tab-3-->
                    <v-tab-item id="tab-3">
                      <v-spacer>&nbsp;</v-spacer>
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
  import {createData,editData,updateData} from '~/api/customer/customer'
  import {fetchStoreList} from '~/api/system/store'
  import {fetchZoneList} from '~/api/system/zone'
  import {fetchCountryList} from '~/api/system/country'
  import {fetchCustomerGroupList} from '~/api/customer/customerGroup'
  import Message from '~/components/common/Message'
  import BreadCrumb from '~/components/common/BreadCrumb'
  import VWidget from '~/components/VWidget';
  import Flash from '~/services/flash'
  import * as $ from 'jquery';

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
        parent_name:'Customer',
        child_name:'Customer Form',
        routeName:'Customer',
        valid: true,
        notifyStatus: '',
        message: '',
        flash: Flash.state,
        store: [],
        addressAlt: [],
        address: [],
        addressData: [],
        password: '',
        confirm_password: '',
        zoneData: [],
        country: [],
        customerGroup: [],
        formData: {
          store_id: '',
          firstname: '',
          lastname: '',
          email: '',
          username: '',
          password: '',
          telephone_1: '',
          address: [],
          fax: '',
          country: '',
          city: '',
          province: '',
          code: '',
          newsletter: 0,
          status: 0
        }
      };
    },
    computed: {
    }, 
    created() {
      this.getZone();
      this.getStore();
      this.getCountry();
      this.getCustomerGroup()
      if(this.id){
        Flash.setLoading(true);
        this.getData();
      }
    },
    methods: {
      // attribute
      addAddress() {
        this.address.push({});
        this.newAddress = {};
      },
      removeAddress(key) {
        this.address.splice(key, 1);
      },
      backList(){
        this.$router.push({name:this.routeName})
      },
      getCustomerGroup() {
        fetchCustomerGroupList().then(response => {
          // this.datatable = response
          for(let x=0 ; x <= response['data'].length-1 ; x++){
            let data = {'id':response['data'][x]['customer_group_id'],'name':response['data'][x]['name']}
            this.customerGroup.push(data)
          }
        })
      },
      getZone(){
        fetchZoneList().then(response => {
          // this.datatable = response
          for(let x=0 ; x <= response['data'].length-1 ; x++){
            let data = {'id':response['data'][x]['name'],'name':response['data'][x]['name']}
            this.zoneData.push(data)
          }
        })
      },
      getCountry(){
        fetchCountryList().then(response => {
          // this.datatable = response
          for(let x=0 ; x <= response['data'].length-1 ; x++){
            let data = {'id':response['data'][x]['name'],'name':response['data'][x]['name']}
            this.country.push(data)
          }
        })
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
          this.formData.username = 'username';//response['data']['user']['username']
          this.formData.store_id = response['data']['store_id'];
          this.formData.customer_group_id = response['data']['customer_group_id'];
          this.formData.firstname = response['data']['firstname'];
          this.formData.lastname = response['data']['lastname'];
          this.formData.email = response['data']['email'];
          this.formData.telephone = response['data']['telephone'];
          this.formData.fax = response['data']['fax'];
          this.formData.country = response['data']['country'];
          this.formData.city = response['data']['city'];
          this.formData.province = response['data']['province'];
          this.formData.code = response['data']['code'];
          this.formData.status = response['data']['status'];
          this.address = response['data']['customer_address'];
          Flash.setLoading(false);
        })
      },
      clear () {
        this.formData = {};
        this.$validator.reset();
      },
      onSubmit () {
        
        this.$validator.validateAll().then((result) => {
          
        // console.log(this.formData);
        let addressData = $('input[name="firstname[]"]').length;
        for(let i = 0 ; i <= addressData - 1; i++){
         let _firstname = $('.firstname'+ i + ' input[name="firstname[]"]').val();
         let _lastname = $('.lastname'+ i + ' input[name="lastname[]"]').val();
         let _company = $('.company'+ i + ' input[name="company[]"]').val();
         let _country = $('.country'+ i + ' input[name="country[]"]').val();
         let _zone = $('.zone'+ i + ' input[name="zone[]"]').val();
         let _city = $('.city'+ i + ' input[name="city[]"]').val();
         let _postcode = $('.postcode'+ i + ' input[name="postcode[]"]').val();
         let _address_1 = $('.address_1'+ i + ' textarea[name="address_1[]"]').val();
         let _address_2 = $('.address_2'+ i + ' textarea[name="address_2[]"]').val();
         let _address = {
                      "firstname":""+_firstname+"",
                      "lastname":""+_lastname+"",
                      "company":""+_company+"",
                      "country":""+_country+"",
                      "zone":""+_zone+"",
                      "city":""+_city+"",
                      "postcode":""+_postcode+"",
                      "address_1":""+_address_1+"",
                      "address_2":""+_address_2+""
                    };
          this.addressData.push(_address);
        }
        this.formData.address = this.addressData;
        
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
                // this.clear()
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
       this.addressData = []; 
      }
    }
  };
</script>