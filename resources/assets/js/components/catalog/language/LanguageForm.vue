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
                      <v-subheader>Name *</v-subheader>
                    </v-flex>
                    <v-flex xs6>
                      <v-text-field
                        label="Name"
                        name="name"
                        placeholder="Name"
                        v-model="formData.name"
                        v-validate="'required'"
                        data-vv-name="name"     
                        :error-messages="errors.collect('name')"  
                        required
                      ></v-text-field>
                    </v-flex>
                  </v-layout>

                  <v-layout row>
                    <v-flex xs3>
                      <v-subheader>Code *</v-subheader>
                    </v-flex>
                    <v-flex xs6>
                      <v-text-field
                        label="Code"
                        name="code"
                        maxlength="3"
                        placeholder="Code"
                        v-model="formData.code"
                        v-validate="'required'"
                        data-vv-name="code"     
                        :error-messages="errors.collect('code')"  
                        required
                      ></v-text-field>
                    </v-flex>
                  </v-layout>

                  <v-layout row>
                    <v-flex xs3>
                      <v-subheader>Locale *</v-subheader>
                    </v-flex>
                    <v-flex xs6>
                      <v-text-field
                        label="Locale"
                        name="locale"
                        placeholder="Locale"
                        v-model="formData.locale"
                        v-validate="'required'"
                        data-vv-name="locale"     
                        :error-messages="errors.collect('locale')"  
                        required
                      ></v-text-field>
                    </v-flex>
                  </v-layout>

                  <v-layout row>
                    <v-flex xs3>
                      <v-subheader>Directory *</v-subheader>
                    </v-flex>
                    <v-flex xs6>
                      <v-text-field
                        label="Directory"
                        name="directory"
                        placeholder="Directory"
                        v-model="formData.directory"
                        v-validate="'required'"
                        data-vv-name="directory"     
                        :error-messages="errors.collect('directory')"  
                        required
                      ></v-text-field>
                    </v-flex>
                  </v-layout>

                  <v-layout row>
                    <v-flex xs3>
                      <v-subheader>Sort Order</v-subheader>
                    </v-flex>
                    <v-flex xs6>
                      <v-text-field
                        label="Sort Order"
                        name="sort_order"
                        placeholder="Sort Order"
                        v-model="formData.sort_order"
                        data-vv-name="sort_order"
                      ></v-text-field>
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
  import {createData,editData,updateData} from '~/api/catalog/language'
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
        parent_name:'Language',
        child_name:'Language Form',
        routeName:'Language',
        valid: true,
        notifyStatus: '',
        message: '',
        flash: Flash.state,
        formData: {
          image: 'image',
          name: '',
          code: '',
          locale: '',
          directory: '',
          sort_order: 0,
          status: true
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
          this.formData.image = response['data']['image']
          this.formData.name = response['data']['name']
          this.formData.code = response['data']['code']
          this.formData.locale = response['data']['locale']
          this.formData.directory = response['data']['directory']
          this.formData.sort_order = response['data']['sort_order'],
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