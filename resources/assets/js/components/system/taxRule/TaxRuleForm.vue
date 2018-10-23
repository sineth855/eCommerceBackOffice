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
                      <v-subheader>Tax Class *</v-subheader>
                    </v-flex>
                    <v-flex xs6>
                      <v-select
                        :items="taxClass"
                        v-model="formData.tax_class_id"
                        label="Tax Class"
                        auto
                        required
                        item-text="name"
                        item-value="id"
                        v-validate="'required'"
                        data-vv-name="Tax Class"     
                        :error-messages="errors.collect('Tax Class')"  
                      ></v-select>
                    </v-flex>
                  </v-layout>

                  <v-layout row>
                    <v-flex xs3>
                      <v-subheader>Tax Rate *</v-subheader>
                    </v-flex>
                    <v-flex xs6>
                      <v-select
                        :items="taxRate"
                        v-model="formData.tax_rate_id"
                        label="Tax Rate"
                        auto
                        required
                        item-text="name"
                        item-value="id"
                        v-validate="'required'"
                        data-vv-name="Tax Rate"     
                        :error-messages="errors.collect('Tax Rate')"  
                      ></v-select>
                    </v-flex>
                  </v-layout>

                  <v-layout row>
                    <v-flex xs3>
                      <v-subheader>Based *</v-subheader>
                    </v-flex>
                    <v-flex xs6>
                      <v-text-field
                        label="Based"
                        name="based"
                        placeholder="Based"
                        v-model="formData.based"
                        v-validate="'required'"
                        data-vv-name="Based"     
                        :error-messages="errors.collect('Based')"  
                        required
                      ></v-text-field>
                    </v-flex>
                  </v-layout>

                  <v-layout row>
                    <v-flex xs3>
                      <v-subheader>Priority *</v-subheader>
                    </v-flex>
                    <v-flex xs6>
                      <v-text-field
                        label="Priority"
                        name="priority"
                        type="number"
                        placeholder="Priority"
                        v-model="formData.priority"
                        v-validate="'required'"
                        data-vv-name="priority"     
                        :error-messages="errors.collect('priority')"  
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
  import {createData,editData,updateData} from '~/api/system/taxRule'
  import {fetchTaxRateList} from '~/api/system/taxRate'
  import {fetchTaxClassList} from '~/api/system/taxClass'
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
        parent_name:'Tax Rule',
        child_name:'Tax Rule Form',
        routeName:'Tax Rule',
        valid: true,
        notifyStatus: '',
        message: '',
        flash: Flash.state,
        formData: {
          tax_class_id: '',
          tax_rate_id: '',
          based: '',
          priority: 0
        },
        taxClass: [],
        taxRate: []
      };
    },
    computed: {
    }, 
    created() {
      if(this.id){
        Flash.setLoading(true)
        this.getData()
      }
      this.getTaxClass()
      this.getTaxRate()
    },
    methods: {
      backList(){
        this.$router.push({name:this.routeName})
      },
      getData() {
        editData(this.id).then(response => {
          // fetch all form data
          this.formData.tax_class_id = response['data']['tax_class_id']
          this.formData.tax_rate_id = response['data']['tax_rate_id']
          this.formData.based = response['data']['based']
          this.formData.priority = response['data']['priority']
          Flash.setLoading(false)
        })
      },
      clear () {
        this.formData = {};
        this.$validator.reset()
      },
      getTaxClass() {
        fetchTaxClassList().then(response => {
          // this.datatable = response
          for(let x=0 ; x <= response['data'].length-1 ; x++){
            let data = {'id':response['data'][x]['tax_class_id'],'name':response['data'][x]['title']}
            this.taxClass.push(data)
          }
        })
      },
      getTaxRate() {
        fetchTaxRateList().then(response => {
          // this.datatable = response
          for(let x=0 ; x <= response['data'].length-1 ; x++){
            let data = {'id':response['data'][x]['tax_rate_id'],'name':response['data'][x]['name']}
            this.taxRate.push(data)
          }
        })
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