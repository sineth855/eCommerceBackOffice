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
                        v-model="formData.title"
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
                        placeholder="Code"
                        maxlength="3"
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
                      <v-subheader>Symbol Left</v-subheader>
                    </v-flex>
                    <v-flex xs6>
                      <v-text-field
                        label="Symbol Left"
                        name="symbol_left"
                        placeholder="Symbol Left"
                        v-model="formData.symbol_left"
                      ></v-text-field>
                    </v-flex>
                  </v-layout>

                  <v-layout row>
                    <v-flex xs3>
                      <v-subheader>Symbol Right</v-subheader>
                    </v-flex>
                    <v-flex xs6>
                      <v-text-field
                        label="Symbol Right"
                        name="symbol_right"
                        placeholder="Symbol Right"
                        v-model="formData.symbol_right"
                      ></v-text-field>
                    </v-flex>
                  </v-layout>

                  <v-layout row>
                    <v-flex xs3>
                      <v-subheader>Decimal Place *</v-subheader>
                    </v-flex>
                    <v-flex xs6>
                      <v-text-field
                        label="Decimal Place"
                        name="decimal_place"
                        maxlength="1"
                        placeholder="Decimal Place"
                        v-model="formData.decimal_place"
                        v-validate="'required'"
                        data-vv-name="decimal place"     
                        :error-messages="errors.collect('decimal place')"  
                        required
                      ></v-text-field>
                    </v-flex>
                  </v-layout>

                  <v-layout row>
                    <v-flex xs3>
                      <v-subheader>Value *</v-subheader>
                    </v-flex>
                    <v-flex xs6>
                      <v-text-field
                        label="Value"
                        name="value"
                        placeholder="Value"
                        v-model="formData.value"
                        v-validate="'required'"
                        data-vv-name="value"     
                        :error-messages="errors.collect('value')"  
                        required
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
  import {createData,editData,updateData} from '~/api/catalog/currencyRate'
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
        parent_name:'Currency Rate',
        child_name:'Currency Rate Form',
        routeName:'Currency Rate',
        valid: true,
        notifyStatus: '',
        message: '',
        flash: Flash.state,
        formData: {
          title: '',
          code: '',
          symbol_left: '',
          symbol_right: '',
          decimal_place: '',
          value: '',
          status: true
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
    },
    methods: {
      backList(){
        this.$router.push({name:this.routeName})
      },
      getData() {
        editData(this.id).then(response => {
          // fetch all form data
          this.formData.title = response['data']['title']
          this.formData.code = response['data']['code']
          this.formData.symbol_left = response['data']['symbol_left']
          this.formData.symbol_right = response['data']['symbol_right']
          this.formData.decimal_place = response['data']['decimal_place']
          this.formData.value = response['data']['value']
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