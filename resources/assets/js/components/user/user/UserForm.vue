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
                        <v-flex xs2>
                          <div class="box">
                            <input name="image" type="file" id="fileInput"  style="display:none" ref="fileInput" accept="image/*" @change="showPreviewMainImage($event)"/>
                            
                            <label for="fileInput">
                              <v-card>
                                <v-badge color="red" overlap style="font-size:10px;position:absolute;left:0;">
                                  <v-btn small @click="clearMainImage">
                                    Remove
                                  </v-btn>
                                </v-badge>
                                <img width="100%" class="image" :src="imagePreview"/>
                                <input type="hidden" v-model="formData.image"/>
                              </v-card>
                            </label>
                          </div>
                        </v-flex>
                      </v-layout>

                      <v-layout row>
                        <v-flex xs3>
                          <v-subheader>User Group *</v-subheader>
                        </v-flex>
                        <v-flex xs6>
                          <v-select
                            :items="userGroup"
                            v-model="formData.user_group_id"
                            label="User Group"
                            auto
                            required
                            item-text="name"
                            item-value="id"
                            v-validate="'required'"
                            data-vv-name="User Group"     
                            :error-messages="errors.collect('User Group')"  
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
                            data-vv-name="First Name"     
                            :error-messages="errors.collect('First Name')"  
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
                            data-vv-name="Last Name"     
                            :error-messages="errors.collect('Last Name')"  
                            required
                          ></v-text-field>
                        </v-flex>
                      </v-layout>

                      <v-layout row>
                        <v-flex xs3>
                          <v-subheader>Primary Telephone *</v-subheader>
                        </v-flex>
                        <v-flex xs6>
                          <v-text-field
                            label="Primary Telephone"
                            name="name"
                            placeholder="Primary Telephone"
                            v-model="formData.telephone_1"
                            v-validate="'required'"
                            data-vv-name="Primary Telephone"     
                            :error-messages="errors.collect('Primary Telephone')"  
                            required
                          ></v-text-field>
                        </v-flex>
                      </v-layout>

                      <v-layout row>
                        <v-flex xs3>
                          <v-subheader>Secondary Telephone</v-subheader>
                        </v-flex>
                        <v-flex xs6>
                          <v-text-field
                            label="Secondary Telephone"
                            name="name"
                            placeholder="Secondary Telephone"
                            v-model="formData.telephone_2"
                          ></v-text-field>
                        </v-flex>
                      </v-layout>

                      <v-layout row>
                        <v-flex xs3>
                          <v-subheader>Country</v-subheader>
                        </v-flex>
                        <v-flex xs6>
                          <v-text-field
                            label="Country"
                            name="name"
                            placeholder="Country"
                            v-model="formData.country"
                          ></v-text-field>
                        </v-flex>
                      </v-layout>

                      <v-layout row>
                        <v-flex xs3>
                          <v-subheader>Province</v-subheader>
                        </v-flex>
                        <v-flex xs6>
                          <v-text-field
                            label="Province"
                            name="name"
                            placeholder="Province"
                            v-model="formData.province"
                          ></v-text-field>
                        </v-flex>
                      </v-layout>

                      <v-layout row>
                        <v-flex xs3>
                          <v-subheader>City</v-subheader>
                        </v-flex>
                        <v-flex xs6>
                          <v-text-field
                            label="City"
                            name="name"
                            placeholder="City"
                            v-model="formData.city"
                          ></v-text-field>
                        </v-flex>
                      </v-layout>

                      <v-layout row>
                        <v-flex xs3>
                          <v-subheader>Postal Code</v-subheader>
                        </v-flex>
                        <v-flex xs6>
                          <v-text-field
                            label="Postal Code"
                            name="name"
                            placeholder="Postal Code"
                            v-model="formData.code"
                          ></v-text-field>
                        </v-flex>
                      </v-layout>

                      <v-layout row>
                        <v-flex xs3>
                          <v-subheader>Primary Email *</v-subheader>
                        </v-flex>
                        <v-flex xs6>
                          <v-text-field
                            label="Primary Email"
                            name="name"
                            placeholder="Primary Email"
                            v-model="formData.email"
                            v-validate="'required'"
                            data-vv-name="Primary Email"     
                            :error-messages="errors.collect('Primary Email')"  
                            required
                          ></v-text-field>
                        </v-flex>
                      </v-layout>

                      <v-layout row>
                        <v-flex xs3>
                          <v-subheader>Secondary Email</v-subheader>
                        </v-flex>
                        <v-flex xs6>
                          <v-text-field
                            label="Secondary Email"
                            name="name"
                            placeholder="Secondary Email"
                            v-model="formData.email_2"
                          ></v-text-field>
                        </v-flex>
                      </v-layout>

                      <v-layout row>
                        <v-flex xs3>
                          <v-subheader>Company</v-subheader>
                        </v-flex>
                        <v-flex xs6>
                          <v-text-field
                            label="Company"
                            name="name"
                            placeholder="Company"
                            v-model="formData.company"
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
                          <v-subheader>Address 1</v-subheader>
                        </v-flex>
                        <v-flex xs6>
                          <v-textarea outline
                            label="Address 1"
                            name="address_1"
                            placeholder="Address 1"
                            v-model="formData.address_1"
                            data-vv-name="address 1"
                          ></v-textarea outline>
                        </v-flex>
                      </v-layout>

                      <v-layout row>
                        <v-flex xs3>
                          <v-subheader>Address 2</v-subheader>
                        </v-flex>
                        <v-flex xs6>
                          <v-textarea outline
                            label="address 2"
                            name="address"
                            placeholder="Address 2"
                            v-model="formData.address_2"
                            data-vv-name="address 2"
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
                    </v-tab-item><!--#End tab-1-->
                    
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
                      <input type="hidden" v-model="formData.newpassword"/>
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
  import {createData,editData,updateData} from '~/api/user/user';
  import {fetchUserGroupList} from '~/api/user/Group';
  import {uploadFile} from '~/services/fileUpload';
  import Message from '~/components/common/Message';
  import BreadCrumb from '~/components/common/BreadCrumb';
  import VWidget from '~/components/VWidget';
  import Flash from '~/services/flash';
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
        parent_name:'Users',
        child_name:'User Form',
        routeName:'Users',
        showpassword: false,
        valid: true,
        notifyStatus: '',
        message: '',
        flash: Flash.state,
        store: [],
        password: '',
        confirm_password: '',
        imagePreview: './img/NoPicture.png',
        formData: {
          user_group_id: '',
          image: this.imagePreview,
          firstname: '',
          lastname: '',
          website: '',
          company: '',
          email: '',
          email_2: '',
          username: '',
          password: '',
          newpassword: '',
          telephone_1: '',
          telephone_2: '',
          country: '',
          city: '',
          code: '',
          province: '',
          address_1: '',
          address_2: '',
          status: 0
        },
        userGroup: [],
      };
    },
    computed: {
    }, 
    created() {
      if(this.id){
        Flash.setLoading(true)
        this.getData();
      }
      this.getUserGroup()
    },
    methods: {
      clearMainImage(){
        this.imagePreview = './img/NoPicture.png';
        this.formData.image = '';
        this.$refs.fileInput = './img/NoPicture.png';
      },
      // Upload Image 
      showPreviewMainImage(event) {
        
        //  event.preventDefault();
        const form = event.target;
        const file = event.target.files[0];
        const fd = new FormData();
        fd.append('image', file);
        // Reference to the DOM input element
        var input = event.target;
        // Ensure that you have a file before attempting to read it
        if (input.files && input.files[0]) {
            // create a new FileReader to read this image and convert to base64 format
            var reader = new FileReader();
            // Define a callback function to run, when FileReader finishes its job
            reader.onload = (e) => {
                // Note: arrow function used here, so that "this.imagePreview" refers to the imageData of Vue component
                // Read image as base64 and set to imageData
                // this.imagePreview = e.target.result;
                // upload file
                $('.image').attr('src', e.target.result);
                uploadFile(fd).then(response => {
                  if(response.success == true){
                    // create data
                    this.formData.image = response.data.image_url
                  }else{
                    alert("Error while trying to upload file!")
                  }
                }).catch(e => {
                    alert("Error while trying to upload file!")
                    // this.errors.push(e)
                });    

            }
            // Start the reader job - read file as a data url (base64 format)
            reader.readAsDataURL(input.files[0]);
        }
      },
      backList(){
        this.$router.push({name:this.routeName})
      },
      getData() {
        editData(this.id).then(response => {
          // fetch all form data
          this.formData.image = response['data']['image'];
          this.imagePreview = response['data']['image'];
          this.formData.username = response['data']['username']
          this.formData.password = response['data']['password']
          this.formData.user_group_id = response['data']['user_group_id']
          this.formData.firstname = response['data']['firstname']
          this.formData.lastname = response['data']['lastname']
          this.formData.website = response['data']['website']
          this.formData.email = response['data']['email']
          this.formData.email_2 = response['data']['email_2']
          this.formData.company = response['data']['company']
          this.formData.telephone_1 = response['data']['telephone_1']
          this.formData.telephone_2 = response['data']['telephone_2']
          this.formData.address_1 = response['data']['address_1']
          this.formData.address_2 = response['data']['address_2']
          this.formData.country = response['data']['country']
          this.formData.city = response['data']['city']
          this.formData.province = response['data']['province']
          this.formData.code = response['data']['code']
          this.formData.status = response['data']['status']
          Flash.setLoading(false)
        })
      },
      getUserGroup() {
        fetchUserGroupList().then(response => {
          // this.datatable = response
          for(let x=0 ; x <= response['data'].length-1 ; x++){
            let data = {'id':response['data'][x]['user_group_id'],'name':response['data'][x]['name']}
            this.userGroup.push(data)
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
              this.formData.newpassword = this.password
            }else{
              this.formData.password = this.formData.password
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