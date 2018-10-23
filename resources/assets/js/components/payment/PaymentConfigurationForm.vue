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
                      <v-icon>settings</v-icon> &nbsp; Configuration
                    </v-tab>

                    <!--tab 1-->
                    <v-tab-item id="tab-1" v-if="showBankTransfer">
                      <v-spacer></v-spacer>

                      <v-layout row>
                        <v-flex xs3>
                          <v-subheader>Account Owner *</v-subheader>
                        </v-flex>
                        <v-flex xs6>
                          <v-text-field
                            label="Account Owner"
                            name="name"
                            placeholder="Account Owner"
                            v-model="formData.config_account_owner"
                            v-validate="'required'"
                            data-vv-name="Account Owner"     
                            :error-messages="errors.collect('Account Owner')"  
                            required
                          ></v-text-field>
                        </v-flex>
                      </v-layout>

                      <v-layout row>
                        <v-flex xs3>
                          <v-subheader>Account Detail *</v-subheader>
                        </v-flex>
                        <v-flex xs6>
                          <v-text-field
                            label="Account Detail"
                            name="name"
                            placeholder="Account Detail"
                            v-model="formData.config_account_detail"
                            v-validate="'required'"
                            data-vv-name="Account Detail"     
                            :error-messages="errors.collect('Account Detail')"  
                            required
                          ></v-text-field>
                        </v-flex>
                      </v-layout>

                      <v-layout row>
                        <v-flex xs3>
                          <v-subheader>Bank Address *</v-subheader>
                        </v-flex>
                        <v-flex xs6>
                          <v-text-field
                            label="Bank Address"
                            name="name"
                            placeholder="Bank Address"
                            v-model="formData.config_bank_address"
                            v-validate="'required'"
                            data-vv-name="Bank Address"     
                            :error-messages="errors.collect('Bank Address')"  
                            required
                          ></v-text-field>
                        </v-flex>
                      </v-layout>

                    </v-tab-item>
                    <!--#End tab1-->

                    <!--tab 1-->
                    <v-tab-item id="tab-1" v-if="showPaymentbyCheck">
                      <v-spacer></v-spacer>

                      <v-layout row>
                        <v-flex xs3>
                          <v-subheader>Account Payee *</v-subheader>
                        </v-flex>
                        <v-flex xs6>
                          <v-text-field
                            label="Account Payee"
                            name="name"
                            placeholder="Account Payee"
                            v-model="formData.config_payee"
                            v-validate="'required'"
                            data-vv-name="Account Payee"     
                            :error-messages="errors.collect('Account Payee')"  
                            required
                          ></v-text-field>
                        </v-flex>
                      </v-layout>

                      <v-layout row>
                        <v-flex xs3>
                          <v-subheader>Payee Address *</v-subheader>
                        </v-flex>
                        <v-flex xs6>
                          <v-text-field
                            label="Payee Address"
                            name="name"
                            placeholder="Payee Address"
                            v-model="formData.config_payee_address"
                            v-validate="'required'"
                            data-vv-name="Payee Address"     
                            :error-messages="errors.collect('Payee Address')"  
                            required
                          ></v-text-field>
                        </v-flex>
                      </v-layout>
                    </v-tab-item>
                    <!--#End tab1-->

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
  import {createData,editData,updateData} from '~/api/payment/paymentMethod'
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
        parent_name:'Payment Methods',
        child_name:'Payment Methods Form',
        routeName:'Payment Methods',
        valid: true,
        notifyStatus: '',
        message: '',
        flash: Flash.state,
        store: [],
        showBankTransfer: false,
        showPaymentbyCheck: false,
        formData: {
          config_account_owner: '',
          config_account_detail: '',
          config_bank_address: '',
          config_payee: '',
          config_payee_address: '',
        }
      };
    },
    computed: {
    }, 
    created() {
      this.getStore()
      if(this.id){
        if(this.id == 1){
          this.showBankTransfer = true;
          this.showPaymentbyCheck = false;
        }else if(this.id == 2) {
          this.showBankTransfer = false;
          this.showPaymentbyCheck = true;
        }
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
            let data = {'store_id':response['data'][x]['store_id'],'name':response['data'][x]['name']}
            this.store.push(data)
          }
        })
      },
      getData() {
        editData(this.id).then(response => {
          // fetch all form data
          if(this.id==1){
            this.formData.config_account_owner = response['data']['PaymentConfiguration'][0]['config_account_owner'];
            this.formData.config_account_detail = response['data']['PaymentConfiguration'][1]['config_account_detail'];
            this.formData.config_bank_address = response['data']['PaymentConfiguration'][2]['config_bank_address'];
          }else if(this.id==2){
            this.formData.config_payee = response['data']['PaymentConfiguration'][0]['config_payee'];
            this.formData.config_payee_address = response['data']['PaymentConfiguration'][1]['config_payee_address'];
          }
          
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